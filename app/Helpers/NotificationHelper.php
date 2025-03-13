<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\AdminBookTransactionNotification;

class NotificationHelper
{
    public static function notifyAdmin($message)
    {
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new AdminBookTransactionNotification($message));
        }
    }
}
