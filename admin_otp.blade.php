@component('mail::message')

{{-- Header Section --}}
@component('mail::panel')
<div style="text-align: center; padding: 20px 0;">
    <h1 style="color: #1a365d; margin: 0; font-size: 28px; font-weight: 600;">
        🔐 Admin Access Verification
    </h1>
    <p style="color: #4a5568; margin: 8px 0 0 0; font-size: 16px;">
        Secure Login Authentication Required
    </p>
</div>
@endcomponent

{{-- Greeting --}}
<div style="margin: 30px 0 20px 0;">
    <p style="font-size: 18px; color: #2d3748; margin: 0;">
        Hello <strong style="color: #1a365d;">{{ $name }}</strong>,
    </p>
</div>

{{-- Main Message --}}
<div style="background-color: #f7fafc; padding: 25px; border-radius: 8px; margin: 25px 0;">
    <p style="color: #4a5568; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
        A login attempt has been detected for your admin account. To ensure the security of your account, 
        please verify your identity using the One-Time Password below.
    </p>
</div>

{{-- OTP Display --}}
@component('mail::panel')
<div style="text-align: center; padding: 25px;">
    <p style="color: #4a5568; font-size: 14px; margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 1px; font-weight: 500;">
        Your Verification Code
    </p>
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; margin: 10px 0;">
        <h2 style="font-size: 32px; font-weight: 700; letter-spacing: 3px; margin: 0; font-family: 'Courier New', monospace; text-align: center;">
            {{ $otpCode }}
        </h2>
    </div>
    <p style="color: #e53e3e; font-size: 14px; margin: 15px 0 0 0; font-weight: 500;">
        ⏱️ Expires in {{ $expiresAt }}
    </p>
</div>
@endcomponent

{{-- Security Information --}}
<div style="background-color: #fff5f5; border-left: 4px solid #e53e3e; padding: 20px; margin: 25px 0;">
    <h3 style="color: #c53030; font-size: 16px; margin: 0 0 12px 0; font-weight: 600;">
        🛡️ Security Notice
    </h3>
    <ul style="color: #744210; margin: 0; padding-left: 20px; line-height: 1.6;">
        <li style="margin-bottom: 8px;">This OTP is valid for <strong>{{ $expiresAt }}</strong> only</li>
        <li style="margin-bottom: 8px;">Never share this code with anyone, including PMD staff</li>
        <li style="margin-bottom: 8px;">If you didn't request this login, please contact your IT administrator immediately</li>
        <li>This code can only be used once for security purposes</li>
    </ul>
</div>



{{-- Alternative Access --}}
<div style="background-color: #f0fff4; padding: 20px; border-radius: 8px; margin: 25px 0;">
    <p style="color: #38a169; font-size: 14px; margin: 0; text-align: center;">
        <strong>💡 Need Help?</strong><br>
        If you're having trouble with the verification process, please contact your system administrator.
    </p>
</div>

{{-- Footer --}}
<div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
    <p style="color: #4a5568; font-size: 16px; margin: 0 0 10px 0;">
        Best regards,<br>
        <strong style="color: #1a365d;">{{ config('app.name') }} Security Team</strong>
    </p>

</div>

@endcomponent 