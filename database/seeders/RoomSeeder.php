<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = Building::all();
        foreach ($buildings as $b) {
            for ($i = 1; $i <= 3; $i++) {
                Room::updateOrCreate(
                    ['building_id' => $b->id, 'name' => 'Ruangan '.$i],
                    [
                        'code' => 'R-'.$i,
                        'latitude' => $b->latitude,
                        'longitude' => $b->longitude,
                    ]
                );
            }
        }
    }
}
