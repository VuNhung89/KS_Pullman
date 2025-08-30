<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::create([
            'user_id' => 2, // user thường
            'room_id' => 1, // Deluxe Ocean View
            'checkin_date' => '2025-09-01',
            'checkout_date' => '2025-09-05',
            'status' => 'confirmed',
        ]);
    }
}
