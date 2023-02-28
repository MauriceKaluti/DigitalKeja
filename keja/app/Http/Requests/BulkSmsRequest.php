<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulkSmsRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'message'  => 'required'
         ];

        if (! request('all_tenants'))
        {
            $rules['phone'] = 'required';
        }
        else{
            $rules['all_tenants'] = 'required';
        }

        return  $rules;
    }

    public function messages()
    {
        return [
            'message.required'  => 'Message is required',
            'all_tenants.required'  => 'Select all tenants',
            'phone.required'  => 'Phone Numbers are required',
        ];

    }
}
