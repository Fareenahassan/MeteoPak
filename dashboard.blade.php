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
        --border-radius: 3px;
        --section-padding: 100px;
        
        /* Navbar height for consistency with app.css */
        --navbar-height: 56px;
        
        /* Theme variables for navbar consistency */
        --navbar-text-color: var(--theme-text-primary, #000000);
        --navbar-bg: var(--theme-bg-primary, #FFFFFF);
        --navbar-dropdown-bg: var(--theme-dropdown-bg, #FFFFFF);
    }
    
    /* Dark Theme Variables for Dashboard Page - Using Global Theme */
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
    }
    
    /* Typography */
    h1, h2, h3, h4, h5, h6 {
        color: var(--black);
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        line-height: 1.3;
    }
    
    /* Dashboard Container */
    .dashboard-container {
        background: var(--primary-bg);
        min-height: calc(100vh - var(--navbar-height));
        padding: 4rem 0 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 300px;
        background: linear-gradient(135deg, 
            rgba(207, 226, 255, 0.1) 0%, 
            transparent 50%, 
            rgba(255, 173, 81, 0.05) 100%);
        pointer-events: none;
        border-radius: 0 0 100px 100px;
    }
    
    /* Enhanced Success Alert */
    .alert-success {
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            rgba(40, 167, 69, 0.05) 100%);
        border: 1px solid rgba(40, 167, 69, 0.3);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 
            0 8px 32px rgba(40, 167, 69, 0.1),
            0 2px 8px rgba(40, 167, 69, 0.05);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }
    
    .alert-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 255, 255, 0.3) 50%, 
            transparent 100%);
        animation: alertShine 3s ease-in-out infinite;
    }
    
    @keyframes alertShine {
        0%, 100% { left: -100%; }
        50% { left: 100%; }
    }
    
    /* Dashboard Header */
    .dashboard-header {
        margin-bottom: 3rem;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .dashboard-header h1 {
        font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        color: var(--black);
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    [data-theme="dark"] .dashboard-header h1 {
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .dashboard-header p {
        color: var(--body-text);
        font-size: 1.25rem;
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .dashboard-header::after {
        content: '';
        display: block;
        width: 120px;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        margin: 1.5rem auto 0;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.3);
    }
    
    /* Enhanced Card Styles */
    .enhanced-card {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.95) 50%, 
            var(--white) 100%);
        border-radius: 20px;
        padding: 2rem 1.75rem;
        box-shadow: 
            0 8px 40px rgba(0, 0, 0, 0.06),
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(255, 173, 81, 0.08);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    /* Profile and Info cards need full height */
    .profile-card,
    .info-card {
        height: 100%;
    }
    
    [data-theme="dark"] .enhanced-card {
        background: linear-gradient(135deg, 
            var(--theme-card-bg) 0%, 
            rgba(47, 43, 43, 0.95) 50%, 
            var(--theme-card-bg) 100%);
        border: 1px solid rgba(255, 173, 81, 0.15);
        box-shadow: 
            0 8px 40px rgba(0, 0, 0, 0.4),
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .enhanced-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        transform: scaleX(0);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 20px 20px 0 0;
    }
    
    .enhanced-card::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: radial-gradient(circle, rgba(255, 173, 81, 0.05) 0%, transparent 70%);
        transform: translate(-50%, -50%);
        transition: all 0.6s ease;
        border-radius: 50%;
        pointer-events: none;
    }
    
    .enhanced-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.12),
            0 8px 20px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(255, 173, 81, 0.1);
    }
    
    .enhanced-card:hover::before {
        transform: scaleX(1);
    }
    
    .enhanced-card:hover::after {
        width: 200px;
        height: 200px;
    }
    
    /* Profile Card Specific */
    .profile-card {
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .profile-image-container {
        margin-bottom: 2rem;
        position: relative;
        display: inline-block;
    }
    
    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 173, 81, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            0 0 0 4px rgba(255, 255, 255, 0.8);
        position: relative;
        z-index: 2;
    }
    
    [data-theme="dark"] .profile-image {
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.4),
            0 0 0 4px rgba(255, 255, 255, 0.1);
    }
    
    .profile-image:hover {
        transform: scale(1.05);
        border-color: var(--heading-color);
        box-shadow: 
            0 12px 40px rgba(255, 173, 81, 0.3),
            0 0 0 4px rgba(255, 173, 81, 0.2);
    }
    
    .profile-placeholder {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: var(--heading-color);
        border: 4px solid rgba(255, 173, 81, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 2px 0 rgba(255, 255, 255, 0.6);
        position: relative;
        z-index: 2;
    }
    
    [data-theme="dark"] .profile-placeholder {
        background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%);
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.4),
            inset 0 2px 0 rgba(255, 255, 255, 0.1);
    }
    
    .profile-placeholder:hover {
        transform: scale(1.05);
        border-color: var(--heading-color);
        box-shadow: 
            0 12px 40px rgba(255, 173, 81, 0.3),
            inset 0 2px 0 rgba(255, 255, 255, 0.8);
    }
    
    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 0.5rem;
    }
    
    .profile-designation {
        color: var(--body-text);
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
    }
    
    .profile-badge {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        color: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1.5rem;
        box-shadow: 
            0 4px 15px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    
    .profile-badge:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }
    
    .profile-description {
        color: var(--body-text);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 0;
    }
    
    .profile-footer {
        background: linear-gradient(135deg, 
            rgba(255, 255, 255, 0.8) 0%, 
            rgba(248, 249, 250, 0.9) 100%);
        border-top: 1px solid rgba(255, 173, 81, 0.1);
        margin: 2rem -2rem -2.5rem;
        padding: 1.5rem 2rem;
        border-radius: 0 0 20px 20px;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
    
    [data-theme="dark"] .profile-footer {
        background: linear-gradient(135deg, 
            rgba(58, 54, 54, 0.8) 0%, 
            rgba(47, 43, 43, 0.9) 100%);
        border-top: 1px solid rgba(255, 173, 81, 0.1);
    }
    
    /* Info Cards */
    .info-card {
        border-left: 4px solid var(--heading-color);
        position: relative;
        z-index: 2;
    }
    
    .info-card .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .info-card.border-primary .card-icon {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
        color: #0d6efd;
        box-shadow: 0 4px 20px rgba(13, 110, 253, 0.15);
    }
    
    .info-card.border-success .card-icon {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
        color: #198754;
        box-shadow: 0 4px 20px rgba(25, 135, 84, 0.15);
    }
    
    .info-card:hover .card-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 8px 30px rgba(255, 173, 81, 0.3);
    }
    
    .info-card h4 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--black);
        margin-bottom: 0.5rem;
    }
    
    .info-card p {
        color: var(--body-text);
        font-size: 0.95rem;
        margin-bottom: 0;
    }
    
    /* Quick Links Section */
    .quick-links {
        padding: 1.5rem 1.75rem;
    }
    
    .quick-links .card-header {
        background: linear-gradient(135deg, 
            var(--container-bg) 0%, 
            rgba(207, 226, 255, 0.8) 100%);
        border-bottom: 1px solid rgba(255, 173, 81, 0.1);
        padding: 1rem 1.25rem;
        border-radius: 16px 16px 0 0;
        position: relative;
        overflow: hidden;
        margin: -1.5rem -1.75rem 1rem;
    }
    
    .quick-links .card-body {
        padding: 0;
    }
    
    [data-theme="dark"] .quick-links .card-header {
        background: linear-gradient(135deg, 
            var(--container-bg) 0%, 
            rgba(58, 54, 54, 0.8) 100%);
    }
    
    [data-theme="dark"] .account-info .card-header {
        background: linear-gradient(135deg, 
            var(--container-bg) 0%, 
            rgba(58, 54, 54, 0.8) 100%);
    }
    
    .quick-links .card-header::before {
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
        animation: headerShine 4s ease-in-out infinite;
    }
    
    @keyframes headerShine {
        0%, 100% { left: -100%; }
        50% { left: 100%; }
    }
    
    .quick-links h5,
    .account-info h5 {
        font-weight: 700;
        color: var(--black);
        margin-bottom: 0;
        font-size: 1.25rem;
    }
    
    /* Enhanced Buttons */
    .enhanced-btn {
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 2px solid transparent;
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
    
    .enhanced-btn::before {
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
    
    .enhanced-btn:hover::before {
        left: 100%;
    }
    
    .enhanced-btn:hover {
        transform: translateY(-3px) scale(1.02);
        text-decoration: none;
    }
    
    .enhanced-btn i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    
    .enhanced-btn:hover i {
        transform: scale(1.2);
    }
    
    .btn-outline-primary.enhanced-btn {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.1) 0%, rgba(13, 110, 253, 0.05) 100%);
        color: #0d6efd;
        border-color: rgba(13, 110, 253, 0.3);
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.1);
    }
    
    .btn-outline-primary.enhanced-btn:hover {
        background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
        color: white;
        border-color: #0d6efd;
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
    }
    
    .btn-outline-secondary.enhanced-btn {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.1) 0%, rgba(108, 117, 125, 0.05) 100%);
        color: #6c757d;
        border-color: rgba(108, 117, 125, 0.3);
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.1);
    }
    
    .btn-outline-secondary.enhanced-btn:hover {
        background: linear-gradient(135deg, #6c757d 0%, #5c636a 100%);
        color: white;
        border-color: #6c757d;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    }
    
    .btn-outline-success.enhanced-btn {
        background: linear-gradient(135deg, rgba(25, 135, 84, 0.1) 0%, rgba(25, 135, 84, 0.05) 100%);
        color: #198754;
        border-color: rgba(25, 135, 84, 0.3);
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.1);
    }
    
    .btn-outline-success.enhanced-btn:hover {
        background: linear-gradient(135deg, #198754 0%, #157347 100%);
        color: white;
        border-color: #198754;
        box-shadow: 0 8px 25px rgba(25, 135, 84, 0.3);
    }
    
    .btn-outline-info.enhanced-btn {
        background: linear-gradient(135deg, rgba(13, 202, 240, 0.1) 0%, rgba(13, 202, 240, 0.05) 100%);
        color: #0dcaf0;
        border-color: rgba(13, 202, 240, 0.3);
        box-shadow: 0 4px 15px rgba(13, 202, 240, 0.1);
    }
    
    .btn-outline-info.enhanced-btn:hover {
        background: linear-gradient(135deg, #0dcaf0 0%, #0bb5d6 100%);
        color: white;
        border-color: #0dcaf0;
        box-shadow: 0 8px 25px rgba(13, 202, 240, 0.3);
    }
    
    /* Account Information Section */
    .account-info {
        padding: 1.5rem 1.75rem;
    }
    
    .account-info .card-header {
        background: linear-gradient(135deg, 
            var(--container-bg) 0%, 
            rgba(207, 226, 255, 0.8) 100%);
        border-bottom: 1px solid rgba(255, 173, 81, 0.1);
        padding: 1rem 1.25rem;
        border-radius: 16px 16px 0 0;
        position: relative;
        overflow: hidden;
        margin: -1.5rem -1.75rem 1rem;
    }
    
    .account-info .card-header::before {
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
        animation: headerShine 4s ease-in-out infinite;
    }
    
    .account-info .card-body {
        padding: 0;
    }
    
    .account-info .detail-row {
        padding: 1rem 0;
        border-bottom: 1px solid rgba(255, 173, 81, 0.1);
        transition: all 0.3s ease;
    }
    
    .account-info .detail-row:last-child {
        border-bottom: none;
    }
    
    .account-info .detail-row:hover {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.03) 0%, 
            rgba(255, 173, 81, 0.01) 100%);
        margin: 0 -2rem;
        padding-left: 2rem;
        padding-right: 2rem;
        border-radius: 8px;
    }
    
    .account-info .detail-label {
        color: var(--body-text);
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 0;
    }
    
    .account-info .detail-value {
        color: var(--black);
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0;
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
    
    /* Responsive Design */
    @media (max-width: 991.98px) {
        .dashboard-container {
            padding: 2rem 0 1rem;
        }
        
        .enhanced-card {
            margin-bottom: 2rem;
            padding: 2rem 1.5rem;
        }
        
        .dashboard-header h1 {
            font-size: clamp(2rem, 4vw, 2.8rem);
        }
        
        .profile-image,
        .profile-placeholder {
            width: 120px;
            height: 120px;
        }
        
        .profile-placeholder {
            font-size: 2.5rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .dashboard-container {
            padding: 1.5rem 0 1rem;
        }
        
        .enhanced-card {
            padding: 1.5rem 1.25rem;
        }
        
        .dashboard-header {
            margin-bottom: 2rem;
        }
        
        .dashboard-header p {
            font-size: 1.1rem;
        }
        
        .enhanced-btn {
            padding: 0.875rem 1.25rem;
            font-size: 0.95rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="container py-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-down" data-aos-delay="100">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="dashboard-header" data-aos="fade-up" data-aos-delay="200">
            <h1>Dashboard</h1>
            <p>Welcome back, {{ auth()->user()->username }}!</p>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="enhanced-card profile-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="profile-image-container">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="{{ auth()->user()->username }}" class="profile-image">
                        @else
                            <div class="profile-placeholder">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    
                    <h4 class="profile-name">{{ auth()->user()->username }}</h4>
                    <p class="profile-designation">{{ auth()->user()->designation }}</p>
                    
                    <div class="profile-badge">
                        <i class="bi bi-geo-alt me-2"></i>
                        {{ auth()->user()->region->name }} - {{ auth()->user()->station->name }}
                    </div>
                    
                    @if(auth()->user()->description)
                        <p class="profile-description">{{ auth()->user()->description }}</p>
                    @endif
                    
                    <div class="profile-footer">
                        <div class="small text-muted text-center">
                            <i class="bi bi-calendar-event me-2"></i>
                            Member since {{ auth()->user()->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="enhanced-card info-card border-primary" data-aos="fade-up" data-aos-delay="400">
                            <div class="d-flex align-items-center mb-3">
                                <div class="card-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">Your Station</h5>
                                </div>
                            </div>
                            <h4>{{ auth()->user()->station->name }}</h4>
                            <p>{{ auth()->user()->region->name }} Region</p>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="enhanced-card info-card border-success" data-aos="fade-up" data-aos-delay="500">
                            <div class="d-flex align-items-center mb-3">
                                <div class="card-icon">
                                    <i class="bi bi-person-workspace"></i>
                                </div>
                                <div class="ms-3">
                                    <h5 class="mb-0">Your Role</h5>
                                </div>
                            </div>
                            <h4>{{ auth()->user()->designation }}</h4>
                            <p>Personal Number: {{ auth()->user()->personal_number }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="enhanced-card quick-links mb-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="card-header">
                        <h5><i class="bi bi-lightning-charge me-2"></i>Quick Links</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <div class="d-grid">
                                    <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary enhanced-btn">
                                        <i class="bi bi-person-gear"></i>
                                        Update Profile
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="d-grid">
                                    <a href="{{ route('user.password.change.form') }}" class="btn btn-outline-secondary enhanced-btn">
                                        <i class="bi bi-key"></i>
                                        Change Password
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="d-grid">
                                    <a href="{{ route('weather.observation.create') }}" class="btn btn-outline-success enhanced-btn">
                                        <i class="bi bi-cloud-sun"></i>
                                        Weather Observation Form
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="d-grid">
                                    <a href="{{ route('weather.observations') }}" class="btn btn-outline-info enhanced-btn">
                                        <i class="bi bi-table"></i>
                                        View Weather Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="enhanced-card account-info" data-aos="fade-up" data-aos-delay="700">
                    <div class="card-header">
                        <h5><i class="bi bi-person-circle me-2"></i>Account Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 detail-row">
                            <div class="col-md-4">
                                <p class="detail-label">Email Address</p>
                            </div>
                            <div class="col-md-8">
                                <p class="detail-value">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3 detail-row">
                            <div class="col-md-4">
                                <p class="detail-label">Personal Number</p>
                            </div>
                            <div class="col-md-8">
                                <p class="detail-value">{{ auth()->user()->personal_number }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3 detail-row">
                            <div class="col-md-4">
                                <p class="detail-label">Gender</p>
                            </div>
                            <div class="col-md-8">
                                <p class="detail-value">{{ auth()->user()->gender }}</p>
                            </div>
                        </div>
                        
                        @if(auth()->user()->date_of_birth)
                            <div class="row mb-3 detail-row">
                                <div class="col-md-4">
                                    <p class="detail-label">Date of Birth</p>
                                </div>
                                <div class="col-md-8">
                                    <p class="detail-value">{{ auth()->user()->date_of_birth->format('F d, Y') }}</p>
                                </div>
                            </div>
                        @endif
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

    // Enhanced card interactions
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.enhanced-card');
        const buttons = document.querySelectorAll('.enhanced-btn');
        
        // Card hover effects
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.01)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Button ripple effect
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
                ripple.style.background = 'rgba(255, 255, 255, 0.4)';
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
        `;
        document.head.appendChild(style);
    });
</script>
@endpush
@endsection