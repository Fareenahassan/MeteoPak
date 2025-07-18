<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Display the form to request a password reset.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Generate a secure token
        $token = Str::random(60);

        // Store the hashed token in the database for security
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        // Send the password reset email
        try {
            $this->sendResetEmail($user, $token);
            
            return back()->with('status', 'A password reset link has been sent to your email address.');
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to send password reset email: ' . $e->getMessage());
            
            return back()->withErrors(['email' => 'Unable to send password reset email. Please try again later.']);
        }
    }

    /**
     * Send the password reset link email.
     *
     * @param  \App\Models\User  $user
     * @param  string  $token
     * @return void
     */
    protected function sendResetEmail($user, $token)
    {
        $resetUrl = route('password.reset', ['token' => $token]);
        
        Mail::send('emails.password-reset', ['user' => $user, 'resetUrl' => $resetUrl, 'token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Reset Your Password');
        });
    }
}