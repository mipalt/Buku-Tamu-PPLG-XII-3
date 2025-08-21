<?php

namespace Database\Seeders;

use App\Models\Purpose;
use App\Models\Visitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Budi Santoso',
                'institution' => 'Universitas Indonesia',
                'phone' => '081298765432',
                'email' => 'budi.santoso@ui.ac.id',
                'signature_path' => 'uploads/signature_visitor/budi.png',
                'purpose' => 'Menghadiri seminar teknologi.',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'institution' => 'SMA Negeri 1 Jakarta',
                'phone' => '081234567890',
                'email' => 'siti.nurhaliza@gmail.com',
                'signature_path' => 'uploads/signature_visitor/siti.png',
                'purpose' => 'Kunjungan studi banding.',
            ],
            [
                'name' => 'Andi Pratama',
                'institution' => 'Komunitas Programmer Indonesia',
                'phone' => '082112345678',
                'email' => 'andi.pratama@kpi.or.id',
                'signature_path' => 'uploads/signature_visitor/andi.png',
                'purpose' => 'Mengikuti workshop Laravel.',
            ],
        ];

        foreach ($data as $item) {
            $visitor = Visitor::create([
                'name' => $item['name'],
                'institution' => $item['institution'],
                'phone' => $item['phone'],
                'email' => $item['email'],
                'signature_path' => $item['signature_path'],
            ]);

            Purpose::create([
                'purpose' => $item['purpose'],
                'visitor_id' => $visitor->id,
                'guest_type' => Visitor::class
            ]);
        }
    }
}
