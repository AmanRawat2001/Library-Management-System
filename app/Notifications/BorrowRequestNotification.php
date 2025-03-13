<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorrowRequestNotification extends Notification
{
    use Queueable;

    public $status;

    public $bookTitle;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $bookTitle)
    {
        $this->status = $status;
        $this->bookTitle = $bookTitle;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Borrow Request Update')
            ->line("Your request to borrow '{$this->bookTitle}' has been {$this->status}.")
            ->action('View Dashboard', url('/dashboard'))
            ->line('Thank you for using our library system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Your request to borrow '{$this->bookTitle}' has been {$this->status}.",
            'book_title' => $this->bookTitle,
            'status' => $this->status,
        ];
    }
}
