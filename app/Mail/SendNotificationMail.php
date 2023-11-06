<?php

namespace App\Mail;

use App\Traits\EncryptionPassphrase;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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
            from: new Address(config('mail.from.address'), config('app.name')),
            subject: 'Seu boleto chegou!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.notification_invoice',
            with: [
                'id' => $this->encrypt($this->content->id, config("app.passphrase")),
                'name' => $this->content->name,
                'debtDueDate' => $this->content->debtDueDate,
                'debtAmount' => $this->content->debtAmount,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
