<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Division;
use App\Service\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Illuminate\Events\queueable;

class DivisionController extends Controller
{
    public function index()
    {
        if(request()->ajax()) {
            $divisions = Division::with('department');

            $additionalColumns = [
                [
                    'name' => 'department',
                    'callback' => function ($row) {
                        return $row->department->description;
                    },
                ],
            ];

            return (new BaseService($divisions))
                ->dataTable($additionalColumns);
        }

        $departments = Department::where('status', 1)->get();
        return view('division.index', compact('departments'));
    }

    public function show(Division $division)
    {
        $division->load('department');
        return response()->json($division);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $division = Division::create([
                'description' => $request->description,
                'department_id' => $request->department
            ]);

            DB::commit();

            return response()->json(['message' => 'Division created successfully', 'data' => $division], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create department', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'department' => 'required|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $division->update([
                'description' => $request->description,
                'department_id' => $request->department
            ]);

            DB::commit();

            return response()->json(['message' => 'Division updated successfully', 'data' => $division]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update division', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Division $division)
    {
        DB::beginTransaction();
        try {

            if ($division->status == 0) {
                $division->update(['status' => 1]);
                $message = 'Division restored successfully';
            } else {
                $division->update(['status' => 0]);
                $message = 'Division deleted successfully';
            }

            DB::commit();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete division', 'error' => $e->getMessage()], 500);
        }
    }

    public function getDivisionByDepartment($departmentId)
    {
        $division = Division::where('department_id', $departmentId)
            ->where('status', 1)
            ->get();
        return response()->json($division);
    }
}
