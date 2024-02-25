<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreRequest extends FormRequest
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
            'document' => ['required', 'exists:documents,id'],
            'folder' => ['required', 'exists:folders,id'],
            'file' => ['required', 'array'],
            'file.*' => ['required', 'mimes:jpeg,png,pdf,docx']
        ];
    }
}
