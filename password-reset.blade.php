@component('mail::message')

{{-- Header Section --}}
@component('mail::panel')
<div style="text-align: center; padding: 20px 0;">
    <h1 style="color: #1a365d; margin: 0; font-size: 28px; font-weight: 600;">
        🔑 Reset Your Password
    </h1>
    <p style="color: #4a5568; margin: 8px 0 0 0; font-size: 16px;">
        Secure Password Recovery Request
    </p>
</div>
@endcomponent

{{-- Greeting --}}
<div style="margin: 30px 0 20px 0;">
    <p style="font-size: 18px; color: #2d3748; margin: 0;">
        Hello <strong style="color: #1a365d;">{{ $user->name }}</strong>,
    </p>
</div>

{{-- Main Message --}}
<div style="background-color: #f7fafc; padding: 25px; border-radius: 8px; margin: 25px 0;">
    <p style="color: #4a5568; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
        We received a request to reset your password for your account. If you made this request, please click the button below to set a new password:
    </p>
</div>

{{-- Reset Button --}}
<div style="text-align: center; margin: 30px 0;">
    @component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
    Reset My Password
    @endcomponent
</div>

{{-- Fallback Link --}}
<div style="background-color: #edf2f7; padding: 20px; border-radius: 8px; margin: 25px 0;">
    <p style="color: #4a5568; font-size: 14px; margin: 0 0 10px 0;">
        If the button above doesn't work, you can copy and paste the following link into your browser:
    </p>
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; font-family: 'Courier New', monospace; font-size: 12px; word-break: break-all; color: #2d3748; border: 1px solid #e2e8f0;">
        {{ $resetUrl }}
    </div>
</div>

{{-- Security Warning --}}
<div style="background-color: #fff5f5; border-left: 4px solid #e53e3e; padding: 20px; margin: 25px 0;">
    <h3 style="color: #c53030; font-size: 16px; margin: 0 0 12px 0; font-weight: 600;">
        ⚠️ Important Security Notice
    </h3>
    <ul style="color: #744210; margin: 0; padding-left: 20px; line-height: 1.6;">
        <li style="margin-bottom: 8px;"><strong>This password reset link will expire in 30 minutes</strong> for security reasons</li>
        <li style="margin-bottom: 8px;">If you did not request a password reset, please ignore this email or contact our support team</li>
        <li style="margin-bottom: 8px;">For your security, never share this link with anyone</li>
        <li>If you have concerns about your account security, contact support immediately</li>
    </ul>
</div>

{{-- Help Section --}}
<div style="background-color: #f0fff4; padding: 20px; border-radius: 8px; margin: 25px 0;">
    <p style="color: #38a169; font-size: 14px; margin: 0; text-align: center;">
        <strong>💡 Need Help?</strong><br>
        If you're having trouble with the link above, copy and paste the URL into your web browser or contact our support team.
    </p>
</div>

{{-- Footer --}}
<div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
    <p style="color: #4a5568; font-size: 16px; margin: 0 0 10px 0;">
        Best regards,<br>
        <strong style="color: #1a365d;">{{ config('app.name') }} Security Team</strong>
    </p>
    <p style="color: #718096; font-size: 14px; margin: 10px 0 0 0;">
        This is an automated message, please do not reply to this email.
    </p>
</div>

@endcomponent
