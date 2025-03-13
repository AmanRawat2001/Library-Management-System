<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pending', 'borrowed', 'returned', 'pending_return'];

        for ($i = 0; $i < 100; $i++) {
            $visitor = User::where('role', 'visitor')->inRandomOrder()->first();

            if ($visitor) {
                $status = $statuses[array_rand($statuses)];
                $data = [
                    'user_id' => $visitor->id,
                    'book_id' => Book::inRandomOrder()->first()->id,
                    'status' => $status,
                ];

                if ($status === 'pending') {
                    $data['requested_at'] = now()->subDays(rand(1, 30));
                } elseif ($status === 'borrowed') {
                    $data['borrowed_at'] = now()->subDays(rand(1, 30));
                    $data['due_date'] = now()->addDays(10);
                } elseif ($status === 'pending_return') {
                    $data['return_requested_at'] = now()->subDays(rand(1, 30));
                } elseif ($status === 'returned') {
                    $data['returned_at'] = now()->subDays(rand(1, 30));
                }

                BookUser::create($data);
            }
        }
    }
}
