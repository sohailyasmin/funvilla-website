<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerFMRequest extends FormRequest
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
     * @return array<string, mixed>
     */
   
    public function rules() 
    {
       return [
            'family_members' => ['required', 'array'],
            'family_members.*.family_first_name' => ['required', 'string', 'max:255'],
            'family_members.*.family_last_name' => ['required', 'string', 'max:255'],
            'family_members.*.family_dob' => ['required', 'date'],
            'family_members.*.signature' => ['sometimes', 'required', 'string'],
            'customer_remarks' => ['nullable', 'string']
       ];
    }

    public function messages(): array
    {
        return [
            'family_members.*.signature.required' => 'This field is required',
            'family_members.*.signature.string' => 'This field must be a validate string!',
        ];
    }
    
}