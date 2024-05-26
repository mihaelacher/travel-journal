<div id="login-form" class="col-md-8">
    <div class="mb-4">
        <h3>Sign In</h3>
    </div>
    <form id="login-form" class="col s12" method="post" action="{{ route('login') }}">
        @csrf

        <x-forms.input text="{{trans('auth.email')}}" name="email"/>
        <x-forms.input text="{{trans('auth.password')}}" name="password" type="password"/>
        <x-forms.checkbox name="{{trans('auth.remember_me')}}"/>
        <x-forms.button value="{{trans('auth.sign_up_btn')}}"/>

        <span class="d-block text-center my-4 text-muted">{{ trans('auth.sign_in_switch') }}</span>

        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <div id="g_id_onload"
                     data-client_id="{{ config('services.google.client_id') }}"
                     data-login_uri={{url('/auth/login/google')}}
                     data-auto_prompt="false">
                </div>
                <div class="g_id_signin"
                     data-type="standard"
                     data-size="large"
                     data-theme="outline"
                     data-text="sign_in_with"
                     data-shape="rectangular"
                     data-logo_alignment="left">
                </div>
            </div>
        </div>
    </form>
</div>
