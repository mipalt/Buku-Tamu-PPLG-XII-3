<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use App\Models\Parents;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Parents::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'student_name' => 'required',
            'rayon' => 'required',
            'address' => 'required',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|unique:parents',
            'purpose' => 'required',
            'signature_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('signature_path')) {
            $uploadedPath = ImageUploadService::upload($request->file('signature_path'), 'parent');
            $data['signature_path'] = $uploadedPath;
        }

        $parent = Parents::create($data);

        return response()->json([
            'message' => 'Data berhasil disimpan',
            'data' => $parent
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
