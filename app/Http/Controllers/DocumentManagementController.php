<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Branch;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\DocumentService;
use App\Http\Requests\DocumentManagementStoreRequest;
use App\Http\Requests\DocumentManagementUpdateRequest;

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
            return response()->json([
                'message' => 'Document Added'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            $log = [
                'user_id' => auth()->id(),
                'timestamp' => now(),
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'type' => 'document management store'
            ];
            Log::error(json_encode($log));
            return response()->json([
                'message' => config('app.env') == 'local' ? $e->getMessage() : 'Server Error'
            ], 500);
        }
    }
}
