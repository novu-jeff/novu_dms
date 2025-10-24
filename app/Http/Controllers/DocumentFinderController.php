<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Document;
use App\Models\Folder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\AuditService; // ✅ added

class DocumentFinderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $access = $request->document_access;

        $documents = Document::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
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
                });
            })
            // 🔹 Add the new filter for document access
            ->when($access, function ($query, $access) {
                $query->where('document_access', $access);
            })
            ->with('files')
            ->latest()
            ->paginate(10);

        

        // Keep query parameters during pagination
        $documents->appends([
            'search' => $search,
            'document_access' => $access,
        ]);

        $folders = Folder::with(['branch', 'division'])->where('status', 1)->get();

        AuditService::log('Searching Document', 'Document Searched: ' . ($documents->title ?? 'Untitled Document'));
    

        return view('document_finder.index', compact('documents','folders'));
    }

    public function download($id)
    {

        $fileName = Str::lower(request()->filename);
        $documentFile = File::where('fileable_type', Document::class)
            ->where('fileable_id', $id)
            ->where('file_name', $fileName)
            ->first();

          AuditService::log('Download Document', 'Document Downloaded: ' . ($documentFile->file_path ?? 'Untitled Document'));
        
        if (!Storage::disk('public')->exists($documentFile->file_path)) {
            abort(404, 'File not found.');
        }

      return Storage::disk('public')->download($documentFile->file_path);
        
        
          //return Storage::disk('public')->download($documentFile->file_path);

        //return Storage::disk(config('filesystems.default'))->download($documentFile->file_path);
    }
}
