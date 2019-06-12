<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SingleTransferRequest extends FormRequest
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
            'amount'=>'required|numeric|min:100',
            'transfer_note'=>'nullable|string|max:100',
            'supplier_id'=>'required|integer|exists:suppliers,id',
            'supplier_account'=>'required|string|exists:bank_accounts,recipient_code',
        ];
    }
}
