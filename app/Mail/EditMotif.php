<?php

namespace App\Mail;

use App\Models\Motif;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EditMotif extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Motif $motif,
        public string $oldtitre,
        public bool $oldaccessible
    ) {
        $this->motif = $motif;
        $this->oldtitre = $oldtitre;
        $this->oldaccessible = $oldaccessible;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jour motif',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.motif.edit',
            with: [
                'motif' => $this->motif,
                'oldtitre' => $this->oldtitre,
                'oldaccessible' => $this->oldaccessible
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
