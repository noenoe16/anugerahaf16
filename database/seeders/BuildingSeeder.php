<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Gedung Kolaboratif',
            'Gerbang Utama',
            'AWI',
            'Shelter Maintenance Area 1',
            'Shelter Maintenance Area 2',
            'Shelter Maintenance Area 3',
            'Shelter Maintenance Area 4',
            'Shelter White OM',
            'Pintu Masuk Area Kilang Pertamina',
            'Marine Region III Pertamina Balongan',
            'Main Control Room',
            'Tank Farm Area 1',
            'Gedung EXOR',
            'Area Produksi Crude Distillation Unit (CDU)',
            'HSSE Demo Room',
            'Gedung Amanah',
            'POC',
            'JGC',
        ];

        foreach ($names as $i => $name) {
            Building::updateOrCreate(
                ['name' => $name],
                [
                    'code' => Str::slug($name),
                    'latitude' => -6.4010000 + ($i * 0.0001),
                    'longitude' => 108.3690000 + ($i * 0.0001),
                    'address' => 'Kilang Pertamina Internasional RU VI Balongan',
                ]
            );
        }
    }
}
