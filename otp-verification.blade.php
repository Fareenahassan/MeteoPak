@extends('layouts.app')

@push('styles')
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
<style>
    :root {
        /* Clean Theme Color Palette - Light Mode */
        --primary-bg: #FFFFFF;
        --heading-color: #FFAD51;
        --container-bg: #CFE2FF;
        --body-text: #898E8F;
        --scrollbar-accent: #FFAD51;
        --white: #FFFFFF;
        --black: #000000;
        --border-radius: 12px;
        --section-padding: 100px;
        
        /* Navbar height for consistency with app.css */
        --navbar-height: 56px;
        
        /* Theme variables for navbar consistency */
        --navbar-text-color: var(--theme-text-primary, #000000);
        --navbar-bg: var(--theme-bg-primary, #FFFFFF);
        --navbar-dropdown-bg: var(--theme-dropdown-bg, #FFFFFF);
    }
    
    /* Dark Theme Variables */
    [data-theme="dark"] {
        --primary-bg: var(--theme-bg-primary, #252222);
        --heading-color: #FFAD51;
        --container-bg: var(--theme-bg-tertiary, #3a3636);
        --body-text: var(--theme-text-secondary, #adb5bd);
        --white: var(--theme-card-bg, #2f2b2b);
        --black: var(--theme-text-primary, #ffffff);
        --navbar-text-color: var(--theme-text-primary, #ffffff);
        --navbar-bg: var(--theme-navbar-bg, #2f2b2b);
        --navbar-dropdown-bg: var(--theme-dropdown-bg, #3a3636);
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        font-weight: 400;
        line-height: 1.6;
        color: var(--body-text);
        background: var(--primary-bg);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
        padding-top: var(--navbar-height);
        min-height: 100vh;
        position: relative;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, 
            rgba(207, 226, 255, 0.03) 0%, 
            rgba(255, 173, 81, 0.02) 25%,
            rgba(207, 226, 255, 0.03) 50%,
            rgba(255, 173, 81, 0.02) 75%,
            rgba(207, 226, 255, 0.03) 100%);
        pointer-events: none;
        z-index: 0;
    }
    
    .otp-container {
        min-height: calc(100vh - var(--navbar-height));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        position: relative;
        z-index: 1;
    }
    
    .otp-wrapper {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 50%, 
            var(--white) 100%);
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.08),
            0 8px 25px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 173, 81, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        max-width: 520px;
        width: 100%;
    }
    
    [data-theme="dark"] .otp-wrapper {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(47, 43, 43, 0.98) 50%, 
            var(--white) 100%);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.4),
            0 8px 25px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 173, 81, 0.2);
    }
    
    .otp-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 24px 24px 0 0;
    }
    
    .otp-wrapper::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255, 173, 81, 0.04) 0%, transparent 70%);
        transform: translate(-50%, -50%);
        border-radius: 50%;
        pointer-events: none;
        animation: subtlePulse 4s ease-in-out infinite;
    }
    
    @keyframes subtlePulse {
        0%, 100% { 
            opacity: 0.5; 
            transform: translate(-50%, -50%) scale(1);
        }
        50% { 
            opacity: 0.8; 
            transform: translate(-50%, -50%) scale(1.1);
        }
    }
    
    .otp-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .otp-title {
        font-weight: 800;
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .otp-title i {
        color: var(--heading-color);
        font-size: 1.8rem;
    }
    
    .otp-subtitle {
        color: var(--body-text);
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 1rem;
    }
    
    .info-alert {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.1) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
        border-radius: var(--border-radius);
        padding: 1.25rem;
        margin-bottom: 2rem;
        color: var(--black);
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        position: relative;
        z-index: 2;
    }
    
    .info-alert i {
        color: var(--heading-color);
        font-size: 1.1rem;
        margin-top: 0.1rem;
        flex-shrink: 0;
    }
    
    .info-alert .email-highlight {
        color: var(--heading-color);
        font-weight: 700;
    }
    
    .otp-form {
        position: relative;
        z-index: 2;
    }
    
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-label i {
        color: var(--heading-color);
        font-size: 0.9rem;
    }
    
    .otp-input {
        padding: 1.25rem 1.5rem;
        border: 2px solid rgba(255, 173, 81, 0.15);
        border-radius: var(--border-radius);
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--black);
        background: linear-gradient(135deg, 
            rgba(255, 255, 255, 0.9) 0%, 
            rgba(207, 226, 255, 0.05) 100%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        text-align: center;
        letter-spacing: 0.5rem;
        width: 100%;
    }
    
    .otp-input:focus {
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 20px rgba(255, 173, 81, 0.1);
        background: var(--white);
        transform: translateY(-1px);
        outline: none;
    }
    
    .otp-input:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.25);
        transform: translateY(-1px);
    }
    
    /* Dark mode styling for OTP input */
    [data-theme="dark"] .otp-input {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(47, 43, 43, 0.98) 50%, 
            var(--white) 100%);
        color: var(--black);
        border-color: rgba(255, 173, 81, 0.25);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    [data-theme="dark"] .otp-input::placeholder {
        color: var(--body-text);
        opacity: 0.8;
    }
    
    [data-theme="dark"] .otp-input:focus {
        background: var(--white);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 20px rgba(255, 173, 81, 0.15);
    }
    
    [data-theme="dark"] .otp-input:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.4);
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(55, 51, 51, 0.98) 50%, 
            var(--white) 100%);
    }
    
    .otp-input.is-invalid {
        border-color: #dc3545;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
        animation: shake 0.5s ease-in-out;
    }
    
    [data-theme="dark"] .otp-input.is-invalid {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            var(--white) 100%);
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .invalid-feedback::before {
        content: '\f06a';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        font-size: 0.8rem;
    }
    
    .verify-btn {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        color: var(--white);
        border: none;
        border-radius: var(--border-radius);
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 4px 15px rgba(255, 173, 81, 0.3),
            0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    
    .verify-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
        transition: left 0.6s ease;
    }
    
    .verify-btn:hover::before {
        left: 100%;
    }
    
    .verify-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .verify-btn:active {
        transform: translateY(0);
    }
    
    .verify-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .divider {
        margin: 2rem 0;
        border: none;
        height: 1px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 173, 81, 0.2) 50%, 
            transparent 100%);
    }
    
    .resend-section {
        text-align: center;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }
    
    .resend-text {
        color: var(--body-text);
        font-weight: 500;
        margin-bottom: 0.75rem;
    }
    
    .resend-btn {
        background: none;
        border: none;
        color: var(--heading-color);
        text-decoration: underline;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .resend-btn:hover {
        background: rgba(255, 173, 81, 0.1);
        text-decoration: none;
        transform: translateY(-1px);
    }
    
    .back-to-login {
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .back-btn {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.1) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        color: var(--heading-color);
        border: 2px solid rgba(255, 173, 81, 0.2);
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .back-btn:hover {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.15) 0%, 
            rgba(255, 173, 81, 0.08) 100%);
        border-color: rgba(255, 173, 81, 0.3);
        transform: translateY(-1px);
        color: var(--heading-color);
        text-decoration: none;
    }
    
    .alert {
        border-radius: var(--border-radius);
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 2;
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    /* Dark mode alert styles */
    [data-theme="dark"] .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.15) 0%, rgba(40, 167, 69, 0.08) 100%);
        color: #d1e7dd;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }
    
    [data-theme="dark"] .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15) 0%, rgba(220, 53, 69, 0.08) 100%);
        color: #f5c2c7;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }
    
    /* Enhanced Responsive Design */
    @media (max-width: 576px) {
        .otp-wrapper {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .otp-title {
            font-size: 1.8rem;
        }
        
        .otp-subtitle {
            font-size: 0.9rem;
        }
        
        .otp-input {
            padding: 1rem 1.25rem;
            font-size: 1.3rem;
            letter-spacing: 0.3rem;
        }
        
        .verify-btn {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
        
        .info-alert {
            padding: 1rem;
        }
    }
    
    /* Animations */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--white);
        border-radius: var(--border-radius);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--scrollbar-accent);
        border-radius: var(--border-radius);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #e89640;
    }
    
    /* Text Selection */
    ::selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
    ::-moz-selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
