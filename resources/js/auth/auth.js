import utils from "@/utils/utils.js";

const auth = () => {
    const attachHandleAuthFormSwitch = () => {
        const $authFormSwitch = $('#auth-form-switch');

        $authFormSwitch.change(() => {
            const checkbox = $(this).find('input[type="checkbox"]');
            const showLogin = !checkbox.is(':checked');

            $('#sign-up-form-switch, #login-form').toggle(showLogin);
            $('#sign-in-form-switch, #register-form').toggle(!showLogin);
        })
    }

    const attachLoginFormValidationHandler = () => {
        $('#login-form').validate({
            errorClass: 'help-block help-block-error',
            errorPlacement: function (error, element) {
                error.addClass('error-placement');
                error.insertAfter(element);
            },
            errorElement: 'span',
            rules: {
                password: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                password: {
                    required: i18next.t('validation.required', { attribute: 'password' }),
                },
                email: {
                    required: i18next.t('validation.required', { attribute: 'email' }),
                    email: i18next.t('validation.email', { attribute: 'password' }),
                }
            },
            submitHandler: (form) => {
                // Handle form submission
                form.submit();
            }
        });
    }

    return {
        init: function () {
            attachHandleAuthFormSwitch();
            attachLoginFormValidationHandler();
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    auth.init();
    utils.onPageLoadShowToastSessionMessage();
});
