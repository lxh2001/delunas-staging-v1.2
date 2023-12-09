<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisionRequest extends FormRequest
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
            'vision_header' => 'required',
            'vision_description' => 'required',
        ];
    }
}
