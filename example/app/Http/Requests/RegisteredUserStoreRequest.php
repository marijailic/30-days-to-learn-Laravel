<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisteredUserStoreRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:15'],
            'last_name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(6), 'confirmed'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
        ];
    }
}
