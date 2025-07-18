<?php

namespace App\Repositories;

use App\Models\User;
use App\Notifications\AccountApprovedNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UserRepository
{
    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::with(['region', 'station'])->get();
    }

    /**
     * Get users by status.
     *
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersByStatus(string $status)
    {
        return User::where('status', $status)
            ->with(['region', 'station'])
            ->get();
    }

    /**
     * Get user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id)
    {
        return User::with(['region', 'station'])->find($id);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {
        $userData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'personal_number' => $data['personal_number'],
            'region_id' => $data['region_id'],
            'station_id' => $data['station_id'],
            'designation' => $data['designation'],
            'gender' => $data['gender'],
            'status' => 'inactive', // Default to inactive until approved
            'role' => 'user', // Default role
        ];

        return User::create($userData);
    }

    /**
     * Update a user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    /**
     * Update user profile.
     *
     * @param User $user
     * @param array $data
     * @param UploadedFile|null $profileImage
     * @return User
     */
    public function updateProfile(User $user, array $data, ?UploadedFile $profileImage = null)
    {
        if ($profileImage) {
            // Delete old profile image if exists
            if ($user->profile_image && file_exists(public_path('images/profile/' . $user->profile_image))) {
                unlink(public_path('images/profile/' . $user->profile_image));
            }

            // Save new profile image
            $imageName = time() . '_' . $user->id . '.' . $profileImage->extension();
            $profileImage->move(public_path('images/profile'), $imageName);
            $data['profile_image'] = $imageName;
        }

        $user->update($data);
        return $user;
    }

    /**
     * Approve a user account.
     *
     * @param User $user
     * @param bool $sendNotification
     * @return User
     */
    public function approveUser(User $user, bool $sendNotification = true)
    {
        $user->status = 'active';
        $user->save();

        if ($sendNotification) {
            $user->notify(new AccountApprovedNotification());
        }

        return $user;
    }

    /**
     * Deactivate a user account.
     *
     * @param User $user
     * @return User
     */
    public function deactivateUser(User $user)
    {
        $user->status = 'inactive';
        $user->save();

        return $user;
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool|null
     */
    public function deleteUser(User $user)
    {
        // Delete profile image if exists
        if ($user->profile_image && file_exists(public_path('images/profile/' . $user->profile_image))) {
            unlink(public_path('images/profile/' . $user->profile_image));
        }

        return $user->delete();
    }

    /**
     * Get admin users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAdminUsers()
    {
        return User::where('is_admin', true)
            ->orWhere('role', 'admin')
            ->get();
    }
}