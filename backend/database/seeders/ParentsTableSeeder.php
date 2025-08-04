<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('parents')->insert([
            [
                'name' => 'Budi Santoso',
                'student_name' => 'Andi Budi',
                'rayon' => 'C1',
                'address' => 'Jl. Melati No. 15',
                'phone' => '081234567890',
                'email' => 'budi@example.com',
                'purpose' => 'Ingin bertemu wali kelas untuk diskusi perkembangan anak.',
                'signature_path' => 'signatures/budi.png',
                'created_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'student_name' => 'Rina Siti',
                'rayon' => 'D3',
                'address' => 'Jl. Kenanga No. 20',
                'phone' => '081298765432',
                'email' => 'siti@example.com',
                'purpose' => 'Mengambil raport dan berdiskusi dengan guru BK.',
                'signature_path' => 'signatures/siti.png',
                'created_at' => now(),
            ],
            [
                'name' => 'Joko Widodo',
                'student_name' => 'Agus Joko',
                'rayon' => 'B2',
                'address' => 'Jl. Mawar No. 5',
                'phone' => '081277755599',
                'email' => 'joko@example.com',
                'purpose' => 'Memberikan informasi penting terkait kesehatan anak.',
                'signature_path' => 'signatures/joko.png',
                'created_at' => now(),
            ],
        ]);
    }
}
