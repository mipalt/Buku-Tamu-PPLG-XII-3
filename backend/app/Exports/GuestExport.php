<?php

namespace App\Exports;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestExport implements FromCollection, WithHeadings
{
    protected $type, $start, $end;

    protected $typeMap = [
        'parents'   => ['table' => 'parents',   'model' => \App\Models\Parents::class],
        'alumni'    => ['table' => 'guest_alumni',    'model' => \App\Models\GuestAlumni::class],
        'visitors'  => ['table' => 'guest_visitors',  'model' => \App\Models\Visitor::class],
        'companies' => ['table' => 'guest_companies', 'model' => \App\Models\GuestCompany::class],
    ];

    public function __construct($type, $start = null, $end = null)
    {
        $this->type  = $type;
        $this->start = $start;
        $this->end   = $end;
    }

    public function collection()
    {
        if (!isset($this->typeMap[$this->type])) {
            return collect([]);
        }

        $table = $this->typeMap[$this->type]['table'];
        $modelClass = $this->typeMap[$this->type]['model'];

        $query = DB::table($table)
            ->leftJoin('purposes', function ($join) use ($table, $modelClass) {
                $join->on('purposes.visitor_id', '=', $table . '.id')
                     ->where('purposes.guest_type', '=', $modelClass);
            })
            ->select($table . '.*', 'purposes.purpose as purpose_name');

        if ($this->start && $this->end) {
            $query->whereBetween($table . '.created_at', [$this->start, $this->end]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        if (!isset($this->typeMap[$this->type])) {
            return [];
        }

        $table = $this->typeMap[$this->type]['table'];

        return array_merge(
            Schema::getColumnListing($table),
            ['purpose']
        );
    }
}
