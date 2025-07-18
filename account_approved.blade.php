@component('mail::message')

{{-- Header Section --}}
@component('mail::panel')
<div style="text-align: center; padding: 20px 0;">
    <h1 style="color: #1a365d; margin: 0; font-size: 28px; font-weight: 600;">
        ✅ Account Approval Confirmation
    </h1>
    <p style="color: #4a5568; margin: 8px 0 0 0; font-size: 16px;">
        Welcome to {{ config('app.name') }}
    </p>
</div>
@endcomponent

{{-- Greeting --}}
<div style="margin: 30px 0 20px 0;">
    <p style="font-size: 18px; color: #2d3748; margin: 0;">
        Dear <strong style="color: #1a365d;">{{ $user->username }}</strong>,
    </p>
</div>

{{-- Main Message --}}
<div style="background-color: #f0fff4; padding: 25px; border-radius: 8px; margin: 25px 0; border-left: 4px solid #38a169;">
    <p style="color: #22543d; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
        We are pleased to inform you that your account registration has been approved. You now have full access to our platform and may begin utilizing all available services.
    </p>
</div>

{{-- Account Details --}}
<div style="margin: 30px 0;">
    <h3 style="color: #1a365d; font-size: 20px; margin: 0 0 20px 0; font-weight: 600;">
        📋 Account Details
    </h3>
    
    @component('mail::panel')
    <div style="background-color: #f7fafc; padding: 20px; border-radius: 8px;">
        <div style="margin-bottom: 12px;">
            <strong style="color: #4a5568;">Account Holder:</strong> 
            <span style="color: #1a365d; font-weight: 600;">{{ $user->username }}</span>
        </div>
        <div style="margin-bottom: 12px;">
            <strong style="color: #4a5568;">Region:</strong> 
            <span style="color: #1a365d; font-weight: 600;">{{ $user->region->name }}</span>
        </div>
        <div style="margin-bottom: 12px;">
            <strong style="color: #4a5568;">Station:</strong> 
            <span style="color: #1a365d; font-weight: 600;">{{ $user->station->name }}</span>
        </div>
        <div>
            <strong style="color: #4a5568;">Designation:</strong> 
            <span style="color: #1a365d; font-weight: 600;">{{ $user->designation }}</span>
        </div>
    </div>
    @endcomponent
</div>

{{-- Access Button --}}
<div style="text-align: center; margin: 30px 0;">
    @component('mail::button', ['url' => route('login'), 'color' => 'primary'])
    Access Your Account
    @endcomponent
</div>

{{-- Profile Completion Section --}}
<div style="margin: 30px 0;">
    <h3 style="color: #1a365d; font-size: 20px; margin: 0 0 20px 0; font-weight: 600;">
        👤 Profile Completion
    </h3>
    
    <div style="background-color: #fffaf0; padding: 20px; border-radius: 8px; border-left: 4px solid #ed8936;">
        <p style="color: #744210; font-size: 16px; line-height: 1.6; margin: 0 0 15px 0;">
            To ensure optimal functionality, please complete your profile by adding the following information:
        </p>
        
        <ul style="color: #744210; margin: 0; padding-left: 20px; line-height: 1.6;">
            <li style="margin-bottom: 8px;">Date of birth</li>
            <li style="margin-bottom: 8px;">Profile picture</li>
            <li>Professional biography</li>
        </ul>
    </div>
</div>

{{-- Next Steps --}}
<div style="margin: 30px 0;">
    <h3 style="color: #1a365d; font-size: 20px; margin: 0 0 20px 0; font-weight: 600;">
        🚀 Next Steps
    </h3>
    
    @component('mail::panel')
    <div style="background-color: #edf2f7; padding: 20px; border-radius: 8px;">
        <ol style="color: #4a5568; margin: 0; padding-left: 20px; line-height: 1.8;">
            <li style="margin-bottom: 8px;">Log in using your registered credentials</li>
            <li style="margin-bottom: 8px;">Complete your profile information</li>
            <li>Begin exploring platform features</li>
        </ol>
    </div>
    @endcomponent
</div>

{{-- Help Section --}}
<div style="background-color: #f0fff4; padding: 20px; border-radius: 8px; margin: 25px 0;">
    <p style="color: #38a169; font-size: 14px; margin: 0; text-align: center;">
        <strong>💡 Need Assistance?</strong><br>
        Should you require assistance or have any questions, please contact our support team.
    </p>
</div>

{{-- Footer --}}
<div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
    <p style="color: #4a5568; font-size: 16px; margin: 0 0 10px 0;">
        Best regards,<br>
        <strong style="color: #1a365d;">The {{ config('app.name') }} Team</strong>
    </p>
</div>

@component('mail::subcopy')
**Having trouble with the button above?** Copy and paste this URL into your web browser:  
{{ route('login') }}
@endcomponent
@endcomponent