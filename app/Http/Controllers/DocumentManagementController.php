<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Branch;
use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentManagementController extends Controller
{
    public function index()
    {
        $branches = Branch::where('status', 1)->get();
        return view('document_management.index', compact('branches'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'branch' => 'required|exists:branches,id',
            'department' => 'required|exists:departments,id',
            'division' => 'required|exists:divisions,id',
            'section' => 'required|exists:sections,id',
            'permission' => 'required|in:1,2,3',
            'tags' => 'required|string',
            'type' => 'required|in:1,2,3,4',
            'folder' => 'required',
            'file.*' => 'required|mimes:jpeg,png,pdf,docx', // Updated file types
        ]);

        DB::beginTransaction();

        try {

            // Create a new document
            $document = Document::create([
                'title' => $validatedData['title'],
                'author' => $validatedData['author'],
                'branch_id' => $validatedData['branch'],
                'department_id' => $validatedData['department'],
                'division_id' => $validatedData['division'],
                'section_id' => $validatedData['section'],
                'document_access' => $validatedData['permission'],
                'tags' => $validatedData['tags'],
                'folder_id' => $validatedData['folder'],
                'type' => $validatedData['type']
            ]);

            $folder = Str::lower($request->folder);

            foreach ($request->file('file') as $file) {
                $filePath = $file->store($folder, 'public');

                // Get the original name of the file
                $originalName = $file->getClientOriginalName();
                $fileName = Str::lower($originalName);

                File::create([
                    'fileable_id' => $document->id,
                    'fileable_type' => Document::class,
                    'file_name' => $fileName,
                    'file_path' => $filePath
                ]);
            }

            DB::commit();
            // Redirect to the index page or show a success message
            return redirect('/document-management')->with('success', 'Document created successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect('/document-management')->with('error', $exception->getMessage());
        }
    }

}
