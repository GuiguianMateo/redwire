<?php

namespace App\Mail;

use App\Models\Absence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EditAbsence extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Absence $absence, public $oldname,  public $oldtitre, public $olddebut, public $oldfin)
    {
        $this->absence = $absence;
        $this->oldname = $oldname;
        $this->oldtitre = $oldtitre;
        $this->olddebut = $olddebut;
        $this->oldfin = $oldfin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Mise à jours absence',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.absence.edit',
            with:['absence' => $this->absence, 'oldname' => $this->oldname, 'oldtitre' => $this->oldtitre, 'olddebut' => $this->olddebut, 'oldfin' => $this->oldfin],
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