</style>

<div class="otp-container">
    <div class="otp-wrapper" data-aos="fade-up" data-aos-delay="200">
        <div class="otp-header">
            <h1 class="otp-title">
                <i class="fas fa-shield-alt"></i>
                OTP Verification
            </h1>
            <p class="otp-subtitle">Secure your admin access with verification</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success" data-aos="fade-in">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('error'))
            <div class="alert alert-danger" data-aos="fade-in">
                <i class="fas fa-exclamation-triangle"></i>
                {{ $errors->first('error') }}
            </div>
        @endif

        <div class="info-alert" data-aos="fade-up" data-aos-delay="300">
            <i class="fas fa-info-circle"></i>
            <div>
                We've sent a 6-digit verification code to <span class="email-highlight">{{ $email }}</span>. 
                Please check your email and enter the code below.
            </div>
        </div>

        <form method="POST" action="{{ route('admin.otp.verify') }}" class="otp-form" data-aos="fade-up" data-aos-delay="400">
            @csrf

            <div class="form-group">
                <label for="otp" class="form-label">
                    <i class="fas fa-key"></i>
                    {{ __('Verification Code') }}
                </label>
                <input 
                    id="otp" 
                    type="text" 
                    class="otp-input @error('otp') is-invalid @enderror" 
                    name="otp" 
                    value="{{ old('otp') }}" 
                    required 
                    autocomplete="off" 
                    placeholder="Enter 6-digit code" 
                    maxlength="6" 
                    pattern="[0-9]{6}"
                >

                @error('otp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div data-aos="fade-up" data-aos-delay="500">
                <button type="submit" class="verify-btn">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Verify OTP') }}
                </button>
            </div>
        </form>

        <hr class="divider">

        <div class="resend-section" data-aos="fade-up" data-aos-delay="600">
            <p class="resend-text">Didn't receive the code?</p>
            <form method="POST" action="{{ route('admin.otp.resend') }}" class="d-inline" id="resendForm">
                @csrf
                <button type="submit" class="resend-btn" id="resendBtn">
                    <i class="fas fa-paper-plane" id="resendIcon"></i>
                    <span id="resendText">Send a new code</span>
                </button>
            </form>
        </div>

        <div class="back-to-login" data-aos="fade-up" data-aos-delay="700">
            <a href="{{ route('login') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Login
            </a>
        </div>
    </div>
</div>

@push('scripts')
<!-- AOS Animation Library Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-quart',
            once: true,
            offset: 50,
            delay: 100
        });

        const otpInput = document.getElementById('otp');
        const otpForm = otpInput.form;

        // Auto-focus on OTP input with enhanced animation
        otpInput.focus();
        otpInput.style.animation = 'fadeInUp 0.6s ease-out';

        // Enhanced auto-submit when 6 digits are entered
        otpInput.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            
            // Add visual feedback for each digit
            if (e.target.value.length > 0) {
                e.target.style.borderColor = 'var(--heading-color)';
                e.target.style.boxShadow = '0 0 0 3px rgba(255, 173, 81, 0.15)';
            }
            
            if (e.target.value.length === 6) {
                // Visual feedback for complete code
                e.target.style.background = 'linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, var(--white) 100%)';
                e.target.style.borderColor = '#28a745';
                
                // Small delay to ensure the last digit is processed and show completion
                setTimeout(function() {
                    // Add loading state to form
                    const submitBtn = otpForm.querySelector('.verify-btn');
                    const originalContent = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
                    submitBtn.disabled = true;
                    
                    // Submit after brief delay for better UX
                    setTimeout(() => {
                        otpForm.submit();
                    }, 300);
                }, 100);
            } else if (e.target.value.length < 6) {
                // Reset styling for incomplete code
                e.target.style.background = '';
                e.target.style.borderColor = '';
                e.target.style.boxShadow = '';
            }
        });

        // Enhanced number-only input with better UX
        otpInput.addEventListener('keypress', function(e) {
            // Allow numbers, backspace, delete, tab, and arrow keys
            if (!/[0-9]/.test(e.key) && 
                !['Backspace', 'Delete', 'Tab', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
                e.preventDefault();
                
                // Visual feedback for invalid input
                this.style.animation = 'shake 0.3s ease-in-out';
                setTimeout(() => {
                    this.style.animation = '';
                }, 300);
            }
        });

        // Enhanced paste handling
        otpInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = (e.clipboardData || window.clipboardData).getData('text');
            const numericData = pastedData.replace(/[^0-9]/g, '').slice(0, 6);
            
            if (numericData.length > 0) {
                this.value = numericData;
                this.dispatchEvent(new Event('input'));
                
                // Visual feedback for successful paste
                this.style.background = 'linear-gradient(135deg, rgba(255, 173, 81, 0.1) 0%, var(--white) 100%)';
                setTimeout(() => {
                    this.style.background = '';
                }, 1000);
            }
        });

        // Form submission enhancement
        otpForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.verify-btn');
            
            if (otpInput.value.length !== 6) {
                e.preventDefault();
                
                // Focus and shake animation for incomplete code
                otpInput.focus();
                otpInput.style.animation = 'shake 0.5s ease-in-out';
                otpInput.style.borderColor = '#dc3545';
                
                setTimeout(() => {
                    otpInput.style.animation = '';
                    otpInput.style.borderColor = '';
                }, 500);
                
                return false;
            }
            
            // Enhanced loading state
            if (!submitBtn.disabled) {
                const originalContent = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
                submitBtn.disabled = true;
                submitBtn.style.transform = 'scale(0.98)';
                
                // Disable OTP input during submission
                otpInput.disabled = true;
                otpInput.style.opacity = '0.7';
            }
        });

        // Enhanced focus effects
        otpInput.addEventListener('focus', function() {
            this.style.transform = 'translateY(-1px)';
            this.parentNode.style.transform = 'scale(1.02)';
        });

        otpInput.addEventListener('blur', function() {
            this.style.transform = '';
            this.parentNode.style.transform = '';
        });

        // Auto-clear server-side errors with smooth animation
        if (otpInput.classList.contains('is-invalid')) {
            otpInput.addEventListener('input', function() {
                const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                if (errorDiv) {
                    errorDiv.style.opacity = '0';
                    setTimeout(() => {
                        this.classList.remove('is-invalid');
                        errorDiv.style.display = 'none';
                    }, 300);
                }
            });
        }

        // Enhanced resend functionality
        const resendForm = document.getElementById('resendForm');
        const resendBtn = document.getElementById('resendBtn');
        const resendIcon = document.getElementById('resendIcon');
        const resendText = document.getElementById('resendText');

        if (resendForm && resendBtn) {
            resendForm.addEventListener('submit', function(e) {
                // Add loading state
                resendBtn.disabled = true;
                resendIcon.className = 'fas fa-spinner fa-spin';
                resendText.textContent = 'Sending...';
                resendBtn.style.opacity = '0.8';
                resendBtn.style.transform = 'scale(0.98)';
            });
        }

        // Add ripple effect to buttons
        const buttons = document.querySelectorAll('.verify-btn, .resend-btn, .back-btn');
        buttons.forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple effect
        if (!document.querySelector('#otp-ripple-styles')) {
            const style = document.createElement('style');
            style.id = 'otp-ripple-styles';
            style.textContent = `
                .ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(0);
                    animation: rippleEffect 0.6s ease-out;
                    pointer-events: none;
                }
                
                @keyframes rippleEffect {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && document.activeElement === otpInput) {
                if (otpInput.value.length === 6) {
                    otpForm.submit();
                }
            }
        });

        // Add accessibility enhancements
        otpInput.setAttribute('aria-describedby', 'otp-help');
        otpInput.setAttribute('aria-label', 'Enter 6-digit verification code');
        
        // Create hidden help text for screen readers
        const helpText = document.createElement('div');
        helpText.id = 'otp-help';
        helpText.className = 'sr-only';
        helpText.textContent = 'Enter the 6-digit verification code sent to your email. The form will auto-submit when complete.';
        otpInput.parentNode.appendChild(helpText);
    });
</script>
@endpush
@endsection 