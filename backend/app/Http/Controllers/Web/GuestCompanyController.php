<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GuestCompany;
use App\Models\Purpose;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\DB;

class GuestCompanyController extends Controller
{
    public function index()
    {
        $companies = GuestCompany::with('purposes')->get();

        if ($companies->isEmpty()) {
            return ApiFormatter::sendNotFound('Guest company not found');
        }

        return ApiFormatter::sendSuccess('Guest companies retrieved successfully', $companies);
    }

    public function show($id)
    {
        $company = GuestCompany::with('purposes')->find($id);

        if (!$company) {
            return ApiFormatter::sendNotFound('Guest company not found');
        }

        return ApiFormatter::sendSuccess('Guest company retrieved successfully', $company);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'company_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'purpose' => 'required|string|max:1000',
            'signature_path' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $signaturePath = ImageUploadService::upload($request->file('signature_path'), 'signature_company');

            $company = GuestCompany::create([
                'name' => $validated['name'],
                'company_name' => $validated['company_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'signature_path' => $signaturePath,
                'created_at' => now(),
            ]);

            $company->purposes()->create([
                'purpose' => $validated['purpose'],
                'visitor_id' => $company->id,
                'guest_type' => GuestCompany::class,
                'created_at' => now(),
            ]);

            DB::commit();
            return ApiFormatter::sendSuccess('Guest company saved successfully', $company->load('purposes'));

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendServerError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'company_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'purpose' => 'required|string|max:1000',
            'signature_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $company = GuestCompany::find($id);
            if (!$company) {
                return ApiFormatter::sendNotFound('Guest company not found');
            }

            // Ganti signature jika ada
            if ($request->hasFile('signature_path')) {
                if ($company->signature_path && file_exists(public_path($company->signature_path))) {
                    unlink(public_path($company->signature_path));
                }
                $company->signature_path = ImageUploadService::upload($request->file('signature_path'), 'signature_company');
            }

            $company->update([
                'name' => $validated['name'],
                'company_name' => $validated['company_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'updated_at' => now(),
            ]);

            // Update atau buat purpose (asumsikan satu purpose per company)
            $company->purposes()->updateOrCreate(
                ['guest_type' => GuestCompany::class, 'visitor_id' => $company->id],
                ['purpose' => $validated['purpose']]
            );

            DB::commit();
            return ApiFormatter::sendSuccess('Guest company updated successfully', $company->load('purposes'));

        } catch (\Exception $e) {
            DB::rollBack();
            return ApiFormatter::sendServerError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $company = GuestCompany::with('purposes')->find($id);
            if (!$company) {
                return ApiFormatter::sendNotFound('Guest company not found');
            }

            // Hapus file signature
            if ($company->signature_path && file_exists(public_path($company->signature_path))) {
                unlink(public_path($company->signature_path));
            }

            // Hapus purposes-nya
            $company->purposes()->delete();

            $company->delete();

            return ApiFormatter::sendSuccess('Guest company deleted successfully');
        } catch (\Exception $e) {
            return ApiFormatter::sendServerError('Something went wrong', ['error' => $e->getMessage()]);
        }
    }
}
