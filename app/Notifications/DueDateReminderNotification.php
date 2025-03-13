<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

class DueDateReminderNotification extends Notification
{
    use Queueable;

    protected $book;

    protected $dueDate;

    /**
     * Create a new notification instance.
     */
    public function __construct(Book $book, $dueDate)
    {
        $this->book = $book;
        $this->dueDate = Carbon::parse($dueDate)->format('jS M Y');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->subject('Library Due Date Reminder')
            ->greeting("Hello, {$notifiable->name}!")
            ->line("The book **{$this->book->title}** you borrowed is due on **{$this->dueDate}**.")
            ->line('Please return the book on time to avoid penalties.')
            ->action('View Book', url('/books/'.$this->book->id))
            ->line('Thank you for using our library!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "The book **{$this->book->title}** is due on **{$this->dueDate}**.",
            'book_id' => $this->book->id,
            'due_date' => $this->dueDate,
        ];
    }
}
