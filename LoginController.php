<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\AdminOtp;
use App\Mail\AdminOtp as AdminOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username'; // Assuming you're using 'username' as the login identifier
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();
        
        // If the user is not active, log them out and show a validation error
        if ($user->status !== 'active') {
            auth()->logout();

            throw ValidationException::withMessages([
                $this->username() => ['Your account is pending admin approval.'],
            ]);
        }

        // If the user is an admin, implement 2FA with OTP
        if ($user->isAdmin()) {
            // Logout the user immediately - they need to verify OTP first
            auth()->logout();
            
            // Store user ID in session for OTP verification
            Session::put('admin_login_user_id', $user->id);
            
            try {
                // Generate OTP
                $otp = AdminOtp::generateOtp($user->id);
                
                // Send OTP via email
                Mail::to($user->email)->send(new AdminOtpMail($user, $otp->otp_code));
                
                // Redirect to OTP verification page
                return redirect()->route('admin.otp.form')->with('success', 'OTP has been sent to your email address. Please check your email and enter the code below.');
            } catch (\Exception $e) {
                // Clear session if email fails
                Session::forget('admin_login_user_id');
                
                throw ValidationException::withMessages([
                    $this->username() => ['Failed to send OTP. Please try again later.'],
                ]);
            }
        }

        // For regular users, proceed normally
        return redirect()->route('user.dashboard');
    }

    /**
     * Determine the redirect path after login (redundant if 'authenticated' method is used)
     *
     * @return string
     */
    protected function redirectTo()
    {
        // This is technically redundant if `authenticated()` handles redirects
        if (auth()->user()->isAdmin()) {
            return route('admin.dashboard');
        } else {
            return route('user.dashboard');
        }
    }
}
