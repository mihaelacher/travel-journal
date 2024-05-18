<div id="register-form" class="col-md-8 hidden">
    <div class="mb-4">
        <h3>Sign Up</h3>
    </div>
    <form class="col s12" method="post" action="{{ route('register') }}">
        @csrf

        <x-forms.input name="name"/>
        <x-forms.input name="registration_email"/>
        <x-forms.input name="registration_password" type="password"/>
        <x-forms.input name="password_confirmation" type="password"/>
        <x-forms.button value="Sign Up"/>

    </form>
</div>
