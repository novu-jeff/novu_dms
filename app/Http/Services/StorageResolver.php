<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Resolves storage disk with S3 + local fallback when FILESYSTEM_DISK=s3.
 * - Writes: try S3 first, fall back to local on failure.
 * - Reads: check S3 first, then local.
 * - Delete: when default is S3, delete from both S3 and local.
 */
class StorageResolver
{
    public function defaultDisk(): string
    {
        return config('filesystems.default');
    }

    public function useS3WithFallback(): bool
    {
        return $this->defaultDisk() === 's3';
    }

    /**
     * Get the disk that actually has the file (for reading). When default is S3, checks S3 then local.
     */
    public function getDiskForReading(string $path): ?string
    {
        $default = $this->defaultDisk();
        if ($default === 's3') {
            if (Storage::disk('s3')->exists($path)) {
                return 's3';
            }
            if (Storage::disk('local')->exists($path)) {
                return 'local';
            }
            return null;
        }
        return Storage::disk($default)->exists($path) ? $default : null;
    }

    /**
     * Store an uploaded file with fallback: when default is S3, try S3 then local.
     * Returns the stored path (relative) and the disk used.
     */
    public function storeWithFallback(UploadedFile $file, string $folder): array
    {
        $default = $this->defaultDisk();
        if ($default === 's3') {
            try {
                $path = $file->store($folder, 's3');
                if ($path !== false) {
                    return ['path' => $path, 'disk' => 's3'];
                }
            } catch (\Throwable $e) {
                // Fallback to local
            }
            $path = $file->store($folder, 'local');
            return ['path' => $path, 'disk' => 'local'];
        }
        $path = $file->store($folder, $default);
        return ['path' => $path, 'disk' => $default];
    }

    /**
     * Delete from storage. When default is S3, deletes from both S3 and local.
     */
    public function delete(string $path): void
    {
        if ($this->useS3WithFallback()) {
            try {
                Storage::disk('s3')->delete($path);
            } catch (\Throwable $e) {
                // ignore
            }
            try {
                Storage::disk('local')->delete($path);
            } catch (\Throwable $e) {
                // ignore
            }
            return;
        }
        Storage::disk($this->defaultDisk())->delete($path);
    }

    /**
     * Get file size. Uses the disk that has the file when default is S3.
     */
    public function size(string $path): int
    {
        $diskName = $this->getDiskForReading($path);
        if ($diskName === null) {
            throw new \RuntimeException("File not found: {$path}");
        }
        return Storage::disk($diskName)->size($path);
    }
}
