<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentManagementRequest extends FormRequest
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
            'year' => ['nullable'],
            'month' => ['nullable'],
            'type' => ['nullable', 'in:1,2,3,4,5'],
            'tags' => ['nullable'],
            'doc_date' => ['nullable']
        ];
    }
}
