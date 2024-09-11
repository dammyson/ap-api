<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class TemporaryPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $toName;
    public $toEmail;
    public $message;
    public $temporaryPassword;
    /**
     * Create a new message instance.
     */
    public function __construct($toName, $toEmail, $message, $temporaryPassword)
    {
        $this->toName = $toName;
        $this->toEmail = $toEmail;
        $this->message = $message;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('gilbergenye4@gmail.com', 'Airpeace'),
            subject: "Airpeace Admin Temporary Password",

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'temporaryAdminPassword',

            // with: [
            //     "receversName" => $this->toName,
            //     "toEmail" => $this->toEmail,
            //     "message" => $this->message,
            //     "temporaryPassword" => $this->temporaryPassword
            // ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
