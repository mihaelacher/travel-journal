<div id="register-form" class="col-md-8 hidden">
    <div class="mb-4">
        <h3>Sign Up</h3>
    </div>
    <form class="col s12" method="post" action="{{ route('register') }}">
        @csrf

        <x-forms.input text="{{trans('auth.name')}}" name="name"/>
        <x-forms.input text="{{trans('auth.registration_email')}}" name="registration_email"/>
        <x-forms.input text="{{trans('auth.registration_password')}}" name="registration_password" type="password"/>
        <x-forms.input text="{{trans('auth.password_confirmation')}}" name="password_confirmation" type="password"/>
        <x-forms.button value="{{trans('auth.sign_up_btn')}}"/>

    </form>
</div>
