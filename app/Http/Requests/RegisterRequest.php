<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact_number' => [
                'required',
                'regex:/^(\+63\s?|0)[9]\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/',
            ],
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'birthdate' => 'required|date'
        ];
    }

    public function messages()
    {
        return [
            'contact_number.regex' => 'The contact number must be in the format +63 900 000 00 or 09234567891.',
        ];
    }
}
