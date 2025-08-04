<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Parents;

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
        //
          $parent = Parents::create($request->validate([
            'name' => 'required|string|max:100',
            'student_name' => 'required|string|max:100',
            'rayon' => 'required|string|max:10',
            'address' => 'required|string|max:150',
            'phone' => 'required|number|max:20',
            'email' => 'nullable|email|unique:parents', 
            'purpose' => 'required|text',
            'signature_path' => 'required|string|max:150',
        ]));

        return response()->json($parent, 201);
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
