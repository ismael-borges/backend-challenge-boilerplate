<?php

namespace App\Mail;

use App\Traits\EncryptionPassphrase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNotificationMail extends Mailable
{
    use Queueable;
    use SerializesModels;
    use EncryptionPassphrase;

    public function __construct(
        private $content
    )
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Notification Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.notification_invoice',
            with: ['content' => $this->content]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
