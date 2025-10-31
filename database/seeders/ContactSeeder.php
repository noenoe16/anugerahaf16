<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'Emergency HSSE', 'email' => 'hsse@kpi.local', 'phone' => '+62 21 123456', 'whatsapp' => '+62 811 1111 111', 'address' => 'HSSE Office, RU VI Balongan'],
            ['name' => 'Control Room', 'email' => 'mcr@kpi.local', 'phone' => '+62 21 234567', 'whatsapp' => '+62 812 2222 222', 'address' => 'Main Control Room, RU VI Balongan'],
            ['name' => 'Maintenance', 'email' => 'maintenance@kpi.local', 'phone' => '+62 21 345678', 'whatsapp' => '+62 813 3333 333', 'address' => 'Maintenance Office, RU VI Balongan'],
        ];

        foreach ($items as $c) {
            Contact::updateOrCreate(['email' => $c['email']], $c);
        }
    }
}
