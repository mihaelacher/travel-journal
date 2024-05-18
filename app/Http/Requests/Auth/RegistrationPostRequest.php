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
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must contain characters.',
            'name.max' => 'The name may not be greater than :max characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must contain characters.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than :max characters.',
            'email.unique_email_attribute' => 'User with this email already exists.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must contain characters.',
            'password.min' => 'The password must be at least :min characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
