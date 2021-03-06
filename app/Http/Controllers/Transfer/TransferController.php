<?php

namespace App\Http\Controllers\Transfer;

use App\Http\Requests\ResendOtpRequest;
use App\Http\Requests\SingleTransferRequest;
use App\Http\Requests\TopupRequest;
use App\Http\Requests\TransferOtpRequest;
use App\Jobs\ProcessScheduledTransfers;
use App\Paystack\PaystackApi;
use App\Supplier\BankAccount;
use App\Supplier\Supplier;
use App\Transfer\Card;
use App\Transfer\Transfer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TransferController extends Controller
{
    protected $paystackApi;

    public function __construct()
    {
        $this->paystackApi = new PaystackApi;
    }


    public function index(Transfer $transfer)
    {
        $this->dispatch(new ProcessScheduledTransfers('fortnightly'));
        $this->dispatch(new ProcessScheduledTransfers('monthly'));
        return view('transfer.index', ['transfers' => $transfer->filter()]);
    }

    public function single(Supplier $supplier) {
        $suppliers = $supplier->orderBy('name', 'ASC')->get(['id','name']);

        return view('transfer.single', ['suppliers'=>$suppliers, 'single_transfer'=>1]);
    }

    public function singleTransfer(SingleTransferRequest $request)
    {
        $validated = $request->validated();

        $data = [
            'amount'=>$validated['amount']*100, //Kobo
            'reason'=>array_key_exists('transfer_note',$validated) ? $validated['transfer_note'] : '',
            'recipient'=>$validated['supplier_account'],
        ];

        $response = $this->makeSingleTransfer($data);

        if ($response instanceof Transfer) {

            if ($response->status === 'otp') {
                return redirect()->route('transfer.single.enter_otp', $response->id);
            }

            if ($response->status === 'success') {
                return redirect()->route('transfers')->with('success','The transfer was successful!');
            }

            if ($response->status === 'pending') {
                return redirect()->route('transfers')->with('response','The transfer has been queued for sending');
            }

            return redirect()->route('transfers')->with('error','The transfer failed');
        }

        return redirect()->back()->with('error',$response['message']);
    }

    public function makeSingleTransfer(array $data)
    {
        $data['source'] = 'balance';
        $data['reference'] = (new Transfer)->generateRef(10);

        $response = $this->paystackApi->makeSingeTransfer($data);

        if ($response['code'] === 200)
        {
            $account = (new BankAccount)->getAccountByRecipientCode($data['recipient']);

            $transfer = (new Transfer)->create([
                'supplier_id'=>$account->supplier_id,
                'amount'=>$response['data']['amount'] / 100,
                'currency'=>$response['data']['currency'],
                'reason'=>$data['reason'],
                'account_id'=>$account->id,
                'transfer_code'=>$response['data']['transfer_code'],
                'reference'=>$data['reference'],
                'status'=>$response['data']['status']
            ]);

            return $transfer;
        }

        return $response;
    }


    public function enterOtp(Transfer $transfer) {
        if ($transfer->status !== 'otp') {
            return redirect()->route('transfers');
        }

        return view('transfer.otp', ['transfer'=>$transfer, 'single_transfer'=>1]);
    }

    public function sendOtp(TransferOtpRequest $request, Transfer $transfer) {
        $validated = $request->validated();

        $response = $this->paystackApi->sendTransferOTP($validated);

        if (array_key_exists('data',$response) && $response['data']['status'] === 'success')
        {
            $transfer = $transfer->where('reference', $response['data']['reference'])
                ->first();

            $transfer->update(['status'=>$response['data']['status']]);

            return redirect()->route('transfers')->with('success', 'The transfer was successful.');
        }

        return redirect()->route('transfers')->with('error', $response['message']);
    }

    public function resendOtp(ResendOtpRequest $request)
    {
        $validated = $request->validated();
        return response()->json($this->paystackApi->resendTransferOtp($validated));
    }

    public function topup() {
        $cards = (new Card)->get();
        return view('transfer.topup', ['topup'=>1, 'cards'=>$cards]);
    }

    public function chargeTopup(TopupRequest $request)
    {
        $validated = $request->validated();

        $card = (new Card)->find($validated['card_id']);
        $data = [
            'amount'=>$validated['amount']*100,
            'email'=>Auth::user()->email,
            'authorization_code'=>$card->auth_code,
            'reference' => (new Transfer)->generateRef(11)
        ];

        $response = $this->paystackApi->chargeCard($data);

        if (array_key_exists('data', $response) && $response['data']['status'] === 'success') {
            Cache::pull('balance');
            return redirect()->route('transfer.topup')->with('success', $response['message']);
        }

        return redirect()->route('transfer.topup')->with('error', $response['message']);
    }


    public function getAccountsForSupplier(BankAccount $bank, $id) {
        $accounts = [];

        foreach ($bank->getAccountForSupplier($id) as $account) {
            $accounts[$account->recipient_code] = $account->number.' '.$account->bank_name.' ('.$account->name.')';
        }

        return response()->json($accounts);
    }
}
