<?php

namespace App\Mail;

use App\Models\Absence;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeleteAbsence extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Absence $absence,
        public string $oldname,
        public string $oldtitre,
        public string $olddebut,
        public string $oldfin,
        public string $oldstatus
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Suppression d\'une Absence',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.absence.delete',
            with: [
                'absence' => $this->absence,
                'oldname' => $this->oldname,
                'oldtitre' => $this->oldtitre,
                'olddebut' => $this->olddebut,
                'oldfin' => $this->oldfin,
                'oldstatus' => $this->oldstatus,
            ],
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
