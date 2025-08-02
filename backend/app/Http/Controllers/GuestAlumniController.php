<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestAlumni;

class GuestAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guest_alumni.guest');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $data = $request->validate([
            'name' => 'required',
            'graduation_year' => 'required',
            'major' => 'required',
            'phone' => 'required',
            'email' => 'nullable|email',
            'purpose' => 'required',
            'signature_path' => 'nullable|image', // boleh kosong
        ]);

            $phone = $data['phone'];
            $phone = preg_replace('/^\+?62+/', '', $phone); // buang +62 di depan jika ada
            $data['phone'] = '+62' . $phone;

        if ($request->hasFile('signature_path')) {
            $filename = time() . '.' . $request->file('signature_path')->getClientOriginalExtension();
            $request->file('signature_path')->move(public_path('ttd_alumni'), $filename);
            $data['signature_path'] = 'ttd_alumni/' . $filename;
        }

        GuestAlumni::create($data);

        return redirect()->back()->with('success', 'Berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
