<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentManagementRequest;
use App\Http\Services\DocumentService;

class DocumentManagementController extends Controller
{
    protected $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    public function getDocumentsByYearAndMonth(DocumentManagementRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->validated();

            $documents = $this->documentService->getDocumentsByYearAndMonth($payload);

            DB::commit();
            return response()->json([
                'data' => $documents,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'Server Error: Contact Administrator',
                'success' => false,
            ], 500);
        }
    }
}
