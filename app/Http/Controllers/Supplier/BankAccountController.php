<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests\AddSupplierBankAccount;
use App\Http\Requests\DeleteAccount;
use App\Http\Requests\MakeAccountPrimary;
use App\Paystack\PaystackApi;
use App\Supplier\BankAccount;
use App\Supplier\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankAccountController extends Controller
{
    protected $paystackApi;

    public function __construct()
    {
        $this->paystackApi = new PaystackApi();
    }

    public function create(AddSupplierBankAccount $request, Supplier $supplier) {
        $validated = $request->validated();

        $supplier = $supplier->find($validated['supplier_id']);

        $response = $this->addBankAccount($validated, $supplier);

        return redirect()->back()->with($response['status']?'success':'error',$response['message']);
    }

    public function makePrimary(MakeAccountPrimary $request, BankAccount $account) {
        $validated = $request->validated();

        $bank = $account->find($validated['id']);

        $bank->supplier->accounts()->update(['primary'=>0]);

        $bank->update(['primary'=> 1]);

        return redirect()->back()->with('success','Primary account has been set.');
    }

    public function delete(DeleteAccount $request, BankAccount $account) {
        $validated = $request->validated();
        $account = $account->find($validated['id']);

        if ($account->primary) {
            return redirect()->back('error', 'The primary account can not be deleted');
        }

        $response = $this->paystackApi->deleteRecipient($validated['recipient_code']);

        if ($response['status'] === true) {
            $account->delete();
        }

        return redirect()->back()->with($response['status']?'success':'error',$response['message']);
    }

    public function resolveAccount($account,$bank_Code)
    {
        $response = $this->paystackApi->resolveAccount($account,$bank_Code);

        if (array_key_exists('data',$response))
        {
            return response()->json($response['data']);
        }

        return response()->json([]);
    }

    /**
     * Add recipient account to database and paystack
     * @param array $params
     * @param Supplier $supplier
     * @return array|mixed
     */
    public function addBankAccount(array $params, Supplier $supplier) {
        $data = [
            'type' => 'nuban',
            'name' => $supplier->name,
            'account_number' => $params['account_no'],
            'bank_code' =>$params['bank_code'],
            'email' => $supplier->email
        ];

        $response = $this->paystackApi->createRecipient($data);

        $data = $response['data'];

        //Save supplier bank detail
        $supplier->accounts()->create([
            'number'=>$data['details']['account_number'],
            'name'=>array_key_exists('account_name',$params) ? $params['account_name'] : null,
            'bank_code'=>$data['details']['bank_code'],
            'bank_name'=>$data['details']['bank_name'],
            'currency'=>$data['currency'],
            'auth_code'=>$data['details']['authorization_code'],
            'recipient_code'=>$data['recipient_code'],
            'primary'=>$supplier->main_account ? 0 : 1
        ]);

        return $response;
    }
}
