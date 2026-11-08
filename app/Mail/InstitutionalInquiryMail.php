<?php

namespace App\Mail;

use App\Models\InstitutionalInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InstitutionalInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public InstitutionalInquiry $inquiry,
        public bool $isInternalAlert = false,
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isInternalAlert
            ? "[New Partnership Inquiry] {$this->inquiry->organization_name} — Brands Academy"
            : "Institutional Inquiry Confirmed: {$this->inquiry->organization_name} — Brands Academy Nigeria Foundation";

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.institutional-inquiry',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
