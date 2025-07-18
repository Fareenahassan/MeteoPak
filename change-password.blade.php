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
    /* Change Password Page Specific Styles */
    .change-password-wrapper {
        /* Theme Variables */
        --primary-bg: #FFFFFF;
        --heading-color: #FFAD51;
        --container-bg: #CFE2FF;
        --body-text: #898E8F;
        --white: #FFFFFF;
        --black: #000000;
        --border-radius: 3px;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
    }
    
    /* Dark Theme Variables */
    [data-theme="dark"] .change-password-wrapper {
        --primary-bg: var(--theme-bg-primary, #252222);
        --heading-color: #FFAD51;
        --container-bg: var(--theme-bg-tertiary, #3a3636);
        --body-text: var(--theme-text-secondary, #adb5bd);
        --white: var(--theme-card-bg, #2f2b2b);
        --black: var(--theme-text-primary, #ffffff);
    }
    
    .change-password-wrapper {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--primary-bg);
        min-height: calc(100vh - 56px);
        padding-top: 2rem;
        padding-bottom: 2rem;
        position: relative;
    }
    
    .change-password-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 300px;
        background: linear-gradient(135deg, 
            rgba(207, 226, 255, 0.1) 0%, 
            rgba(255, 173, 81, 0.05) 50%, 
            rgba(207, 226, 255, 0.1) 100%);
        pointer-events: none;
        border-radius: 0 0 50px 50px;
    }
    
    [data-theme="dark"] .change-password-wrapper::before {
        background: linear-gradient(135deg, 
            rgba(58, 54, 54, 0.3) 0%, 
            rgba(255, 173, 81, 0.1) 50%, 
            rgba(58, 54, 54, 0.3) 100%);
    }
    
    /* Enhanced Card Styling */
    .password-card {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 50%, 
            var(--white) 100%);
        border-radius: 24px;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.08),
            0 8px 20px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 173, 81, 0.08);
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    [data-theme="dark"] .password-card {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(47, 43, 43, 0.98) 50%, 
            var(--white) 100%);
        border: 1px solid rgba(255, 173, 81, 0.15);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            0 8px 20px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .password-card:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.12),
            0 12px 30px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }
    
    [data-theme="dark"] .password-card:hover {
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.4),
            0 12px 30px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    /* Enhanced Header */
    .password-card-header {
        background: linear-gradient(135deg, 
            var(--heading-color) 0%, 
            #ffb866 50%, 
            var(--heading-color) 100%);
        padding: 2rem 2.5rem;
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .password-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 255, 255, 0.2) 50%, 
            transparent 100%);
        animation: headerShine 3s ease-in-out infinite;
    }
    
    @keyframes headerShine {
        0%, 100% { left: -100%; }
        50% { left: 100%; }
    }
    
    .password-card-header h5 {
        color: var(--white);
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        position: relative;
        z-index: 2;
        flex: 1;
    }
    
    .header-back-btn {
        background: rgba(255, 255, 255, 0.2);
        color: var(--white);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;
        margin-left: auto;
    }
    
    .header-back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: var(--white);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateX(3px) scale(1.02);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
    }
    
    .header-back-btn i {
        transition: transform 0.3s ease;
    }
    
    .header-back-btn:hover i {
        transform: translateX(2px);
    }
    
    /* Enhanced Card Body */
    .password-card-body {
        padding: 3rem 2.5rem;
        position: relative;
    }
    
    /* Enhanced Alert Styling */
    .custom-alert {
        border-radius: 16px;
        border: none;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .custom-alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        border-radius: 0 16px 16px 0;
    }
    
    .alert-success.custom-alert {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            rgba(40, 167, 69, 0.05) 100%);
        border: 1px solid rgba(40, 167, 69, 0.2);
        color: var(--success-color);
    }
    
    .alert-success.custom-alert::before {
        background: var(--success-color);
    }
    
    .alert-info.custom-alert {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.1) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
    .alert-info.custom-alert::before {
        background: var(--heading-color);
    }
    
    [data-theme="dark"] .alert-success.custom-alert {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.15) 0%, 
            rgba(40, 167, 69, 0.08) 100%);
        color: #4ade80;
    }
    
    [data-theme="dark"] .alert-info.custom-alert {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.15) 0%, 
            rgba(255, 173, 81, 0.08) 100%);
        color: #ffb866;
    }
    
    .custom-alert i {
        font-size: 1.25rem;
        margin-right: 0.75rem;
        opacity: 0.9;
    }
    
    .custom-alert strong {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .custom-alert ul {
        margin: 0.75rem 0 0 1.5rem;
        padding: 0;
    }
    
    .custom-alert li {
        margin-bottom: 0.25rem;
        position: relative;
    }
    
    .custom-alert li::before {
        content: '•';
        color: var(--heading-color);
        font-weight: bold;
        position: absolute;
        left: -1rem;
    }
    
    .btn-close-custom {
        background: none;
        border: none;
        color: inherit;
        opacity: 0.7;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-close-custom:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
    }
    
    /* Enhanced Form Styling */
    .form-group-enhanced {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .form-label-enhanced {
        font-weight: 600;
        color: var(--black);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        position: relative;
    }
    
    .form-label-enhanced i {
        color: var(--heading-color);
        font-size: 1.1rem;
        opacity: 0.8;
    }
    
    .form-control-enhanced {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 100%);
        border: 2px solid rgba(255, 173, 81, 0.1);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        font-family: 'Poppins', sans-serif;
        color: var(--black);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        position: relative;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    [data-theme="dark"] .form-control-enhanced {
        background: linear-gradient(135deg, 
            var(--container-bg) 0%, 
            rgba(58, 54, 54, 0.98) 100%);
        border: 2px solid rgba(255, 173, 81, 0.2);
        color: var(--black);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .form-control-enhanced:focus {
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 15px rgba(255, 173, 81, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        transform: translateY(-1px);
        outline: none;
    }
    
    [data-theme="dark"] .form-control-enhanced:focus {
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 15px rgba(255, 173, 81, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .form-control-enhanced.is-invalid {
        border-color: var(--danger-color);
        box-shadow: 
            0 0 0 3px rgba(220, 53, 69, 0.15),
            0 4px 15px rgba(220, 53, 69, 0.1);
    }
    
    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .invalid-feedback::before {
        content: '⚠';
        font-size: 1rem;
    }
    
    /* Enhanced Button Styling */
    .btn-enhanced {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        padding: 0.875rem 2rem;
        border-radius: 12px;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .btn-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 255, 255, 0.2) 50%, 
            transparent 100%);
        transition: left 0.6s ease;
    }
    
    .btn-enhanced:hover::before {
        left: 100%;
    }
    
    .btn-primary-enhanced {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        color: var(--white);
        box-shadow: 
            0 4px 15px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    
    .btn-primary-enhanced:hover {
        background: linear-gradient(135deg, #e89640 0%, #ff9f42 100%);
        color: var(--white);
        transform: translateY(-2px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }
    
    .btn-secondary-enhanced {
        background: linear-gradient(135deg, 
            rgba(108, 117, 125, 0.1) 0%, 
            rgba(108, 117, 125, 0.05) 100%);
        color: var(--black);
        border: 2px solid rgba(108, 117, 125, 0.2);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .btn-secondary-enhanced:hover {
        background: linear-gradient(135deg, 
            rgba(108, 117, 125, 0.15) 0%, 
            rgba(108, 117, 125, 0.1) 100%);
        color: var(--black);
        border-color: rgba(108, 117, 125, 0.4);
        transform: translateY(-2px) scale(1.02);
        box-shadow: 
            0 6px 20px rgba(108, 117, 125, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }
    
    [data-theme="dark"] .btn-secondary-enhanced {
        background: linear-gradient(135deg, 
            rgba(108, 117, 125, 0.2) 0%, 
            rgba(108, 117, 125, 0.1) 100%);
        color: var(--black);
        border: 2px solid rgba(108, 117, 125, 0.3);
    }
    
    [data-theme="dark"] .btn-secondary-enhanced:hover {
        background: linear-gradient(135deg, 
            rgba(108, 117, 125, 0.3) 0%, 
            rgba(108, 117, 125, 0.2) 100%);
        border-color: rgba(108, 117, 125, 0.5);
    }
    
    .btn-warning-enhanced {
        background: linear-gradient(135deg, 
            rgba(255, 193, 7, 0.1) 0%, 
            rgba(255, 193, 7, 0.05) 100%);
        color: #856404;
        border: 2px solid rgba(255, 193, 7, 0.3);
        box-shadow: 
            0 2px 8px rgba(255, 193, 7, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
    }
    
    .btn-warning-enhanced:hover {
        background: linear-gradient(135deg, var(--warning-color) 0%, #ffca2c 100%);
        color: var(--white);
        border-color: var(--warning-color);
        transform: translateY(-2px) scale(1.02);
        box-shadow: 
            0 6px 20px rgba(255, 193, 7, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    
    .btn-enhanced i {
        transition: transform 0.3s ease;
    }
    
    .btn-enhanced:hover i {
        transform: scale(1.1);
    }
    
    /* Enhanced Divider */
    .custom-divider {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 173, 81, 0.3) 20%, 
            rgba(255, 173, 81, 0.5) 50%, 
            rgba(255, 173, 81, 0.3) 80%, 
            transparent 100%);
        margin: 3rem 0;
        border-radius: 1px;
    }
    
    /* Enhanced Reset Section */
    .reset-section {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.03) 0%, 
            rgba(255, 173, 81, 0.01) 100%);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        border: 1px solid rgba(255, 173, 81, 0.1);
        position: relative;
        overflow: hidden;
    }
    
    [data-theme="dark"] .reset-section {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.08) 0%, 
            rgba(255, 173, 81, 0.03) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
    }
    
    .reset-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at center, 
            rgba(255, 173, 81, 0.05) 0%, 
            transparent 70%);
        pointer-events: none;
    }
    
    .reset-section > * {
        position: relative;
        z-index: 2;
    }
    
    .reset-section p {
        color: var(--body-text);
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .reset-section strong {
        color: var(--black);
        font-weight: 600;
    }
    
    /* Button Group Enhancement */
    .button-group {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
        .button-group {
            justify-content: stretch;
        }
        
        .button-group .btn-enhanced {
            flex: 1;
            min-width: 0;
        }
    }
    
    /* Loading State */
    .btn-enhanced:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }
    
    .btn-enhanced:disabled::before {
        display: none;
    }
    
    /* Responsive Design */
    @media (max-width: 991.98px) {
        .password-card-body {
            padding: 2rem 1.5rem;
        }
        
        .password-card-header {
            padding: 1.5rem 2rem;
        }
        
        .password-card-header h5 {
            font-size: 1.3rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .change-password-wrapper {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .password-card-body {
            padding: 1.5rem 1rem;
        }
        
        .password-card-header {
            padding: 1.25rem 1.5rem;
        }
        
                 .password-card-header {
             flex-direction: column;
             align-items: flex-start;
             gap: 1rem;
         }
         
         .password-card-header h5 {
             font-size: 1.2rem;
             margin-bottom: 0;
         }
         
         .header-back-btn {
             align-self: flex-end;
             margin-left: 0;
         }
        
        .button-group {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn-enhanced {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Focus Management */
    .form-control-enhanced:focus {
        z-index: 2;
    }
    
    /* Animation Classes */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Text Selection */
    .change-password-wrapper ::selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
    .change-password-wrapper ::-moz-selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
</style>

<div class="change-password-wrapper">
        <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="password-card shadow fade-in" data-aos="fade-up" data-aos-delay="200">
                    <div class="password-card-header">
                        <h5 class="mb-0">Change Password</h5>
                        <a href="{{ route('user.dashboard') }}" class="header-back-btn">
                            <i class="bi bi-arrow-right"></i> Back to Dashboard
                        </a>
                    </div>

                    <div class="password-card-body">
                        @if (session('success'))
                            <div class="alert alert-success custom-alert alert-dismissible fade show" role="alert" data-aos="fade-down" data-aos-delay="100">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close-custom" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        @endif

                        <div class="alert alert-info custom-alert mb-4" role="alert">
                            <i class="bi bi-info-circle-fill"></i>
                            <strong>Password Requirements:</strong>
                            <ul class="mt-2 mb-0">
                                <li>At least 8 characters long</li>
                                <li>Must contain uppercase and lowercase letters</li>
                                <li>Must contain at least one number</li>
                                <li>Must contain at least one special character</li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('user.password.change') }}">
                            @csrf

                            <div class="form-group-enhanced">
                                <label for="current_password" class="form-label-enhanced">
                                    <i class="bi bi-lock-fill"></i>Current Password
                                </label>
                                <input id="current_password" 
                                       type="password" 
                                       class="form-control-enhanced @error('current_password') is-invalid @enderror" 
                                       name="current_password" 
                                       required 
                                       autofocus>

                                @error('current_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-enhanced">
                                <label for="password" class="form-label-enhanced">
                                    <i class="bi bi-key-fill"></i>New Password
                                </label>
                                <input id="password" 
                                       type="password" 
                                       class="form-control-enhanced @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-enhanced">
                                <label for="password_confirmation" class="form-label-enhanced">
                                    <i class="bi bi-key-fill"></i>Confirm New Password
                                </label>
                                <input id="password_confirmation" 
                                       type="password" 
                                       class="form-control-enhanced" 
                                       name="password_confirmation" 
                                       required>
                            </div>

                            <div class="button-group">
                                <a href="{{ route('user.dashboard') }}" class="btn btn-enhanced btn-secondary-enhanced">
                                    <i class="bi bi-x-circle"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-enhanced btn-primary-enhanced">
                                    <i class="bi bi-check-circle"></i>Change Password
                                </button>
                            </div>
                        </form>

                        <hr class="custom-divider">

                        <div class="reset-section">
                            <p class="mb-2">
                                <strong>Forgot your password?</strong>
                            </p>
                            <p class="small mb-3">
                                If you can't remember your current password, you can use the password reset option below. 
                                This will log you out and send a reset link to your email.
                            </p>
                            <a href="{{ route('password.request') }}" class="btn btn-enhanced btn-warning-enhanced">
                                <i class="bi bi-envelope"></i>Reset Password via Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- AOS Animation Library Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out-quart',
        once: true,
        offset: 50,
        delay: 100
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced form interactions
        const formControls = document.querySelectorAll('.form-control-enhanced');
        
        formControls.forEach(control => {
            // Add floating effect on focus
            control.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            control.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
            });
            
            // Add input validation styling
            control.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.classList.add('has-content');
                } else {
                    this.classList.remove('has-content');
                }
            });
        });
        
        // Enhanced button interactions
        const buttons = document.querySelectorAll('.btn-enhanced');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(0) scale(1)';
                }
            });
            
            // Add click effect
            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(0) scale(0.98)';
            });
            
            button.addEventListener('mouseup', function() {
                if (!this.disabled) {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                }
            });
        });
        
        // Form submission enhancement
        const form = document.querySelector('form');
        const submitButton = document.querySelector('button[type="submit"]');
        
        if (form && submitButton) {
            form.addEventListener('submit', function() {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Changing Password...';
                submitButton.style.opacity = '0.7';
                submitButton.style.cursor = 'not-allowed';
            });
        }
        
        // Auto-dismiss alerts
        const alerts = document.querySelectorAll('.alert.alert-dismissible');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
        
        // Password strength indicator (visual feedback only)
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Check length
                if (password.length >= 8) strength++;
                // Check for uppercase
                if (/[A-Z]/.test(password)) strength++;
                // Check for lowercase
                if (/[a-z]/.test(password)) strength++;
                // Check for number
                if (/\d/.test(password)) strength++;
                // Check for special character
                if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
                
                // Visual feedback through border color
                this.style.borderLeftWidth = '4px';
                if (strength < 2) {
                    this.style.borderLeftColor = '#dc3545';
                } else if (strength < 4) {
                    this.style.borderLeftColor = '#ffc107';
                } else {
                    this.style.borderLeftColor = '#28a745';
                }
            });
        }
        
        // Password confirmation matching
        if (confirmPasswordInput && passwordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                this.style.borderLeftWidth = '4px';
                if (this.value === passwordInput.value && this.value.length > 0) {
                    this.style.borderLeftColor = '#28a745';
                } else if (this.value.length > 0) {
                    this.style.borderLeftColor = '#dc3545';
                } else {
                    this.style.borderLeftColor = 'rgba(255, 173, 81, 0.1)';
                }
            });
        }
    });
</script>
@endpush
@endsection 