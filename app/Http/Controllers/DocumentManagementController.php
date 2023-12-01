<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentManagementController extends Controller
{
    public function index()
    {
        return view('document_management.index');
    }
}
