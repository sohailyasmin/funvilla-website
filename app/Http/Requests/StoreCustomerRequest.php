<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:4', 'max:30'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string'],
            'postal_code' => ['required', 'string', 'max:255'],
            'location_id' => ['required', 'exists:locations,id'],
            'signing_wavier_for_family_member' => ['required'],
            'family_members' => ['required_if:signing_wavier_for_family_member,==,true', 'array'],
            'family_members.*.family_first_name' => ['required_if:signing_wavier_for_family_member,==,true', 'string', 'max:255'],
            'family_members.*.family_last_name' => ['required_if:signing_wavier_for_family_member,==,true', 'string', 'max:255'],
            'family_members.*.family_dob' => ['required_if:signing_wavier_for_family_member,==,true', 'string'],
            'family_members.*.signature' => ['sometimes', 'required_if:signing_wavier_for_family_member,==,true', 'string'],
            'customer_remarks' => ['nullable', 'string'],
            'news_subscription' => ['nullable', 'boolean'],
            'waiver_via' => ['nullable', 'string'],
        ];

        return array_merge($rules);
    }

    public function messages(): array
    {
        return [
            'family_members.*.signature.required' => 'This field is required',
            'family_members.*.signature.string' => 'This field must be a validate string!',
        ];
    }

}
