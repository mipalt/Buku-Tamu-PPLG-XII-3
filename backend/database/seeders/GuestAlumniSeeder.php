<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestAlumni;
use App\Models\Purpose;

class GuestAlumniSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Ahmad Subarjo',
                'graduation_year' => 2010,
                'major' => 'PPLG',
                'phone' => '08123454321',
                'email' => 'ahmad@suburjayaabadi.co.id',
                'signature_path' => 'uploads/guest-alumni/ahmad.png',
                'purpose' => 'Bertemu dengan kaprog PPLG, untuk membahas kerja sama.',
            ],
            [
                'name' => 'Lina Hartati',
                'graduation_year' => 2012,
                'major' => 'RPL',
                'phone' => '08213456789',
                'email' => 'lina@teknonusantara.co.id',
                'signature_path' => 'uploads/guest-alumni/lina.png',
                'purpose' => 'Membahas peluang magang siswa.',
            ],
            [
                'name' => 'Dedi Gunawan',
                'graduation_year' => 2008,
                'major' => 'TKJ',
                'phone' => '08314567890',
                'email' => 'dedi@solusitech.co.id',
                'signature_path' => 'uploads/guest-alumni/dedi.png',
                'purpose' => 'Diskusi terkait rekrutmen alumni.',
            ],
        ];

        foreach ($data as $item) {
            $guest = GuestAlumni::create([
                'name' => $item['name'],
                'graduation_year' => $item['graduation_year'],
                'major' => $item['major'],
                'phone' => $item['phone'],
                'email' => $item['email'],
                'signature_path' => $item['signature_path'],
                'created_at' => now(),
            ]);

            Purpose::create([
                'purpose' => $item['purpose'],
                'visitor_id' => $guest->id,
                'guest_type' => GuestAlumni::class
            ]);
        }
    }
}
