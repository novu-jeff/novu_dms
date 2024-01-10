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
            $tags = $request->input('tags');

            $documents = Document::when($year, function ($query) use ($year) {
                $query->whereYear('created_at', '=', $year);
            })
            ->when(!empty($month), function ($query) use ($month) {
                $query->whereMonth('created_at', '=', $month);
            })
            ->when(!empty($type), function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when(!empty($tags), function ($query) use ($tags) {
                $query->where('tags', 'like', '%' . $tags . '%');
            })
            ->with([
                'branch:id,description,status',
                'department:id,description,status',
                'division:id,description,status',
                'section:id,description,status',
                'folder',
                'files'
            ])
            ->get();

            return response()->json([
                'data' => $documents,
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'success' => false,
            ], 500);
        }

    }
}
