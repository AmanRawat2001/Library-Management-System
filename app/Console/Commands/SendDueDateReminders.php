<?php

namespace App\Console\Commands;

use App\Mail\DueDateReminderMail;
use App\Models\User;
use App\Notifications\DueDateReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendDueDateReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:due-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email &  notifications for books due soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dueSoon = Carbon::now()->addDays(2);

        $users = User::whereHas('books', function ($query) use ($dueSoon) {
            $query->where('status', 'borrowed')->where('due_date', '<=', $dueSoon);
        })->get();

        foreach ($users as $user) {
            foreach ($user->books()->wherePivot('status', 'borrowed')->wherePivot('due_date', '<=', $dueSoon)->get() as $book) {
                // for the email only
                // Mail::to($user->email)->send(new DueDateReminderMail($user, $book, $book->pivot->due_date));
                // for the notification  and email
                $user->notify(new DueDateReminderNotification($book, $book->pivot->due_date));
            }
        }
        $this->info('Due date reminder emails sent successfully.');

    }
}
