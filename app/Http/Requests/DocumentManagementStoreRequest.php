<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentManagementStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'description' => 'required|string',
            'branch' => 'required|exists:branches,id',
            'department' => 'required|exists:departments,id',
            'division' => 'required|exists:divisions,id',
            'section' => 'required|exists:sections,id',
            'permission' => 'required|in:1,2,3',
            'tags' => 'required|string',
            'type' => 'required|in:1,2,3,4,5',
            'doc_date' => 'required|date',
            'folder' => 'required',
            'file.*' => 'required|mimes:jpeg,png,pdf,docx',
        ];
    }
}
