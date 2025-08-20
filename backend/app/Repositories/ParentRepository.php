<?php

namespace App\Repositories;

use App\Models\Parents;
use Illuminate\Support\Facades\Schema;

class ParentRepository
{
    protected Parents $parent;

    public function __construct(Parents $parent)
    {
        $this->parent = $parent;
    }

    public function getAllParents(array $filters = [])
    {
        // $query = $this->parent->query();
         $query = $this->parent->with('purposes');

        // === Search ===
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('rayon', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('student_name', 'like', "%{$search}%");
            });
        }

        // === Sorting (hanya berdasarkan tanggal) ===
        $sortOrder = strtolower($filters['sortOrder'] ?? 'asc');
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        if (Schema::hasColumn($this->parent->getTable(), 'created_at')) {
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
