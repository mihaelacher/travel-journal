<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * GET /auth/login
     * @param Request $request
     * @return View
     */
    public function showLoginForm(Request $request): View
    {
        return view('auth.auth-page')
            ->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-checked, pre-checked',
            'Pragma' => 'no-cache',
        ]);
    }

    /**
     * Redirect the user to auth page on logout
     *
     * @param Request $request
     * @return void
     */
    public function loggedOut(Request $request): void
    {
        redirect('/auth');
    }
}
