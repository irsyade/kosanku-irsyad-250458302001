<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $lokasi = [
            'Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Bali',
            'Semarang', 'Bogor', 'Depok', 'Bekasi', 'Medan',
            'Malang', 'Makassar', 'Tangerang', 'Solo', 'Padang'
        ];

        for ($i = 1; $i <= 20; $i++) {
            $kota = $lokasi[array_rand($lokasi)];

            Room::create([
                'owner_id'      => 1, // pastikan user dengan ID 1 ada di database
                'name'          => 'Kamar Kost ' . $i . ' di ' . $kota,
                'address'       => $kota . ', Indonesia',
                'description'   => 'Kamar kost yang nyaman, bersih, dan strategis di daerah ' 
                                    .  $kota . '. Cocok untuk mahasiswa atau pekerja.',
                'price'         => rand(500000, 2500000),
                'capacity'      => rand(1, 4),
                'status'        => 'active',
                'is_available'  => true,
                'image'         => 'rooms/default.png', 
            ]);
        }
    }
}
