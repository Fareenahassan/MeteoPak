<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    /**
     * Show the change password form.
     *
     * @return \Illuminate\View\View
     */
    public function showChangePasswordForm()
    {
        return view('user.change-password');
    }

    /**
     * Handle password change request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ]);

        $user = auth()->user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Check if the new password is different from the current password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The new password must be different from your current password.']);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.dashboard')->with('success', 'Your password has been changed successfully!');
    }
} 