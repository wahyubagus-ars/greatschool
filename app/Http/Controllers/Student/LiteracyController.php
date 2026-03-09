<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiteracyContent;
use App\Models\StudentLiteracyProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class LiteracyController extends Controller
{
    public function index(Request $request): View
    {
        // Get category filter from query string
        $category = $request->query('category');

        // Build query with optional category filter
        $query = LiteracyContent::query();

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        // Get paginated results (12 per page)
        $contents = $query->orderBy('created_at', 'desc')->paginate(12);

        // Get unique categories for filter UI
        $categories = LiteracyContent::whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->map(fn($cat) => [
                'slug' => $cat,
                'label' => $this->getCategoryLabel($cat)
            ])
            ->sortBy('label')
            ->values();

        // Add "All Content" as first option
        $categories->prepend([
            'slug' => 'all',
            'label' => 'All Content'
        ]);

        return view('student.literacy.index', compact('contents', 'categories', 'category'));
    }

    public function redirect(Request $request): RedirectResponse
    {
        $url = $request->query('url');

        if (!$url) {
            return redirect()->route('student.literacy.index')
                ->with('error', 'No URL provided');
        }

        // Basic sanitization
        $url = trim($url);

        // Validate URL format
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return redirect()->route('student.literacy.index')
                ->with('error', 'Invalid URL format');
        }

        // Security: Only allow safe external domains
        $allowedHosts = [
            'youtube.com', 'www.youtube.com', 'youtu.be',
            'tiktok.com', 'www.tiktok.com',
            'instagram.com', 'www.instagram.com',
            'medium.com', 'www.medium.com',
            'vimeo.com', 'www.vimeo.com'
        ];

        $host = parse_url($url, PHP_URL_HOST);
        $host = strtolower(trim($host ?? '', 'www.'));

        if (!in_array($host, $allowedHosts)) {
            \Log::warning('Blocked unsafe redirect attempt', [
                'student_id' => auth()->guard('student')->id(),
                'url' => $url,
                'host' => $host
            ]);

            return redirect()->route('student.literacy.index')
                ->with('error', 'This link is not allowed for security reasons');
        }

        // Log access for analytics (optional)
        \Log::info('Literacy content accessed', [
            'student_id' => auth()->guard('student')->id(),
            'url' => $url
        ]);

        // CRITICAL FIX: Use redirect()->away() for external URLs
        return redirect()->away($url);
    }

    private function getCategoryLabel(string $category): string
    {
        return match($category) {
            'anti-bullying' => 'Anti-Bullying',
            'digital-literacy' => 'Digital Literacy',
            'mental-health' => 'Mental Health',
            'school-safety' => 'School Safety',
            default => ucfirst(str_replace('-', ' ', $category))
        };
    }

    public function show(LiteracyContent $literacyContent)
    {
        $student = Auth::guard('student')->user();

        // Record that student viewed this content
        StudentLiteracyProgress::updateOrCreate(
            [
                'student_id' => $student->id,
                'literacy_content_id' => $literacyContent->id,
            ],
            [
                'viewed_at' => now(),
            ]
        );

        return view('student.literacy.show', compact('literacyContent'));
    }
}
