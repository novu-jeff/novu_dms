<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Services\DocumentService;
use App\Http\Services\FileService;
use App\Http\Services\StorageResolver;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct(
        protected FileService $fileService,
        protected StorageResolver $storageResolver
    ) {
    }

    /**
     * Serve a file from storage (local, public, or S3). When FILESYSTEM_DISK=s3, streams from S3 or local fallback.
     */
    public function serve(string $folder_id, string $filename)
    {
        $folder_id = preg_replace('/[^0-9a-zA-Z_-]/', '', $folder_id);
        $filename = basename($filename);
        if ($filename === '' || str_contains($filename, '..')) {
            abort(404);
        }

        $path = $folder_id . '/' . $filename;
        $diskName = $this->storageResolver->getDiskForReading($path);
        if ($diskName === null && Storage::disk('public')->exists($path)) {
            $fullPath = Storage::disk('public')->path($path);
            if (is_file($fullPath) && is_readable($fullPath)) {
                $mimeType = \Illuminate\Support\Facades\File::mimeType($fullPath) ?: 'application/octet-stream';
                return response()->file($fullPath, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                ]);
            }
        }
        if ($diskName === null) {
            $localRoot = storage_path('app');
            $directPath = $localRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
            if (is_file($directPath) && is_readable($directPath)) {
                $mimeType = \Illuminate\Support\Facades\File::mimeType($directPath) ?: 'application/octet-stream';
                return response()->file($directPath, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"',
                ]);
            }
            abort(404);
        }

        // Stream from disk (S3 or local)
        $disk = Storage::disk($diskName);
        try {
            $mimeType = $disk->mimeType($path) ?: 'application/octet-stream';
        } catch (\Throwable $e) {
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $mimeType = $ext && class_exists(\Symfony\Component\Mime\MimeTypes::class)
                ? (\Symfony\Component\Mime\MimeTypes::getDefault()->getMimeTypes($ext)[0] ?? 'application/octet-stream')
                : 'application/octet-stream';
        }
        return response($disk->get($path), 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function store(FileStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            foreach ($request->file('file') as $file) {
                $this->fileService->uploadFile(
                    $file,
                    $request->folder,
                    $request->document
                );
            }

            DB::commit();
            return response()->json([
                'message' => 'File Uploaded'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => config('app.env') == 'local' ? $e->getMessage() : 'Server Error'
            ], 500);
        }
    }

    public function show(File $file)
    {
        return response()->json($file);
    }

    public function update(FileUpdateRequest $request, File $file)
    {
        DB::beginTransaction();
        try {
            $data = $this->fileService->updateFile($file, $request->validated());
            DB::commit();
            return response()->json([
                'data' => $data,
                'message' => 'File Deleted'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => config('app.env') == 'local' ? $e->getMessage() : 'Server Error'
            ], 500);
        }
    }

    public function destroy(File $file)
    {
        DB::beginTransaction();
        try {
            $id = $file->id;
            $path = $file->file_path;

            $this->storageResolver->delete($path);

            $file->delete();
            DB::commit();
            return response()->json([
                'id' => $id,
                'message' => 'File Deleted'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => config('app.env') == 'local' ? $e->getMessage() : 'Server Error'
            ], 500);
        }
    }
}
