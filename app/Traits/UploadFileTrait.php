<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

trait UploadFileTrait
{
    public function uploadFileWithMedia($classType, $classId, $folderName, $file)
    {
        $original_extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $original_extension;
        $storePath = "images/" . $folderName . '/' . $filename;
        $contents = File::get($file);
        Storage::disk('public')->put($storePath, $contents);

        Media::create([
            "mediable_type" => $classType,
            "mediable_id" => $classId->id,
            "url" => asset(Storage::url($storePath))
        ]);
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file;
        $original_extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $original_extension;
        $storePath = "images/general/" . $filename;
        $contents = File::get($file);
        Storage::disk('public')->put($storePath, $contents);
        return asset(Storage::url($storePath));
    }
}
