<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
            'first_name' => ['sometimes','string','max:100'],
            'last_name'  => ['sometimes','string','max:100'],
            'phone'      => ['sometimes','nullable','string','max:30','regex:/^\+?[0-9()\-\s\.]{7,}$/'],
            'email'      => ['sometimes','nullable','email:rfc,dns'],
        ];
    }
}
