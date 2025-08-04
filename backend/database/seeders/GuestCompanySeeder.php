<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuestCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('guest_companies')->insert([
            'name' => 'Ahmad Subarjo',
            'company_name' => 'PT. Subur Jaya Abadi',
            'phone' => '08123454321',
            'email' => 'ahmad@suburjayaabadi.co.id',
            'purpose' => 'Bertemu dengan kaprog PPLG, untuk membahas kerja sama.',
            'signature_path' => 'uploads/signature_company/minyak.png',
            'created_at' => now(),
        ]);
    }
}
