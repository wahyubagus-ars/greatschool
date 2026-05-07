<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PointRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RedemptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:student');
    }

    public function index()
    {
        $student = Auth::guard('student')->user();
        $redemptions = $student->pointRedemptions()
            ->latest()
            ->paginate(10);

        return view('student.redemptions.index', compact('student', 'redemptions'));
    }

    public function create()
    {
        $student = Auth::guard('student')->user();

        // Calculate max redeemable points (min 10, max available)
        $maxPoints = max(10, min($student->available_points, 1000));

        return view('student.redemptions.create', compact('student', 'maxPoints'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:10|max:1000',
        ]);

        $student = Auth::guard('student')->user();

        try {
            $redemption = $student->generateRedemptionQr($request->points);

            // Generate QR code image (base64 for embedding)
            $qrCode = QrCode::size(300)->generate($redemption->qr_code);

            return view('student.redemptions.qr', compact('redemption', 'qrCode'));
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(PointRedemption $redemption)
    {
        $student = Auth::guard('student')->user();

        // Ensure ownership
        if ($redemption->student_id !== $student->id) {
            abort(403);
        }

        // Generate QR if still valid
        $qrCode = null;
        if ($redemption->isValid()) {
            $qrCode = QrCode::size(300)->generate($redemption->qr_code);
        }

        return view('student.redemptions.show', compact('redemption', 'qrCode'));
    }
}
