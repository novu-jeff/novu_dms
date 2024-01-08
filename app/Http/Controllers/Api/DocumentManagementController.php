<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    public function getDocumentsByYearAndMonth(Request $request)
    {
        try {
            $year = $request->input('year');
            $month = $request->input('month');
            $type = $request->input('type');

            $documents = Document::whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month)
                ->where('type', $type)
                ->with([
                    'branch:id,description,status',
                    'department:id,description,status',
                    'division:id,description,status',
                    'section:id,description,status',
                    'folder'
                ])
                ->get();

            return response()->json([
                'data' => $documents,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response([
                'error' => $e->getMessage(),
                'success' => false,
            ], 500)->json();
        }

    }
}
