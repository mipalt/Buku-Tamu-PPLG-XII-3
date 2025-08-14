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
        $request->validate([
            'type' => 'required|in:parents,alumni,visitors,companies',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'format' => 'nullable|in:Xlsx,Csv'
        ]);

        $type = $request->input('type');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $format = $request->input('format', 'Xlsx');

        $fileName = "guest_{$type}";
        if ($start && $end) {
            $fileName .= "_{$start}_to_{$end}";
        }
        $fileName .= ".{$format}";

        return Excel::download(new GuestExport($type, $start, $end), $fileName, $format);
    }
}
