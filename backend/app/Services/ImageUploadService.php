<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ImageUploadService
{
    protected $directory = 'uploads/alumni_signature';

    public function upload(UploadedFile $file): string
    {
        // Validasi MIME dan ukuran maksimum 2MB
        if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png'])) {
            throw ValidationException::withMessages([
                'signature_path' => 'File harus berupa JPG, JPEG, atau PNG.',
            ]);
        }

        if ($file->getSize() > 2 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'signature_path' => 'Ukuran file maksimal 2MB.',
            ]);
        }

        // Nama file aman
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = Str::slug($originalName);
        $filename = $safeName . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Simpan ke storage/app/uploads/alumni_signature
        $path = $file->storeAs($this->directory, $filename, 'public');

        return $path; // contoh: uploads/alumni_signature/namafile.jpg
    }
}
