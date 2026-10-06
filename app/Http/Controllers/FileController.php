<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileStoreRequest;
use App\Http\Requests\FileUpdateRequest;
use App\Http\Services\DocumentService;
use App\Http\Services\FileService;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Serve a file from storage (local or public disk). Used when file is in local disk
     * and not under public/storage (e.g. LIS ordinance/resolution file links).
     */
    public function serve(string $folder_id, string $filename)
    {
        $path = $folder_id . '/' . $filename;

        // Try default (local) disk first (where DMS stores uploads)
        $disk = config('filesystems.default');
        if (!Storage::disk($disk)->exists($path)) {
            // Fallback to public disk
            if (!Storage::disk('public')->exists($path)) {
                abort(404);
            }
            $disk = 'public';
        }

        $fullPath = Storage::disk($disk)->path($path);

        if (!is_file($fullPath) || !is_readable($fullPath)) {
            abort(404);
        }

        $mimeType = Storage::disk($disk)->mimeType($path) ?: 'application/octet-stream';

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($filename) . '"',
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

            if (Storage::disk(config('filesystems.default'))->exists($path)) {
                // Delete the file from the public disk
                Storage::disk(config('filesystems.default'))->delete($path);
            }

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
