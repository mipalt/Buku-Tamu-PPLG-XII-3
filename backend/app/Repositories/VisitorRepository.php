<?php

namespace App\Repositories;

use App\Models\Visitor;
use Illuminate\Support\Facades\Schema;

class VisitorRepository
{
    protected Visitor $visitor;

    public function __construct(Visitor $visitor)
    {
        $this->visitor = $visitor;
    }

    public function getAllVisitor(array $filters = [])
    {
        // $query = $this->parent->query();
         $query = $this->visitor->with('purposes');

        // === Search ===
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // === Sorting (hanya berdasarkan tanggal) ===
        $sortOrder = strtolower($filters['sortOrder'] ?? 'asc');
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        if (Schema::hasColumn($this->visitor->getTable(), 'created_at')) {
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