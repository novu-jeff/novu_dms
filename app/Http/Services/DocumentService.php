<?php

namespace App\Http\Services;

use App\Models\File;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DocumentManagementStoreRequest;
use App\Http\Requests\DocumentManagementUpdateRequest;

class DocumentService
{
    protected const PUBLIC_PERMISSION = 1;

    public function addDocument(DocumentManagementStoreRequest $request)
    {
        // Create a new document
        $document = Document::create([
            'title' => $request['title'],
            'author' => $request['author'],
            'description' => $request['description'],
            'branch_id' => $request['branch'],
            'department_id' => $request['department'],
            'division_id' => $request['division'],
            'section_id' => $request['section'],
            'document_access' => $request['permission'],
            'tags' => $request['tags'],
            'folder_id' => $request['folder'],
            'doc_date' => $request['doc_date'],
            'type' => $request['type']
        ]);

        $folder = Str::lower($request->folder);

        foreach ($request->file('file') as $file) {
            $filePath = $file->store($folder, 'public');

            $fullFilePath = "public/" . $filePath;

            // Get the original name of the file
            $originalName = $file->getClientOriginalName();
            $fileName = Str::lower($originalName);

            // Get the file size in bytes
            $fileSizeBytes = Storage::size($fullFilePath);

            // Convert file size to human-readable format
            $fileSizeReadable = $this->humanFilesize($fileSizeBytes);

            File::create([
                'fileable_id' => $document->id,
                'fileable_type' => Document::class,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_size' => $fileSizeReadable
            ]);
        }
    }

    public function updateDocument(DocumentManagementUpdateRequest $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->update($request->validated());
    }

    public function getDocumentsByYearAndMonth($payload = [])
    {
        $year = isset($payload['year']) ? $payload['year'] : null;
        $month = isset($payload['month']) ? $payload['month'] : null;
        $type = isset($payload['type']) ? $payload['type'] : null;
        $tags = isset($payload['tags']) ? $payload['tags'] : null;
        $docDate = isset($payload['doc_date']) ? $payload['doc_date'] : null;

        $documents = Document::when(isset($year), function ($query) use ($year) {
            $query->whereYear('created_at', '=', $year);
        })
        ->when(isset($month), function ($query) use ($month) {
            $query->whereMonth('created_at', '=', $month);
        })
        ->when(isset($type), function ($query) use ($type) {
            $query->where('type', $type);
        })
        ->when(isset($tags), function ($query) use ($tags) {
            $query->where('tags', 'like', '%' . $tags . '%');
        })
        ->when(isset($docDate), function ($query) use ($docDate) {
            $query->whereDate('doc_date', $docDate);
        })
        ->where('document_access', self::PUBLIC_PERMISSION)
        ->with([
            'branch:id,description,status',
            'department:id,description,status',
            'division:id,description,status',
            'section:id,description,status',
            'folder',
            'files'
        ])
        ->get();

        return $documents;
    }

    public function updateDocumentPermission($id, $payload)
    {
        $doc = Document::findOrFail($id);
        $doc->update([
            'document_access' => $payload
        ]);

        return $doc;
    }

    public function getDocumentById($id)
    {
        return Document::with('files')->findOrFail($id);
    }

    public function humanFilesize($bytes, $decimals = 2)
    {
        $size = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
    }
}
