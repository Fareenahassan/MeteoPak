<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Where to redirect users after resetting their password.
     */
    protected function redirectTo()
    {
        if (Auth::user()->isAdmin()) {
            return route('admin.dashboard');
        }
        
        return route('user.dashboard');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        $passwordResets = DB::table('password_reset_tokens')->get();
        $validReset = null;

        // Check each reset record to find a matching hashed token
        foreach ($passwordResets as $passwordReset) {
            if (Hash::check($token, $passwordReset->token)) {
                $validReset = $passwordReset;
                break;
            }
        }

        if (!$validReset) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid password reset token.']);
        }

        // Check if the token has expired (30 minutes)
        if (Carbon::parse($validReset->created_at)->addMinutes(30)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $validReset->email)->delete();
            
            return redirect()->route('password.request')
                ->withErrors(['email' => 'The password reset token has expired. Please request a new one.']);
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $validReset->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find the password reset record with hashed token verification
        $passwordResets = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->get();

        $validReset = null;
        foreach ($passwordResets as $passwordReset) {
            if (Hash::check($request->token, $passwordReset->token)) {
                $validReset = $passwordReset;
                break;
            }
        }

        // Check if the reset record exists
        if (!$validReset) {
            return back()
                ->withErrors(['email' => 'Invalid password reset token.']);
        }

        // Check if the reset token has expired (30 minutes)
        if (Carbon::parse($validReset->created_at)->addMinutes(30)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            
            return back()
                ->withErrors(['email' => 'The password reset token has expired. Please request a new one.']);
        }

        // Find the user
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Invalidate all sessions for this user
        DB::table('sessions')->where('user_id', $user->id)->delete();

        // Delete the password reset record
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Redirect to login page with success message
        return redirect()->route('login')->with('status', 'Your password has been reset successfully! Please log in with your new password.');
    }
}
