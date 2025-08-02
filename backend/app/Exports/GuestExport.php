<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\GuestParent;
use App\Models\GuestAlumni;
use App\Models\GuestVisitor;
use App\Models\GuestCompany;

class GuestExport implements FromCollection
{
    protected $type, $start, $end;

    public function __construct($type, $start = null, $end = null)
    {
        $this->type = $type;
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $model = match ($this->type) {
            'parents' => GuestParent::class,
            'alumni' => GuestAlumni::class,
            'visitors' => GuestVisitor::class,
            'companies' => GuestCompany::class,
        };

        $query = $model::query();

        if ($this->start && $this->end) {
            $query->whereBetween('created_at', [$this->start, $this->end]);
        }

        return $query->get();
    }
}

