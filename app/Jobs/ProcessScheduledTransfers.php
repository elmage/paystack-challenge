<?php

namespace App\Jobs;

use App\Http\Controllers\Transfer\TransferController;
use App\Paystack\PaystackApi;
use App\Transfer\Card;
use App\Transfer\Schedule;
use App\Transfer\Transfer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Exception;

class ProcessScheduledTransfers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $frequency;
    protected $card;
    protected $otp_status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($frequency)
    {
        $this->frequency = $frequency;
        $this->card = (new Card)->where('primary', 1)->first();
        Cache::pull('balance'); Cache::pull('raw_balance');
        try {
            $this->otp_status = cache('otp_status');
        } catch (Exception $exception) {
            $this->otp_status = 1;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $expexted_last_run = $this->getLastRun();

        (new Schedule)->where('status', 1)
            ->whereDate('end','>=',now()->toDateString())
            ->whereDate('start','<=',now()->toDateString())
            ->where('frequency', $this->frequency)
            ->where(function ($query) use ($expexted_last_run) {
                $query->where('last_run', null)
                    ->orWhere('last_run', $expexted_last_run->toDateString());

            })
            ->chunk(100, function ($schedules) {
                //Sum of transfer amount for current chunk
                $batch_sum = $schedules->sum('amount');

                //If auto top up allowed and current balance is insufficient for this transfer batch
                if (cache('auto_topup') && $batch_sum > raw_balance()) {

                    //Charge card if a card has been added
                    if ($this->card) {
                        $data = [
                            'amount'=>($batch_sum - raw_balance()) * 100,
                            'email'=>$this->card->email,
                            'authorization_code'=>$this->card->auth_code,
                            'reference' => (new Transfer)->generateRef(11)
                        ];

                        $response = (new PaystackApi)->chargeCard($data);

                        if (array_key_exists('data', $response) && $response['data']['status'] === 'success') {
                            Cache::pull('balance'); Cache::pull('raw_balance');
                        }
                    }

                }

                $balance = raw_balance();

                foreach ($schedules as $schedule) {
                    if ($balance >= $schedule->amount && cache('otp_status') == 0) {

                        try {
                            $data = [
                                'amount'=>$schedule->amount * 100, //Kobo
                                'reason'=>$schedule->reason,
                                'recipient'=>$schedule->supplier->main_account->recipient_code,
                            ];


                            $response = (new TransferController)->makeSingleTransfer($data);


                            //If a transfer record was created
                            if ($response instanceof Transfer && $response->status === 'success') {

                                $balance = $balance - $schedule->amount;

                                Cache::pull('balance'); Cache::pull('raw_balance');


                                $schedule->update([
                                    'last_run'=>now(config('app.timezone')),
                                ]);


                            } else {
                                //Pause schedule
                                $schedule->update(['status'=>0]);
                            }
                        } catch (Exception $exception) {
                            $schedule->update(['status'=>0]);
                        }

                    }
                    else {
                        //Pause schedule
                        $schedule->update(['status'=>0]);
                        //Debugging
                        echo "Bal & OTP";
                    }
                }
            });
    }



    public function getLastRun():Carbon
    {
        switch ($this->frequency) {
            case 'daily':
                return now(config('app.timezone'))->subDay();
                break;
            case 'weekly':
                return now(config('app.timezone'))->subWeek();
                break;
            case 'fortnightly':
                return now(config('app.timezone'))->subWeeks(2);
                break;
            case 'monthly':
                return now(config('app.timezone'))->subMonth();
                break;
            default:
                return null;
                break;
        }
    }
}