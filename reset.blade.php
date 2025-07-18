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
    
    .reset-container {
        min-height: calc(100vh - var(--navbar-height));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        position: relative;
        z-index: 1;
    }
    
    .reset-wrapper {
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
        max-width: 500px;
        width: 100%;
    }
    
    [data-theme="dark"] .reset-wrapper {
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
    
    .reset-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 24px 24px 0 0;
    }
    
    .reset-wrapper::after {
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
    
    .reset-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .reset-title {
        font-weight: 800;
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        position: relative;
    }
    
    .reset-subtitle {
        color: var(--body-text);
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
    }
    
    .reset-form {
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
    
    .password-strength {
        margin-top: 0.5rem;
    }
    
    .progress {
        height: 4px;
        border-radius: 2px;
        background: rgba(255, 173, 81, 0.1);
        overflow: hidden;
    }
    
    .progress-bar {
        transition: all 0.3s ease;
    }
    
    .form-text {
        font-size: 0.8rem;
        color: var(--body-text);
        margin-top: 0.25rem;
        opacity: 0.8;
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
    
    .alert p {
        margin: 0;
        line-height: 1.5;
    }
    
    .reset-btn {
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
    
    .reset-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
        transition: left 0.6s ease;
    }
    
    .reset-btn:hover::before {
        left: 100%;
    }
    
    .reset-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .reset-btn:active {
        transform: translateY(0);
    }
    
    .reset-btn:disabled {
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
    
    /* Enhanced Responsive Design */
    @media (max-width: 576px) {
        .reset-wrapper {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .reset-title {
            font-size: 1.8rem;
        }
        
        .reset-subtitle {
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.875rem 1rem;
        }
        
        .reset-btn {
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

<div class="reset-container">
    <div class="reset-wrapper" data-aos="fade-up" data-aos-delay="200">
        <div class="reset-header">
            <h1 class="reset-title">Reset Password</h1>
            <p class="reset-subtitle">Create a new password for your account</p>
        </div>

        <div class="reset-form">
            @if (session('status'))
                <div class="alert alert-success" data-aos="fade-in">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <div class="alert alert-info" data-aos="fade-up" data-aos-delay="250">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Reset Your Password</strong>
                    <p>Please enter your new password below to complete the password reset process.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i>
                        {{ __('New Password') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        required 
                        autocomplete="new-password" 
                        autofocus
                        placeholder="Enter your new password"
                    >
                    <div class="invalid-feedback" id="password-error"></div>
                    <div class="password-strength">
                        <div class="progress">
                            <div class="progress-bar" id="password-strength-bar" role="progressbar" style="width: 0%"></div>
                        </div>
                        <small id="password-strength-text" class="form-text">Password strength: <span id="strength-level">-</span></small>
                    </div>
                    <small class="form-text">Password must be at least 8 characters with uppercase, lowercase, number, and special character.</small>
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="350">
                    <label for="password-confirm" class="form-label">
                        <i class="fas fa-lock"></i>
                        {{ __('Confirm New Password') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <input 
                        id="password-confirm" 
                        type="password" 
                        class="form-control" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Confirm your new password"
                    >
                    <div class="invalid-feedback" id="password-confirm-error"></div>
                </div>

                <div data-aos="fade-up" data-aos-delay="400">
                    <button type="submit" class="reset-btn" id="submitBtn">
                        <span id="submitText">
                            <i class="fas fa-key me-2"></i>
                            {{ __('Reset Password') }}
                        </span>
                        <div class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                    
                    <a class="back-to-login-link" href="{{ route('login') }}">
                        <i class="fas fa-arrow-left"></i>
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
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

        const form = document.getElementById('resetForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');

        // Validation rules
        const validationRules = {
            password: {
                required: true,
                minLength: 8,
                pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/,
                message: 'Password must be at least 8 characters with uppercase, lowercase, number, and special character.'
            },
            password_confirmation: {
                required: true,
                matchField: 'password',
                message: 'Password confirmation must match the password.'
            }
        };

        // Real-time validation function
        function validateField(fieldName, value, showError = true) {
            const rule = validationRules[fieldName];
            const field = document.getElementById(fieldName === 'password_confirmation' ? 'password-confirm' : fieldName);
            const errorDiv = document.getElementById(fieldName === 'password_confirmation' ? 'password-confirm-error' : fieldName + '-error');
            
            if (!rule) return true;

            let isValid = true;
            let errorMessage = '';

            // Check required
            if (rule.required && (!value || value.trim() === '')) {
                isValid = false;
                errorMessage = `${fieldName.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())} is required.`;
            }
            // Check min length
            else if (rule.minLength && value.length < rule.minLength) {
                isValid = false;
                errorMessage = rule.message || `Minimum ${rule.minLength} characters required.`;
            }
            // Check pattern
            else if (rule.pattern && !rule.pattern.test(value)) {
                isValid = false;
                errorMessage = rule.message || 'Invalid format.';
            }
            // Check match field (for password confirmation)
            else if (rule.matchField) {
                const matchFieldValue = document.getElementById(rule.matchField).value;
                if (value !== matchFieldValue) {
                    isValid = false;
                    errorMessage = rule.message || 'Fields do not match.';
                }
            }

            if (showError && field && errorDiv) {
                field.style.transition = 'all 0.3s ease';
                
                if (isValid) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                    errorDiv.textContent = '';
                    errorDiv.style.opacity = '0';
                    setTimeout(() => {
                        errorDiv.style.display = 'none';
                    }, 300);
                } else {
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                    errorDiv.textContent = errorMessage;
                    errorDiv.style.display = 'block';
                    errorDiv.style.opacity = '0';
                    setTimeout(() => {
                        errorDiv.style.opacity = '1';
                    }, 50);
                }
            }

            return isValid;
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('strength-level');
            
            let score = 0;
            let feedback = '';
            
            if (password.length >= 8) score++;
            if (/[a-z]/.test(password)) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/\d/.test(password)) score++;
            if (/[@$!%*?&]/.test(password)) score++;
            
            switch (score) {
                case 0:
                case 1:
                    strengthBar.className = 'progress-bar bg-danger';
                    strengthBar.style.width = '20%';
                    feedback = 'Very Weak';
                    break;
                case 2:
                    strengthBar.className = 'progress-bar bg-warning';
                    strengthBar.style.width = '40%';
                    feedback = 'Weak';
                    break;
                case 3:
                    strengthBar.className = 'progress-bar bg-info';
                    strengthBar.style.width = '60%';
                    feedback = 'Fair';
                    break;
                case 4:
                    strengthBar.className = 'progress-bar bg-primary';
                    strengthBar.style.width = '80%';
                    feedback = 'Good';
                    break;
                case 5:
                    strengthBar.className = 'progress-bar bg-success';
                    strengthBar.style.width = '100%';
                    feedback = 'Strong';
                    break;
            }
            
            strengthText.textContent = feedback;
            return score >= 4; // Consider good or strong as acceptable
        }

        // Add event listeners for real-time validation
        Object.keys(validationRules).forEach(fieldName => {
            const fieldId = fieldName === 'password_confirmation' ? 'password-confirm' : fieldName;
            const field = document.getElementById(fieldId);
            
            if (field) {
                field.addEventListener('blur', function() {
                    validateField(fieldName, this.value);
                });
                
                field.addEventListener('input', function() {
                    // Special handling for password strength
                    if (fieldName === 'password') {
                        checkPasswordStrength(this.value);
                    }
                    
                    // Remove error state on input for better UX
                    if (this.classList.contains('is-invalid')) {
                        validateField(fieldName, this.value);
                    }
                });
            }
        });

        // Password confirmation real-time validation
        const passwordConfirmField = document.getElementById('password-confirm');
        if (passwordConfirmField) {
            passwordConfirmField.addEventListener('input', function() {
                validateField('password_confirmation', this.value);
            });
        }

        // Enhanced form submission with loading states
        form.addEventListener('submit', function(e) {
            let isFormValid = true;
            
            // Validate all fields
            Object.keys(validationRules).forEach(fieldName => {
                const fieldId = fieldName === 'password_confirmation' ? 'password-confirm' : fieldName;
                const field = document.getElementById(fieldId);
                
                if (field) {
                    const isValid = validateField(fieldName, field.value, true);
                    if (!isValid) {
                        isFormValid = false;
                        // Add shake animation for invalid fields
                        field.style.animation = 'shake 0.5s ease-in-out';
                        setTimeout(() => {
                            field.style.animation = '';
                        }, 500);
                    }
                }
            });
            
            // Check password strength
            const password = document.getElementById('password').value;
            if (password && !checkPasswordStrength(password)) {
                isFormValid = false;
                const passwordField = document.getElementById('password');
                const errorDiv = document.getElementById('password-error');
                passwordField.classList.add('is-invalid');
                errorDiv.textContent = 'Password is not strong enough.';
                errorDiv.style.display = 'block';
                errorDiv.style.opacity = '1';
            }
            
            if (!isFormValid) {
                e.preventDefault();
                
                // Focus on first invalid field
                const firstInvalidField = form.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                return false;
            }
            
            // Enhanced loading state with animations
            submitBtn.disabled = true;
            submitBtn.style.transform = 'scale(0.98)';
            
            const originalHTML = submitText.innerHTML;
            submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Resetting Password...';
            submitSpinner.classList.remove('d-none');
            
            // Simulate realistic loading time for better UX
            setTimeout(() => {
                submitBtn.style.opacity = '0.8';
            }, 100);
        });

        // Enhanced input animations
        const formInputs = form.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.transform = 'translateY(-1px)';
                this.style.boxShadow = '0 0 0 3px rgba(255, 173, 81, 0.15), 0 4px 20px rgba(255, 173, 81, 0.1)';
            });

            input.addEventListener('blur', function() {
                this.style.transform = '';
            });

            input.addEventListener('input', function() {
                // Remove invalid class when user starts typing
                if (this.classList.contains('is-invalid')) {
                    this.classList.remove('is-invalid');
                }
            });
        });

        // Enhanced keyboard navigation
        form.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                const formElements = Array.from(form.querySelectorAll('input:not([type="hidden"]), button'));
                const currentIndex = formElements.indexOf(activeElement);
                
                if (currentIndex < formElements.length - 1 && activeElement.tagName !== 'BUTTON') {
                    e.preventDefault();
                    formElements[currentIndex + 1].focus();
                }
            }
        });

        // Add ripple effect to buttons
        const buttons = form.querySelectorAll('button, .reset-btn');
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

        // Add CSS for animations if not already present
        if (!document.querySelector('#reset-animations')) {
            const style = document.createElement('style');
            style.id = 'reset-animations';
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                
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
    });
</script>
@endpush
@endsection