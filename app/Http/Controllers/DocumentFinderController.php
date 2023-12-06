<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentFinderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $documents = Document::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('tags', 'like', '%' . $search . '%');
        })->paginate(8);

        // Append the search parameter to pagination links
        $documents->appends(['search' => $search]);

        return view('document_finder.index', compact('documents'));
    }

    public function download(Document $document)
    {
        return Storage::disk('public')->download($document->file);
    }
}
