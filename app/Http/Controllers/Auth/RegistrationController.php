<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationPostRequest;
use App\Services\Auth\AuthService;
use App\Services\Utils\LogUtil;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    /**
     * POST /auth/register
     * @param RegistrationPostRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function register(RegistrationPostRequest $request): RedirectResponse
    {
        try {
            $user = AuthService::fetchLoggedInUser(data: $request->all());

            Auth::login($user);

            return redirect('dashboard');
        } catch (\Exception $e) {
            LogUtil::logError(message: $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to register. Please, try again.');
        }
    }
}
