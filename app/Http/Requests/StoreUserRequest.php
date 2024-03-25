<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users',],
            'city' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:11', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'max:30',],
            'role' => ['required', 'exists:roles,id'],
            'location_id' => ['required_if:role,admin'],
            'access_locations' => ['nullable'],
            'status' => ['required', 'boolean'],
            'address' => ['nullable']
        ];
    }
}
