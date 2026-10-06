<?php

namespace App\Http\Controllers;

use App\Http\Services\StorageResolver;
use App\Models\File;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentFinderController extends Controller
{
    public function __construct(
        protected StorageResolver $storageResolver
    ) {
    }
    public function index(Request $request)
    {
        $search = $request->search;
        $documents = Document::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%')
                ->orWhereMonth('created_at', '=', $search)
                ->orWhereYear('created_at', '=', $search)
                ->orWhereHas('branch', function ($branchQuery) use ($search) {
                    $branchQuery->where('description', 'like', '%' . $search . '%');
                })
                ->orWhereHas('department', function ($departmentQuery) use ($search) {
                    $departmentQuery->where('description', 'like', '%' . $search . '%');
                })
                ->orWhereHas('division', function ($divisionQuery) use ($search) {
                    $divisionQuery->where('description', 'like', '%' . $search . '%');
                })
                ->orWhereHas('section', function ($sectionQuery) use ($search) {
                    $sectionQuery->where('description', 'like', '%' . $search . '%');
                });
        })
        ->with('files')
        ->latest()
        ->paginate($this->resolvePerPage($request));

        $documents->appends($request->only(['search', 'per_page']));

        return view('document_finder.index', compact('documents'));
    }

    private function resolvePerPage(Request $request): int
    {
        $requested = (int) $request->get('per_page', 10);
        $allowed = [10, 25, 50, 100];
        return in_array($requested, $allowed, true) ? $requested : 10;
    }

    public function download($id)
    {
        $fileId = request()->input('file_id');
        if ($fileId) {
            $documentFile = File::where('id', $fileId)
                ->where('fileable_type', Document::class)
                ->where('fileable_id', $id)
                ->firstOrFail();
        } else {
            $fileName = Str::lower(request()->filename);
            $documentFile = File::where('fileable_type', Document::class)
                ->where('fileable_id', $id)
                ->where('file_name', $fileName)
                ->firstOrFail();
        }

        $diskName = $this->storageResolver->getDiskForReading($documentFile->file_path);
        if ($diskName === null) {
            abort(404, 'File not found on disk. It may have been lost; please re-upload this file.');
        }

        return Storage::disk($diskName)->download($documentFile->file_path);
    }
}
