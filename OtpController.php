<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminOtp;
use App\Models\User;
use App\Mail\AdminOtp as AdminOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class OtpController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function showOtpForm()
    {
        // Check if user is in the middle of admin login process
        if (!Session::has('admin_login_user_id')) {
            return redirect()->route('login')->withErrors(['error' => 'Invalid session. Please login again.']);
        }

        $userId = Session::get('admin_login_user_id');
        $user = User::find($userId);

        if (!$user || !$user->isAdmin()) {
            Session::forget('admin_login_user_id');
            return redirect()->route('login')->withErrors(['error' => 'Invalid user session.']);
        }

        return view('auth.otp-verification', ['email' => $user->email]);
    }

    /**
     * Verify the OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        // Check if user is in the middle of admin login process
        if (!Session::has('admin_login_user_id')) {
            return redirect()->route('login')->withErrors(['error' => 'Invalid session. Please login again.']);
        }

        $userId = Session::get('admin_login_user_id');
        $user = User::find($userId);

        if (!$user || !$user->isAdmin()) {
            Session::forget('admin_login_user_id');
            return redirect()->route('login')->withErrors(['error' => 'Invalid user session.']);
        }

        // Verify OTP
        if (AdminOtp::verifyOtp($userId, $request->otp)) {
            // OTP is valid, complete the login process
            auth()->login($user);
            Session::forget('admin_login_user_id');
            
            // Regenerate session for security
            $request->session()->regenerate();
            
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        } else {
            throw ValidationException::withMessages([
                'otp' => ['Invalid or expired OTP code. Please try again.'],
            ]);
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        // Check if user is in the middle of admin login process
        if (!Session::has('admin_login_user_id')) {
            return redirect()->route('login')->withErrors(['error' => 'Invalid session. Please login again.']);
        }

        $userId = Session::get('admin_login_user_id');
        $user = User::find($userId);

        if (!$user || !$user->isAdmin()) {
            Session::forget('admin_login_user_id');
            return redirect()->route('login')->withErrors(['error' => 'Invalid user session.']);
        }

        // Check for rate limiting - allow resend after 60 seconds instead of full OTP expiry
        $lastOtp = AdminOtp::where('user_id', $userId)
            ->where('is_verified', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < 60) {
            $waitTime = 60 - $lastOtp->created_at->diffInSeconds(now());
            return back()->withErrors(['error' => "Please wait {$waitTime} seconds before requesting a new code."]);
        }

        try {
            // Generate new OTP (this will delete any existing OTPs for the user)
            $otp = AdminOtp::generateOtp($userId);
            
            // Send OTP via email
            Mail::to($user->email)->send(new AdminOtpMail($user, $otp->otp_code));
            
            return back()->with('success', 'New OTP has been sent to your email address.');
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP resend email: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send OTP. Please try again later.']);
        }
    }
}
