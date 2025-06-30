<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $guest;
    public $task;

    public function __construct($guest, $task)
    {
        $this->guest = $guest;
        $this->task = $task;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Graduation Mission 🎓',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.task_assigned',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
