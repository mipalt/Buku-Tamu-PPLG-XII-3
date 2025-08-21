<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
  public static function uploadBase64(string $base64Data, string $subfolder = ''): string
  {
    $folder = 'uploads/' . trim($subfolder, '/');
    $filename = Str::uuid() . '.png';

    $base64Data = preg_replace('/^data:image\/\w+;base64,/', '', $base64Data);

    $fileData = base64_decode($base64Data);

    Storage::disk('public')->put("$folder/$filename", $fileData);

    return "$folder/$filename";
  }


  public static function upload(UploadedFile $file, string $subfolder = ''): string
  {
    $folder = 'uploads/' . trim($subfolder, '/');
    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $filename = Str::slug($originalName) . Str::random(5) . now()->format('YmdHis')
      . '.' . $file->getClientOriginalExtension();

    return $file->storeAs($folder, $filename, 'public');
  }

  public static function delete(string $relativePath): void
  {
    Storage::disk('public')->delete($relativePath);
  }
}
