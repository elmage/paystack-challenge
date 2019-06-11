<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Requests\StoreSupplier;
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
        return view('supplier.index',['suppliers'=>$supplier->latest()->get()]);
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

        $data = [
            'type' => 'nuban',
            'name' => $validated['name'],
            'account_number' => $validated['account_no'],
            'bank_code' =>$validated['bank_code']
        ];

        $response = $this->paystackApi->createRecipient($data);

        if ($response['status'] === true) {

            //Save supplier
            $supplier = $supplier->create([
                'name'=>$validated['name'],
                'contact_tel'=>$validated['tel'],
                'contact_name'=>$validated['contact_name'],
                'email'=>$validated['email']
            ]);

            $data = $response['data'];

            //Save supplier bank detail
            $supplier->accounts()->create([
                'number'=>$data['details']['account_number'],
                'bank_code'=>$data['details']['bank_code'],
                'bank_name'=>$data['details']['bank_name'],
                'currency'=>$data['currency'],
                'auth_code'=>$data['details']['authorization_code'],
                'recipient_code'=>$data['recipient_code'],
                'primary'=>1
            ]);

            return redirect()->route('suppliers')->with('success', 'The supplier details was successfully added!');

        } else {
            return redirect()->back()->with('error', $response['message']);
        }
    }

    public function edit(Supplier $supplier) {
        return view('supplier.edit', ['supplier'=>$supplier,'suppliers'=>1 /* navigation hack */ ]);
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
