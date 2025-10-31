<?php

namespace Database\Seeders;

use App\Models\Cctv;
use App\Models\Room;
use Illuminate\Database\Seeder;

class CctvSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::with('building')->get();
        $counter = 1;
        foreach ($rooms as $room) {
            for ($j = 1; $j <= 2; $j++) {
                $octet = str_pad((string) $counter, 3, '0', STR_PAD_LEFT);
                Cctv::updateOrCreate(
                    ['room_id' => $room->id, 'name' => 'CCTV '.$room->id.'-'.$j],
                    [
                        'building_id' => $room->building_id,
                        'ip_address' => "rtsp://admin:password.123@10.56.236.$octet/streaming/channels/",
                        'status' => 'offline',
                        'location_note' => optional($room->building)->name.' - '.$room->name,
                    ]
                );
                $counter++;
            }
        }
    }
}
