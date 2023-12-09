<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'name' => 'required',
            'email'  => 'required|email',
            'phone_number' => [
                'required',
                'regex:/^(\+63\s?|0)[9]\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/',
            ],
            'service' => 'required',
            'message' => 'required'
        ];
    }
}
