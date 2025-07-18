@extends('layouts.app')

@push('styles')
<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@section('content')
<style>
    /* Profile page specific colors - scoped to avoid global conflicts */
    .profile-edit-container {
        --heading-color: #FFAD51;
        --container-bg: #CFE2FF;
        --body-text: #898E8F;
        --border-radius: 12px;
        --success-color: #198754;
        --danger-color: #dc3545;
        
        /* Form specific colors */
        --form-bg: #FFFFFF;
        --form-border: rgba(255, 173, 81, 0.2);
        --form-focus: #FFAD51;
        --form-text: #495057;
        --form-label: #2c3e50;
    }
    
    /* Dark Theme Variables - scoped to profile container */
    [data-theme="dark"] .profile-edit-container {
        --heading-color: #FFAD51;
        --container-bg: var(--theme-bg-tertiary, #3a3636);
        --body-text: var(--theme-text-secondary, #adb5bd);
        --form-bg: var(--theme-card-bg, #2f2b2b);
        --form-border: rgba(255, 173, 81, 0.3);
        --form-text: var(--theme-text-primary, #ffffff);
        --form-label: var(--theme-text-primary, #ffffff);
    }
    
    /* Typography - scoped to profile container */
    .profile-edit-container h1, 
    .profile-edit-container h2, 
    .profile-edit-container h3, 
    .profile-edit-container h4, 
    .profile-edit-container h5, 
    .profile-edit-container h6 {
        color: var(--theme-text-primary);
        font-weight: 600;
        line-height: 1.3;
    }
    
    /* Profile Edit Container */
    .profile-edit-container {
        padding: 4rem 0 6rem 0;
        position: relative;
    }
    
    .profile-edit-container::before {
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
        border-radius: 0 0 50px 50px;
        pointer-events: none;
    }
    
    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 4rem;
        position: relative;
        z-index: 2;
    }
    
    .page-title {
        font-weight: 800;
        font-size: clamp(2.2rem, 4vw, 3rem);
        color: var(--theme-text-primary);
        margin-bottom: 1rem;
        position: relative;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .page-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        margin: 1rem auto 0;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.3);
    }
    
    .page-subtitle {
        color: var(--body-text);
        font-size: 1.1rem;
        font-weight: 400;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.7;
    }
    
    /* Back Button */
    .back-button {
        background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%) !important;
        border: 1px solid var(--form-border) !important;
        color: var(--theme-text-primary) !important;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
        position: relative;
        overflow: hidden;
    }
    
    .back-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.4) 50%, transparent 100%);
        transition: left 0.5s ease;
    }
    
    .back-button:hover {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%) !important;
        color: white !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border-color: var(--heading-color) !important;
    }
    
    .back-button:hover::before {
        left: 100%;
    }
    
    .back-button i {
        transition: transform 0.3s ease;
    }
    
    .back-button:hover i {
        transform: translateX(-3px);
    }
    
    /* Dark mode back button */
    [data-theme="dark"] .back-button {
        background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%) !important;
        border: 1px solid rgba(255, 173, 81, 0.3) !important;
        color: var(--theme-text-primary) !important;
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    [data-theme="dark"] .back-button:hover {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%) !important;
        color: white !important;
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border-color: var(--heading-color) !important;
    }
    
    /* Success Alert */
    .alert-success {
        background: linear-gradient(135deg, 
            rgba(25, 135, 84, 0.1) 0%, 
            rgba(25, 135, 84, 0.05) 100%) !important;
        border: 1px solid rgba(25, 135, 84, 0.2) !important;
        border-radius: var(--border-radius) !important;
        color: var(--success-color) !important;
        padding: 1.25rem 1.5rem;
        box-shadow: 
            0 4px 20px rgba(25, 135, 84, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .alert-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--success-color);
        border-radius: 0 var(--border-radius) var(--border-radius) 0;
    }
    
    .alert-success i {
        color: var(--success-color);
        font-size: 1.1rem;
        filter: drop-shadow(0 1px 2px rgba(25, 135, 84, 0.3));
    }
    
    /* Enhanced Cards */
    .profile-card {
        background: linear-gradient(135deg, 
            var(--form-bg) 0%, 
            rgba(255, 255, 255, 0.95) 50%, 
            var(--form-bg) 100%);
        border-radius: 20px;
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.08),
            0 4px 12px rgba(0, 0, 0, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        border: 1px solid var(--form-border);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .profile-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
        border-radius: 20px 20px 0 0;
    }
    
    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.12),
            0 8px 20px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(255, 173, 81, 0.1);
    }
    
    /* Dark mode cards */
    [data-theme="dark"] .profile-card {
        background: linear-gradient(135deg, 
            var(--form-bg) 0%, 
            rgba(47, 43, 43, 0.95) 50%, 
            var(--form-bg) 100%);
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.4),
            0 4px 12px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .card-header {
        background: transparent !important;
        border-bottom: 1px solid var(--form-border) !important;
        padding: 2rem 2rem 1.5rem 2rem !important;
        position: relative;
    }
    
    .card-header h5 {
        color: var(--theme-text-primary) !important;
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-header h5 i {
        color: var(--heading-color);
        font-size: 1.2rem;
        filter: drop-shadow(0 2px 4px rgba(255, 173, 81, 0.3));
    }
    
    .card-body {
        padding: 2rem !important;
    }
    
    /* Profile Image Section */
    .profile-image-container {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .profile-image-wrapper {
        position: relative;
        display: inline-block;
        margin-bottom: 1.5rem;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid var(--heading-color);
        box-shadow: 
            0 8px 30px rgba(255, 173, 81, 0.3),
            inset 0 2px 0 rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        object-fit: cover;
    }
    
    .profile-image:hover {
        transform: scale(1.05) rotate(2deg);
        box-shadow: 
            0 15px 40px rgba(255, 173, 81, 0.4),
            inset 0 2px 0 rgba(255, 255, 255, 0.4);
    }
    
    .profile-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%);
        border: 4px solid var(--heading-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--heading-color);
        box-shadow: 
            0 8px 30px rgba(255, 173, 81, 0.3),
            inset 0 2px 0 rgba(255, 255, 255, 0.3);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        text-shadow: 0 2px 4px rgba(255, 173, 81, 0.3);
    }
    
    .profile-placeholder:hover {
        transform: scale(1.05) rotate(-2deg);
        box-shadow: 
            0 15px 40px rgba(255, 173, 81, 0.4),
            inset 0 2px 0 rgba(255, 255, 255, 0.4);
    }
    
    /* Dark mode profile placeholder */
    [data-theme="dark"] .profile-placeholder {
        background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%);
        color: #ffffff;
        border: 4px solid var(--heading-color);
        box-shadow: 
            0 8px 30px rgba(255, 173, 81, 0.4),
            inset 0 2px 0 rgba(255, 255, 255, 0.1);
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    [data-theme="dark"] .profile-placeholder:hover {
        box-shadow: 
            0 15px 40px rgba(255, 173, 81, 0.5),
            inset 0 2px 0 rgba(255, 255, 255, 0.2);
    }
    
    /* Enhanced Form Elements */
    .form-label {
        color: var(--form-label) !important;
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
    }
    
    .form-label i {
        color: var(--heading-color);
        font-size: 0.9rem;
        filter: drop-shadow(0 1px 2px rgba(255, 173, 81, 0.3));
    }
    
    .form-control, .form-select {
        background: var(--form-bg) !important;
        border: 2px solid var(--form-border) !important;
        border-radius: var(--border-radius) !important;
        padding: 0.875rem 1.25rem !important;
        font-size: 0.95rem !important;
        font-weight: 500 !important;
        color: var(--form-text) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.6) !important;
        position: relative;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--form-focus) !important;
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 15px rgba(255, 173, 81, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.8) !important;
        transform: translateY(-2px);
        background: var(--theme-bg-primary) !important;
    }
    
    .form-control:disabled, .form-select:disabled {
        background: linear-gradient(135deg, 
            rgba(248, 249, 250, 0.8) 0%, 
            rgba(233, 236, 239, 0.6) 100%) !important;
        border-color: rgba(0, 0, 0, 0.1) !important;
        color: var(--body-text) !important;
        cursor: not-allowed;
        position: relative;
    }
    
    /* Dark mode form controls */
    [data-theme="dark"] .form-control:disabled, 
    [data-theme="dark"] .form-select:disabled {
        background: linear-gradient(135deg, 
            rgba(58, 54, 54, 0.8) 0%, 
            rgba(47, 43, 43, 0.6) 100%) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    
    .form-text {
        color: var(--body-text) !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        margin-top: 0.5rem !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-text i {
        color: var(--heading-color);
        font-size: 0.8rem;
        opacity: 0.8;
    }
    
    /* File Input Enhancement */
    .form-control[type="file"] {
        padding: 0.75rem 1rem !important;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    
    .form-control[type="file"]:hover {
        border-color: var(--heading-color) !important;
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.05) 0%, 
            rgba(255, 173, 81, 0.02) 100%) !important;
    }
    
    /* Textarea Enhancement */
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.6 !important;
    }
    
    /* Invalid Feedback */
    .invalid-feedback {
        color: var(--danger-color) !important;
        font-size: 0.85rem !important;
        font-weight: 600 !important;
        margin-top: 0.5rem !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .invalid-feedback::before {
        content: '\f071';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: var(--danger-color);
        font-size: 0.8rem;
    }
    
    .is-invalid {
        border-color: var(--danger-color) !important;
        box-shadow: 
            0 0 0 3px rgba(220, 53, 69, 0.15),
            0 2px 8px rgba(220, 53, 69, 0.1) !important;
    }
    
    /* Enhanced Buttons - scoped to profile container */
    .profile-edit-container .btn {
        font-weight: 600 !important;
        padding: 0.875rem 2rem !important;
        border-radius: var(--border-radius) !important;
        border: none !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        position: relative;
        overflow: hidden;
        font-size: 0.95rem !important;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
        cursor: pointer;
    }
    
    .profile-edit-container .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
        transition: left 0.5s ease;
    }
    
    .profile-edit-container .btn:hover::before {
        left: 100%;
    }
    
    .profile-edit-container .btn-primary {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%) !important;
        color: white !important;
        box-shadow: 
            0 4px 15px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    
    .profile-edit-container .btn-primary:hover {
        background: linear-gradient(135deg, #e89640 0%, var(--heading-color) 100%) !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        color: white !important;
    }
    
    .profile-edit-container .btn-outline-secondary {
        background: transparent !important;
        border: 2px solid var(--form-border) !important;
        color: var(--theme-text-primary) !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .profile-edit-container .btn-outline-secondary:hover {
        background: var(--container-bg) !important;
        border-color: var(--heading-color) !important;
        color: var(--theme-text-primary) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(207, 226, 255, 0.3);
    }
    
    .profile-edit-container .btn-outline-danger {
        background: transparent !important;
        border: 2px solid rgba(220, 53, 69, 0.3) !important;
        color: var(--danger-color) !important;
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.1);
    }
    
    .profile-edit-container .btn-outline-danger:hover {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            rgba(220, 53, 69, 0.05) 100%) !important;
        border-color: var(--danger-color) !important;
        color: var(--danger-color) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.2);
    }
    
    .profile-edit-container .btn-sm {
        padding: 0.6rem 1.25rem !important;
        font-size: 0.85rem !important;
    }
    
    .profile-edit-container .btn i {
        transition: transform 0.3s ease;
    }
    
    .profile-edit-container .btn:hover i {
        transform: scale(1.1);
    }
    
    /* Button Groups */
    .profile-edit-container .d-grid .btn,
    .profile-edit-container .d-md-flex .btn {
        min-width: 140px;
        justify-content: center;
    }
    
    /* Row and Column Spacing */
    .row.mb-3 {
        margin-bottom: 2rem !important;
    }
    
    /* Responsive Design */
    @media (max-width: 991.98px) {
        .profile-edit-container {
            padding: 2rem 0 4rem 0;
        }
        
        .page-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
        }
        
        .card-header,
        .card-body {
            padding: 1.5rem !important;
        }
        
        .profile-image,
        .profile-placeholder {
            width: 120px;
            height: 120px;
        }
        
        .profile-edit-container .btn {
            padding: 0.75rem 1.5rem !important;
        }
    }
    
    @media (max-width: 767.98px) {
        .profile-edit-container {
            padding: 1.5rem 0 3rem 0;
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .back-button {
            margin-bottom: 1rem;
        }
        
        .profile-image,
        .profile-placeholder {
            width: 100px;
            height: 100px;
            font-size: 2rem;
        }
    }
    
    /* Custom Scrollbar - scoped to profile container */
    .profile-edit-container ::-webkit-scrollbar {
        width: 8px;
    }
    
    .profile-edit-container ::-webkit-scrollbar-track {
        background: var(--theme-bg-primary);
        border-radius: var(--border-radius);
    }
    
    .profile-edit-container ::-webkit-scrollbar-thumb {
        background: var(--heading-color);
        border-radius: var(--border-radius);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .profile-edit-container ::-webkit-scrollbar-thumb:hover {
        background: #e89640;
    }
    
    /* Text Selection - scoped to profile container */
    .profile-edit-container ::selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
    .profile-edit-container ::-moz-selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
    /* Loading States - scoped to profile container */
    .profile-edit-container .spinner-border {
        color: var(--heading-color);
    }
    
    /* Accessibility Improvements - scoped to profile container */
    .profile-edit-container .btn:focus,
    .profile-edit-container .form-control:focus,
    .profile-edit-container .form-select:focus {
        outline: 2px solid var(--heading-color);
        outline-offset: 2px;
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
    
    .slide-up {
        animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="profile-edit-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header" data-aos="fade-up">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="fas fa-user-edit me-3"></i>Edit Profile
                    </h1>
                    <p class="page-subtitle">Update your personal information and preferences</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('user.dashboard') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-in" role="alert" data-aos="fade-down">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="profile-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-camera"></i>Profile Picture
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="profile-image-container">
                            <div class="profile-image-wrapper">
                                @if(auth()->user()->profile_image)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->username }}" class="profile-image">
                                @else
                                    <div class="profile-placeholder">
                                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('user.profile.updateImage') }}" method="POST" enctype="multipart/form-data" class="slide-up">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">
                                    <i class="fas fa-upload"></i>Upload New Image
                                </label>
                                <input type="file" class="form-control @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*">
                                
                                @error('profile_image')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i>Recommended size: 300x300 pixels. Max 2MB.
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cloud-upload-alt"></i> Upload Image
                                </button>
                            </div>
                            
                            @if(auth()->user()->profile_image)
                                <div class="mt-3">
                                    <form action="{{ route('user.profile.removeImage') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Remove Image
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                <div class="profile-card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-user-cog"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.profile.update') }}" method="POST" class="slide-up">
                            @csrf
                            @method('PATCH')
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="username" class="form-label">
                                        <i class="fas fa-user"></i>Username
                                    </label>
                                    <input type="text" class="form-control" id="username" value="{{ auth()->user()->username }}" disabled>
                                    <div class="form-text">
                                        <i class="fas fa-lock"></i>Username cannot be changed.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control" id="email" value="{{ auth()->user()->email }}" disabled>
                                    <div class="form-text">
                                        <i class="fas fa-lock"></i>Email cannot be changed.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="personal_number" class="form-label">
                                        <i class="fas fa-id-card"></i>Personal Number
                                    </label>
                                    <input type="text" class="form-control" id="personal_number" value="{{ auth()->user()->personal_number }}" disabled>
                                    <input type="hidden" name="personal_number" value="{{ auth()->user()->personal_number }}">
                                    <div class="form-text">
                                        <i class="fas fa-lock"></i>Personal number cannot be changed.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="date_of_birth" class="form-label">
                                        <i class="fas fa-birthday-cake"></i>Date of Birth
                                    </label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ auth()->user()->date_of_birth ? auth()->user()->date_of_birth->format('Y-m-d') : '' }}">
                                    
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="region_id" class="form-label">
                                        <i class="fas fa-map-marked-alt"></i>Region
                                    </label>
                                    <select class="form-select" id="region_id" disabled>
                                        <option>{{ auth()->user()->region->name }}</option>
                                    </select>
                                    <input type="hidden" name="region_id" value="{{ auth()->user()->region_id }}">
                                    <div class="form-text">
                                        <i class="fas fa-lock"></i>Region cannot be changed.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="station_id" class="form-label">
                                        <i class="fas fa-broadcast-tower"></i>Station
                                    </label>
                                    <select class="form-select" id="station_id" disabled>
                                        <option>{{ auth()->user()->station->name }}</option>
                                    </select>
                                    <input type="hidden" name="station_id" value="{{ auth()->user()->station_id }}">
                                    <div class="form-text">
                                        <i class="fas fa-lock"></i>Station cannot be changed.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="designation" class="form-label">
                                        <i class="fas fa-briefcase"></i>Designation
                                    </label>
                                    <select class="form-select" id="designation" disabled>
                                        <option>{{ auth()->user()->designation }}</option>
                                    </select>
                                    <input type="hidden" name="designation" value="{{ auth()->user()->designation }}">
                                    <div class="form-text">
                                        <i class="fas fa-lock"></i>Designation cannot be changed.
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="gender" class="form-label">
                                        <i class="fas fa-venus-mars"></i>Gender
                                    </label>
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="Male" {{ auth()->user()->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ auth()->user()->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ auth()->user()->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <i class="fas fa-edit"></i>Bio / Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Tell us about yourself...">{{ auth()->user()->description }}</textarea>
                                
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                                
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i>Maximum 500 characters.
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo-alt"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

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

    // Enhanced form interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Form control focus effects
        const formControls = document.querySelectorAll('.form-control, .form-select');
        
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.closest('.col-md-6, .mb-3')?.classList.add('focused');
            });
            
            control.addEventListener('blur', function() {
                this.closest('.col-md-6, .mb-3')?.classList.remove('focused');
            });
        });

        // File input change effect
        const fileInput = document.getElementById('profile_image');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const fileName = this.files[0]?.name;
                if (fileName) {
                    // Show file name feedback
                    const feedback = document.createElement('div');
                    feedback.className = 'mt-2 text-success';
                    feedback.innerHTML = `<i class="fas fa-check-circle me-2"></i>Selected: ${fileName}`;
                    
                    // Remove existing feedback
                    const existingFeedback = this.parentNode.querySelector('.text-success');
                    if (existingFeedback) {
                        existingFeedback.remove();
                    }
                    
                    // Add new feedback
                    this.parentNode.appendChild(feedback);
                }
            });
        }

        // Textarea character counter
        const textarea = document.getElementById('description');
        if (textarea) {
            const maxLength = 500;
            
            function updateCounter() {
                const currentLength = textarea.value.length;
                const remaining = maxLength - currentLength;
                
                let counterElement = document.getElementById('char-counter');
                if (!counterElement) {
                    counterElement = document.createElement('div');
                    counterElement.id = 'char-counter';
                    counterElement.className = 'form-text mt-2';
                    textarea.parentNode.appendChild(counterElement);
                }
                
                counterElement.innerHTML = `
                    <i class="fas fa-keyboard me-1"></i>
                    ${currentLength}/${maxLength} characters 
                    ${remaining < 50 ? `<span class="text-warning">(${remaining} remaining)</span>` : ''}
                `;
                
                if (remaining < 0) {
                    counterElement.classList.add('text-danger');
                    counterElement.classList.remove('text-warning');
                } else if (remaining < 50) {
                    counterElement.classList.add('text-warning');
                    counterElement.classList.remove('text-danger');
                } else {
                    counterElement.classList.remove('text-danger', 'text-warning');
                }
            }
            
            textarea.addEventListener('input', updateCounter);
            updateCounter(); // Initial call
        }

        // Enhanced button interactions - scoped to profile container
        const buttons = document.querySelectorAll('.profile-edit-container .btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
            
            button.addEventListener('mousedown', function() {
                this.style.transform = 'translateY(0) scale(0.98)';
            });
            
            button.addEventListener('mouseup', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });
        });

        // Form validation enhancement - scoped to profile container
        const forms = document.querySelectorAll('.profile-edit-container form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                    submitButton.disabled = true;
                    
                    // Re-enable after a delay (in case of validation errors)
                    setTimeout(() => {
                        if (submitButton.disabled) {
                            submitButton.innerHTML = submitButton.textContent.includes('Upload') 
                                ? '<i class="fas fa-cloud-upload-alt"></i> Upload Image'
                                : '<i class="fas fa-save"></i> Save Changes';
                            submitButton.disabled = false;
                        }
                    }, 3000);
                }
            });
        });

        // Add ripple effect to buttons
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
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.pointerEvents = 'none';
                ripple.style.zIndex = '1000';
                ripple.style.animation = 'rippleEffect 0.6s ease-out';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add ripple effect animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes rippleEffect {
                0% {
                    transform: scale(0);
                    opacity: 1;
                }
                100% {
                    transform: scale(2);
                    opacity: 0;
                }
            }
            
            .focused {
                animation: focusPulse 0.3s ease-out;
            }
            
            @keyframes focusPulse {
                0% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.01);
                }
                100% {
                    transform: scale(1);
                }
            }
        `;
        document.head.appendChild(style);

        // Smooth scroll to validation errors
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            setTimeout(() => {
                firstInvalid.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstInvalid.focus();
            }, 100);
        }
    });
</script>
@endpush