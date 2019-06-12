<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests\StoreSupplier;
use App\Http\Requests\UpdateSupplier;
use App\Paystack\PaystackApi;
use App\Supplier\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class SupplierController extends Controller
{
    protected $paystackApi;

    public function __construct()
    {
        $this->paystackApi = new PaystackApi();
    }

    public function index(Supplier $supplier)
    {
        return view('supplier.index',['suppliers'=>$supplier->latest()->get(),'all_suppliers'=>1]);
    }

    public function getSuppliers(Supplier $supplier)
    {
        $suppliers = [];

        foreach ($supplier->latest()->get() as $result) {
            $suppliers[] = [
                'id' => $result->id,
                'name' => $result->name,
                'tel' => $result->contact_tel,
                'email' => $result->email,
                'account_no'=>$result->main_account->number,
                'bank_name'=>$result->main_account->bank_name,
            ];
        }

        return response()->json($suppliers);
    }

    public function create()
    {
        return view('supplier.create',['create_supplier'=>1, 'banks'=>$this->getBanksFromPaystack()]);
    }

    public function store(StoreSupplier $request, Supplier $supplier)
    {
        $validated = $request->validated();

        //Save supplier
        $supplier = $supplier->create([
            'name'=>$validated['name'],
            'contact_tel'=>$validated['tel'],
            'contact_name'=>$validated['contact_name'],
            'email'=>$validated['email']
        ]);

        $params = [
            'account_no' => $validated['account_no'],
            'bank_code' =>$validated['bank_code'],
            'account_name'=>$validated['account_name']
        ];

        $response = (new BankAccountController())->addBankAccount($params,$supplier);

        if ($response['status']===false) { $supplier->delete(); }

        return redirect()->back()->with($response['status']?'success':'error',$response['message']);

    }


    public function edit(Supplier $supplier) {
        return view('supplier.edit', [
            'supplier'=>$supplier,
            'banks'=>$this->getBanksFromPaystack(),
            'suppliers'=>1 /* navigation hack */
        ]);
    }

    public function updateSupplier(UpdateSupplier $request, Supplier $supplier)
    {
        $validated = $request->validated();
        $supplier = $supplier->find($validated['id']);

        //TODO update recipient name and email on pay stack if there is a change

        $supplier->update([
            'name' => $validated['name'],
            'contact_tel' => $validated['tel'],
            'contact_name' => $validated['contact_name'],
            'email' => $validated['email'],
        ]);

        return redirect()->back()->with('success','The Supplier was updated');
    }



    private function getBanksFromPaystack()
    {
        $banks = Cache::remember('all_banks',60*24*7, function () {
            $list = $this->paystackApi->getBankList();
            if (is_array($list) && array_key_exists('data',$list)) return $list['data'];
        });

        return $banks;
    }
}
