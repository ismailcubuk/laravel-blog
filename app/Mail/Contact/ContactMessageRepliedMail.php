<?php

namespace App\Mail\Contact;

use App\Mail\Concerns\InteractsWithBranding;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class ContactMessageRepliedMail extends Mailable
{
    use Queueable, SerializesModels, InteractsWithBranding;

    public ContactMessage $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function build(): self
    {
        $siteName = Setting::get('site_name', config('app.name', 'My Website'));
        $subject = $this->contactMessage->subject ?: 'Contact message';
        $branding = $this->brandingViewData();

        return $this
            ->subject($siteName . ' | Re: ' . $subject)
            ->view('emails.contact.contact-message-replied', $branding)
            ->withSymfonyMessage(function (Email $message) {
                $this->injectBrandingCids($message);
            });
    }
}
