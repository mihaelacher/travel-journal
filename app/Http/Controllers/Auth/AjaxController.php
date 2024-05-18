<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\FetchAuthFormGetRequest;
use Illuminate\View\View;

class AjaxController extends Controller
{
    /**
     * Fetch the authentication form based on the request parameter.
     *
     * GET /auth
     * @param FetchAuthFormGetRequest $request
     * @return View
     */
    public function fetchAuthForm(FetchAuthFormGetRequest $request): View
    {
        return $request->query('showLogin')
            ? view('auth.login-form')
            : view('auth.register-form');
    }
}
