<?php

namespace App\Http\Controllers\Api;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\DocumentService;
use App\Http\Requests\DocumentManagementRequest;
use App\Http\Requests\DocumentPermissionRequest;
use App\Http\Requests\DocumentManagementUpdateRequest;

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
            dd($request->all());
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

    public function updateDocumentPermission($id, DocumentPermissionRequest $documentPermissionRequest)
    {
        DB::beginTransaction();
        try {
            $this->documentService->updateDocumentPermission($id, $documentPermissionRequest->permission);

            $document = Document::find($id);

            DB::commit();
            return response()->json([
                'data' => $document,
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

    public function getDocumentById($id)
    {
        try {
            $document = $this->documentService->getDocumentById($id);
            return response()->json([
                'data' => $document,
                'success' => true
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Document does not exist',
                'success' => false,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'Server Error: Contact Administrator',
                'success' => false,
            ], 500);
        }
    }


    public function updateDocument(DocumentManagementUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->documentService->updateDocument($request, $id);

            DB::commit();

            return response()->json([
                'message' => 'Success',
                'success' => true,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            DB::rollback();
            return response()->json([
                'message' => 'Document not found',
                'success' => false,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => env('APP_ENV') === 'local' ? $e->getMessage() : 'Server Error: Contact Administrator',
                'success' => false,
            ], 500);
        }
    }
}
