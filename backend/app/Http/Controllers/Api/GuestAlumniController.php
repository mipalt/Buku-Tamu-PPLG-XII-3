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
        $alumni = GuestAlumni::find($id);

        if (!$alumni) {
            return response()->json(['message' => 'data tidak ditemukan'], 404);
        }

        $data = $request->validate([ //ini validasi data
            'name' => 'sometimes|required',
            'graduation_year' => 'sometimes|required',
            'major' => 'sometimes|required',
            'phone' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'purpose' => 'sometimes|required',
            'signature_path' => 'nullable|image',
        ]);

        if ($request->hasFile('signature_path')) {
            try {
                if ($alumni->signature_path && file_exists(public_path($alumni->signature_path))) {
                    unlink(public_path($alumni->signature_path));
                }

                $filename = time() . '.' . $request->file('signature_path')->getClientOriginalExtension();
                $request->file('signature_path')->move(public_path('ttd_alumni'), $filename);
                $data['signature_path'] = 'ttd_alumni/' . $filename;
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error saat upload file',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }

        $alumni->update($data);

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $alumni->fresh() // ini akan ambil ulang data dari database
        ], 200);
    }

    public function destroy($id)
    {
        $alumni = GuestAlumni::find($id);
        if (!$alumni) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($alumni->signature_path && file_exists(public_path($alumni->signature_path))) {
            unlink(public_path($alumni->signature_path));
        }
        $alumni->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
