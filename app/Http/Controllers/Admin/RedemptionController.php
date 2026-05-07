<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PointRedemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedemptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $redemptions = PointRedemption::with('student', 'redeemedByAdmin')
            ->latest()
            ->paginate(20);

        $stats = [
            'today_redeemed' => PointRedemption::whereDate('redeemed_at', today())->count(),
            'today_value' => PointRedemption::whereDate('redeemed_at', today())->sum('idr_value'),
            'pending' => PointRedemption::where('status', 'pending')->count(),
        ];

        return view('admin.redemptions.index', compact('redemptions', 'stats'));
    }

    public function scan()
    {
        return view('admin.redemptions.scan');
    }

    public function processScan(Request $request)
    {
        // Validate with NEW code format (8 chars, uppercase letters + numbers, no confusing chars)
        $request->validate([
            'qr_code' => [
                'required',
                'string',
                'max:8',
                'regex:/^[ABCDEFGHJKMNPQRSTUVWXY346789]{8}$/i' // Case-insensitive validation
            ],
            'location' => 'required|string|max:255',
        ], [
            'qr_code.regex' => 'Invalid code format. Please enter exactly 8 characters (A-Z, 0-9, excluding O, I, L).',
        ]);

        $admin = Auth::guard('admin')->user();

        // Normalize input to uppercase for consistent lookup
        $qrCode = strtoupper(trim($request->qr_code));

        try {
            $result = $admin->redeemQr($qrCode, $request->location);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $result['message'],
                    'student_name' => $result['student_name'],
                    'idr_value' => $result['idr_value'],
                ]);
            }

            return response()->json(['success' => false, 'message' => $result['message']], 400);

        } catch (\Exception $e) {
            \Log::error('Redemption system error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'qr_code' => $qrCode,
            ]);

            return response()->json(['success' => false, 'message' => 'System error. Please try again.'], 500);
        }
    }

    public function history()
    {
        $redemptions = PointRedemption::with('student', 'redeemedByAdmin')
            ->where('status', 'redeemed')
            ->latest()
            ->paginate(20);

        return view('admin.redemptions.history', compact('redemptions'));
    }
}
