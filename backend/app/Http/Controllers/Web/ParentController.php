<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Parents;
use App\Models\Purpose;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParentController extends Controller
{
 public function index()
 {
  $parents = Parents::with('purposes')->get();

  if ($parents->isEmpty()) {
   return ApiFormatter::sendNotFound('Data orang tua tidak ditemukan');
  }

  return ApiFormatter::sendSuccess('Data berhasil ditemukan', $parents);
 }

 public function store(Request $request)
 {
  $data = $request->validate([
   'name' => 'required|string',
   'student_name' => 'required|string',
   'rayon' => 'required|string',
   'address' => 'required|string',
   'phone' => 'required|string|max:20|unique:parents,phone',
   'email' => 'nullable|email|unique:parents',
   'purpose' => 'required|string|max:1000',
   'signature_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
  ]);

  DB::beginTransaction();

  try {
   if ($request->hasFile('signature_path')) {
    $data['signature_path'] = ImageUploadService::upload(
     $request->file('signature_path'),
     'guest-parent'
    );
   }

   $parent = Parents::create($data);

   $parent->purposes()->create([
    'purpose' => $data['purpose'],
    'visitor_id' => $parent->id,
    'guest_type' => Parents::class,
   ]);

   DB::commit();

   return ApiFormatter::sendSuccess('Data berhasil disimpan', $parent->load('purposes'));
  } catch (\Exception $e) {
   DB::rollBack();
   return ApiFormatter::sendServerError('Terjadi kesalahan', ['error' => $e->getMessage()]);
  }
 }

 public function show(string $id)
 {
  $parent = Parents::with('purposes')->find($id);

  if (!$parent) {
   return ApiFormatter::sendNotFound('Data orang tua tidak ditemukan');
  }

  if ($parent->signature_path) {
   $parent->signature_path = asset($parent->signature_path);
  }

  return ApiFormatter::sendSuccess('Data berhasil ditemukan', $parent);
 }

 public function update(Request $request, string $id)
 {
  $parent = Parents::find($id);

  if (!$parent) {
   return ApiFormatter::sendNotFound('Data orang tua tidak ditemukan');
  }

  $data = $request->validate([
   'name' => 'sometimes|string',
   'student_name' => 'sometimes|string',
   'rayon' => 'sometimes|string',
   'address' => 'sometimes|string',
   'phone' => 'sometimes|string|max:20|unique:parents,phone,' . $id,
   'email' => 'nullable|email|unique:parents,email,' . $id,
   'purpose' => 'sometimes|string|max:1000',
   'signature_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
  ]);

  DB::beginTransaction();

  try {
   if ($request->hasFile('signature_path')) {
    if ($parent->signature_path) {
     ImageUploadService::delete($parent->signature_path);
    }

    $data['signature_path'] = ImageUploadService::upload(
     $request->file('signature_path'),
     'guest-parent'
    );
   }

   $parent->update($data);

   if (isset($data['purpose'])) {
    $parent->purposes()->updateOrCreate(
     ['visitor_id' => $parent->id, 'guest_type' => Parents::class],
     ['purpose' => $data['purpose']]
    );
   }

   DB::commit();

   return ApiFormatter::sendSuccess('Data berhasil diperbarui', $parent->load('purposes'));
  } catch (\Exception $e) {
   DB::rollBack();
   return ApiFormatter::sendServerError('Gagal memperbarui data', ['error' => $e->getMessage()]);
  }
 }

 public function destroy(string $id)
 {
  $parent = Parents::with('purposes')->find($id);

  if (!$parent) {
   return ApiFormatter::sendNotFound('Data orang tua tidak ditemukan');
  }

  DB::beginTransaction();

  try {
   if ($parent->signature_path) {
    ImageUploadService::delete($parent->signature_path);
   }

   $parent->purposes()->delete();
   $parent->delete();

   DB::commit();

   return ApiFormatter::sendSuccess('Data berhasil dihapus');
  } catch (\Exception $e) {
   DB::rollBack();
   return ApiFormatter::sendServerError('Gagal menghapus data', ['error' => $e->getMessage()]);
  }
 }
}
