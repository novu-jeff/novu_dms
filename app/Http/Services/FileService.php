<?php

namespace App\Http\Services;

use App\Models\File;
use App\Models\Document;
use App\Models\FileHistory;
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

        return File::create([
            'fileable_id' => $documentId,
            'fileable_type' => Document::class,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $fileSizeReadable,
            'uploaded_by' => auth()->id()
        ]);
    }

    public function updateFile($file, array $payload = [])
    {
        $this->saveFileHistory($file);

        // Set up for update
        $folder = $payload['folder'];

        $filePath = $payload['file']->store($folder, 'public');

        $fullFilePath = "public/" . $filePath;

        // Get the file size in bytes
        $fileSizeBytes = Storage::size($fullFilePath);

        // Convert file size to human-readable format
        $fileSizeReadable = $this->humanFilesize($fileSizeBytes);

        // Get the original name of the file
        $originalName = $payload['file']->getClientOriginalName();
        $fileName = Str::lower($originalName);

        $documentId = $payload['document'];

        $addVersion = $file->file_version + 1;

        // Update the file
        return tap($file->update([
            'fileable_id' => $documentId,
            'fileable_type' => Document::class,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $fileSizeReadable,
            'file_version' => $addVersion
        ]));
    }

    public function saveFileHistory($file)
    {
        // Save Old File To Logs
        $oldFileToSave = array_merge($file->toArray(), [
            'uploaded_at' => $file->created_at,
            'uploaded_by' => auth()->id(),
            'file_id' => $file->id
        ]);

        unset($oldFileToSave['id']);
        unset($oldFileToSave['created_at']);
        unset($oldFileToSave['updated_at']);

        FileHistory::create($oldFileToSave);
    }

    public function humanFilesize($bytes, $decimals = 2)
    {
        $size = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }
}
