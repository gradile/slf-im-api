<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'phone'      => ['required','string','max:30','regex:/^\+?[0-9()\-\s\.]{7,}$/'],
            'email'      => ['required','email:rfc,dns'],
            'question'   => ['nullable', 'string', 'max:255'],
            'consent1'   => ['required', 'boolean'],
            'consent2'   => ['nullable', 'boolean'],
        ];
    }
}
