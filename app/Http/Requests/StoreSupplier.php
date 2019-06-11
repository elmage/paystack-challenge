<?php

namespace App\Http\Requests;

use App\Rules\AccountNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupplier extends FormRequest
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
            'name'         => 'required|bail|string|max:250',
            'contact_name' => 'nullable|string|max:250',
            'email'        => 'nullable|email|string|max:250',
            'tel'          => 'nullable|numeric|digits_between:8,14',
            'bank_code'    => 'required',
            'account_no'   => ['required', new AccountNumber]
        ];
    }
}
