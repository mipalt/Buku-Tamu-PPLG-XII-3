<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestAlumni;

class GuestAlumniController extends Controller
{
    public function index()
    {
        return response()->json(GuestAlumni::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'graduation_year' => 'required',
            'major' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'purpose' => 'required',
            'signature_path' => 'nullable|image',
        ]);

        if ($request->hasFile('signature_path')) {
            $filename = time() . '.' . $request->file('signature_path')->getClientOriginalExtension();
            $request->file('signature_path')->move(public_path('ttd_alumni'), $filename);
            $data['signature_path'] = 'ttd_alumni/' . $filename;
        }

        $alumni = GuestAlumni::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $alumni
        ], 201);
    }
}
