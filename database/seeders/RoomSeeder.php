<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::create([
            'name' => 'Deluxe Ocean View',
            'type' => 'Deluxe',
            'price' => 150.00,
            'description' => 'Phòng nhìn ra biển, tiện nghi cao cấp',
            'image' => 'https://movenpickresortwaverlyphuquoc.com/wp-content/uploads/sites/227/2020/04/5.Superior-Twin-Seaview.jpg',
            'status' => 'available',
        ]);

        Room::create([
            'name' => 'Superior City View',
            'type' => 'Superior',
            'price' => 100.00,
            'description' => 'Phòng nhìn ra thành phố, đầy đủ tiện nghi',
            'image' => 'https://d2e5ushqwiltxm.cloudfront.net/wp-content/uploads/sites/79/2024/09/11113002/PSC-Corner-Room-2.jpg',
            'status' => 'available',
        ]);
    }
}
