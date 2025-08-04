<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
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

        return ApiFormatter::sendSuccess('Data berhasil disimpan', $alumni);
    }

    public function show($id)
    {
        $alumni = GuestAlumni::find($id);

        if (!$alumni) {
            return ApiFormatter::sendNotFound('Data tidak ada');
        }

        return ApiFormatter::sendSuccess('Data berhasil diambil', $alumni);
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

    public function destroy($id, ImageUploadService $imageUploadService)
    {
        $alumni = GuestAlumni::find($id);

        if (!$alumni) {
            return  ApiFormatter::sendNotFound('Data tidak ditemukan');
        }

        if ($alumni->signature_path) {
            $imageUploadService->delete(($alumni->signature_path), 'guest-alumni');
        }

        $alumni->delete();

        return ApiFormatter::sendSuccess('Data berhasil dihapus');
    }
}
