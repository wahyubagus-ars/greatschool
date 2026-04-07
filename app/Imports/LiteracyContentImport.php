<?php

namespace App\Imports;

use App\Models\LiteracyContent;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LiteracyContentImport implements ToCollection, WithHeadingRow, WithValidation, WithLimit, SkipsEmptyRows, SkipsOnFailure, SkipsOnError
{
    protected $successCount = 0;
    protected $failures = [];

    public function limit(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:article,video'],
            'category' => ['required', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'thumbnail' => ['nullable', 'url', 'max:255'],
            'platform' => ['nullable', 'string', 'in:youtube,vimeo,coursera,udemy,medium,blog,other'],
            'platform_id' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'title.required' => 'Title is required',
            'title.max' => 'Title cannot exceed 255 characters',
            'type.required' => 'Type is required',
            'type.in' => 'Type must be either "article" or "video"',
            'category.required' => 'Category is required',
            'url.url' => 'URL must be a valid URL',
            'thumbnail.url' => 'Thumbnail must be a valid URL',
            'platform.in' => 'Platform must be one of: youtube, vimeo, coursera, udemy, medium, blog, other',
        ];
    }

    public function collection(Collection $rows)
    {
        $duplicates = [];

        foreach ($rows as $index => $row) {
            try {
                // Skip if both content and url are empty
                if (empty($row['content']) && empty($row['url'])) {
                    $this->failures[] = [
                        'row' => $index + 2, // +2 for header and 0-index
                        'errors' => ['At least Content or URL must be provided'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                // Check for duplicate title
                $exists = LiteracyContent::where('title', $row['title'])->exists();
                if ($exists) {
                    $this->failures[] = [
                        'row' => $index + 2,
                        'errors' => ['Duplicate title: "' . $row['title'] . '" already exists'],
                        'data' => $row->toArray(),
                    ];
                    continue;
                }

                // Validate thumbnail is image URL
                if (!empty($row['thumbnail'])) {
                    $extension = strtolower(pathinfo(parse_url($row['thumbnail'], PHP_URL_PATH), PATHINFO_EXTENSION));
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                        $this->failures[] = [
                            'row' => $index + 2,
                            'errors' => ['Thumbnail must be an image URL (jpg, jpeg, png, webp, gif)'],
                            'data' => $row->toArray(),
                        ];
                        continue;
                    }
                }

                // Create the record
                LiteracyContent::create([
                    'type' => strtolower($row['type']),
                    'title' => trim($row['title']),
                    'content' => $row['content'] ?? null,
                    'url' => $row['url'] ?? null,
                    'thumbnail' => $row['thumbnail'] ?? null,
                    'category' => trim($row['category']),
                    'platform' => $row['platform'] ?? null,
                    'platform_id' => $row['platform_id'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->successCount++;

            } catch (\Exception $e) {
                $this->failures[] = [
                    'row' => $index + 2,
                    'errors' => [$e->getMessage()],
                    'data' => $row->toArray(),
                ];
            }
        }

        // Log import activity
        \Log::channel('admin_audit')->info('Literacy content bulk import', [
            'admin_id' => Auth::guard('admin')->id(),
            'admin_username' => Auth::guard('admin')->user()->username,
            'total_rows' => count($rows),
            'success_count' => $this->successCount,
            'failed_count' => count($this->failures),
            'ip_address' => request()->ip(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failures[] = [
                'row' => $failure->row(),
                'errors' => $failure->errors(),
                'data' => $failure->attributes(),
            ];
        }
    }

    public function onError(\Throwable $e)
    {
        \Log::error('Literacy content import error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    public function failures(): Collection
    {
        return collect($this->failures);
    }
}
