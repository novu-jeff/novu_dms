<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the audit logs.
     */
    public function index(Request $request)
    {
        // Optional search filters
        $query = AuditLog::with('user')->latest();

        if ($request->filled('user')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }

        $logs = $query->paginate(20);

        return view('admin.audit_logs.index', compact('logs'));
    }

    /**
     * Display a specific audit log entry.
     */
    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);
        return view('admin.audit_logs.show', compact('log'));
    }

    /**
     * Delete a specific log (optional for admin cleanup).
     */
    public function destroy($id)
    {
        $log = AuditLog::findOrFail($id);
        $log->delete();

        return redirect()->route('audit-logs.index')->with('success', 'Audit log deleted successfully.');
    }
}
