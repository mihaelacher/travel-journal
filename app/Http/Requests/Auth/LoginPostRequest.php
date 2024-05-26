<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainFormRequest;

class LoginPostRequest extends MainFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => trans('validation.required', ['attribute' => 'email']),
            'email.string' => trans('validation.string', ['attribute' => 'email']),
            'email.email' => trans('validation.email', ['attribute' => 'email']),
            'email.max' => trans('validation.max.string', ['attribute' => 'email', 'max' => 255]),
            'password.required' => trans('validation.required', ['attribute' => 'password']),
            'password.string' => trans('validation.string', ['attribute' => 'password']),
            'password.min' => trans('validation.min.string', ['attribute' => 'password', 'min' => 8]),
        ];
    }
}
