<?php

namespace App\Services\Mail;

use App\Mail\Auth\PasswordResetRequestMail;
use App\Mail\Auth\VerifyEmailChangeMail;
use App\Mail\Auth\VerifyEmailMail;
use App\Mail\Auth\WelcomeMail;
use App\Mail\Contact\ContactFormSubmittedMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class MailWorkflowService
{
    public function sendRegistrationVerification(User $user, string $verifyUrl): void
    {
        Mail::to($user->email)->send(new VerifyEmailMail($user->name, $verifyUrl));
    }

    public function sendEmailChangeVerification(string $name, string $toEmail, string $verifyUrl): void
    {
        Mail::to($toEmail)->send(new VerifyEmailChangeMail($name, $verifyUrl));
    }

    public function sendWelcomeAfterVerification(User $user): void
    {
        Mail::to($user->email)->send(new WelcomeMail($user->name));
    }

    public function sendPasswordResetRequest(User $user, string $resetUrl): void
    {
        Mail::to($user->email)->send(new PasswordResetRequestMail($user->name, $resetUrl));
    }

    /** @param array{name:string,email:string,subject:?string,message:string} $payload */
    public function sendContactFormMessageToSite(string $toEmail, array $payload): void
    {
        Mail::to($toEmail)->send(new ContactFormSubmittedMail($payload));
    }
}
