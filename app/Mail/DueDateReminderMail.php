<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DueDateReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $book;
    public $dueDate;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Book $book, $dueDate)
    {
        $this->user = $user;
        $this->book = $book;
        $this->dueDate = $dueDate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Library Due Date Reminder',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.due_date_reminder',
            with: [
                'userName' => $this->user->name,
                'bookTitle' => $this->book->title,
                'dueDate' => $this->dueDate,
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
