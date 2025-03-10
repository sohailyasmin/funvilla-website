<?php

namespace App\Http\Requests\Api\User;

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
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users',],
            'password' => ['required', 'string', 'min:8',],
            'role' => ['required', 'exists:roles,id'],
            'location_id' => ['required', 'string', 'exists:location_id']
        ];
    }
}
