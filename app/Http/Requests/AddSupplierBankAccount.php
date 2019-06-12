<?php

namespace App\Http\Requests;

use App\Rules\AccountNumber;
use Illuminate\Foundation\Http\FormRequest;

class AddSupplierBankAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id'    => 'required|bail|integer|exists:suppliers,id',
            'bank_code'    => 'required',
            'account_no'   => ['required', new AccountNumber, 'unique:bank_accounts,number']
        ];
    }
}
