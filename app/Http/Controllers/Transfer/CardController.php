<?php

namespace App\Http\Controllers\Transfer;

use App\Paystack\PaystackApi;
use App\Transfer\Card;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    protected $paystackApi;

    public function __construct()
    {
        $this->paystackApi = new PaystackApi;
    }

    public function add($ref)
    {
        $tranx = $this->paystackApi->verifyTransaction($ref);

        if ('success' === $tranx->data->status) {

            //TODO history
            /*
             * $customer->payments()->create([
                'schedule_id'=>null,
                'customer_id'=>session('customer_id'),
                'ref'=>$ref,
                'amount'=>Core::settingsCache('add_card_fee'),
                'status'=>1
            ]);
             */

            $authorization = $tranx->data->authorization;

            (new Card)->update(['primary'=>0]);

            $card = (new Card)->create([
                'type'=>$authorization->card_type,
                'bin'=>$authorization->bin,
                'last_4'=>$authorization->last4,
                'exp_month'=>$authorization->exp_month,
                'exp_year'=>$authorization->exp_year,
                'auth_code'=>$authorization->authorization_code,
                'primary'=>1,
                'email'=>Auth::user()->email
            ]);

            return response()->json(['state'=>'success','msg'=>'Card added successfully.']);
        }

        return response()->json(['state'=>'error','msg'=>'Could not add card: ' . $tranx->message]);
    }

    public function remove(Request $request, Card $card) {
        $this->validate($request, [
            'id'=>'required|integer|exists:cards,id'
        ]);

        $card->destroy($request->id);

        return redirect()->back()->with('success', 'Your card was removed.');
    }
}
