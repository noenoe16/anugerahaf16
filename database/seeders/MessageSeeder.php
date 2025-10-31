<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::take(3)->get();
        if ($users->count() >= 2) {
            $a = $users[0];
            $b = $users[1];
            Message::updateOrCreate(
                ['sender_id' => $a->id, 'receiver_id' => $b->id, 'content' => 'Halo, ini pesan awal.'],
                []
            );
            Message::updateOrCreate(
                ['sender_id' => $b->id, 'receiver_id' => $a->id, 'content' => 'Halo, pesan diterima.'],
                []
            );
        }
    }
}
