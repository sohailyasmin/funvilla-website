<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
        // $familyMemberData = $this->input('family_member_data', []);

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'exists:locations,id'],
            'news_subscription' => ['nullable', 'boolean'],

        ];

        // $familyMemberRules = [];

        // foreach ($familyMemberData as $index => $data) {
        //     $familyMemberRules["family_member_data.$index.id"] = ['required'];
        //     $familyMemberRules["family_member_data.$index.first_name"] = ['required', 'string', 'max:255'];
        //     $familyMemberRules["family_member_data.$index.last_name"] = ['required', 'string', 'max:255'];
        //     $familyMemberRules["family_member_data.$index.dob"] = ['required', 'date']; 
        // }
        
        return $rules;
    }
}
