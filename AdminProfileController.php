<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    /**
     * Show the admin profile edit form.
     */
    public function edit()
    {
        return view('admin.profile.edit');
    }

    /**
     * Update the admin's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'description' => 'nullable|string|max:500',
        ]);

        $user->update([
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the admin's profile image.
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Delete old profile image if exists
        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
        }

        // Store new profile image
        $path = $request->file('profile_image')->store('profile', 'public');

        $user->update([
            'profile_image' => $path,
        ]);

        return redirect()->route('admin.profile.edit')->with('success', 'Profile image updated successfully!');
    }

    /**
     * Remove the admin's profile image.
     */
    public function removeImage()
    {
        $user = auth()->user();

        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
            $user->update(['profile_image' => null]);
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Profile image removed successfully!');
    }
} 