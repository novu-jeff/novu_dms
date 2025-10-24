<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Service\BaseService;
use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Services\AuditService; // ✅ added

class BranchController extends Controller
{
    public function all()
    {
        $branches = Branch::where('status', 1)->get();
        AuditService::log('Visit Branch Page', 'View all branches');    
        return response()->json($branches);
    }

    public function index()
    {
        if(request()->ajax()) {
            $branches = Branch::query();
            return (new BaseService($branches))->dataTable();
        }
        AuditService::log('Visit Branch Page', 'View all branches index page');

        return view('branch.index');
    }

    public function show(Branch $branch)
    {
        AuditService::log('Show Branch', 'View Branch Details ' . ($branch->description ?? 'Untitled Document'));
        return response()->json($branch);
    }

    public function store(Request $request)
    {

        $request->validate([
            'description' => 'required|string|max:255|unique:branches',
        ]);

        DB::beginTransaction();

        try {
            $branch = Branch::create($request->only('description'));

            DB::commit();
            AuditService::log('Added Branch', 'Branch created Successfully ' . ($branch->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Branch created successfully', 'data' => $branch], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            AuditService::log('Failed Branch', 'Failed to create branch ' . ($branch->description ?? 'Untitled Document')); 
            return response()->json(['message' => 'Failed to create branch', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $branch->update($request->only('description'));

            DB::commit();
            AuditService::log('Update Branch', 'Branch updated successfully ' . ($branch->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Branch updated successfully', 'data' => $branch]);
        } catch (\Exception $e) {
            DB::rollBack();
            AuditService::log('Failed to Update', 'Failed to update branch' . ($branch->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Failed to update branch', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Branch $branch)
    {
        DB::beginTransaction();
        try {

            if ($branch->status == 0) {
                // If the branch is soft-deleted, restore it
                $branch->update(['status' => 1]);
                AuditService::log('Restore', 'Branch restored successfully' . ($branch->description ?? 'Untitled Document'));
                $message = 'Branch restored successfully';
            } else {
                // If the branch is not soft-deleted, soft delete it
                $branch->update(['status' => 0]);
                AuditService::log('Delete', 'Branch deleted successfully' . ($branch->description ?? 'Untitled Document'));
                $message = 'Branch deleted successfully';
            }

            DB::commit();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            AuditService::log('Failed to Delete', 'Failed to delete branch' . ($branch->description ?? 'Untitled Document'));
            return response()->json(['message' => 'Failed to delete branch', 'error' => $e->getMessage()], 500);
        }
    }
}
