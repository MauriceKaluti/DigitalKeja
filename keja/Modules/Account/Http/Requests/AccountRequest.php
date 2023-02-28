<?php

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       return  [
            'name' => 'required',
            'glcode' => [
                'required',
                Rule::unique('accounts')->ignore(request('account_id'))
            ],
            'chart_id' => 'required',
            'description' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'chart_id.required' => 'Please select Chart of account',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
