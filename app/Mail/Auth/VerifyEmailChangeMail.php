<?php

namespace App\Mail\Auth;

use App\Mail\Concerns\InteractsWithBranding;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class VerifyEmailChangeMail extends Mailable
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
            ->subject($siteName . ' | Confirm your new email')
            ->view('emails.auth.verify-email-change', $branding)
            ->withSymfonyMessage(function (Email $message) {
                $this->injectBrandingCids($message);
            });
    }
}
