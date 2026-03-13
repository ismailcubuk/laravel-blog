# Mail Architecture

## Folder Structure

- `app/Mail/Auth`
- `app/Mail/Contact`
- `app/Services/Mail`
- `resources/views/emails/auth`
- `resources/views/emails/contact`

## Workflows

1. Registration Verification
- Trigger: `AuthController@register`
- Mail: `VerifyEmailMail`
- Token storage: `email_verification_tokens`

2. Welcome Mail After Verification
- Trigger: `AuthController@verifyEmail`
- Mail: `WelcomeMail`

3. Contact Form Mail
- Trigger: `PageController@submitContact`
- Mail: `ContactFormSubmittedMail`

4. Password Reset Request Mail
- Trigger: `AuthController@sendPasswordResetLink`
- Mail: `PasswordResetRequestMail`
- Token storage: `password_reset_tokens`

## Central Mail Service

`App\Services\Mail\MailWorkflowService` is the single orchestration point used by controllers.
