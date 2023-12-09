<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAppointmentRequest extends FormRequest
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
            'doctor_id' => 'required|integer',
            'availability_id' => 'required|integer',
            'date_schedule' => "required|date",
            'start_time' => 'required',
            'end_time' => 'required',
            'service' => 'required',
            // 'covidForm' => [
            //     'required',
            //     'array',
            //     'size:11', // Ensure there are 11 elements in the array
            //     'each' => [
            //         'required',
            //         'string',
            //     ],
            // ],
            // 'mqForm' => [
            //     'required',
            //     'array',
            //     'size:4', // Ensure there are 11 elements in the array
            //     'each' => [
            //         'required',
            //         'string',
            //     ],
            // ],
        ];
    }
}
