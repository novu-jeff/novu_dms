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
use App\Services\AuditService; // ✅ added

class FileController extends Controller
{
    protected $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
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

            AuditService::log('Added File', 'File Uploaded: ' . ($documents->title ?? 'Untitled Document'));
    
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
        AuditService::log('Visited File Management', 'User viewed the files index page.');
        return response()->json($file);
    }

    public function update(FileUpdateRequest $request, File $file)
    {
        DB::beginTransaction();
        try {
            $data = $this->fileService->updateFile($file, $request->validated());
            DB::commit();

            AuditService::log('Update File', 'Update File: ' . ($data->title ?? 'Untitled Document'));
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
