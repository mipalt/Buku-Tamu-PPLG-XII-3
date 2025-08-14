<?php

namespace App\Repositories;

use App\Models\GuestAlumni;
use Illuminate\Support\Facades\Schema;

class GuestAlumniRepository
{
    protected GuestAlumni $alumni;

    public function __construct(GuestAlumni $alumni)
    {
        $this->alumni = $alumni;
    }

    public function getAllGuestAlumni(array $filters = ["name", "graduation_year", "major", "phone", "email"])
    {
        $query = $this->alumni->query();

        // === Search ===
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('graduation_year', 'like', "%{$search}%")
                ->orWhere('major', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // === Sorting (hanya berdasarkan tanggal) ===
        $sortOrder = strtolower($filters['sortOrder'] ?? 'asc');
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        if (Schema::hasColumn($this->alumni->getTable(), 'created_at')) {
            $query->orderBy('created_at', $sortOrder);
        }

        // === Pagination & Limit ===
        $limit = (int) ($filters['limit'] ?? 10);
        if ($limit < 1) {
            $limit = 10;
        }
        $limit = min($limit, 100); // batas maksimum untuk keamanan

        // Laravel otomatis ambil "page" dari query string
        return $query->paginate($limit);
    }
}
