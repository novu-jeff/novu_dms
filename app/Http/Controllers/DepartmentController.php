<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Service\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function all()
    {
        $departments = Department::where('status', 1)->get();
        return response()->json($departments);
    }

    public function index()
    {
        if(request()->ajax()) {
            $departments = Department::with('branch');

            $additionalColumns = [
                [
                    'name' => 'branch',
                    'callback' => function ($row) {
                        return $row->branch->description;
                    },
                ],
            ];

            return (new BaseService($departments))
                ->dataTable($additionalColumns);
        }

        $branches = Branch::where('status', 1)->get();
        return view('department.index', compact('branches'));
    }

    public function show(Department $department)
    {
        $department->load('branch');
        return response()->json($department);
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $department = Department::create([
                'description' => $request->description,
                'branch_id' => $request->branch
            ]);

            DB::commit();

            return response()->json(['message' => 'Department created successfully', 'data' => $department], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create branch', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'branch' => 'required|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $department->update([
                'description' => $request->description,
                'branch_id' => $request->branch
            ]);

            DB::commit();

            return response()->json(['message' => 'Department updated successfully', 'data' => $department]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update branch', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Department $department)
    {
        DB::beginTransaction();
        try {

            if ($department->status == 0) {
                $department->update(['status' => 1]);
                $message = 'Department restored successfully';
            } else {
                $department->update(['status' => 0]);
                $message = 'Department deleted successfully';
            }

            DB::commit();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete department', 'error' => $e->getMessage()], 500);
        }
    }
}
