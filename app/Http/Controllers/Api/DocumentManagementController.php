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
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('created_at', '=', $month);
            })
            ->when($type, function ($query) use ($type) {
                $query->where('type', $type);
            })
            ->when($tags, function ($query) use ($tags) {
                $query->where('tags', 'like', '%' . $tags . '%');
            })
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
