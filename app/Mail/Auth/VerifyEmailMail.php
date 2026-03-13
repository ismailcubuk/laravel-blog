<?php

namespace App\Mail\Auth;

use App\Mail\Concerns\InteractsWithBranding;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels, InteractsWithBranding;

    public function __construct(
        public string $name,
        public string $verifyUrl
    ) {
    }

    public function build(): self
    {
        $siteName = Setting::get('site_name', config('app.name', 'My Website'));
        $branding = $this->brandingViewData();

        return $this
            ->subject($siteName . ' | Verify your email')
            ->view('emails.auth.verify-email', $branding)
            ->withSymfonyMessage(function (Email $message) {
                $this->injectBrandingCids($message);
            });
    }
}
