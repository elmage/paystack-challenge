<?php

namespace App\Http\Requests;

use App\Rules\ValidDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ScheduleTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->level > 1;
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
            'reason'=>'nullable|string|max:100',
            'supplier_id'=>'required|integer|exists:suppliers,id',
            'status'=>'required|boolean',
            'start'=>['required','string','max:25', new ValidDate],
            'end'=>['required','string','max:25', new ValidDate],
            'frequency'=>'required|string|max:20',
        ];
    }
}
