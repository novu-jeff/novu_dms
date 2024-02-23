<?php

namespace App\Http\Services;

use App\Models\File;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function uploadFile($file, $folder, $documentId)
    {
        $filePath = $file->store($folder, 'public');

        $fullFilePath = "public/" . $filePath;

        // Get the file size in bytes
        $fileSizeBytes = Storage::size($fullFilePath);

        // Convert file size to human-readable format
        $fileSizeReadable = $this->humanFilesize($fileSizeBytes);

        // Get the original name of the file
        $originalName = $file->getClientOriginalName();
        $fileName = Str::lower($originalName);

        File::create([
            'fileable_id' => $documentId,
            'fileable_type' => Document::class,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $fileSizeReadable
        ]);
    }

    public function updateFile(array $payload = [], $file)
    {
        // TODO: Add the old version to logs
        $id = $file->id;
        $path = $file->file_path;

        // FileLogs::create([]);

        // Set up for update
        $folder = $payload['folder'];

        $filePath = $payload['file']->store($folder, 'public');

        $fullFilePath = "public/" . $filePath;

        // Get the file size in bytes
        $fileSizeBytes = Storage::size($fullFilePath);

        // Convert file size to human-readable format
        $fileSizeReadable = $this->humanFilesize($fileSizeBytes);

        // Get the original name of the file
        $originalName = $file->getClientOriginalName();
        $fileName = Str::lower($originalName);

        $documentId = $payload['document'];

        // Update the file
        $file->update([
            'fileable_id' => $documentId,
            'fileable_type' => Document::class,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $fileSizeReadable
        ]);
    }

    public function humanFilesize($bytes, $decimals = 2)
    {
        $size = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }
}
