<?php

namespace App\Http\Controllers\web;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Purpose;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestVisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::with('purposes')->get();

        if ($visitors->isEmpty()) {
            return ApiFormatter::sendNotFound('No visitors found');
        }

        return ApiFormatter::sendSuccess('Visitors retrieved successfully', $visitors);
    }

    public function show($id)
    {
        $visitor = Visitor::with('purposes')->find($id);

        if (!$visitor) {
            return ApiFormatter::sendNotFound('Visitor not found');
        }

        return ApiFormatter::sendSuccess('Visitor retrieved successfully', $visitor);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:100',
            'institution'    => 'nullable|string|max:100',
            'phone'          => 'required|string|max:20',
            'email'          => 'nullable|email|max:100',
            'purpose'        => 'required|string|max:1000',
            'signature_path' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Upload tanda tangan
            $validated['signature_path'] = ImageUploadService::upload(
                $request->file('signature_path'),
                'signatures'
            );

            // Simpan ke guest_visitors
            $guestVisitor = Visitor::create([
                'name'           => $validated['name'],
                'institution'    => $validated['institution'] ?? null,
                'phone'          => $validated['phone'],
                'email'          => $validated['email'] ?? null,
                'signature_path' => $validated['signature_path'],
                'created_at'     => now(),
            ]);

            // Simpan purpose ke tabel purposes (relasi polimorfik)
            $guestVisitor->purposes()->create([
                'purpose' => $validated['purpose'],
                'visitor_id' => $guestVisitor->id,
                'guest_type' => Visitor::class,
                'created_at' => now(),
            ]);

            DB::commit();

            return ApiFormatter::sendSuccess('Data successfully created!', $guestVisitor->load('purposes'));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendError('Failed to create data', $e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name'           => 'sometimes|required|string|max:100',
            'institution'    => 'nullable|string|max:100',
            'phone'          => 'sometimes|required|string|max:20',
            'email'          => 'nullable|email|max:100',
            'purpose'        => 'sometimes|required|string',
            'signature_path' => 'nullable|image|max:2048'
        ]);

        DB::beginTransaction();
        try {

            $guestVisitor = Visitor::find($id);
            if (!$guestVisitor) {
                return ApiFormatter::sendNotFound('Visitor not found');
            }

            // Update file tanda tangan
            if ($request->hasFile('signature_path')) {
                if ($guestVisitor->signature_path) {
                    ImageUploadService::delete($guestVisitor->signature_path);
                }
                $guestVisitor->signature_path = ImageUploadService::upload($request->file('signature_path'), 'signature_company');
            }

            // Update guest_visitors
            $guestVisitor->update([
                'name'           => $validated['name'] ?? $guestVisitor->name,
                'institution'    => $validated['institution'] ?? $guestVisitor->institution,
                'phone'          => $validated['phone'] ?? $guestVisitor->phone,
                'email'          => $validated['email'] ?? $guestVisitor->email,
                'updated_at'     => now(),
            ]);

            $guestVisitor->purposes()->updateOrCreate([
                ['guest_type' => Visitor::class, 'visitor_id' => $guestVisitor->id],
                ['purpose' => $validated['purpose'] ?? $guestVisitor->purposes->first()->purpose ?? null]
            ]);
                

            DB::commit();
            return ApiFormatter::sendSuccess('Data successfully updated!', $guestVisitor->load('purposes'));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendError('Failed to update data', $e->getMessage(), 500);
        }
    }

    public function destroy($id)
    {
        try {
            $guestVisitor = Visitor::with('purposes')->find($id);
            if (!$guestVisitor) {
                return ApiFormatter::sendNotFound('Visitor not found');
            }

            // Hapus tanda tangan jika ada
            if ($guestVisitor->signature_path) {
                ImageUploadService::delete($guestVisitor->signature_path);
            }

            // Hapus relasi purposes
            $guestVisitor->purposes()->delete();

            // Hapus data visitor
            $guestVisitor->delete();

            return ApiFormatter::sendSuccess('Data successfully deleted!');
        } catch (\Exception $e) {
            return ApiFormatter::sendError('Something went wrong', ['error' => $e->getMessage()], 500);
        }
    }
}
