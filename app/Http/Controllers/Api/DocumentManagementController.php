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
    protected const PUBLIC_PERMISSION = 1;

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

    // List all documents with relationships
    public function index(Request $request)
        {
            $query = Document::query()
            ->where('document_access', self::PUBLIC_PERMISSION)
            ->with([
                'branch:id,description,status',
                'department:id,description,status',
                'division:id,description,status',
                'section:id,description,status',
                'folder',   // load all columns
                'files'     // load all columns
            ]);

            // Filter by folder_id
            if ($request->filled('folder_id')) {
                $query->where('folder_id', $request->folder_id);
            }

            // Filter by year
            if ($request->filled('year')) {
                $query->whereYear('created_at', $request->year);
            }

            // Filter by month
            if ($request->filled('month')) {
                $query->whereMonth('created_at', $request->month);
            }

            // Filter by tags
            if ($request->filled('tags')) {
                $tags = explode(',', $request->tags);
                foreach ($tags as $tag) {
                    $query->where('tags', 'LIKE', "%$tag%");
                }
            }

            // Filter by document date
            if ($request->filled('doc_date')) {
                $query->whereDate('doc_date', $request->doc_date);
            }

            // Filter by type (if column exists)
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

//             dd([
//      'sql'      => $query->toSql(),
//      'bindings' => $query->getBindings(),
//  ]);
             // Paginate results, default 10 per page
         $perPage = $request->get('per_page', 10);
         $documents = $query->orderBy('created_at', 'desc')->paginate($perPage);


            //$documents = $query->orderBy('created_at', 'desc')->get();

            // return response()->json([
            //     'status' => true,
            //     'count'  => $documents->count(),
            //     'data'   => $documents
            // ]);

            return response()->json([
                'status' => true,
                'count'  => $documents->total(),
                'current_page' => $documents->currentPage(),
                'last_page'    => $documents->lastPage(),
                'per_page'     => $documents->perPage(),
                'data'   => $documents->items(),
            ]);
        }

}
