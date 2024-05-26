<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Session expired
        $this->middleware(function ($request, $next) {
            if (empty(Auth::user())){
                return redirect('/auth')
                    ->with('message', trans('auth.session_expired'))
                    ->with('classes', 'alert-danger');
            }

            return $next($request);
        });
    }
}
