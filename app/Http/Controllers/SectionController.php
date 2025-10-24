<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Division;
use App\Models\Section;
use App\Service\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\AuditService; // ✅ added

class SectionController extends Controller
{
    public function all()
    {
        $sections = Section::where('status', 1)->get();
        AuditService::log('Visit Section Page', 'View all sections');
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
        AuditService::log('Visit Section Page', 'View all sections index page');
        return view('section.index', compact('departments', 'divisions'));
    }

    public function show(Section $section)
    {
        $section->load(['department', 'division']);
        AuditService::log('Show Section', 'View Section Details ' . ($section->description ?? 'Untitled Document'));
        return response()->json($section);
    }

    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|max:255',
            'division' => 'required|max:255',
            'description' => 'required|string|max:255|unique:sections',
        ]);

        DB::beginTransaction();

        try {
            $section = Section::create([
                'description' => $request->description,
                'department_id' => $request->department,
                'division_id' => $request->division
            ]);

            DB::commit();
            AuditService::log('Added Section', 'Section created Successfully ' . ($section->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Section created successfully', 'data' => $section], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            AuditService::log('Failed Section', 'Failed to create section ' . ($section->description ?? 'Untitled Document'));
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
            AuditService::log('Update Section', 'Section updated successfully ' . ($section->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Section updated successfully', 'data' => $section]);
        } catch (\Exception $e) {
            DB::rollBack();
            AuditService::log('Failed to Update', 'Failed to update section' . ($section->description ?? 'Untitled Document'));
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
            AuditService::log('Delete Section', 'Section status changed ' . ($section->description ?? 'Untitled Document'));
            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            AuditService::log('Failed to Delete', 'Failed to delete section' . ($section->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Failed to delete section', 'error' => $e->getMessage()], 500);
        }
    }

    public function getSectionByDivisionAndDepartment(Request $request)
    {
        $departmentId = $request->department;
        $divisionId = $request->division;

        $division = Section::where('department_id', $departmentId)
            ->where('division_id', $divisionId)
            ->where('status', 1)
            ->get();

        return response()->json($division);
    }
}
