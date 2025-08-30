<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'name' => 'Nguyen Van A',
            'email' => 'a@example.com',
            'message' => 'Xin chào, tôi muốn hỏi về phòng Deluxe.',
        ]);

        Contact::create([
            'name' => 'Tran Thi B',
            'email' => 'b@example.com',
            'message' => 'Khách sạn có dịch vụ đưa đón sân bay không?',
        ]);
    }
}
