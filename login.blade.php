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
    
    .login-container {
        min-height: calc(100vh - var(--navbar-height));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        position: relative;
        z-index: 1;
    }
    
    .login-wrapper {
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
    
    [data-theme="dark"] .login-wrapper {
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
    
    .login-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 24px 24px 0 0;
    }
    
    .login-wrapper::after {
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
    
    .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .login-title {
        font-weight: 800;
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        position: relative;
    }
    
    .login-subtitle {
        color: var(--body-text);
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
    }
    
    .login-form {
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
    
    .form-control:focus {
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 20px rgba(255, 173, 81, 0.1);
        background: var(--white);
        transform: translateY(-1px);
        outline: none;
    }
    
    .form-control:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.25);
        transform: translateY(-1px);
    }
    
    /* Disable browser's native password reveal buttons to prevent duplicate eye icons */
    .form-control[type="password"]::-webkit-textfield-decoration-container {
        display: none !important;
    }
    
    .form-control[type="password"]::-webkit-credentials-auto-fill-button {
        display: none !important;
    }
    
    .form-control[type="password"]::-webkit-inner-spin-button,
    .form-control[type="password"]::-webkit-outer-spin-button {
        display: none !important;
    }
    
    .form-control[type="password"]::-ms-reveal,
    .form-control[type="password"]::-ms-clear {
        display: none !important;
    }
    
    /* Firefox password reveal button */
    .form-control[type="password"] {
        -moz-appearance: textfield;
    }
    
    /* Edge password reveal button */
    .form-control[type="password"]::-webkit-contacts-auto-fill-button {
        display: none !important;
    }
    
    /* Ensure our custom toggle is always visible and positioned correctly */
    .password-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .password-input-wrapper .form-control {
        padding-right: 3.5rem; /* Ensure space for our custom toggle */
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
    
    [data-theme="dark"] .form-control:focus {
        background: var(--white);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 20px rgba(255, 173, 81, 0.15);
    }
    
    [data-theme="dark"] .form-control:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.4);
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(55, 51, 51, 0.98) 50%, 
            var(--white) 100%);
    }
    
    [data-theme="dark"] .form-control.is-valid {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            var(--white) 100%);
    }
    
    [data-theme="dark"] .form-control.is-invalid {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            var(--white) 100%);
    }
    
    .form-control.is-valid {
        border-color: #28a745;
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
    }
    
    .password-toggle {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: var(--body-text);
        font-size: 1rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 6px;
        transition: all 0.3s ease;
        z-index: 10;
    }
    
    .password-toggle:hover {
        color: var(--heading-color);
        background: rgba(255, 173, 81, 0.1);
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
    }
    
    .form-check {
        margin: 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        border: 2px solid rgba(255, 173, 81, 0.3);
        border-radius: 4px;
        background: var(--white);
        transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-color: var(--heading-color);
        border-color: var(--heading-color);
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(255, 173, 81, 0.15);
    }
    
    .form-check-label {
        color: var(--body-text);
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        user-select: none;
    }
    
    .login-btn {
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
    
    .login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
        transition: left 0.6s ease;
    }
    
    .login-btn:hover::before {
        left: 100%;
    }
    
    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .login-btn:active {
        transform: translateY(0);
    }
    
    .login-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .forgot-password-link {
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
    }
    
    .forgot-password-link:hover {
        color: var(--heading-color);
        background: rgba(255, 173, 81, 0.05);
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
    }
    
    .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    
    /* Dark mode alert styles */
    [data-theme="dark"] .alert {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }
    
    [data-theme="dark"] .alert-danger {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.15) 0%, rgba(220, 53, 69, 0.08) 100%);
        color: #f5c2c7;
        border-left: 4px solid #dc3545;
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }
    
    /* Enhanced Responsive Design */
    @media (max-width: 576px) {
        .login-wrapper {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .login-title {
            font-size: 1.8rem;
        }
        
        .login-subtitle {
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.875rem 1rem;
        }
        
        .login-btn {
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
    
    /* Sign Up Section Styles */
    .signup-section {
        margin-top: 2rem;
        position: relative;
        z-index: 2;
    }
    
    .divider {
        position: relative;
        text-align: center;
        margin: 2rem 0 1.5rem 0;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 173, 81, 0.2) 20%, 
            rgba(255, 173, 81, 0.4) 50%, 
            rgba(255, 173, 81, 0.2) 80%, 
            transparent 100%);
        transform: translateY(-50%);
    }
    
    .divider-text {
        background: var(--white);
        color: var(--body-text);
        padding: 0 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }
    
    [data-theme="dark"] .divider-text {
        background: var(--white);
    }
    
    .signup-content {
        text-align: center;
    }
    
    .signup-text {
        color: var(--body-text);
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 1rem;
        opacity: 0.9;
    }
    
    .signup-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 0.875rem 2rem;
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.08) 0%, 
            rgba(207, 226, 255, 0.08) 100%);
        color: var(--heading-color);
        border: 2px solid rgba(255, 173, 81, 0.2);
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.1);
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
    
    .signup-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 173, 81, 0.1) 50%, 
            transparent 100%);
        transition: left 0.6s ease;
    }
    
    .signup-btn:hover::before {
        left: 100%;
    }
    
    .signup-btn:hover {
        color: var(--white);
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        border-color: var(--heading-color);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.3),
            0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .signup-btn:active {
        transform: translateY(0);
    }
    
    .signup-btn i {
        font-size: 0.9rem;
        transition: transform 0.3s ease;
    }
    
    .signup-btn:hover i {
        transform: scale(1.1);
    }
    
    [data-theme="dark"] .signup-btn {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.12) 0%, 
            rgba(207, 226, 255, 0.08) 100%);
        border-color: rgba(255, 173, 81, 0.3);
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.15);
    }
    
    [data-theme="dark"] .signup-btn:hover {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="login-container">
    <div class="login-wrapper" data-aos="fade-up" data-aos-delay="200">
        <div class="login-header">
            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Sign in to access your weather reporting dashboard</p>
        </div>

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="login-form" novalidate>
            @csrf

            @if (session('status'))
                <div class="alert alert-danger" data-aos="fade-in">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('status') }}
                </div>
            @endif

            <div class="form-group" data-aos="fade-up" data-aos-delay="300">
                <label for="username" class="form-label">
                    <i class="fas fa-user"></i>
                    {{ __('Username') }}
                    <span class="required-asterisk">*</span>
                </label>
                <input 
                    id="username" 
                    type="text" 
                    class="form-control @error('username') is-invalid @enderror" 
                    name="username" 
                    value="{{ old('username') }}" 
                    required 
                    autocomplete="username" 
                    autofocus
                    placeholder="Enter your username"
                >
                <div class="invalid-feedback" id="username-error"></div>
                @error('username')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group" data-aos="fade-up" data-aos-delay="400">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i>
                    {{ __('Password') }}
                    <span class="required-asterisk">*</span>
                </label>
                <div class="password-input-wrapper">
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        required 
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                    <button type="button" class="password-toggle" id="togglePassword">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                <div class="invalid-feedback" id="password-error"></div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div data-aos="fade-up" data-aos-delay="600">
                <button type="submit" class="login-btn" id="submitBtn">
                    <span id="submitText">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        {{ __('Sign In') }}
                    </span>
                    <div class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </button>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="forgot-password-link" href="{{ route('password.request') }}">
                            <i class="fas fa-key"></i>
                            {{ __('Forgot your password?') }}
                        </a>
                    </div>
                @endif
            </div>
        </form>

        <!-- Sign Up Section -->
        <div class="signup-section" data-aos="fade-up" data-aos-delay="700">
            <div class="divider">
                <span class="divider-text">or</span>
            </div>
            <div class="signup-content">
                <p class="signup-text">Don't have an account?</p>
                <a href="/register" class="signup-btn">
                    <i class="fas fa-user-plus"></i>
                    Create New Account
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

        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitSpinner = document.getElementById('submitSpinner');
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        // Validation rules
        const validationRules = {
            username: {
                required: true,
                minLength: 3,
                maxLength: 50,
                pattern: /^[a-zA-Z0-9_@.-]+$/,
                message: 'Username must be 3-50 characters long and contain only letters, numbers, underscores, @ symbol, dots, or hyphens.'
            },
            password: {
                required: true
            }
        };

        // Enhanced validation function with smooth animations
        function validateField(fieldName, value, showError = true) {
            const rule = validationRules[fieldName];
            const field = document.getElementById(fieldName);
            const errorDiv = document.getElementById(fieldName + '-error');
            
            if (!rule) return true;

            let isValid = true;
            let errorMessage = '';

            // Check required
            if (rule.required && (!value || value.trim() === '')) {
                isValid = false;
                errorMessage = `${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} is required.`;
            }
            // Check min length
            else if (rule.minLength && value.length < rule.minLength) {
                isValid = false;
                errorMessage = rule.message || `Minimum ${rule.minLength} characters required.`;
            }
            // Check max length
            else if (rule.maxLength && value.length > rule.maxLength) {
                isValid = false;
                errorMessage = rule.message || `Maximum ${rule.maxLength} characters allowed.`;
            }
            // Check pattern
            else if (rule.pattern && !rule.pattern.test(value)) {
                isValid = false;
                errorMessage = rule.message || 'Invalid format.';
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

        // Add enhanced event listeners for real-time validation
        Object.keys(validationRules).forEach(fieldName => {
            const field = document.getElementById(fieldName);
            
            if (field) {
                // Enhanced input animation
                field.addEventListener('focus', function() {
                    this.style.transform = 'translateY(-1px)';
                    this.style.boxShadow = '0 0 0 3px rgba(255, 173, 81, 0.15), 0 4px 20px rgba(255, 173, 81, 0.1)';
                });

                field.addEventListener('blur', function() {
                    this.style.transform = '';
                    validateField(fieldName, this.value);
                });
                
                // Real-time validation with debouncing
                let timeout;
                field.addEventListener('input', function() {
                    clearTimeout(timeout);
                    
                    // Immediate visual feedback for typing
                    if (this.classList.contains('is-invalid') && this.value.length > 0) {
                        timeout = setTimeout(() => {
                            validateField(fieldName, this.value);
                        }, 300);
                    }
                });

                // Validate on keyup for immediate feedback
                field.addEventListener('keyup', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        if (this.value.length > 0) {
                            validateField(fieldName, this.value);
                        }
                    }, 500);
                });
            }
        });

        // Enhanced password toggle with animation
        if (togglePasswordBtn && passwordField && togglePasswordIcon) {
            togglePasswordBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                
                // Animated icon transition
                togglePasswordIcon.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    if (type === 'password') {
                        togglePasswordIcon.classList.remove('fa-eye-slash');
                        togglePasswordIcon.classList.add('fa-eye');
                    } else {
                        togglePasswordIcon.classList.remove('fa-eye');
                        togglePasswordIcon.classList.add('fa-eye-slash');
                    }
                    togglePasswordIcon.style.transform = 'scale(1)';
                }, 150);
            });

            // Hover effects for password toggle
            togglePasswordBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1)';
            });

            togglePasswordBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        }

        // Enhanced form submission with loading states
        form.addEventListener('submit', function(e) {
            let isFormValid = true;
            
            // Validate all fields with animation
            Object.keys(validationRules).forEach(fieldName => {
                const field = document.getElementById(fieldName);
                
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
            
            if (!isFormValid) {
                e.preventDefault();
                
                // Focus on first invalid field with smooth scroll
                const firstInvalidField = form.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.focus();
                    firstInvalidField.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }
                
                return false;
            }
            
            // Enhanced loading state with animations - maintain until page navigation
            submitBtn.disabled = true;
            submitBtn.style.transform = 'scale(0.98)';
            submitBtn.style.opacity = '0.8';
            
            // Store original content
            window.originalButtonHTML = submitText.innerHTML;
            
            // Set submitting state
            submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            submitSpinner.classList.remove('d-none');
            
            // Ensure loading state persists during navigation
            const maintainLoadingState = () => {
                if (submitBtn && submitText) {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.8';
                    submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
                }
            };
            
            // Maintain state during the entire submission process
            const persistenceInterval = setInterval(maintainLoadingState, 100);
            
            // Clean up interval when page unloads (navigation happens)
            window.addEventListener('beforeunload', () => {
                clearInterval(persistenceInterval);
            });
            
            // Handle page visibility changes to maintain state during slow redirects
            document.addEventListener('visibilitychange', maintainLoadingState);
            
            // Handle focus/blur to maintain state
            window.addEventListener('blur', maintainLoadingState);
            window.addEventListener('focus', maintainLoadingState);
            
            // Additional safety - maintain state for longer duration
            setTimeout(() => {
                maintainLoadingState();
            }, 50);
            
            // Final fallback - keep checking for a reasonable time
            setTimeout(() => {
                clearInterval(persistenceInterval);
                // Remove event listeners to prevent memory leaks if form fails
                document.removeEventListener('visibilitychange', maintainLoadingState);
                window.removeEventListener('blur', maintainLoadingState);
                window.removeEventListener('focus', maintainLoadingState);
            }, 30000); // 30 seconds max
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

        // Auto-clear server-side errors with fade animation
        const serverErrorFields = form.querySelectorAll('.is-invalid');
        serverErrorFields.forEach(field => {
            field.addEventListener('input', function() {
                const serverErrorDiv = this.parentNode.querySelector('.invalid-feedback.d-block');
                if (serverErrorDiv) {
                    serverErrorDiv.style.opacity = '0';
                    setTimeout(() => {
                        serverErrorDiv.style.display = 'none';
                    }, 300);
                }
            });
        });

        // Enhanced accessibility
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            field.setAttribute('aria-required', 'true');
            field.setAttribute('aria-describedby', field.id + '-error');
        });

        // Add floating label effect
        const formInputs = form.querySelectorAll('.form-control');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentNode.classList.remove('focused');
                }
            });

            // Check for pre-filled values
            if (input.value) {
                input.parentNode.classList.add('focused');
            }
        });

        // Add ripple effect to buttons
        const buttons = form.querySelectorAll('button, .login-btn');
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
        if (!document.querySelector('#login-animations')) {
            const style = document.createElement('style');
            style.id = 'login-animations';
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
                
                .form-group.focused .form-label {
                    color: var(--heading-color);
                    transform: translateY(-2px);
                }
            `;
            document.head.appendChild(style);
        }
    });
</script>
@endpush
@endsection