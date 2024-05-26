<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\MainFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RegistrationPostRequest extends MainFormRequest
{
    protected function extendValidatorRules(): void
    {
        Validator::extend('unique_email_attribute', function ($attribute, $value) {
            return User::where('email', '=', $value)->whereNull('google_id')->doesntExist();
        });
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique_email_attribute',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => 'name']),
            'name.string' => trans('validation.string', ['attribute' => 'name']),
            'name.max' => trans('validation.max.string', ['attribute' => 'name', 'max' => 255]),
            'email.required' => trans('validation.required', ['attribute' => 'email']),
            'email.string' => trans('validation.string', ['attribute' => 'email']),
            'email.email' => trans('validation.email', ['attribute' => 'email']),
            'email.max' => trans('validation.max.string', ['attribute' => 'email', 'max' => 255]),
            'email.unique_email_attribute' => trans('validation.unique', ['attribute' => 'email']),
            'password.required' => trans('validation.required', ['attribute' => 'password']),
            'password.string' => trans('validation.string', ['attribute' => 'password']),
            'password.min' => trans('validation.min.string', ['attribute' => 'password', 'min' => 8]),
            'password.confirmed' => trans('validation.confirmed', ['attribute' => 'password']),
        ];
    }
}
