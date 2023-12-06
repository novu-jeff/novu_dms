<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Folder;
use App\Service\BaseService;
use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FolderController extends Controller
{
    public function all()
    {
        $folders = Folder::where('status', 1)->get();
        return response()->json($folders);
    }

    public function index()
    {
        if(request()->ajax()) {
            $folders = Folder::with(['department', 'division', 'branch', 'section']);

            $additionalColumns = [
                [
                    'name' => 'branch',
                    'callback' => function ($row) {
                        return $row->branch->description;
                    },
                ],
                [
                    'name' => 'department',
                    'callback' => function ($row) {
                        return $row->department->description;
                    },
                ],
                [
                    'name' => 'division',
                    'callback' => function ($row) {
                        return $row->division->description;
                    },
                ],
                [
                    'name' => 'section',
                    'callback' => function ($row) {
                        return $row->section->description;
                    },
                ],
            ];
            return (new BaseService($folders))->dataTable($additionalColumns, [], '#addModal');
        }

        $branches = Branch::where('status', 1)->get();
        return view('folder.index', compact('branches'));
    }

    public function show(Folder $folder)
    {
        $folder->load(['department', 'division', 'branch', 'section']);
        return response()->json($folder);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch' => 'required',
            'department' => 'required',
            'division' => 'required',
            'section' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $folder = Folder::create([
                'name' => $request->name,
                'branch_id' => $request->branch,
                'department_id' => $request->department,
                'division_id' => $request->division,
                'section_id' => $request->section
            ]);

            DB::commit();

            return response()->json(['message' => 'Folder created successfully', 'data' => $folder], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create folder', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Folder $folder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch' => 'required',
            'department' => 'required',
            'division' => 'required',
            'section' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $folder->update([
                'name' => $request->name,
                'branch_id' => $request->branch,
                'department_id' => $request->department,
                'division_id' => $request->division,
                'section_id' => $request->section
            ]);

            DB::commit();

            return response()->json(['message' => 'Folder updated successfully', 'data' => $folder]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update folder', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Folder $folder)
    {
        DB::beginTransaction();
        try {

            if ($folder->status == 0) {
                // If the branch is soft-deleted, restore it
                $folder->update(['status' => 1]);
                $message = 'Folder restored successfully';
            } else {
                // If the branch is not soft-deleted, soft delete it
                $folder->update(['status' => 0]);
                $message = 'Folder deleted successfully';
            }

            DB::commit();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete branch', 'error' => $e->getMessage()], 500);
        }
    }

    public function getFolderByLocation(Request $request)
    {
        $folders = Folder::where('branch_id', $request->branch)
            ->where('department_id', $request->department)
            ->where('division_id', $request->division)
            ->where('section_id', $request->section)
            ->get();

        return response()->json($folders);
    }
}
