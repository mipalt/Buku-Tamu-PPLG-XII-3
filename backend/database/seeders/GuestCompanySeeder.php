<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestCompany;
use App\Models\Purpose;

class GuestCompanySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Ahmad Subarjo',
                'company_name' => 'PT. Subur Jaya Abadi',
                'phone' => '08123454321',
                'email' => 'ahmad@suburjayaabadi.co.id',
                'signature_path' => 'uploads/guest-company/ahmad.png',
                'purpose' => 'Bertemu dengan kaprog PPLG, untuk membahas kerja sama.',
            ],
            [
                'name' => 'Lina Hartati',
                'company_name' => 'CV. Teknologi Nusantara',
                'phone' => '08213456789',
                'email' => 'lina@teknonusantara.co.id',
                'signature_path' => 'uploads/guest-company/lina.png',
                'purpose' => 'Membahas peluang magang siswa.',
            ],
            [
                'name' => 'Dedi Gunawan',
                'company_name' => 'PT. Solusi Informatika',
                'phone' => '08314567890',
                'email' => 'dedi@solusitech.co.id',
                'signature_path' => 'uploads/guest-company/dedi.png',
                'purpose' => 'Diskusi terkait rekrutmen alumni.',
            ],
        ];

        foreach ($data as $item) {
            $company = GuestCompany::create([
                'name' => $item['name'],
                'company_name' => $item['company_name'],
                'phone' => $item['phone'],
                'email' => $item['email'],
                'signature_path' => $item['signature_path'],
            ]);

            Purpose::create([
                'purpose' => $item['purpose'],
                'visitor_id' => $company->id,
                'guest_type' => GuestCompany::class
            ]);
        }
    }
}