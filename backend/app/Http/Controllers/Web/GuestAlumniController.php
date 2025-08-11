<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use App\Helpers\PaginationFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\GuestAlumniRepository;
use App\Models\GuestAlumni;
use Illuminate\Support\Facades\DB;
use App\Services\ImageUploadService;


class GuestAlumniController extends Controller
{
     protected $alumniRepo;

    public function __construct(GuestAlumniRepository $alumniRepo)
    {
        $this->alumniRepo = $alumniRepo;
    }

    public function index(Request $request)
{
    $filters = $request->only(['search', 'limit', 'sortOrder', 'page']);

    $alumni = $this->alumniRepo->getAllGuestAlumni($filters);

    if ($alumni->isEmpty()) {
        return ApiFormatter::sendNotFound('Guest alumni not found');
    }

    return ApiFormatter::sendSuccess(
        'Guest alumni retrieved successfully',
        $alumni,
        200,
        ['pagination' => PaginationFormatter::format($alumni)]
    );
}


    public function show($id)
    {
        $alumni = GuestAlumni::with('purposes')->find($id);

        if (!$alumni) {
            return ApiFormatter::sendNotFound('Guest alumni not found');
        }

        return ApiFormatter::sendSuccess('Guest alumni retrieved successfully', $alumni);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'graduation_year' => 'required|integer',
            'major' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:guest_alumni,phone',
            'email' => 'required|email|max:100|unique:guest_alumni,email',
            'purpose' => 'required|string|max:1000',
            'signature_path' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $signaturePath = ImageUploadService::upload($request->file('signature_path'), 'guest-alumni');

            $alumni = GuestAlumni::create([
                'name' => $validated['name'],
                'graduation_year' => $validated['graduation_year'],
                'major' => $validated['major'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'signature_path' => $signaturePath,
                'created_at' => now(),
            ]);

            $alumni->purposes()->create([
                'purpose' => $validated['purpose'],
                'visitor_id' => $alumni->id,
                'guest_type' => GuestAlumni::class,
                'created_at' => now(),
            ]);

            DB::commit();
            return ApiFormatter::sendSuccess('Guest alumni saved successfully', $alumni->load('purposes'));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendServerError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'graduation_year' => 'required|integer',
            'major' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:guest_alumni,phone,' . $id,
            'email' => 'required|email|max:100|unique:guest_alumni,email,' . $id,
            'purpose' => 'required|string|max:1000',
            'signature_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $alumni = GuestAlumni::find($id);
            if (!$alumni) {
                return ApiFormatter::sendNotFound('Guest alumni not found');
            }

            if ($request->hasFile('signature_path')) {
                if ($alumni->signature_path) {
                    $imageUploadService->delete(($alumni->signature_path));
                }
                $alumni->signature_path = ImageUploadService::upload($request->file('signature_path'), 'guest-alumni');
            }

            $alumni->update([
                'name' => $validated['name'],
                'graduation_year' => $validated['graduation_year'],
                'major' => $validated['major'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'updated_at' => now(),
            ]);

            $alumni->purposes()->updateOrCreate(
                ['guest_type' => GuestAlumni::class, 'visitor_id' => $alumni->id],
                ['purpose' => $validated['purpose']]
            );

            DB::commit();
            return ApiFormatter::sendSuccess('Guest alumni updated successfully', $alumni->load('purposes'));
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendServerError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    public function destroy($id, ImageUploadService $imageUploadService)
    {
        DB::beginTransaction();

        try {
            $alumni = GuestAlumni::with('purposes')->find($id);
            if (!$alumni) {
                return ApiFormatter::sendNotFound('Guest alumni not found');
            }

            if ($alumni->signature_path) {
                $imageUploadService->delete(($alumni->signature_path));
            }

            $alumni->purposes()->delete();
            $alumni->delete();

            DB::commit();
            return ApiFormatter::sendSuccess('Guest alumni deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendServerError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }
}
