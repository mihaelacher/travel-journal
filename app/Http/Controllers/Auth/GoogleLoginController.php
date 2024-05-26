<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GoogleLoginRequest;
use App\Services\Auth\AuthService;
use App\Services\Utils\LogUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * GET /auth/login/google
     * @param Request $request
     * @return RedirectResponse
     */
    public function redirectToGoogle(Request $request): RedirectResponse
    {
        return Socialite::driver('google')->setScopes(['openid', 'email'])->redirect();
    }

    /**
     * Handle the callback from Google authentication.
     *
     * POST /auth/login/google
     * @param GoogleLoginRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function handleGoogleCallback(GoogleLoginRequest $request): RedirectResponse
    {
        $payload = $request->getPayload();

        try {
            Auth::login(user: AuthService::fetchLoggedInUser($payload->all()));
        } catch (\Throwable $t) {
            LogUtil::logError(message: $t->getMessage());
            return redirect()
                ->back()
                ->with('error', trans('auth.login_failed'));
        }

        return redirect('dashboard');
    }
}
