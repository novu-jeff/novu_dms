<?php

namespace App\Http\Services;

use App\Models\Document;

class DocumentService
{
    protected const PUBLIC_PERMISSION = 1;

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
}
