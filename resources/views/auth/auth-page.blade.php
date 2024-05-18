@extends('layout')

@section('title', 'Login #7')

@section('vite-content')
    @vite(['resources/css/login.scss', 'resources/js/auth/auth.js'])
@endsection

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="images/travel-login-image.jpg" alt="Image" class="img-fluid">
                </div>
                <div class="col-md-6 contents">
                    <div id="auth-form" class="row justify-content-center">

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div id="auth-form-switch" class="switch">
                                    <label>
                                        <input type="checkbox">
                                        <span class="lever"></span>
                                        <span id="sign-up-form-switch">Don't have account yet? Sign up now.</span>
                                        <span id="sign-in-form-switch" class="hidden">Return to sign in form.</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        @include('auth.login-form')
                        @include('auth.register-form')

                    </div>
                </div>
            </div>
        </div>
        <script src="https://accounts.google.com/gsi/client" async></script>
@endsection
