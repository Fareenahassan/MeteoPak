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
    
    .forgot-password-container {
        min-height: calc(100vh - var(--navbar-height));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        position: relative;
        z-index: 1;
    }
    
    .forgot-password-wrapper {
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
        max-width: 480px;
        width: 100%;
    }
    
    [data-theme="dark"] .forgot-password-wrapper {
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
    
    .forgot-password-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 24px 24px 0 0;
    }
    
    .forgot-password-wrapper::after {
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
    
    .forgot-password-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .forgot-password-title {
        font-weight: 800;
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        position: relative;
    }
    
    .forgot-password-subtitle {
        color: var(--body-text);
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
    }
    
    .forgot-password-form {
        position: relative;
        z-index: 2;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
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
    
    .required-asterisk {
        color: #dc3545;
        font-weight: 700;
    }
    
    .form-control {
        padding: 1rem 1.25rem;
        border: 2px solid rgba(255, 173, 81, 0.15);
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 500;
        color: var(--black);
        background: linear-gradient(135deg, 
            rgba(255, 255, 255, 0.9) 0%, 
            rgba(207, 226, 255, 0.05) 100%);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        position: relative;
        z-index: 1;
    }
    
    /* Dark mode styling for form controls */
    [data-theme="dark"] .form-control {
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
    
    [data-theme="dark"] .form-control::placeholder {
        color: var(--body-text);
        opacity: 0.8;
    }
    
    .form-control:focus {
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 20px rgba(255, 173, 81, 0.1);
        background: var(--white);
        transform: translateY(-1px);
        outline: none;
    }
    
    [data-theme="dark"] .form-control:focus {
        background: var(--white);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 20px rgba(255, 173, 81, 0.15);
    }
    
    .form-control:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.25);
        transform: translateY(-1px);
    }
    
    [data-theme="dark"] .form-control:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.4);
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(55, 51, 51, 0.98) 50%, 
            var(--white) 100%);
    }
    
    .form-control.is-valid {
        border-color: #28a745;
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
    }
    
    [data-theme="dark"] .form-control.is-valid {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            var(--white) 100%);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
    }
    
    [data-theme="dark"] .form-control.is-invalid {
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
    
    .alert {
        border-radius: var(--border-radius);
        border: none;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }
    
    .alert-info {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(13, 202, 240, 0.05) 100%);
        color: #055160;
        border-left: 4px solid #0dcaf0;
    }
    
    .forgot-password-btn {
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
    
    .forgot-password-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
        transition: left 0.6s ease;
    }
    
    .forgot-password-btn:hover::before {
        left: 100%;
    }
    
    .forgot-password-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .forgot-password-btn:active {
        transform: translateY(0);
    }
    
    .forgot-password-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .back-to-login-link {
        color: var(--body-text);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        border-radius: 6px;
        width: 100%;
        justify-content: center;
        margin-top: 0.5rem;
    }
    
    .back-to-login-link:hover {
        color: var(--heading-color);
        background: rgba(255, 173, 81, 0.05);
        text-decoration: none;
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }
    
    .info-box {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(13, 202, 240, 0.05) 100%);
        border: 1px solid rgba(13, 202, 240, 0.2);
        border-left: 4px solid #0dcaf0;
        border-radius: var(--border-radius);
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        color: #055160;
        font-size: 0.9rem;
        line-height: 1.5;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .info-box i {
        color: #0dcaf0;
        font-size: 1rem;
        margin-top: 0.1rem;
        flex-shrink: 0;
    }
    
    /* Dark mode styling for info box */
    [data-theme="dark"] .info-box {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.15) 0%, rgba(13, 202, 240, 0.08) 100%);
        border: 1px solid rgba(13, 202, 240, 0.3);
        border-left: 4px solid #17a2b8;
        color: #9ec5fe;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
    }
    
    [data-theme="dark"] .info-box i {
        color: #17a2b8;
    }
    
    /* Enhanced Responsive Design */
    @media (max-width: 576px) {
        .forgot-password-wrapper {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .forgot-password-title {
            font-size: 1.8rem;
        }
        
        .forgot-password-subtitle {
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.875rem 1rem;
        }
        
        .forgot-password-btn {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
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

<div class="forgot-password-container">
    <div class="forgot-password-wrapper" data-aos="fade-up" data-aos-delay="200">
        <div class="forgot-password-header">
            <h1 class="forgot-password-title">Forgot Password</h1>
            <p class="forgot-password-subtitle">Enter your email to receive a password reset link</p>
        </div>

        <div class="forgot-password-form">
            @if (session('status'))
                <div class="alert alert-success" data-aos="fade-up" data-aos-delay="300">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <div class="info-box" data-aos="fade-up" data-aos-delay="350">
                <i class="fas fa-info-circle"></i>
                <div>
                    Enter your email address and we'll send you a secure link to reset your password. 
                    The link will expire in 60 minutes for security reasons.
                </div>
            </div>

            <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm" novalidate>
                @csrf

                <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        {{ __('Email Address') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        placeholder="Enter your email address"
                    >
                    <div class="invalid-feedback" id="email-error"></div>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div data-aos="fade-up" data-aos-delay="450">
                    <button type="submit" class="forgot-password-btn" id="submitBtn">
                        <span id="submitText">
                            <i class="fas fa-paper-plane me-2"></i>
                            {{ __('Send Reset Link') }}
                        </span>
                        <div class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
            </form>

            <div data-aos="fade-up" data-aos-delay="500">
                <a href="{{ route('login') }}" class="back-to-login-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to Login
                </a>
            </div>
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

        const form = document.getElementById('forgotPasswordForm');
        const emailInput = document.getElementById('email');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');

        // Email validation function
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Real-time email validation
        function validateEmailField(showError = true) {
            const email = emailInput.value.trim();
            const errorDiv = document.getElementById('email-error');
            
            let isValid = true;
            let errorMessage = '';

            if (!email) {
                isValid = false;
                errorMessage = 'Email address is required.';
            } else if (!validateEmail(email)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }

            if (showError) {
                if (isValid) {
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                    errorDiv.textContent = '';
                } else {
                    emailInput.classList.remove('is-valid');
                    emailInput.classList.add('is-invalid');
                    errorDiv.textContent = errorMessage;
                }
            }

            return isValid;
        }

        // Add event listeners for real-time validation
        emailInput.addEventListener('blur', function() {
            validateEmailField();
        });

        emailInput.addEventListener('input', function() {
            // Remove error state on input for better UX
            if (this.classList.contains('is-invalid')) {
                validateEmailField();
            }
        });

        // Enhanced form submission
        form.addEventListener('submit', function(e) {
            const isValid = validateEmailField(true);
            
            if (!isValid) {
                e.preventDefault();
                emailInput.focus();
                emailInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }

            // Enhanced loading state with animations
            submitBtn.disabled = true;
            submitBtn.style.transform = 'scale(0.98)';
            
            const originalHTML = submitText.innerHTML;
            submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitSpinner.classList.remove('d-none');
            
            // Simulate realistic loading time for better UX
            setTimeout(() => {
                submitBtn.style.opacity = '0.8';
            }, 100);
        });

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target === emailInput) {
                if (validateEmailField(true)) {
                    form.submit();
                }
            }
        });

        // Add ripple effect to button
        submitBtn.addEventListener('click', function(e) {
            if (!this.disabled) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            }
        });
    });

    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            0% {
                transform: scale(0);
                opacity: 1;
            }
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
@endsection