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
    public function update(Request $request, $id)
{
    $alumni = GuestAlumni::findOrFail($id);

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
        if ($alumni->signature_path && file_exists(public_path($alumni->signature_path))) {
            unlink(public_path($alumni->signature_path));
        }
        $filename = time() . '.' . $request->file('signature_path')->getClientOriginalExtension();
        $request->file('signature_path')->move(public_path('ttd_alumni'), $filename);
        $data['signature_path'] = 'ttd_alumni/' . $filename;
    }

    $alumni->update($data);

    return response()->json([
        'message' => 'Data berhasil diperbarui',
        'data' => $alumni
    ], 200);
}

public function destroy($id)
{
    $alumni = GuestAlumni::findOrFail($id);
    if ($alumni->signature_path && file_exists(public_path($alumni->signature_path))) {
        unlink(public_path($alumni->signature_path));
    }

    $alumni->delete();

    return response()->json([
        'message' => 'Data berhasil dihapus'
    ], 200);
}
}
