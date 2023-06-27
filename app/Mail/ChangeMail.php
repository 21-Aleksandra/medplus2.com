<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class ChangeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $doctorName;
    public $userName;
    public $appointmentDate;
    public $appointmentTime;
    public $appointmentStatus;
    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->userName = $appointment->user->name;
        $this->doctorName = $appointment->doctor->name;
        $this->appointmentDate = $appointment->date;
        $this->appointmentTime = $appointment->time;
        $this->appointmentStatus = $appointment->status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your appoitment status was changed!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.statusmail',
            with:[
                'doctorName' => $this->doctorName,
                'appointmentDate' => $this->appointmentDate,
                'appointmentTime' => $this->appointmentTime,
                'userName' => $this->userName,
                'appointmentStatus' => $this->appointmentStatus,
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
