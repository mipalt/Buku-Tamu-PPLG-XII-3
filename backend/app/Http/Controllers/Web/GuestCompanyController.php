<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ApiFormatter;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestCompany;
use App\Service\ImageUploadService;

class GuestCompanyController extends Controller
{
    public function index()
    {
        $companies = GuestCompany::all();

        if (!$companies || $companies->isEmpty()) {
            return ApiFormatter::sendNotFound('Guest company not found');
        }

        return ApiFormatter::sendSuccess('Guest companies retrieved successfully', $companies);
    }

    public function show($id)
    {
        $company = GuestCompany::find($id);

        if (!$company) {
            return ApiFormatter::sendNotFound('Guest company not found');
        }

        return ApiFormatter::sendSuccess('Guest company retrieved successfully', $company);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'company_name' => 'required|string|max:100',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:100',
                'purpose' => 'required|string|max:1000',
                'signature_path' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        } catch (\Exception $e) {
            return ApiFormatter::sendValidationError('Validation failed', $e->errors());
        }

        try {
            $signaturePath = null;

            if ($request->hasFile('signature_path')) {
                $signaturePath = ImageUploadService::upload($request->file('signature_path'), 'signature_company');
            }

            $company = GuestCompany::create([
                'name' => $validated['name'],
                'company_name' => $validated['company_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'purpose' => $validated['purpose'],
                'signature_path' => $signaturePath,
                'created_at' => now(),
            ]);

            return ApiFormatter::sendSuccess('Guest company saved successfully', $company);

        } catch (\Exception $e) {
            return ApiFormatter::sendServerError('Something went wrong', [
                'error' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'company_name' => 'required|string|max:100',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:100',
                'purpose' => 'required|string|max:1000',
                'signature_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);
        } catch (\Exception $e) {
            return ApiFormatter::sendValidationError('Validation failed', $e->errors());
        }

        try {
            $company = GuestCompany::find($id);

            if (!$company) {
                return ApiFormatter::sendNotFound('Guest company not found');
            }

            if ($request->hasFile('signature_path')) {
                // Opsional: hapus file lama jika perlu
                if ($company->signature_path && file_exists(public_path($company->signature_path))) {
                    unlink(public_path($company->signature_path));
                }

                $signaturePath = ImageUploadService::upload($request->file('signature_path'), 'signature_company');
                $company->signature_path = $signaturePath;
            }

            $company->name = $validated['name'];
            $company->company_name = $validated['company_name'];
            $company->phone = $validated['phone'];
            $company->email = $validated['email'] ?? null;
            $company->purpose = $validated['purpose'];
            $company->updated_at = now();

            $company->save();

            return ApiFormatter::sendSuccess('Guest company updated successfully', $company);
        } catch (\Exception $e) {
            return ApiFormatter::sendServerError('Something went wrong', [
                'error' => $e->getMessage()
            ]);
        }
    }

   public function destroy($id)
{
    try {
        $company = GuestCompany::find($id);

        if (!$company) {
            return ApiFormatter::sendNotFound('Guest company not found');
        }

        // Hapus file signature jika ada
        if ($company->signature_path && file_exists(public_path($company->signature_path))) {
            unlink(public_path($company->signature_path));
        }

        $company->delete();

        return ApiFormatter::sendSuccess('Guest company deleted successfully');
    } catch (\Exception $e) {
        return ApiFormatter::sendServerError('Something went wrong', [
            'error' => $e->getMessage()
        ]);
    }
}

}
