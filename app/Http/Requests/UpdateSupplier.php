<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplier extends FormRequest
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
            'id'           => 'required|bail|integer|exists:suppliers,id',
            'name'         => 'required|bail|string|max:250',
            'contact_name' => 'nullable|string|max:250',
            'email'        => 'nullable|email|string|max:250',
            'tel'          => 'nullable|numeric|digits_between:8,14'
        ];
    }
}
