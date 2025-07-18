<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AdminOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp_code',
        'expires_at',
        'is_verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    /**
     * Generate a new OTP for a user
     */
    public static function generateOtp($userId)
    {
        // Delete any existing OTPs for this user
        self::where('user_id', $userId)->delete();

        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Create new OTP record
        return self::create([
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10), // OTP expires in 10 minutes
            'is_verified' => false
        ]);
    }

    /**
     * Verify OTP code
     */
    public static function verifyOtp($userId, $otpCode)
    {
        $otp = self::where('user_id', $userId)
            ->where('otp_code', $otpCode)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_verified', false)
            ->first();

        if ($otp) {
            $otp->update(['is_verified' => true]);
            return true;
        }

        return false;
    }

    /**
     * Check if user has a valid pending OTP
     */
    public static function hasPendingOtp($userId)
    {
        return self::where('user_id', $userId)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_verified', false)
            ->exists();
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 