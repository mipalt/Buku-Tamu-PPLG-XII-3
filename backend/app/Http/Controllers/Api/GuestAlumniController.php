<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestAlumni;
use Illuminate\Support\Str;
use App\Service\ImageUploadService;
use Illuminate\Support\Facades\Storage;


class GuestAlumniController extends Controller
{
    public function index()
    {
        return response()->json(GuestAlumni::all());
    }

    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $data = $request->validate([
            'name' => 'required',
            'graduation_year' => 'required',
            'major' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'purpose' => 'required',
            'signature_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('signature_path')) {
            $uploadedPath = $imageUploadService->upload($request->file('signature_path'), 'guest-alumni');
            $data['signature_path'] = $uploadedPath;
        }

        $alumni = GuestAlumni::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $alumni
        ], 201);
    }

    public function update(Request $request, ImageUploadService $imageUploadService, $id)

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
            'signature_path' => 'sometimes|required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('signature_path')) {
            $uploadedPath = $imageUploadService->upload($request->file('signature_path'), 'guest-alumni');
            $data['signature_path'] = $uploadedPath;
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

        if ($alumni->signature_path && Storage::exists($alumni->signature_path)) {
            Storage::delete($alumni->signature_path);
        }

        $alumni->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus'
        ], 200);
    }
}
