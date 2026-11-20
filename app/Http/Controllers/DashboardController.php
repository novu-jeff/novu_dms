<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Document;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'documents' => Document::count(),
            'folders' => Folder::count(),
            'files' => File::count(),
            'locations' => Branch::count() + Department::count(),
        ];

        // Keep this query aligned with fields already used by the existing Document Finder view.
        $recentDocuments = Document::with(['folder', 'files'])
            ->latest('created_at')
            ->take(7)
            ->get();

        return view('dashboard.index', compact('stats', 'recentDocuments'));
    }
}
