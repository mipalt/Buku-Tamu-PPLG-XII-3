<?php

namespace App\Http\Controllers\web;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class GuestVisitorController extends Controller
{
    //
    public function index()
    {
        $visitors = Visitor::all();

        if ($visitors->isEmpty()) {
            return ApiFormatter::sendNotFound('No visitors found');
        }

        return ApiFormatter::sendSuccess('Visitors retrieved successfully', $visitors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitor = Visitor::find($id);

        if (!$visitor) {
            return ApiFormatter::sendNotFound('Visitor not found');
        }

        return ApiFormatter::sendSuccess('Visitor retrieved successfully', $visitor);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'institution' => 'nullable|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'purpose' => 'required|string',
            'signature_path' => 'required|image|max:2048'
        ]);

        // Upload tanda tangan ke folder "uploads/signatures"
        $validated['signature_path'] = ImageUploadService::upload($request->file('signature_path'), 'signatures');
        $validated['created_at'] = now();

        $visitor = Visitor::create($validated);

        return ApiFormatter::sendSuccess('Data successfully created!', $visitor);
    }
     public function update(Request $request, $id)
    {
        $visitor = Visitor::find($id);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'institution' => 'nullable|string|max:100',
            'phone' => 'sometimes|required|string|max:20',
            'email' => 'nullable|email|max:100',
            'purpose' => 'sometimes|required|string',
            'signature_path' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('signature_path')) {
            // Hapus file lama
            ImageUploadService::delete($visitor->signature_path);

            // Upload baru
            $validated['signature_path'] = ImageUploadService::upload($request->file('signature_path'), 'signatures');
        }

        $visitor->update($validated);

        return ApiFormatter::sendSuccess('Data successfully updated!', $visitor);
    }
    public function destroy($id)
    {
        $visitor = Visitor::find($id);

        if (!$visitor) {
            return response()->json(['message' => 'Visitor not found'], 404);
        }

        ImageUploadService::delete($visitor->signature_path);

        $visitor->delete();

        return ApiFormatter::sendSuccess('Data successfully deleted!');
    }
}
