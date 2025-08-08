<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parents;
use App\Models\Purpose;

class ParentsTableSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Budi Santoso',
                'student_name' => 'Andi Budi',
                'rayon' => 'C1',
                'address' => 'Jl. Melati No. 15',
                'phone' => '081234567890',
                'email' => 'budi@example.com',
                'signature_path' => 'uploads/signature_parent/budi.png',
                'purpose' => 'Ingin bertemu wali kelas untuk diskusi perkembangan anak.',
            ],
            [
                'name' => 'Siti Aminah',
                'student_name' => 'Rina Siti',
                'rayon' => 'D3',
                'address' => 'Jl. Kenanga No. 20',
                'phone' => '081298765432',
                'email' => 'siti@example.com',
                'signature_path' => 'uploads/signature_parent/siti.png',
                'purpose' => 'Mengambil raport dan berdiskusi dengan guru BK.',
            ],
            [
                'name' => 'Joko Widodo',
                'student_name' => 'Agus Joko',
                'rayon' => 'B2',
                'address' => 'Jl. Mawar No. 5',
                'phone' => '081277755599',
                'email' => 'joko@example.com',
                'signature_path' => 'uploads/signature_parent/joko.png',
                'purpose' => 'Memberikan informasi penting terkait kesehatan anak.',
            ],
        ];

        foreach ($data as $item) {
            $parent = Parents::create([
                'name' => $item['name'],
                'student_name' => $item['student_name'],
                'rayon' => $item['rayon'],
                'address' => $item['address'],
                'phone' => $item['phone'],
                'email' => $item['email'],
                'signature_path' => $item['signature_path'],
            ]);

            Purpose::create([
                'purpose' => $item['purpose'],
                'visitor_id' => $parent->id,
                'guest_type' => Parents::class,
            ]);
        }
    }
}
