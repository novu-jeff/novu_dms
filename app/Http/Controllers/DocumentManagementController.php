<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentManagementStoreRequest;
use App\Http\Requests\DocumentManagementUpdateRequest;
use App\Http\Services\DocumentService;
use App\Models\File;
use App\Models\Branch;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentManagementController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function index()
    {
        $branches = Branch::where('status', 1)->get();
        return view('document_management.index', compact('branches'));
    }

    public function store(DocumentManagementStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->documentService->addDocument($request);

            DB::commit();
            // Redirect to the index page or show a success message
            return redirect('/document-management')->with('success', 'A new document has been added successfully.');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect('/document-management')->with('error', $exception->getMessage());
        }
    }
}
