<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
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
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
