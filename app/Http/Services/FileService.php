<?php

namespace App\Http\Services;

use App\Models\File;
use App\Models\Document;
use App\Models\FileHistory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function __construct(
        protected StorageResolver $storageResolver
    ) {
    }

    public function uploadFile($file, $folder, $documentId)
    {
        $result = $this->storageResolver->storeWithFallback($file, $folder);
        $filePath = $result['path'];

        $fileSizeBytes = $file->getSize();
        $fileSizeReadable = $this->humanFilesize($fileSizeBytes);

        $originalName = $file->getClientOriginalName();
        $fileName = Str::lower($originalName);

        // Version control: allow same file name per document; assign next version number
        $nextVersion = (int) File::where('fileable_id', $documentId)
            ->where('fileable_type', Document::class)
            ->whereRaw('LOWER(file_name) = ?', [$fileName])
            ->max('file_version') + 1;
        $nextVersion = $nextVersion < 1 ? 1 : $nextVersion;

        return File::create([
            'fileable_id' => $documentId,
            'fileable_type' => Document::class,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'file_size' => $fileSizeReadable,
            'file_version' => $nextVersion,
            'uploaded_by' => auth()->id()
        ]);
    }

    public function updateFile($file, array $payload = [])
    {
        $this->saveFileHistory($file);

        // Set up for update
        $folder = $payload['folder'];

        $result = $this->storageResolver->storeWithFallback($payload['file'], $folder);
        $filePath = $result['path'];

        // Get the file size in bytes
        $fileSizeBytes = $this->storageResolver->size($filePath);

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
