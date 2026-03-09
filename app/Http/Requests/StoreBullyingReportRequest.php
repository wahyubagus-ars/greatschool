<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBullyingReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->guard('student')->check();
    }

    public function rules(): array
    {
        return [
            'reporter_type' => 'required|in:victim,witness',
            'title' => 'required|string|max:255',
            'incident_date' => 'required|date|before_or_equal:today',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'evidence' => 'nullable|array',
            'evidence.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi,pdf,doc,docx|max:10240', // max 10MB per file
        ];
    }

    public function messages(): array
    {
        return [
            'incident_date.before_or_equal' => 'The incident date cannot be in the future.',
        ];
    }
}
