<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:user,username|min:3',
            'password' => 'required|string|min:6',
        ];
    }
}
