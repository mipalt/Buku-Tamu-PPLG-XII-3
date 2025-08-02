<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\GuestExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportDataController extends Controller
{
    public function export(Request $request)
    {
        // Validasi parameter
        $request->validate([
            'type' => 'required|in:parents,alumni,visitors,companies',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'format' => 'nullable|in:xlsx,csv'
        ]);

        // Ambil nilai dari query
        $type = $request->type;
        $start = $request->start_date;
        $end = $request->end_date;
        $format = $request->format ?? 'Xlsx';

        // Buat nama file
        $fileName = "guest_{$type}";
        if ($start && $end) {
            $fileName .= "_{$start}_to_{$end}";
        }
        $fileName .= ".{$format}";

        // Jalankan export
        return Excel::download(new GuestExport($type, $start, $end), $fileName, $format);
    }
}

