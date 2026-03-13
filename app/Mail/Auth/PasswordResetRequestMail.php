<?php

namespace App\Mail\Auth;

use App\Mail\Concerns\InteractsWithBranding;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class PasswordResetRequestMail extends Mailable
{
    use Queueable, SerializesModels, InteractsWithBranding;

    public function __construct(
        public string $name,
        public string $resetUrl
    ) {
    }

    public function build(): self
    {
        $siteName = Setting::get('site_name', config('app.name', 'My Website'));
        $branding = $this->brandingViewData();

        return $this
            ->subject($siteName . ' | Password reset request')
            ->view('emails.auth.password-reset-request', $branding)
            ->withSymfonyMessage(function (Email $message) {
                $this->injectBrandingCids($message);
            });
    }
}
