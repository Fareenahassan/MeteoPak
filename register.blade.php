@extends('layouts.app')

@push('styles')
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    
    .register-container {
        min-height: calc(100vh - var(--navbar-height));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
        position: relative;
        z-index: 1;
    }
    
    .register-wrapper {
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
        max-width: 600px;
        width: 100%;
    }
    
    [data-theme="dark"] .register-wrapper {
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
    
    .register-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 24px 24px 0 0;
    }
    
    .register-wrapper::after {
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
    
    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
        position: relative;
        z-index: 2;
    }
    
    .register-title {
        font-weight: 800;
        font-size: 2.2rem;
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        position: relative;
    }
    
    .register-subtitle {
        color: var(--body-text);
        font-size: 1rem;
        font-weight: 500;
        opacity: 0.9;
    }
    
    .register-form {
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
    
    .form-control, .form-select {
        padding: 0.875rem 1rem;
        border: 2px solid rgba(255, 173, 81, 0.15);
        border-radius: var(--border-radius);
        font-size: 0.95rem;
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
    [data-theme="dark"] .form-control,
    [data-theme="dark"] .form-select {
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
    
    [data-theme="dark"] .form-control::placeholder,
    [data-theme="dark"] .form-select option {
        color: var(--body-text);
        opacity: 0.8;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 20px rgba(255, 173, 81, 0.1);
        background: var(--white);
        transform: translateY(-1px);
        outline: none;
    }
    
    [data-theme="dark"] .form-control:focus,
    [data-theme="dark"] .form-select:focus {
        background: var(--white);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 20px rgba(255, 173, 81, 0.15);
    }
    
    .form-control:hover:not(:focus), .form-select:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.25);
        transform: translateY(-1px);
    }
    
    [data-theme="dark"] .form-control:hover:not(:focus),
    [data-theme="dark"] .form-select:hover:not(:focus) {
        border-color: rgba(255, 173, 81, 0.4);
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(55, 51, 51, 0.98) 50%, 
            var(--white) 100%);
    }
    
    .form-control.is-valid, .form-select.is-valid {
        border-color: #28a745;
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
    }
    
    [data-theme="dark"] .form-control.is-valid,
    [data-theme="dark"] .form-select.is-valid {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            var(--white) 100%);
    }
    
    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #dc3545;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%);
    }
    
    [data-theme="dark"] .form-control.is-invalid,
    [data-theme="dark"] .form-select.is-invalid {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            var(--white) 100%);
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
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8rem;
        font-weight: 500;
        margin-top: 0.5rem;
        padding-left: 0.5rem;
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
        align-items: center;
        gap: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    
    .alert-info {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(13, 202, 240, 0.05) 100%);
        color: #055160;
        border-left: 4px solid #0dcaf0;
    }
    
    /* Dark mode alert styles */
    [data-theme="dark"] .alert {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }
    
    [data-theme="dark"] .alert-info {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.15) 0%, rgba(13, 202, 240, 0.08) 100%);
        color: #9ec5fe;
        border-left: 4px solid #0dcaf0;
    }
    
    .register-btn {
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
    
    .register-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
        transition: left 0.6s ease;
    }
    
    .register-btn:hover::before {
        left: 100%;
    }
    
    .register-btn:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .register-btn:active {
        transform: translateY(0);
    }
    
    .register-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
    
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }
    
    /* Enhanced Responsive Design */
    @media (max-width: 768px) {
        .register-wrapper {
            margin: 1rem;
            padding: 2rem 1.5rem;
        }
        
        .register-title {
            font-size: 1.8rem;
        }
        
        .register-subtitle {
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            padding: 0.75rem 0.875rem;
        }
        
        .register-btn {
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
    }
    
    @media (max-width: 576px) {
        .register-wrapper {
            padding: 1.5rem 1rem;
        }
        
        .register-title {
            font-size: 1.6rem;
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
    
    /* Select2 Custom Styling */
    .select2-container {
        width: 100% !important;
    }
    
    .select2-container--default .select2-selection--single {
        height: auto !important;
        padding: 0.875rem 1rem !important;
        border: 2px solid rgba(255, 173, 81, 0.15) !important;
        border-radius: var(--border-radius) !important;
        font-size: 0.95rem !important;
        font-weight: 500 !important;
        color: var(--black) !important;
        background: var(--white) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.8) !important;
    }
    
    [data-theme="dark"] .select2-container--default .select2-selection--single {
        background: var(--white) !important;
        color: var(--black) !important;
        border-color: rgba(255, 173, 81, 0.25) !important;
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: var(--heading-color) !important;
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 20px rgba(255, 173, 81, 0.15) !important;
        background: var(--white) !important;
        transform: translateY(-1px) !important;
        outline: none !important;
    }
    
    .select2-container--default:hover .select2-selection--single:not(.select2-container--focus .select2-selection--single) {
        border-color: rgba(255, 173, 81, 0.25) !important;
        transform: translateY(-1px) !important;
    }
    
    [data-theme="dark"] .select2-container--default:hover .select2-selection--single:not(.select2-container--focus .select2-selection--single) {
        border-color: rgba(255, 173, 81, 0.4) !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: var(--black) !important;
        padding: 0 !important;
        line-height: 1.5 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: var(--body-text) !important;
        opacity: 0.8 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        right: 1rem !important;
        top: 0 !important;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: var(--body-text) transparent transparent transparent !important;
    }
    
    .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
        border-color: transparent transparent var(--body-text) transparent !important;
    }
    
    /* Select2 Dropdown */
    .select2-dropdown {
        border: 2px solid var(--heading-color) !important;
        border-radius: var(--border-radius) !important;
        background: var(--white) !important;
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.08),
            0 4px 12px rgba(255, 173, 81, 0.1) !important;
        border-top: none !important;
        margin-top: -1px !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
    }
    
    [data-theme="dark"] .select2-dropdown {
        background: var(--white) !important;
        border-color: rgba(255, 173, 81, 0.3) !important;
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.4),
            0 4px 12px rgba(255, 173, 81, 0.2) !important;
    }
    
    .select2-dropdown .select2-search {
        padding: 0.5rem !important;
    }
    
    .select2-dropdown .select2-search .select2-search__field {
        padding: 0.75rem 1rem !important;
        border: 2px solid rgba(255, 173, 81, 0.15) !important;
        border-radius: var(--border-radius) !important;
        font-size: 0.9rem !important;
        color: var(--black) !important;
        background: var(--white) !important;
        transition: all 0.3s ease !important;
    }
    
    [data-theme="dark"] .select2-dropdown .select2-search .select2-search__field {
        background: var(--white) !important;
        border-color: rgba(255, 173, 81, 0.25) !important;
    }
    
    .select2-dropdown .select2-search .select2-search__field:focus {
        border-color: var(--heading-color) !important;
        box-shadow: 0 0 0 2px rgba(255, 173, 81, 0.15) !important;
        outline: none !important;
    }
    
    .select2-dropdown .select2-search .select2-search__field::placeholder {
        color: var(--body-text) !important;
        opacity: 0.8 !important;
    }
    
    /* Select2 Results */
    .select2-results {
        max-height: 250px !important;
    }
    
    .select2-results__options {
        padding: 0.25rem 0 !important;
    }
    
    .select2-results__option {
        padding: 0.75rem 1rem !important;
        font-size: 0.9rem !important;
        color: var(--black) !important;
        background: transparent !important;
        transition: all 0.2s ease !important;
        border-bottom: 1px solid rgba(255, 173, 81, 0.15) !important;
    }
    
    .select2-results__option:last-child {
        border-bottom: none !important;
    }
    
    .select2-results__option--highlighted {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.15) 0%, 
            rgba(255, 173, 81, 0.08) 100%) !important;
        color: var(--heading-color) !important;
    }
    
    .select2-results__option[aria-selected="true"] {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.2) 0%, 
            rgba(255, 173, 81, 0.12) 100%) !important;
        color: var(--heading-color) !important;
        font-weight: 600 !important;
    }
    
    .select2-results__option--disabled {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
    }
    
    /* No results message */
    .select2-results__message {
        padding: 1rem !important;
        color: var(--body-text) !important;
        text-align: center !important;
        font-style: italic !important;
    }
    
    /* Loading message */
    .select2-results__option--loading {
        text-align: center !important;
        color: var(--body-text) !important;
        font-style: italic !important;
    }
    
    /* Error states for Select2 */
    .select2-container.is-invalid .select2-selection--single {
        border-color: #dc3545 !important;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%) !important;
    }
    
    .select2-container.is-valid .select2-selection--single {
        border-color: #28a745 !important;
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.05) 0%, 
            rgba(255, 255, 255, 0.9) 100%) !important;
    }
    
    [data-theme="dark"] .select2-container.is-invalid .select2-selection--single {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            var(--white) 100%) !important;
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    }
    
    [data-theme="dark"] .select2-container.is-valid .select2-selection--single {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            var(--white) 100%) !important;
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    }
    
    /* Mobile responsive adjustments for Select2 */
    @media (max-width: 768px) {
        .select2-container--default .select2-selection--single {
            padding: 0.75rem 0.875rem !important;
        }
        
        .select2-dropdown .select2-search .select2-search__field {
            padding: 0.625rem 0.875rem !important;
        }
        
        .select2-results__option {
            padding: 0.625rem 0.875rem !important;
        }
    }
