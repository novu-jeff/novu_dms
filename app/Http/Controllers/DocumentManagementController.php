<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    public function index()
    {
        $branches = Branch::where('status', 1)->get();
        return view('document_management.index', compact('branches'));
    }
}
