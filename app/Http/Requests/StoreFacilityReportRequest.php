<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFacilityReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('student')->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'evidence_files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048', // 2MB max per file
        ];
    }

    public function messages(): array
    {
        return [
            'evidence_files.*.mimes' => 'Each file must be an image (jpg, png) or document (pdf, doc, docx).',
            'evidence_files.*.max' => 'Each file may not be larger than 2MB.',
        ];
    }
}