</style>

<div class="register-container">
    <div class="register-wrapper" data-aos="fade-up" data-aos-delay="200">
        <div class="register-header">
            <h1 class="register-title">Create Account</h1>
            <p class="register-subtitle">Join our weather reporting system</p>
        </div>

        <div class="register-form">
            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                @csrf

                <div class="form-group" data-aos="fade-up" data-aos-delay="300">
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
                        placeholder="Enter your email address"
                    >
                    <div class="invalid-feedback" id="email-error"></div>
                    @error('email')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="350">
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
                        placeholder="Enter your username"
                    >
                    <div class="invalid-feedback" id="username-error"></div>
                    <small class="form-text">Username must be 3-20 characters long and contain only letters, numbers, and underscores.</small>
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
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Enter your password"
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

                <div class="form-group" data-aos="fade-up" data-aos-delay="450">
                    <label for="password-confirm" class="form-label">
                        <i class="fas fa-lock"></i>
                        {{ __('Confirm Password') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <input 
                        id="password-confirm" 
                        type="password" 
                        class="form-control" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Confirm your password"
                    >
                    <div class="invalid-feedback" id="password-confirm-error"></div>
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="500">
                    <label for="personal_number" class="form-label">
                        <i class="fas fa-id-card"></i>
                        {{ __('Personal Number') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <input 
                        id="personal_number" 
                        type="text" 
                        class="form-control @error('personal_number') is-invalid @enderror" 
                        name="personal_number" 
                        value="{{ old('personal_number') }}" 
                        required
                        placeholder="Enter your employee ID"
                    >
                    <div class="invalid-feedback" id="personal_number-error"></div>
                    <small class="form-text">Enter your employee ID or personal identification number.</small>
                    @error('personal_number')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="550">
                    <label for="region_id" class="form-label">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ __('Region') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <select 
                        id="region_id" 
                        class="form-select @error('region_id') is-invalid @enderror" 
                        name="region_id" 
                        required
                    >
                        <option value="">-- Select Region --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="region_id-error"></div>
                    @error('region_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="600">
                    <label for="station_id" class="form-label">
                        <i class="fas fa-building"></i>
                        {{ __('Station') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <select 
                        id="station_id" 
                        class="form-select @error('station_id') is-invalid @enderror" 
                        name="station_id" 
                        required
                    >
                        <option value="">-- Select Station --</option>
                    </select>
                    <div class="invalid-feedback" id="station_id-error"></div>
                    @error('station_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="650">
                    <label for="designation" class="form-label">
                        <i class="fas fa-briefcase"></i>
                        {{ __('Designation') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <select 
                        id="designation" 
                        class="form-select @error('designation') is-invalid @enderror" 
                        name="designation" 
                        required
                    >
                                    <option value="">-- Select Designation --</option>
                                    <option value="Director General" {{ old('designation') == 'Director General' ? 'selected' : '' }}>Director General</option>
                                    <option value="Chief Meteorologist" {{ old('designation') == 'Chief Meteorologist' ? 'selected' : '' }}>Chief Meteorologist</option>
                                    <option value="Director (Engineering) / Principal Engineer" {{ old('designation') == 'Director (Engineering) / Principal Engineer' ? 'selected' : '' }}>Director (Engineering) / Principal Engineer</option>
                                    <option value="Director / Principal Meteorologist" {{ old('designation') == 'Director / Principal Meteorologist' ? 'selected' : '' }}>Director / Principal Meteorologist</option>
                                    <option value="Senior Private Secretary" {{ old('designation') == 'Senior Private Secretary' ? 'selected' : '' }}>Senior Private Secretary</option>
                                    <option value="Deputy Director / Senior Meteorologist" {{ old('designation') == 'Deputy Director / Senior Meteorologist' ? 'selected' : '' }}>Deputy Director / Senior Meteorologist</option>
                                    <option value="Senior Programmer" {{ old('designation') == 'Senior Programmer' ? 'selected' : '' }}>Senior Programmer</option>
                                    <option value="Deputy Chief Administrative Officer" {{ old('designation') == 'Deputy Chief Administrative Officer' ? 'selected' : '' }}>Deputy Chief Administrative Officer</option>
                                    <option value="Sr. Electronic Engineer / Deputy Director (Engineering)" {{ old('designation') == 'Sr. Electronic Engineer / Deputy Director (Engineering)' ? 'selected' : '' }}>Sr. Electronic Engineer / Deputy Director (Engineering)</option>
                                    <option value="Administrative Officer" {{ old('designation') == 'Administrative Officer' ? 'selected' : '' }}>Administrative Officer</option>
                                    <option value="Meteorologist" {{ old('designation') == 'Meteorologist' ? 'selected' : '' }}>Meteorologist</option>
                                    <option value="Accounts Officer" {{ old('designation') == 'Accounts Officer' ? 'selected' : '' }}>Accounts Officer</option>
                                    <option value="Librarian" {{ old('designation') == 'Librarian' ? 'selected' : '' }}>Librarian</option>
                                    <option value="Security Officer" {{ old('designation') == 'Security Officer' ? 'selected' : '' }}>Security Officer</option>
                                    <option value="Electronics Engineer" {{ old('designation') == 'Electronics Engineer' ? 'selected' : '' }}>Electronics Engineer</option>
                                    <option value="Programmer" {{ old('designation') == 'Programmer' ? 'selected' : '' }}>Programmer</option>
                                    <option value="Assistant Meteorologist" {{ old('designation') == 'Assistant Meteorologist' ? 'selected' : '' }}>Assistant Meteorologist</option>
                                    <option value="Superintendent" {{ old('designation') == 'Superintendent' ? 'selected' : '' }}>Superintendent</option>
                                    <option value="Assistant Private Secretary" {{ old('designation') == 'Assistant Private Secretary' ? 'selected' : '' }}>Assistant Private Secretary</option>
                                    <option value="Assistant Programmer" {{ old('designation') == 'Assistant Programmer' ? 'selected' : '' }}>Assistant Programmer</option>
                                    <option value="Assistant Mechanical Engineer" {{ old('designation') == 'Assistant Mechanical Engineer' ? 'selected' : '' }}>Assistant Mechanical Engineer</option>
                                    <option value="Assistant Electronic Engineer" {{ old('designation') == 'Assistant Electronic Engineer' ? 'selected' : '' }}>Assistant Electronic Engineer</option>
                                    <option value="Head Draughtsman" {{ old('designation') == 'Head Draughtsman' ? 'selected' : '' }}>Head Draughtsman</option>
                                    <option value="Assistant Ministerial" {{ old('designation') == 'Assistant Ministerial' ? 'selected' : '' }}>Assistant Ministerial</option>
                                    <option value="Data Entry Operator" {{ old('designation') == 'Data Entry Operator' ? 'selected' : '' }}>Data Entry Operator</option>
                                    <option value="Meteorological Assistant" {{ old('designation') == 'Meteorological Assistant' ? 'selected' : '' }}>Meteorological Assistant</option>
                                    <option value="Stenotypist" {{ old('designation') == 'Stenotypist' ? 'selected' : '' }}>Stenotypist</option>
                                    <option value="Sub Engineer (Electronics)" {{ old('designation') == 'Sub Engineer (Electronics)' ? 'selected' : '' }}>Sub Engineer (Electronics)</option>
                                    <option value="Sub Engineer (Mechanical)" {{ old('designation') == 'Sub Engineer (Mechanical)' ? 'selected' : '' }}>Sub Engineer (Mechanical)</option>
                                    <option value="Mechanical Assistant" {{ old('designation') == 'Mechanical Assistant' ? 'selected' : '' }}>Mechanical Assistant</option>
                                    <option value="Draughtsman" {{ old('designation') == 'Draughtsman' ? 'selected' : '' }}>Draughtsman</option>
                                    <option value="Upper Division Clerk" {{ old('designation') == 'Upper Division Clerk' ? 'selected' : '' }}>Upper Division Clerk</option>
                                    <option value="Lower Division Clerk" {{ old('designation') == 'Lower Division Clerk' ? 'selected' : '' }}>Lower Division Clerk</option>
                                    <option value="Senior Observer" {{ old('designation') == 'Senior Observer' ? 'selected' : '' }}>Senior Observer</option>
                                    <option value="Observer" {{ old('designation') == 'Observer' ? 'selected' : '' }}>Observer</option>
                    </select>
                    <div class="invalid-feedback" id="designation-error"></div>
                    @error('designation')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="700">
                    <label for="gender" class="form-label">
                        <i class="fas fa-venus-mars"></i>
                        {{ __('Gender') }}
                        <span class="required-asterisk">*</span>
                    </label>
                    <select 
                        id="gender" 
                        class="form-select @error('gender') is-invalid @enderror" 
                        name="gender" 
                        required
                    >
                        <option value="">-- Select Gender --</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <div class="invalid-feedback" id="gender-error"></div>
                    @error('gender')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" data-aos="fade-up" data-aos-delay="750">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <small>Your account will need to be approved by an administrator before you can log in.</small>
                    </div>
                </div>

                <div data-aos="fade-up" data-aos-delay="800">
                    <button type="submit" class="register-btn" id="submitBtn">
                        <span id="submitText">
                            <i class="fas fa-user-plus me-2"></i>
                            {{ __('Register') }}
                        </span>
                        <div class="spinner-border spinner-border-sm d-none" id="submitSpinner" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- AOS Animation Library Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Select2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        // Initialize Select2 for all dropdowns
        function initializeSelect2() {
            // Region dropdown with search
            $('#region_id').select2({
                placeholder: '-- Select Region --',
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-custom',
                language: {
                    noResults: function() {
                        return "No regions found";
                    },
                    searching: function() {
                        return "Searching regions...";
                    }
                }
            });

            // Station dropdown with search (will be populated dynamically)
            $('#station_id').select2({
                placeholder: '-- Select Station --',
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-custom',
                language: {
                    noResults: function() {
                        return "No stations found";
                    },
                    searching: function() {
                        return "Searching stations...";
                    },
                    loadingMore: function() {
                        return "Loading stations...";
                    }
                }
            });

            // Designation dropdown with search
            $('#designation').select2({
                placeholder: '-- Select Designation --',
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-custom',
                language: {
                    noResults: function() {
                        return "No designation found";
                    },
                    searching: function() {
                        return "Searching designations...";
                    }
                }
            });

            // Gender dropdown with search (though limited options)
            $('#gender').select2({
                placeholder: '-- Select Gender --',
                allowClear: true,
                width: '100%',
                dropdownCssClass: 'select2-dropdown-custom',
                minimumResultsForSearch: Infinity, // Disable search for gender as it has only 3 options
                language: {
                    noResults: function() {
                        return "No options found";
                    }
                }
            });
        }

        // Initialize Select2 after DOM is ready
        initializeSelect2();

        const form = document.getElementById('registerForm');
        const regionSelect = document.getElementById('region_id');
        const stationSelect = document.getElementById('station_id');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');

        // Validation rules
        const validationRules = {
            email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email address.'
            },
            username: {
                required: true,
                minLength: 3,
                maxLength: 20,
                pattern: /^[a-zA-Z0-9_]+$/,
                message: 'Username must be 3-20 characters long and contain only letters, numbers, and underscores.'
            },
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
            },
            personal_number: {
                required: true,
                minLength: 2,
                pattern: /^[a-zA-Z0-9-_]+$/,
                message: 'Personal number must be at least 2 characters and contain only letters, numbers, hyphens, and underscores.'
            },
            region_id: {
                required: true,
                message: 'Please select a region.'
            },
            station_id: {
                required: true,
                message: 'Please select a station.'
            },
            designation: {
                required: true,
                message: 'Please select a designation.'
            },
            gender: {
                required: true,
                message: 'Please select a gender.'
            }
        };

        // Real-time validation function
        function validateField(fieldName, value, showError = true) {
            const rule = validationRules[fieldName];
            const field = document.getElementById(fieldName === 'password_confirmation' ? 'password-confirm' : fieldName);
            const errorDiv = document.getElementById(fieldName === 'password_confirmation' ? 'password-confirm-error' : fieldName + '-error');
            
            // Handle Select2 containers for validation states
            const select2Container = field ? field.parentNode.querySelector('.select2-container') : null;
            
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
            // Check match field (for password confirmation)
            else if (rule.matchField) {
                const matchFieldValue = document.getElementById(rule.matchField).value;
                if (value !== matchFieldValue) {
                    isValid = false;
                    errorMessage = rule.message || 'Fields do not match.';
                }
            }

            if (showError && field && errorDiv) {
                if (isValid) {
                    field.classList.remove('is-invalid');
                    field.classList.add('is-valid');
                    if (select2Container) {
                        select2Container.classList.remove('is-invalid');
                        select2Container.classList.add('is-valid');
                    }
                    errorDiv.textContent = '';
                } else {
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                    if (select2Container) {
                        select2Container.classList.remove('is-valid');
                        select2Container.classList.add('is-invalid');
                    }
                    errorDiv.textContent = errorMessage;
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
        document.getElementById('password-confirm').addEventListener('input', function() {
            validateField('password_confirmation', this.value);
        });

        // Function to fetch stations based on selected region
        function loadStations(regionId) {
            const stationSelect2 = $('#station_id');
            
            if (!regionId) {
                // Clear station dropdown and reinitialize Select2
                stationSelect2.empty().append('<option value="">-- Select Station --</option>');
                stationSelect2.trigger('change');
                validateField('station_id', '');
                return;
            }
            
            // Show loading state in Select2
            stationSelect2.empty().append('<option value="">Loading stations...</option>');
            stationSelect2.prop('disabled', true);
            stationSelect2.trigger('change');
            
            fetch(`/stations/by-region?region_id=${regionId}`)
                .then(response => response.json())
                .then(stations => {
                    // Clear and rebuild station options
                    stationSelect2.empty().append('<option value="">-- Select Station --</option>');
                    
                    stations.forEach(station => {
                        const option = new Option(station.name, station.id, false, false);
                        
                        // Set selected if it matches old value
                        if (station.id == {{ old('station_id') ? old('station_id') : 'null' }}) {
                            option.selected = true;
                        }
                        
                        stationSelect2.append(option);
                    });
                    
                    stationSelect2.prop('disabled', false);
                    stationSelect2.trigger('change');
                    
                    // Validate station selection after loading
                    validateField('station_id', stationSelect2.val());
                })
                .catch(error => {
                    console.error('Error loading stations:', error);
                    stationSelect2.empty().append('<option value="">Error loading stations</option>');
                    stationSelect2.prop('disabled', false);
                    stationSelect2.trigger('change');
                });
        }
        
        // Initial load if region is selected
        const initialRegionValue = $('#region_id').val();
        if (initialRegionValue) {
            loadStations(initialRegionValue);
        }
        
        // Add event listener for region change (Select2)
        $('#region_id').on('change', function() {
            const value = $(this).val();
            loadStations(value);
            validateField('region_id', value);
        });

        // Add event listeners for all Select2 dropdowns
        $('#region_id, #station_id, #designation, #gender').on('change', function() {
            const fieldName = $(this).attr('id');
            const value = $(this).val();
            validateField(fieldName, value);
        });

        // Add Select2 event listeners for better UX
        $('#region_id, #station_id, #designation, #gender').on('select2:open', function() {
            // Focus the search field when dropdown opens
            setTimeout(() => {
                const searchField = document.querySelector('.select2-search__field');
                if (searchField) {
                    searchField.focus();
                }
            }, 100);
        });

        // Form submission validation
        form.addEventListener('submit', function(e) {
            let isFormValid = true;
            
            // Validate all fields
            Object.keys(validationRules).forEach(fieldName => {
                const fieldId = fieldName === 'password_confirmation' ? 'password-confirm' : fieldName;
                const field = document.getElementById(fieldId);
                
                if (field) {
                    let value;
                    // Handle Select2 fields differently
                    if (['region_id', 'station_id', 'designation', 'gender'].includes(fieldName)) {
                        value = $('#' + fieldId).val();
                    } else {
                        value = field.value;
                    }
                    
                    const isValid = validateField(fieldName, value, true);
                    if (!isValid) {
                        isFormValid = false;
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
            
            const submitText = document.getElementById('submitText');
            const originalHTML = submitText.innerHTML;
            submitText.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Registering...';
            submitSpinner.classList.remove('d-none');
            
            // Simulate realistic loading time for better UX
            setTimeout(() => {
                submitBtn.style.opacity = '0.8';
            }, 100);
        });
    });
</script>
@endpush
@endsection