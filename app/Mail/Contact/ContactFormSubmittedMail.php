<?php

namespace App\Mail\Contact;

use App\Mail\Concerns\InteractsWithBranding;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class ContactFormSubmittedMail extends Mailable
{
    use Queueable, SerializesModels, InteractsWithBranding;

    /** @var array{name:string,email:string,subject:?string,message:string} */
    public array $payload;

    /** @param array{name:string,email:string,subject:?string,message:string} $payload */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function build(): self
    {
        $siteName = Setting::get('site_name', config('app.name', 'My Website'));
        $branding = $this->brandingViewData();

        return $this
            ->subject($siteName . ' | New contact form message')
            ->replyTo($this->payload['email'], $this->payload['name'])
            ->view('emails.contact.contact-form-submitted', $branding)
            ->withSymfonyMessage(function (Email $message) {
                $this->injectBrandingCids($message);
            });
    }
}
