<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use App\Service\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function all()
    {
        $sections = Section::where('status', 1)->get();
        return response()->json($sections);
    }

    public function index()
    {
        if(request()->ajax()) {
            $sections = Section::with(['department', 'division']);

            $additionalColumns = [
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
            ];

            return (new BaseService($sections))
                ->dataTable($additionalColumns);
        }

        $departments = Department::where('status', 1)->get();

        $divisions = Division::where('status', 1)
            ->where('department_id', $departments->first()->id)
            ->get();

        return view('section.index', compact('departments', 'divisions'));
    }

    public function show(Section $section)
    {
        $section->load(['department', 'division']);
        return response()->json($section);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|max:255',
            'division' => 'required|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $section = Section::create([
                'description' => $request->description,
                'department_id' => $request->department,
                'division_id' => $request->division
            ]);

            DB::commit();

            return response()->json(['message' => 'Section created successfully', 'data' => $section], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create section', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'department' => 'required|max:255',
            'division' => 'required|max:255',
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $section->update([
                'description' => $request->description,
                'department_id' => $request->department,
                'division_id' => $request->division
            ]);

            DB::commit();

            return response()->json(['message' => 'Section updated successfully', 'data' => $section]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update section', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Section $section)
    {
        DB::beginTransaction();
        try {

            if ($section->status == 0) {
                $section->update(['status' => 1]);
                $message = 'Section restored successfully';
            } else {
                $section->update(['status' => 0]);
                $message = 'Section deleted successfully';
            }

            DB::commit();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete section', 'error' => $e->getMessage()], 500);
        }
    }
}
