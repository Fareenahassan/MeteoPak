@extends('layouts.app')

@push('styles')
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<!-- AOS Animation Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush

@push('styles')
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
        --section-padding: 2rem;
        --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        --card-hover-shadow: 0 12px 48px rgba(0, 0, 0, 0.12);
        
        /* Navbar height for consistency */
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
        --card-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        --card-hover-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
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
    
    .container {
        position: relative;
        z-index: 1;
    }
    
    /* Page Header Styling */
    .page-header {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 50%, 
            var(--white) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 173, 81, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        position: relative;
        overflow: visible; /* Changed from hidden to visible */
        z-index: 10; /* Lower z-index than dropdown */
    }
    
    [data-theme="dark"] .page-header {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(47, 43, 43, 0.98) 50%, 
            var(--white) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 20px 20px 0 0;
    }
    
    .page-header h1 {
        font-weight: 800;
        font-size: 2.5rem;
        color: var(--black);
        margin: 0;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Language Dropdown Styling */
    .dropdown {
        position: relative;
        z-index: 1050; /* High z-index to ensure visibility */
    }
    
    .language-dropdown {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 4px 15px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1051;
        cursor: pointer;
        min-width: 140px;
        justify-content: center;
    }
    
    .language-dropdown:hover {
        transform: translateY(-2px);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        color: white;
        background: linear-gradient(135deg, #e89640 0%, #FFAD51 100%);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    .language-dropdown:focus {
        color: white;
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 4px 15px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        outline: none;
    }
    
    .language-dropdown:active {
        transform: translateY(0);
        box-shadow: 
            0 2px 8px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .dropdown-menu {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 50%, 
            var(--white) 100%) !important;
        border: 1px solid rgba(255, 173, 81, 0.2) !important;
        border-radius: 12px !important;
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.15),
            0 4px 12px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
        padding: 0.75rem 0 !important;
        margin-top: 0.75rem !important;
        z-index: 1052 !important;
        min-width: 180px !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        overflow: hidden !important;
        animation: dropdownFadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    
    /* Enhanced dropdown animation */
    @keyframes dropdownFadeIn {
        0% {
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    /* Dropdown arrow pointer */
    .dropdown-menu::before {
        content: '';
        position: absolute;
        top: -6px;
        right: 20px;
        width: 12px;
        height: 12px;
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
        border-bottom: none;
        border-right: none;
        transform: rotate(45deg);
        border-radius: 2px 0 0 0;
    }
    
    [data-theme="dark"] .dropdown-menu {
        background: linear-gradient(135deg, 
            var(--theme-dropdown-bg, #3a3636) 0%, 
            rgba(58, 54, 54, 0.98) 50%, 
            var(--theme-dropdown-bg, #3a3636) 100%) !important;
        border-color: rgba(255, 173, 81, 0.3) !important;
        box-shadow: 
            0 10px 40px rgba(0, 0, 0, 0.6),
            0 4px 12px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
    }
    
    [data-theme="dark"] .dropdown-menu::before {
        background: linear-gradient(135deg, 
            var(--theme-dropdown-bg, #3a3636) 0%, 
            rgba(58, 54, 54, 0.98) 100%);
        border-color: rgba(255, 173, 81, 0.3);
    }
    
    .dropdown-menu.show {
        display: block !important;
    }
    
    .dropdown-item {
        color: var(--body-text);
        padding: 0.875rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        background: none;
        width: calc(100% - 1rem);
        text-align: left;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        white-space: nowrap;
        border-radius: 8px;
        margin: 0.125rem 0.5rem;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        font-size: 0.95rem;
    }
    
    /* Subtle gradient effect on hover */
    .dropdown-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.1) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        transition: left 0.3s ease;
        z-index: -1;
    }
    
    .dropdown-item:hover::before {
        left: 0;
    }
    
    [data-theme="dark"] .dropdown-item {
        color: var(--theme-text-primary, #ffffff);
    }
    
    .dropdown-item:hover,
    .dropdown-item.active {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.12) 0%, 
            rgba(255, 173, 81, 0.08) 100%);
        color: var(--heading-color);
        transform: translateX(2px);
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.15);
    }
    
    [data-theme="dark"] .dropdown-item:hover,
    [data-theme="dark"] .dropdown-item.active {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.2) 0%, 
            rgba(255, 173, 81, 0.15) 100%);
        color: var(--heading-color);
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.25);
    }
    
    .dropdown-item:focus {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.15) 0%, 
            rgba(255, 173, 81, 0.1) 100%);
        color: var(--heading-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 173, 81, 0.3);
    }
    
    /* Active state enhancement */
    .dropdown-item.active {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        color: white !important;
        font-weight: 600;
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(255, 173, 81, 0.3);
    }
    
    /* Language flag/icon placeholder */
    .dropdown-item i {
        width: 18px;
        margin-right: 0;
        opacity: 0.7;
        transition: all 0.3s ease;
        font-size: 1rem;
    }
    
    .dropdown-item:hover i {
        opacity: 1;
        transform: scale(1.1);
    }
    
    /* Card Styling */
    .card {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 50%, 
            var(--white) 100%);
        border: 1px solid rgba(255, 173, 81, 0.1);
        border-radius: 20px;
        box-shadow: var(--card-shadow);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    [data-theme="dark"] .card {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(47, 43, 43, 0.98) 50%, 
            var(--white) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-hover-shadow);
    }
    
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        border-radius: 20px 20px 0 0;
    }
    
    .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(255, 173, 81, 0.1);
        padding: 1.5rem 2rem;
        position: relative;
    }
    
    .card-header h3 {
        font-weight: 700;
        font-size: 1.4rem;
        color: var(--black);
        margin: 0;
        letter-spacing: -0.01em;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-header h3::before {
        content: '';
        width: 4px;
        height: 24px;
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        border-radius: 2px;
    }
    
    .card-header .text-muted {
        color: var(--body-text);
        font-size: 0.95rem;
        font-weight: 500;
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
    }
    
    .card-body {
        padding: 2rem;
    }
    
    /* Form Controls */
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
    
    .form-control {
        padding: 1rem 1.25rem;
        border: 2px solid rgba(255, 173, 81, 0.15);
        border-radius: var(--border-radius);
        font-size: 1rem;
        font-weight: 500;
        color: var(--black);
        background: var(--white);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.04),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    /* Dark mode form control styling */
    [data-theme="dark"] .form-control {
        background: var(--theme-bg-secondary, #3a3636);
        color: var(--theme-text-primary, #ffffff);
        border-color: rgba(255, 173, 81, 0.3);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.05);
    }
    
    .form-control:focus {
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 4px 20px rgba(255, 173, 81, 0.1);
        transform: translateY(-1px);
        outline: none;
    }
    
    [data-theme="dark"] .form-control:focus {
        background: var(--theme-bg-secondary, #3a3636);
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
        background: var(--theme-bg-secondary, #3a3636);
    }
    
    .form-control[readonly] {
        background: rgba(255, 173, 81, 0.05);
        border-color: rgba(255, 173, 81, 0.2);
        cursor: not-allowed;
    }
    
    [data-theme="dark"] .form-control[readonly] {
        background: rgba(255, 173, 81, 0.1);
        border-color: rgba(255, 173, 81, 0.3);
        color: var(--theme-text-secondary, #adb5bd);
    }
    
    /* Placeholder styling for dark mode */
    .form-control::placeholder {
        color: var(--body-text);
        opacity: 0.7;
    }
    
    [data-theme="dark"] .form-control::placeholder {
        color: var(--theme-text-secondary, #adb5bd);
        opacity: 0.8;
    }
    
    /* Button Styling */
    .btn {
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(255, 173, 81, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #ff9a33 0%, #ffad51 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 173, 81, 0.4);
        color: white;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        border: none;
        color: white;
        font-size: 1.1rem;
        padding: 1rem 2rem;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #28a745 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    .btn-outline-secondary {
        border: 2px solid rgba(255, 173, 81, 0.3);
        color: var(--body-text);
        background: var(--white);
    }
    
    .btn-outline-secondary:hover {
        background: var(--heading-color);
        border-color: var(--heading-color);
        color: white;
        transform: translateY(-1px);
    }
    
    /* Custom back button styling */
    .back-button {
        background: linear-gradient(135deg, #FFAD51 0%, #ffb866 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.25rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 15px rgba(255, 173, 81, 0.3);
    }
    
    .back-button:hover {
        background: linear-gradient(135deg, #ff9a33 0%, #ffad51 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 173, 81, 0.4);
        text-decoration: none;
    }
    
    /* Textarea specific styling */
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }
    
    [data-theme="dark"] textarea.form-control {
        background: var(--theme-bg-secondary, #3a3636);
        color: var(--theme-text-primary, #ffffff);
    }
    
    /* Enhanced File Upload Styling */
    .enhanced-file-upload-container {
        position: relative;
        width: 100%;
    }
    
    .file-upload-zone {
        position: relative;
        border: 3px dashed rgba(255, 173, 81, 0.3);
        border-radius: 16px;
        padding: 3rem 2rem;
        text-align: center;
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.02) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        overflow: hidden;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
    }
    
    .file-upload-zone::before {
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
        z-index: 1;
    }
    
    .file-upload-zone:hover {
        border-color: rgba(255, 173, 81, 0.6);
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.08) 0%, 
            rgba(255, 173, 81, 0.12) 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(255, 173, 81, 0.15);
    }
    
    .file-upload-zone:hover::before {
        left: 100%;
    }
    
    .file-upload-zone.drag-over {
        border-color: var(--heading-color);
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.15) 0%, 
            rgba(255, 173, 81, 0.2) 100%);
        transform: scale(1.02);
        box-shadow: 0 16px 50px rgba(255, 173, 81, 0.25);
    }
    
    .upload-icon-container {
        position: relative;
        z-index: 2;
    }
    
    .upload-main-icon {
        font-size: 4rem;
        color: var(--heading-color);
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        filter: drop-shadow(0 4px 8px rgba(255, 173, 81, 0.3));
    }
    
    .file-upload-zone:hover .upload-main-icon {
        transform: scale(1.1) translateY(-4px);
        color: #ff9a33;
    }
    
    .upload-animation {
        position: absolute;
        top: -10px;
        right: -10px;
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .upload-arrow {
        font-size: 1.5rem;
        color: var(--heading-color);
        animation: bounce 2s infinite;
    }
    
    .file-upload-zone:hover .upload-animation {
        opacity: 1;
        transform: translateY(-5px);
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }
    
    .upload-text {
        z-index: 2;
        position: relative;
    }
    
    .upload-title {
        font-weight: 700;
        color: var(--black);
        margin: 0 0 0.5rem 0;
        font-size: 1.3rem;
    }
    
    .upload-subtitle {
        color: var(--body-text);
        margin: 0 0 0.75rem 0;
        font-size: 1rem;
    }
    
    .browse-link {
        color: var(--heading-color);
        font-weight: 600;
        text-decoration: underline;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    
    .browse-link:hover {
        color: #ff9a33;
    }
    
    .upload-hint {
        color: var(--body-text);
        opacity: 0.8;
        font-size: 0.85rem;
    }
    
    .hidden-file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 3;
    }
    
    /* Upload Progress */
    .upload-progress-container {
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 173, 81, 0.05);
        border-radius: 12px;
        border: 1px solid rgba(255, 173, 81, 0.2);
    }
    
    .progress-bar-wrapper {
        flex: 1;
        height: 8px;
        background: rgba(255, 173, 81, 0.2);
        border-radius: 4px;
        overflow: hidden;
        position: relative;
    }
    
    .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
        border-radius: 4px;
        width: 0%;
        transition: width 0.3s ease;
        position: relative;
    }
    
    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(255, 255, 255, 0.3) 50%, 
            transparent 100%);
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .progress-text {
        font-weight: 600;
        color: var(--heading-color);
        min-width: 40px;
        text-align: right;
    }
    
    /* Selected Files Grid */
    .selected-files-grid {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.02) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        border: 1px solid rgba(255, 173, 81, 0.15);
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }
    
    .grid-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 173, 81, 0.1);
    }
    
    .grid-title {
        color: var(--black);
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .grid-title i {
        color: var(--heading-color);
    }
    
    .file-count-badge {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    
    .clear-all-btn {
        border-color: #dc3545;
        color: #dc3545;
        transition: all 0.3s ease;
    }
    
    .clear-all-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    
    .files-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    /* File Card */
    .file-card {
        background: var(--white);
        border: 1px solid rgba(255, 173, 81, 0.1);
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 173, 81, 0.15);
        border-color: rgba(255, 173, 81, 0.3);
    }
    
    .file-preview {
        width: 100%;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 0.75rem;
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.1) 0%, 
            rgba(255, 173, 81, 0.05) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .file-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .file-icon {
        font-size: 2.5rem;
        color: var(--heading-color);
        opacity: 0.7;
    }
    
    .file-info {
        text-align: center;
    }
    
    .file-name {
        font-weight: 600;
        color: var(--black);
        font-size: 0.9rem;
        margin: 0 0 0.25rem 0;
        word-break: break-word;
        line-height: 1.3;
    }
    
    .file-size {
        color: var(--body-text);
        font-size: 0.8rem;
        margin: 0 0 0.75rem 0;
    }
    
    .file-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    
    .file-action-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        border: none;
        font-size: 0.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .remove-file-btn {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }
    
    .remove-file-btn:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
    }
    
    /* Dark Theme Support */
    [data-theme="dark"] .file-upload-zone {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.05) 0%, 
            rgba(255, 173, 81, 0.08) 100%);
        border-color: rgba(255, 173, 81, 0.4);
    }
    
    [data-theme="dark"] .file-upload-zone:hover {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.12) 0%, 
            rgba(255, 173, 81, 0.15) 100%);
        border-color: rgba(255, 173, 81, 0.7);
    }
    
    [data-theme="dark"] .upload-title {
        color: var(--theme-text-primary, #ffffff);
    }
    
    [data-theme="dark"] .selected-files-grid {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.05) 0%, 
            rgba(255, 173, 81, 0.08) 100%);
        border-color: rgba(255, 173, 81, 0.3);
    }
    
    [data-theme="dark"] .file-card {
        background: var(--theme-card-bg, #2f2b2b);
        border-color: rgba(255, 173, 81, 0.2);
    }
    
    [data-theme="dark"] .file-name {
        color: var(--theme-text-primary, #ffffff);
    }
    
    [data-theme="dark"] .file-preview {
        background: linear-gradient(135deg, 
            rgba(255, 173, 81, 0.15) 0%, 
            rgba(255, 173, 81, 0.1) 100%);
    }
    
    /* Responsive Design for File Upload */
    @media (max-width: 768px) {
        .file-upload-zone {
            padding: 2rem 1rem;
            min-height: 160px;
        }
        
        .upload-main-icon {
            font-size: 3rem;
        }
        
        .upload-title {
            font-size: 1.1rem;
        }
        
        .files-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.75rem;
        }
        
        .file-card {
            padding: 0.75rem;
        }
        
        .file-preview {
            height: 100px;
        }
    }
    
    /* Form text helper styling */
    .form-text {
        color: var(--body-text);
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    [data-theme="dark"] .form-text {
        color: var(--theme-text-secondary, #adb5bd);
    }
    
    /* Weather Type Checkboxes */
    .form-check {
        background: var(--white);
        border: 2px solid rgba(255, 173, 81, 0.1);
        border-radius: var(--border-radius);
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    /* Enhanced Weather Item Styling with Background Images */
    .weather-item {
        position: relative;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        text-align: center;
        padding: 1.5rem 1rem;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        overflow: hidden;
    }
    
    /* Create overlay for better text readability */
    .weather-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.1) 0%,
            rgba(0, 0, 0, 0.3) 60%,
            rgba(0, 0, 0, 0.7) 100%
        );
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
    }
    
    .weather-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
    }
    
    /* Hide the individual weather images since we're using background images */
    .weather-image {
        display: none !important;
        position: absolute !important;
        visibility: hidden !important;
        opacity: 0 !important;
        z-index: -1 !important;
    }
    
    /* Ensure weather images are completely hidden in dark mode */
    [data-theme="dark"] .weather-image {
        display: none !important;
        position: absolute !important;
        visibility: hidden !important;
        opacity: 0 !important;
        z-index: -1 !important;
    }
    
    .weather-item .form-check-input {
        position: absolute;
        top: 2rem;
        left: 2rem;
        width: 1.2rem;
        height: 1.2rem;
        z-index: 3;
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid rgba(255, 173, 81, 0.8);
        border-radius: 4px;
        box-shadow: 
            0 2px 6px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.8);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .weather-item .form-check-input:hover {
        background: rgba(255, 255, 255, 1);
        border-color: var(--heading-color);
        box-shadow: 
            0 3px 8px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 173, 81, 0.4);
        transform: none;
    }
    
    .weather-item .form-check-label {
        font-weight: 700;
        color: white;
        margin: 0;
        cursor: pointer;
        text-align: center;
        font-size: 0.95rem;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7);
        position: relative;
        z-index: 2;
    }
    
    /* Individual weather type background images */
    .weather-item:has(#weather_rain) {
        background-image: url('{{ asset("images/rain.jpg") }}');
    }
    
    .weather-item:has(#weather_drizzle) {
        background-image: url('{{ asset("images/drizzle.jpg") }}');
    }
    
    .weather-item:has(#weather_thunder) {
        background-image: url('{{ asset("images/thunder.jpg") }}');
    }
    
    .weather-item:has(#weather_hail) {
        background-image: url('{{ asset("images/hail.jpg") }}');
    }
    
    .weather-item:has(#weather_duststorm) {
        background-image: url('{{ asset("images/duststorm.webp") }}');
    }
    
    .weather-item:has(#weather_fog) {
        background-image: url('{{ asset("images/fog.jpg") }}');
    }
    
    .weather-item:has(#weather_snow) {
        background-image: url('{{ asset("images/snow.jpg") }}');
    }
    
    .weather-item:has(#weather_gusty_wind) {
        background-image: url('{{ asset("images/wind.webp") }}');
    }
    
    .weather-item:has(#weather_smog) {
        background-image: url('{{ asset("images/smog.jpg") }}');
    }
    
    [data-theme="dark"] .form-check {
        background: var(--theme-bg-secondary, #3a3636);
        border-color: rgba(255, 173, 81, 0.2);
    }
    
    /* Dark mode support for weather items */
    [data-theme="dark"] .weather-item {
        border-color: rgba(255, 173, 81, 0.3);
    }
    
    /* Ensure weather content positioning is consistent in dark mode */
    [data-theme="dark"] .weather-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        width: 100%;
    }
    
    [data-theme="dark"] .weather-item::before {
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.2) 0%,
            rgba(0, 0, 0, 0.5) 60%,
            rgba(0, 0, 0, 0.8) 100%
        );
    }
    
    /* Ensure background images are visible in dark mode */
    [data-theme="dark"] .weather-item {
        background-attachment: scroll;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    [data-theme="dark"] .weather-item:hover {
        box-shadow: 0 8px 25px rgba(255, 173, 81, 0.4);
        border-color: rgba(255, 173, 81, 0.6);
    }
    
    [data-theme="dark"] .weather-item:hover::before {
        background: linear-gradient(
            to bottom,
            rgba(255, 173, 81, 0.15) 0%,
            rgba(255, 173, 81, 0.25) 60%,
            rgba(0, 0, 0, 0.7) 100%
        );
    }
    
    [data-theme="dark"] .weather-item .form-check-input {
        background: rgba(255, 255, 255, 0.98);
        border-color: rgba(255, 173, 81, 0.9);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.9);
    }
    
    [data-theme="dark"] .weather-item .form-check-input:hover {
        background: rgba(255, 255, 255, 1);
        box-shadow: 
            0 3px 10px rgba(0, 0, 0, 0.6),
            0 0 0 1px rgba(255, 173, 81, 0.5);
    }
    
    .form-check:hover {
        border-color: rgba(255, 173, 81, 0.3);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 173, 81, 0.1);
    }
    
    [data-theme="dark"] .form-check:hover {
        border-color: rgba(255, 173, 81, 0.4);
        box-shadow: 0 4px 12px rgba(255, 173, 81, 0.2);
    }
    
    /* Enhanced hover effects for weather items */
    .weather-item:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(255, 173, 81, 0.3);
        border-color: rgba(255, 173, 81, 0.5);
    }
    
    .weather-item:hover::before {
        background: linear-gradient(
            to bottom,
            rgba(255, 173, 81, 0.1) 0%,
            rgba(255, 173, 81, 0.2) 60%,
            rgba(0, 0, 0, 0.6) 100%
        );
    }
    
    .form-check-input:checked + .form-check-label,
    .form-check-input:checked ~ .form-check-label {
        color: var(--heading-color);
        font-weight: 600;
    }
    
    .form-check:has(.form-check-input:checked) {
        border-color: var(--heading-color);
        background: rgba(255, 173, 81, 0.05);
        box-shadow: 0 4px 15px rgba(255, 173, 81, 0.2);
    }
    
    [data-theme="dark"] .form-check:has(.form-check-input:checked) {
        background: rgba(255, 173, 81, 0.1);
        box-shadow: 0 4px 15px rgba(255, 173, 81, 0.3);
    }
    
    /* Enhanced selected state for weather items */
    .weather-item:has(.form-check-input:checked) {
        border-color: var(--heading-color);
        box-shadow: 0 8px 30px rgba(255, 173, 81, 0.4);
        transform: translateY(-4px) scale(1.03);
        border-width: 3px;
    }
    
    .weather-item:has(.form-check-input:checked)::before {
        background: linear-gradient(
            to bottom,
            rgba(255, 173, 81, 0.2) 0%,
            rgba(255, 173, 81, 0.3) 60%,
            rgba(255, 173, 81, 0.1) 100%
        );
    }
    
    .weather-item:has(.form-check-input:checked) .form-check-label {
        color: white;
        font-weight: 800;
        text-shadow: 0 2px 8px rgba(255, 173, 81, 0.8);
        font-size: 1rem;
    }
    
    .weather-item:has(.form-check-input:checked) .form-check-input {
        background: var(--heading-color);
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 1px rgba(255, 173, 81, 0.4),
            0 0 0 3px rgba(255, 255, 255, 0.9),
            0 3px 10px rgba(255, 173, 81, 0.6);
        transform: none;
    }
    
    /* Add checkmark symbol for checked state */
    .weather-item:has(.form-check-input:checked) .form-check-input::after {
        content: "✓";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: 900;
        font-size: 0.75rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    [data-theme="dark"] .weather-item:has(.form-check-input:checked) {
        box-shadow: 0 8px 30px rgba(255, 173, 81, 0.5);
    }
    
    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
        border: 2px solid rgba(255, 173, 81, 0.8);
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.95);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-right: 0.75rem;
        box-shadow: 
            0 2px 6px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.8);
        position: relative;
    }
    
    .form-check-input:hover {
        background: rgba(255, 255, 255, 1);
        border-color: var(--heading-color);
        box-shadow: 
            0 3px 8px rgba(0, 0, 0, 0.4),
            0 0 0 1px rgba(255, 173, 81, 0.4);
    }
    
    [data-theme="dark"] .form-check-input {
        background: rgba(255, 255, 255, 0.98);
        border-color: rgba(255, 173, 81, 0.9);
        box-shadow: 
            0 2px 8px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.9);
    }
    
    [data-theme="dark"] .form-check-input:hover {
        background: rgba(255, 255, 255, 1);
        box-shadow: 
            0 3px 10px rgba(0, 0, 0, 0.6),
            0 0 0 1px rgba(255, 173, 81, 0.5);
    }
    
    .form-check-input:checked {
        background-color: var(--heading-color);
        border-color: var(--heading-color);
        box-shadow: 
            0 0 0 1px rgba(255, 173, 81, 0.4),
            0 0 0 3px rgba(255, 255, 255, 0.9),
            0 3px 10px rgba(255, 173, 81, 0.6);
    }
    
    /* Add checkmark symbol for checked state */
    .form-check-input:checked::after {
        content: "✓";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: 900;
        font-size: 0.75rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }
    
    .form-check-input:focus {
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.15),
            0 2px 6px rgba(0, 0, 0, 0.3),
            0 0 0 1px rgba(255, 255, 255, 0.8);
    }
    
    [data-theme="dark"] .form-check-input:focus {
        box-shadow: 
            0 0 0 3px rgba(255, 173, 81, 0.25),
            0 2px 8px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.9);
    }
    
    .form-check-label {
        color: var(--body-text);
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    [data-theme="dark"] .form-check-label {
        color: var(--theme-text-primary, #ffffff);
    }
    
    /* Map Container */
    .map-container {
        position: relative;
        width: 100%;
        height: auto;
        min-height: 400px;
        display: flex;
        flex-direction: column;
    }
    
    #locationMap {
        width: 100%;
        height: 400px;
        min-height: 350px;
        flex: 1;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 173, 81, 0.1);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    #locationMap:hover {
        box-shadow: var(--card-hover-shadow);
        border-color: rgba(255, 173, 81, 0.2);
    }
    
    [data-theme="dark"] #locationMap {
        border-color: rgba(255, 173, 81, 0.2);
        box-shadow: var(--card-shadow);
    }
    
    [data-theme="dark"] #locationMap:hover {
        box-shadow: var(--card-hover-shadow);
        border-color: rgba(255, 173, 81, 0.3);
    }
    
    /* Responsive map sizing */
    @media (min-width: 768px) {
        .map-container {
            min-height: 400px;
        }
        
        #locationMap {
            height: 420px;
            min-height: 380px;
        }
    }
    
    @media (min-width: 992px) {
        .map-container {
            min-height: 420px;
        }
        
        #locationMap {
            height: 440px;
            min-height: 400px;
        }
    }
    
    @media (min-width: 1200px) {
        .map-container {
            min-height: 440px;
        }
        
        #locationMap {
            height: 450px;
            min-height: 410px;
        }
    }
    
    @media (max-width: 767px) {
        .map-container {
            min-height: 300px;
            margin-top: 1rem;
        }
        
        #locationMap {
            min-height: 300px;
        }
    }
    
    @media (max-width: 576px) {
        .map-container {
            min-height: 250px;
        }
        
        #locationMap {
            min-height: 250px;
        }
    }
    
    /* Error Styling */
    .text-danger {
        color: #dc3545;
        font-weight: 500;
        padding: 0.75rem 1rem;
        background: rgba(220, 53, 69, 0.1);
        border-radius: var(--border-radius);
        border-left: 4px solid #dc3545;
    }
    
    [data-theme="dark"] .text-danger {
        color: #ff6b7a;
        background: rgba(220, 53, 69, 0.2);
    }
    
    /* Location status text */
    #locationStatus {
        color: var(--body-text);
        font-weight: 500;
        padding: 0.5rem 0;
    }
    
    [data-theme="dark"] #locationStatus {
        color: var(--theme-text-secondary, #adb5bd);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .page-header h1 {
            font-size: 2rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
        }
        
        .btn {
            padding: 0.875rem 1.25rem;
        }
        
        .form-control {
            padding: 0.875rem 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .page-header {
            padding: 1rem;
        }
        
        .page-header h1 {
            font-size: 1.75rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .card-header {
            padding: 1rem;
        }
        
        .form-check {
            padding: 0.75rem;
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
    
    /* Card-based Alert System */
    .card-alert {
        position: relative;
        margin-bottom: 1rem;
        padding: 1rem 1.25rem;
        border: 1px solid;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 500;
        display: none !important;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        z-index: 1000;
        width: 100%;
        box-sizing: border-box;
    }
    
    .card-alert.show {
        display: block !important;
        opacity: 1 !important;
        transform: translateY(0) !important;
        visibility: visible !important;
        animation: alertSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    @keyframes alertSlideIn {
        0% {
            opacity: 0;
            transform: translateY(-15px) scale(0.95);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    
    .card-alert.hide {
        opacity: 0;
        transform: translateY(-10px) scale(0.95);
        transition: all 0.3s ease-out;
    }
    
    /* Alert types */
    .card-alert.alert-danger {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            rgba(220, 53, 69, 0.05) 100%);
        border-color: rgba(220, 53, 69, 0.3);
        color: #721c24;
        box-shadow: 
            0 4px 15px rgba(220, 53, 69, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .card-alert.alert-warning {
        background: linear-gradient(135deg, 
            rgba(255, 193, 7, 0.1) 0%, 
            rgba(255, 193, 7, 0.05) 100%);
        border-color: rgba(255, 193, 7, 0.3);
        color: #664d03;
        box-shadow: 
            0 4px 15px rgba(255, 193, 7, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .card-alert.alert-success {
        background: linear-gradient(135deg, 
            rgba(25, 135, 84, 0.1) 0%, 
            rgba(25, 135, 84, 0.05) 100%);
        border-color: rgba(25, 135, 84, 0.3);
        color: #0f5132;
        box-shadow: 
            0 4px 15px rgba(25, 135, 84, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    .card-alert.alert-info {
        background: linear-gradient(135deg, 
            rgba(13, 202, 240, 0.1) 0%, 
            rgba(13, 202, 240, 0.05) 100%);
        border-color: rgba(13, 202, 240, 0.3);
        color: #055160;
        box-shadow: 
            0 4px 15px rgba(13, 202, 240, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    /* Alert icons */
    .card-alert-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        margin-right: 0.5rem;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .alert-danger .card-alert-icon {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    .alert-warning .card-alert-icon {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }
    
    .alert-success .card-alert-icon {
        background: rgba(25, 135, 84, 0.2);
        color: #198754;
    }
    
    .alert-info .card-alert-icon {
        background: rgba(13, 202, 240, 0.2);
        color: #0dcaf0;
    }
    
    /* Alert content */
    .card-alert-content {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .card-alert-text {
        flex: 1;
        line-height: 1.4;
    }
    
    .card-alert-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }
    
    .card-alert-message {
        margin: 0;
        opacity: 0.9;
    }
    
    .card-alert-list {
        margin: 0.5rem 0 0 1.5rem;
        padding: 0;
        list-style: none;
    }
    
    .card-alert-list li {
        position: relative;
        padding-left: 1rem;
        margin-bottom: 0.25rem;
        opacity: 0.85;
    }
    
    .card-alert-list li::before {
        content: "•";
        position: absolute;
        left: 0;
        color: currentColor;
        font-weight: 700;
    }
    
    /* Alert close button */
    .card-alert-close {
        background: none;
        border: none;
        color: currentColor;
        opacity: 0.5;
        padding: 0;
        margin-left: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    
    .card-alert-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
    }
    
    .card-alert-close:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.1);
    }
    
    /* Dark theme support for alerts */
    [data-theme="dark"] .card-alert.alert-danger {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.2) 0%, 
            rgba(220, 53, 69, 0.1) 100%);
        border-color: rgba(220, 53, 69, 0.4);
        color: #f5c2c7;
    }
    
    [data-theme="dark"] .card-alert.alert-warning {
        background: linear-gradient(135deg, 
            rgba(255, 193, 7, 0.2) 0%, 
            rgba(255, 193, 7, 0.1) 100%);
        border-color: rgba(255, 193, 7, 0.4);
        color: #ffecb5;
    }
    
    [data-theme="dark"] .card-alert.alert-success {
        background: linear-gradient(135deg, 
            rgba(25, 135, 84, 0.2) 0%, 
            rgba(25, 135, 84, 0.1) 100%);
        border-color: rgba(25, 135, 84, 0.4);
        color: #a3d9a5;
    }
    
    [data-theme="dark"] .card-alert.alert-info {
        background: linear-gradient(135deg, 
            rgba(13, 202, 240, 0.2) 0%, 
            rgba(13, 202, 240, 0.1) 100%);
        border-color: rgba(13, 202, 240, 0.4);
        color: #9eeaf9;
    }
    
    [data-theme="dark"] .alert-danger .card-alert-icon {
        background: rgba(220, 53, 69, 0.3);
        color: #ea868f;
    }
    
    [data-theme="dark"] .alert-warning .card-alert-icon {
        background: rgba(255, 193, 7, 0.3);
        color: #ffe69c;
    }
    
    [data-theme="dark"] .alert-success .card-alert-icon {
        background: rgba(25, 135, 84, 0.3);
        color: #75b798;
    }
    
    [data-theme="dark"] .alert-info .card-alert-icon {
        background: rgba(13, 202, 240, 0.3);
        color: #6edff6;
    }
    
    [data-theme="dark"] .card-alert-close:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    /* RTL support for alerts */
    html[dir="rtl"] .card-alert,
    .rtl-active .card-alert {
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .card-alert-content,
    .rtl-active .card-alert-content {
        flex-direction: row-reverse !important;
    }
    
    html[dir="rtl"] .card-alert-icon,
    .rtl-active .card-alert-icon {
        margin-right: 0 !important;
        margin-left: 0.5rem !important;
    }
    
    html[dir="rtl"] .card-alert-close,
    .rtl-active .card-alert-close {
        margin-left: 0 !important;
        margin-right: 0.5rem !important;
    }
    
    html[dir="rtl"] .card-alert-list,
    .rtl-active .card-alert-list {
        margin-left: 0 !important;
        margin-right: 1.5rem !important;
    }
    
    html[dir="rtl"] .card-alert-list li,
    .rtl-active .card-alert-list li {
        padding-left: 0 !important;
        padding-right: 1rem !important;
    }
    
    html[dir="rtl"] .card-alert-list li::before,
    .rtl-active .card-alert-list li::before {
        left: auto !important;
        right: 0 !important;
    }
    
    /* Field error highlighting */
    .field-error {
        border-color: #dc3545 !important;
        box-shadow: 
            0 0 0 2px rgba(220, 53, 69, 0.15) !important,
            0 2px 8px rgba(220, 53, 69, 0.1) !important;
    }
    
    [data-theme="dark"] .field-error {
        border-color: #ea868f !important;
        box-shadow: 
            0 0 0 2px rgba(220, 53, 69, 0.25) !important,
            0 2px 8px rgba(220, 53, 69, 0.2) !important;
    }
    
    .field-error:focus {
        border-color: #dc3545 !important;
        box-shadow: 
            0 0 0 3px rgba(220, 53, 69, 0.25) !important,
            0 4px 20px rgba(220, 53, 69, 0.15) !important;
    }
    
    [data-theme="dark"] .field-error:focus {
        box-shadow: 
            0 0 0 3px rgba(220, 53, 69, 0.35) !important,
            0 4px 20px rgba(220, 53, 69, 0.25) !important;
    }
    
    /* Enhanced form validation states */
    .form-control.is-valid {
        border-color: #198754;
        box-shadow: 
            0 0 0 2px rgba(25, 135, 84, 0.15),
            0 2px 8px rgba(25, 135, 84, 0.1);
    }
    
    .form-control.is-valid:focus {
        border-color: #198754;
        box-shadow: 
            0 0 0 3px rgba(25, 135, 84, 0.25),
            0 4px 20px rgba(25, 135, 84, 0.15);
    }
    
    [data-theme="dark"] .form-control.is-valid {
        border-color: #75b798;
        box-shadow: 
            0 0 0 2px rgba(25, 135, 84, 0.25),
            0 2px 8px rgba(25, 135, 84, 0.2);
    }
    
    [data-theme="dark"] .form-control.is-valid:focus {
        box-shadow: 
            0 0 0 3px rgba(25, 135, 84, 0.35),
            0 4px 20px rgba(25, 135, 84, 0.25);
    }
    
    /* Shake animation for validation errors */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .shake {
        animation: shake 0.4s ease-in-out;
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
    
    /* RTL Language Support - Comprehensive Implementation */
    html[dir="rtl"],
    .rtl-active {
        direction: rtl !important;
        text-align: right !important;
    }
    
    /* Global RTL reset for all text elements with maximum specificity */
    html[dir="rtl"] *:not(.navbar):not(.navbar *):not(.mapboxgl-canvas):not(.mapboxgl-canvas *),
    .rtl-active *:not(.navbar):not(.navbar *):not(.mapboxgl-canvas):not(.mapboxgl-canvas *) {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Exclude navbar completely from RTL styling */
    html[dir="rtl"] .navbar,
    html[dir="rtl"] .navbar *,
    .rtl-active .navbar,
    .rtl-active .navbar *,
    .rtl-active .navbar .container,
    .rtl-active .navbar .container-fluid {
        direction: ltr !important;
        text-align: left !important;
    }
    
    .rtl-active .navbar .navbar-nav {
        flex-direction: row !important;
    }
    
    .rtl-active .navbar .nav-link,
    .rtl-active .navbar .navbar-brand {
        text-align: left !important;
    }
    
    /* Container and layout RTL */
    html[dir="rtl"] .container:not(.navbar .container),
    .rtl-active .container:not(.navbar .container) {
        direction: rtl !important;
        text-align: right !important;
    }
    
    /* Page header RTL - strongest specificity */
    html[dir="rtl"] .page-header,
    html[dir="rtl"] .page-header *,
    body.rtl-active .page-header,
    body.rtl-active .page-header * {
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .page-header h1,
    body.rtl-active .page-header h1 {
        text-align: right !important;
        direction: rtl !important;
        justify-content: flex-end !important;
    }
    
    html[dir="rtl"] .page-header .d-flex,
    body.rtl-active .page-header .d-flex {
        flex-direction: row-reverse !important;
        justify-content: space-between !important;
    }
    
    /* Card headers with maximum specificity */
    html[dir="rtl"] .card-header,
    html[dir="rtl"] .card-header *,
    body.rtl-active .card-header,
    body.rtl-active .card-header * {
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .card-header h3,
    body.rtl-active .card-header h3 {
        flex-direction: row-reverse !important;
        text-align: right !important;
        justify-content: flex-end !important;
        direction: rtl !important;
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.75rem !important;
    }
    
    html[dir="rtl"] .card-header h3::before,
    body.rtl-active .card-header h3::before {
        order: 1 !important;
        margin-left: 0 !important;
        margin-right: 0.75rem !important;
    }
    
    /* Card body content RTL - missing critical styling */
    html[dir="rtl"] .card-body,
    html[dir="rtl"] .card-body *,
    body.rtl-active .card-body,
    body.rtl-active .card-body * {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Form labels with highest specificity */
    html[dir="rtl"] .form-label,
    body.rtl-active .form-label {
        flex-direction: row-reverse !important;
        text-align: right !important;
        direction: rtl !important;
        justify-content: flex-end !important;
    }
    
    html[dir="rtl"] .form-label i,
    body.rtl-active .form-label i {
        order: 2 !important;
        margin-left: 0.5rem !important;
        margin-right: 0 !important;
    }
    
    /* Form controls with comprehensive RTL */
    html[dir="rtl"] .form-control,
    html[dir="rtl"] textarea.form-control,
    html[dir="rtl"] input.form-control,
    body.rtl-active .form-control,
    body.rtl-active textarea.form-control,
    body.rtl-active input.form-control {
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .form-control::placeholder,
    body.rtl-active .form-control::placeholder {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Form check elements */
    html[dir="rtl"] .form-check,
    body.rtl-active .form-check {
        direction: rtl !important;
        text-align: right !important;
    }
    
    html[dir="rtl"] .form-check-label,
    body.rtl-active .form-check-label {
        flex-direction: row-reverse !important;
        padding-right: 0 !important;
        padding-left: 1.25rem !important;
        text-align: right !important;
        direction: rtl !important;
        justify-content: flex-end !important;
    }
    
    html[dir="rtl"] .form-check-input,
    body.rtl-active .form-check-input {
        float: right !important;
        margin-left: 0.75rem !important;
        margin-right: 0 !important;
    }
    
    /* Weather items RTL */
    html[dir="rtl"] .weather-item .form-check-input,
    body.rtl-active .weather-item .form-check-input {
        left: auto !important;
        right: 2rem !important;
    }
    
    html[dir="rtl"] .weather-content,
    body.rtl-active .weather-content {
        direction: rtl !important;
        text-align: center !important;
    }
    
    html[dir="rtl"] .weather-item .form-check-label,
    body.rtl-active .weather-item .form-check-label {
        text-align: center !important;
        direction: rtl !important;
    }
    
    /* Buttons RTL */
    html[dir="rtl"] .btn,
    body.rtl-active .btn {
        flex-direction: row-reverse !important;
        text-align: center !important;
    }
    
    html[dir="rtl"] .btn i,
    body.rtl-active .btn i {
        order: 2 !important;
        margin-left: 0.5rem !important;
        margin-right: 0 !important;
    }
    
    /* Language dropdown RTL */
    html[dir="rtl"] .language-dropdown,
    body.rtl-active .language-dropdown {
        flex-direction: row-reverse !important;
    }
    
    html[dir="rtl"] .language-dropdown i,
    body.rtl-active .language-dropdown i {
        order: 2 !important;
        margin-left: 0.5rem !important;
        margin-right: 0 !important;
    }
    
    /* Dropdown menu RTL */
    html[dir="rtl"] .dropdown-menu,
    body.rtl-active .dropdown-menu {
        right: 0 !important;
        left: auto !important;
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .dropdown-item,
    body.rtl-active .dropdown-item {
        text-align: right !important;
        padding-right: 1.25rem !important;
        padding-left: 1rem !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .dropdown-item:hover,
    html[dir="rtl"] .dropdown-item.active,
    body.rtl-active .dropdown-item:hover,
    body.rtl-active .dropdown-item.active {
        transform: translateX(-2px) !important;
    }
    
    html[dir="rtl"] .dropdown-item.active,
    body.rtl-active .dropdown-item.active {
        transform: translateX(-4px) !important;
    }
    
    /* Error and status messages RTL */
    html[dir="rtl"] .text-danger,
    body.rtl-active .text-danger {
        text-align: right !important;
        border-right: 4px solid #dc3545 !important;
        border-left: none !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] #locationStatus,
    body.rtl-active #locationStatus {
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .form-text,
    body.rtl-active .form-text {
        text-align: right !important;
        direction: rtl !important;
    }
    
    html[dir="rtl"] .card-header .text-muted,
    body.rtl-active .card-header .text-muted {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Row and column RTL adjustments */
    html[dir="rtl"] .row,
    body.rtl-active .row {
        direction: rtl !important;
    }
    
    html[dir="rtl"] .col-md-4,
    html[dir="rtl"] .col-md-6,
    html[dir="rtl"] .col-md-3,
    html[dir="rtl"] .col-md-12,
    body.rtl-active .col-md-4,
    body.rtl-active .col-md-6,
    body.rtl-active .col-md-3,
    body.rtl-active .col-md-12 {
        direction: rtl !important;
        text-align: right !important;
    }
    
    /* Button alignment RTL - Move submit button to left in Urdu mode */
    html[dir="rtl"] .d-grid.gap-2.d-md-flex.justify-content-md-end,
    body.rtl-active .d-grid.gap-2.d-md-flex.justify-content-md-end {
        justify-content: flex-start !important;
        direction: rtl !important;
    }
    
    /* Ensure submit button container is left-aligned in RTL */
    html[dir="rtl"] .d-grid.gap-2.d-md-flex,
    body.rtl-active .d-grid.gap-2.d-md-flex {
        justify-content: flex-start !important;
        text-align: left !important;
    }
    
    /* Submit button specific RTL positioning */
    html[dir="rtl"] .btn-success,
    body.rtl-active .btn-success {
        margin-left: 0 !important;
        margin-right: auto !important;
    }
    
    /* Bootstrap override for specific elements */
    html[dir="rtl"] .mb-3,
    html[dir="rtl"] .mb-2,
    html[dir="rtl"] .mb-4,
    body.rtl-active .mb-3,
    body.rtl-active .mb-2,
    body.rtl-active .mb-4 {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* File input RTL */
    html[dir="rtl"] input[type="file"].form-control,
    body.rtl-active input[type="file"].form-control {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Date and time inputs RTL */
    html[dir="rtl"] input[type="date"].form-control,
    html[dir="rtl"] input[type="time"].form-control,
    html[dir="rtl"] input[type="email"].form-control,
    html[dir="rtl"] input[type="tel"].form-control,
    html[dir="rtl"] input[type="text"].form-control,
    body.rtl-active input[type="date"].form-control,
    body.rtl-active input[type="time"].form-control,
    body.rtl-active input[type="email"].form-control,
    body.rtl-active input[type="tel"].form-control,
    body.rtl-active input[type="text"].form-control {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Ensure all paragraphs and text elements are RTL */
    html[dir="rtl"] p,
    html[dir="rtl"] span,
    html[dir="rtl"] div:not(.navbar):not(.navbar *):not(.mapboxgl-canvas):not(.mapboxgl-canvas *),
    html[dir="rtl"] label,
    html[dir="rtl"] h1, html[dir="rtl"] h2, html[dir="rtl"] h3, html[dir="rtl"] h4, html[dir="rtl"] h5, html[dir="rtl"] h6,
    body.rtl-active p,
    body.rtl-active span,
    body.rtl-active div:not(.navbar):not(.navbar *):not(.mapboxgl-canvas):not(.mapboxgl-canvas *),
    body.rtl-active label,
    body.rtl-active h1, body.rtl-active h2, body.rtl-active h3, body.rtl-active h4, body.rtl-active h5, body.rtl-active h6 {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Override Bootstrap's text utilities for RTL */
    html[dir="rtl"] .text-left,
    html[dir="rtl"] .text-start,
    body.rtl-active .text-left,
    body.rtl-active .text-start {
        text-align: right !important;
    }
    
    html[dir="rtl"] .text-right,
    html[dir="rtl"] .text-end,
    body.rtl-active .text-right,
    body.rtl-active .text-end {
        text-align: left !important;
    }
    
    /* Force all remaining text elements to be RTL */
    html[dir="rtl"] *:not(.navbar):not(.navbar *):not(.mapboxgl-canvas):not(.mapboxgl-canvas *):not(script):not(style),
    body.rtl-active *:not(.navbar):not(.navbar *):not(.mapboxgl-canvas):not(.mapboxgl-canvas *):not(script):not(style) {
        text-align: inherit !important;
        direction: inherit !important;
    }
    
    /* RTL adjustments for responsive design */
    @media (max-width: 768px) {
        html[dir="rtl"] .page-header .d-flex,
        body.rtl-active .page-header .d-flex {
            flex-direction: column !important;
            align-items: flex-end !important;
        }
        
        html[dir="rtl"] .dropdown,
        body.rtl-active .dropdown {
            align-self: flex-end !important;
            margin-bottom: 1rem !important;
        }
    }

    /* Animation for form sections */
    .card {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease-out forwards;
    }
    
    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }
    .card:nth-child(5) { animation-delay: 0.5s; }
    .card:nth-child(6) { animation-delay: 0.6s; }
    .card:nth-child(7) { animation-delay: 0.7s; }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Loading animation for buttons */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }
    
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid white;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

<script>
    // Replace navbar navigation items with back button
    document.addEventListener('DOMContentLoaded', function() {
        const navbarNav = document.querySelector('#navbarNav .navbar-nav');
        if (navbarNav) {
            // Keep the theme toggle (first item) and replace everything else
            const themeToggleItem = navbarNav.querySelector('li:first-child');
            
            // Clear all nav items except theme toggle
            navbarNav.innerHTML = '';
            
            // Add back the theme toggle
            if (themeToggleItem) {
                navbarNav.appendChild(themeToggleItem);
            }
            
            // Add back button
            const backButtonItem = document.createElement('li');
            backButtonItem.className = 'nav-item';
            backButtonItem.innerHTML = '<a href="{{ route("welcome") }}" class="back-button"><i class="bi bi-arrow-left"></i> Back to Home</a>';
            navbarNav.appendChild(backButtonItem);
        }
    });
</script>

@section('content')
    <div class="container py-4">
        <div class="page-header" data-aos="fade-down" data-aos-delay="100">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Weather Observation Report</h1>

                <div class="dropdown">
                    <button class="language-dropdown dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-globe"></i> Language
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                        <li><button class="dropdown-item active" type="button" data-language="en">English</button></li>
                        <li><button class="dropdown-item" type="button" data-language="ur">اردو</button></li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="weatherObservationForm" method="POST" action="{{ route('public.weather.observation.store') }}" enctype="multipart/form-data" data-no-protection="true" novalidate>
            @csrf
            
            <!-- Personal Details Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <h3>Personal Details</h3>
                </div>
                <div class="card-body">
                    <!-- Personal Details Alert -->
                    <div class="card-alert alert-danger" id="personalDetailsAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-person-x-fill"></i>
                            </div>
                            <div class="card-alert-text">
                                                        <div class="card-alert-title" data-translate="pleaseCompletePersonalDetails">Personal details required</div>
                        <div class="card-alert-message" data-translate="followingFieldsRequired">Please fill in all required personal information to continue:</div>
                                <ul class="card-alert-list" id="personalDetailsErrorList"></ul>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('personalDetailsAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="personal_name" class="form-label">
                                <i class="bi bi-person"></i>
                                Full Name
                            </label>
                            <input type="text" class="form-control" id="personal_name" name="personal_name" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="personal_phone" class="form-label">
                                <i class="bi bi-telephone"></i>
                                Phone Number
                            </label>
                            <input type="tel" class="form-control" id="personal_phone" name="personal_phone" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="personal_email" class="form-label">
                                <i class="bi bi-envelope"></i>
                                Email Address
                            </label>
                            <input type="email" class="form-control" id="personal_email" name="personal_email" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card-header">
                    <h3>Location Information</h3>
                </div>
                <div class="card-body">
                    <!-- Location Alert -->
                    <div class="card-alert alert-danger" id="locationAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="card-alert-text">
                                                        <div class="card-alert-title" data-translate="locationInfoNeeded">Location information required</div>
                        <div class="card-alert-message" data-translate="clickGetLocationMessage">Please click "Get My Current Location" button to automatically detect and fill your location details.</div>
                                <ul class="card-alert-list" id="locationErrorList"></ul>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('locationAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <button type="button" id="getLocationBtn" class="btn btn-primary mb-3">Get My Current Location</button>
                                <div id="locationStatus" class="text-muted"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="location_city" class="form-label">
                                        <i class="bi bi-building"></i>
                                        City
                                    </label>
                                    <input type="text" class="form-control" id="location_city" name="location_city" readonly required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="location_state" class="form-label">
                                        <i class="bi bi-map"></i>
                                        State
                                    </label>
                                    <input type="text" class="form-control" id="location_state" name="location_state" readonly required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="time_zone" class="form-label">
                                        <i class="bi bi-clock"></i>
                                        Time Zone
                                    </label>
                                    <input type="text" class="form-control" id="time_zone" name="time_zone" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="map-container">
                                <div id="locationMap"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Date and Time Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="card-header">
                    <h3>Event Date and Time</h3>
                </div>
                <div class="card-body">
                    <!-- Event Date Time Alert -->
                    <div class="card-alert alert-danger" id="eventDateTimeAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-calendar-x-fill"></i>
                            </div>
                            <div class="card-alert-text">
                                                        <div class="card-alert-title" data-translate="eventDateTimeRequired">Event date and time required</div>
                        <div class="card-alert-message" data-translate="specifyWhenEventOccurred">Please provide the date and time when the weather event occurred:</div>
                                <ul class="card-alert-list" id="eventDateTimeErrorList"></ul>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('eventDateTimeAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="event_date" class="form-label">
                                <i class="bi bi-calendar3"></i>
                                Date of Weather Event
                            </label>
                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="event_time" class="form-label">
                                <i class="bi bi-clock-history"></i>
                                Time of Weather Event
                            </label>
                            <input type="time" class="form-control" id="event_time" name="event_time" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weather Phenomena Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header">
                    <h3>Weather Phenomena</h3>
                    <p class="text-muted">Select all that apply</p>
                </div>
                <div class="card-body">
                    <!-- Weather Phenomena Alert -->
                    <div class="card-alert alert-danger" id="weatherPhenomenaAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-cloud-lightning"></i>
                            </div>
                            <div class="card-alert-text">
                                                        <div class="card-alert-title" data-translate="weatherTypeSelectionRequired">Weather type selection required</div>
                        <div class="card-alert-message" data-translate="selectAtLeastOneWeather">Please select at least one weather phenomenon that you observed.</div>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('weatherPhenomenaAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Weather Incompatibility Alert -->
                    <div class="card-alert alert-warning" id="weatherIncompatibilityAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="card-alert-text">
                                                        <div class="card-alert-title" data-translate="incompatibleWeatherTypes">Incompatible weather types</div>
                        <div class="card-alert-message" data-translate="dustStormFogCannotCoexist">Duststorm and Fog cannot occur simultaneously. Please select only one of these options.</div>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('weatherIncompatibilityAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_rain" name="weather_types[]" value="rain">
                                <div class="weather-content">
                                    <img src="{{ asset('images/rain.jpg') }}" alt="Rain Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_rain">Rain</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_drizzle" name="weather_types[]" value="drizzle">
                                <div class="weather-content">
                                    <img src="{{ asset('images/drizzle.jpg') }}" alt="Drizzle Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_drizzle">Drizzle</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_thunder" name="weather_types[]" value="thunder_lightning">
                                <div class="weather-content">
                                    <img src="{{ asset('images/thunder.jpg') }}" alt="Thunder/Lightning Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_thunder">Thunder/Lightning</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_hail" name="weather_types[]" value="hailstorm">
                                <div class="weather-content">
                                    <img src="{{ asset('images/hail.jpg') }}" alt="Hailstorm Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_hail">Hailstorm</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type incompatible-group-1" type="checkbox" id="weather_duststorm" name="weather_types[]" value="duststorm">
                                <div class="weather-content">
                                    <img src="{{ asset('images/duststorm.webp') }}" alt="Duststorm Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_duststorm">Duststorm</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type incompatible-group-1" type="checkbox" id="weather_fog" name="weather_types[]" value="fog">
                                <div class="weather-content">
                                    <img src="{{ asset('images/fog.jpg') }}" alt="Fog Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_fog">Fog</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_snow" name="weather_types[]" value="snow">
                                <div class="weather-content">
                                    <img src="{{ asset('images/snow.jpg') }}" alt="Snow Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_snow">Snow</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_gusty_wind" name="weather_types[]" value="gusty_wind">
                                <div class="weather-content">
                                    <img src="{{ asset('images/wind.webp') }}" alt="Gusty Wind Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_gusty_wind">Gusty Wind</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-check weather-item">
                                <input class="form-check-input weather-type" type="checkbox" id="weather_smog" name="weather_types[]" value="smog">
                                <div class="weather-content">
                                    <img src="{{ asset('images/smog.jpg') }}" alt="Smog Icon" class="weather-image">
                                    <label class="form-check-label" for="weather_smog">Smog</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Damage Caused Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="600">
                <div class="card-header">
                    <h3>Damage Caused</h3>
                    <p class="text-muted">Select all that apply</p>
                </div>
                <div class="card-body">
                    <!-- Other Damage Alert -->
                    <div class="card-alert alert-warning" id="otherDamageAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="card-alert-text">
                                                        <div class="card-alert-title" data-translate="descriptionRequiredOtherDamage">Description required for "Other" damage</div>
                        <div class="card-alert-message" data-translate="provideOtherDamageDescription">Please provide a description of the other damage you selected.</div>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('otherDamageAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_tree_branches" name="damages[]" value="tree_branches_breaking">
                                <label class="form-check-label" for="damage_tree_branches">Tree branches breaking</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_small_tree" name="damages[]" value="small_tree_uprooting">
                                <label class="form-check-label" for="damage_small_tree">Small tree uprooting</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_big_tree" name="damages[]" value="big_tree_uprooting">
                                <label class="form-check-label" for="damage_big_tree">Big tree uprooting</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_pole_bend" name="damages[]" value="pole_damaged_bending">
                                <label class="form-check-label" for="damage_pole_bend">Telephone pole / Transmission tower damaged by bending</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_pole_uproot" name="damages[]" value="pole_uprooting">
                                <label class="form-check-label" for="damage_pole_uproot">Telephone pole / Transmission tower uprooting</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_makeshift" name="damages[]" value="damage_makeshift_structures">
                                <label class="form-check-label" for="damage_makeshift">Damage to Makeshift structures (houses, cowsheds)</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_reinforced" name="damages[]" value="damage_reinforced_structures">
                                <label class="form-check-label" for="damage_reinforced">Damage to Reinforced structures (houses, shelters)</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_flooding" name="damages[]" value="flooding_of_land">
                                <label class="form-check-label" for="damage_flooding">Flooding of land</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_livestock" name="damages[]" value="damage_to_livestock">
                                <label class="form-check-label" for="damage_livestock">Damage/Death to livestock</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_humans" name="damages[]" value="damage_to_humans">
                                <label class="form-check-label" for="damage_humans">Damage/Death to Humans</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_crops" name="damages[]" value="damage_to_crops">
                                <label class="form-check-label" for="damage_crops">Damage to vegetation/crops</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_other" name="damages[]" value="other_damage">
                                <label class="form-check-label" for="damage_other">Other</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Other damage description field (hidden by default) -->
                    <div id="otherDamageContainer" class="mt-3" style="display: none;">
                        <label for="other_damage_description" class="form-label">Please describe the other damage:</label>
                        <textarea class="form-control" id="other_damage_description" name="other_damage_description" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="700">
                <div class="card-header">
                    <h3>Description</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="event_description" class="form-label">
                            <i class="bi bi-file-text"></i>
                            Describe the weather event in detail
                        </label>
                        <textarea class="form-control" id="event_description" name="event_description" rows="4" placeholder="Please provide any additional details about the weather event..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Media Upload Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="800">
                <div class="card-header">
                    <h3>Media Files</h3>
                    <p class="text-muted">Upload photos or videos related to the weather event (Optional)</p>
                </div>
                <div class="card-body">
                    <!-- Media File Type Validation Alert -->
                    <div class="card-alert alert-danger" id="mediaFileAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="card-alert-text">
                                <div class="card-alert-title" data-translate="mediaFileUnsupportedType">Unsupported file type</div>
                                <div class="card-alert-message" data-translate="mediaFileTypeMessage">Please upload only supported file formats: JPEG, PNG, GIF images or MP4, MOV videos (Max: 10MB each).</div>
                                <ul class="card-alert-list" id="mediaFileErrorList"></ul>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('mediaFileAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Enhanced File Upload Area -->
                    <div class="enhanced-file-upload-container mb-4">
                        <div class="file-upload-zone" id="fileUploadZone">
                            <div class="upload-icon-container">
                                <i class="bi bi-cloud-upload-fill upload-main-icon"></i>
                                <div class="upload-animation">
                                    <i class="bi bi-arrow-up-circle upload-arrow"></i>
                                </div>
                            </div>
                            <div class="upload-text">
                                <h5 class="upload-title">Drag & Drop Files Here</h5>
                                <p class="upload-subtitle">or <span class="browse-link">browse files</span></p>
                                <small class="upload-hint">Supported: JPEG, PNG, GIF, MP4, MOV (Max: 10MB each)</small>
                            </div>
                            <input type="file" class="hidden-file-input" id="media_files" name="media_files[]" multiple accept="image/*,video/*">
                        </div>
                        
                        <!-- Upload Progress (hidden by default) -->
                        <div class="upload-progress-container" id="uploadProgressContainer" style="display: none;">
                            <div class="progress-bar-wrapper">
                                <div class="progress-bar" id="uploadProgressBar"></div>
                            </div>
                            <span class="progress-text" id="uploadProgressText">0%</span>
                        </div>
                    </div>
                    
                    <!-- Selected Files Grid -->
                    <div id="selectedFilesGrid" class="selected-files-grid" style="display: none;">
                        <div class="grid-header">
                            <h6 class="grid-title">
                                <i class="bi bi-collection"></i>
                                Selected Files <span class="file-count-badge" id="selectedFileCount">0</span>
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-danger clear-all-btn" id="clearAllFiles">
                                <i class="bi bi-trash"></i> Clear All
                            </button>
                        </div>
                        <div class="files-grid" id="filesGrid"></div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4" data-aos="fade-up" data-aos-delay="900">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle me-2"></i>
                    Submit Report
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <!-- AOS Animation Library Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Global variables for alert system (must be defined before DOMContentLoaded)
        let currentLanguage = 'en';
        
        // Ensure currentLanguage is available globally
        window.currentLanguage = currentLanguage;
        
        // Global function to update current language
        function updateCurrentLanguage(lang) {
            currentLanguage = lang;
        }
        
        // Global alert functions that need to be accessible from anywhere
        function showAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                // Clear any inline display style that might prevent showing and force visibility
                alert.style.display = 'block';
                alert.style.visibility = 'visible';
                alert.style.opacity = '1';
                alert.style.transform = 'translateY(0)';
                alert.classList.remove('hide');
                alert.classList.add('show');
                
                // Apply RTL styling if current language is Urdu
                if (currentLanguage === 'ur') {
                    alert.style.textAlign = 'right';
                    alert.style.direction = 'rtl';
                    alert.setAttribute('dir', 'rtl');
                    alert.classList.add('rtl-active');
                } else {
                    alert.style.textAlign = '';
                    alert.style.direction = '';
                    alert.setAttribute('dir', 'ltr');
                    alert.classList.remove('rtl-active');
                }
                
                // Scroll alert into view
                setTimeout(() => {
                    alert.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }, 100);
            } else {
                console.error('Alert element not found for ID:', alertId); // Debug log
            }
        }
        
        function hideAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('hide');
                setTimeout(() => {
                    alert.style.display = 'none';
                    alert.style.visibility = 'hidden';
                    alert.style.opacity = '0';
                    alert.classList.remove('hide');
                }, 300);
            }
        }
        
        function hideAllAlerts() {
            console.log('hideAllAlerts called'); // Debug log
            const alerts = document.querySelectorAll('.card-alert');
            console.log('Found alerts:', alerts.length); // Debug log
            alerts.forEach(alert => {
                console.log('Processing alert:', alert.id, 'has show class:', alert.classList.contains('show')); // Debug log
                // Hide alert regardless of current state to ensure clean slate
                alert.style.display = 'none';
                alert.style.visibility = 'hidden';
                alert.style.opacity = '0';
                alert.classList.remove('show', 'hide');
            });
        }
        
        function addErrorToList(listId, error) {
            const list = document.getElementById(listId);
            if (list) {
                const li = document.createElement('li');
                li.textContent = error;
                list.appendChild(li);
            }
        }
        
        function clearErrorList(listId) {
            const list = document.getElementById(listId);
            if (list) {
                list.innerHTML = '';
            }
        }
        
        function addFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.add('field-error');
                // Add shake animation
                field.classList.add('shake');
                setTimeout(() => {
                    field.classList.remove('shake');
                }, 400);
            }
        }
        
        function removeFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.remove('field-error');
                field.classList.add('is-valid');
            }
        }
        
        function removeAllFieldErrors() {
            const errorFields = document.querySelectorAll('.field-error');
            errorFields.forEach(field => {
                field.classList.remove('field-error');
            });
            
            const validFields = document.querySelectorAll('.is-valid');
            validFields.forEach(field => {
                field.classList.remove('is-valid');
            });
        }
        
        // Global weather incompatibility checking function
        function checkWeatherIncompatibility() {
            const dustStormCheckbox = document.getElementById('weather_duststorm');
            const fogCheckbox = document.getElementById('weather_fog');
            
            if (dustStormCheckbox && fogCheckbox) {
                if (dustStormCheckbox.checked && fogCheckbox.checked) {
                    showAlert('weatherIncompatibilityAlert');
                    return false;
                } else {
                    hideAlert('weatherIncompatibilityAlert');
                    return true;
                }
            }
            return true;
        }
        
        // Test function to manually show alerts (for debugging)
        function testAlerts() {
            console.log('Testing all alerts...');
            const alertIds = ['personalDetailsAlert', 'locationAlert', 'eventDateTimeAlert', 'weatherPhenomenaAlert', 'weatherIncompatibilityAlert', 'otherDamageAlert'];
            
            // First check if all alert elements exist
            alertIds.forEach(alertId => {
                const alertElement = document.getElementById(alertId);
                console.log(`Alert ${alertId}:`, alertElement ? 'EXISTS' : 'MISSING');
            });
            
            // Then test showing them
            alertIds.forEach((alertId, index) => {
                setTimeout(() => {
                    console.log('Testing alert:', alertId);
                    showAlert(alertId);
                }, index * 1000);
            });
        }
        
        // Function to check all alert elements exist
        function checkAlertElements() {
            const alertIds = ['personalDetailsAlert', 'locationAlert', 'eventDateTimeAlert', 'weatherPhenomenaAlert', 'weatherIncompatibilityAlert', 'otherDamageAlert'];
            const missing = [];
            
            alertIds.forEach(alertId => {
                const alertElement = document.getElementById(alertId);
                if (!alertElement) {
                    missing.push(alertId);
                }
            });
            
            if (missing.length > 0) {
                console.error('Missing alert elements:', missing);
                return false;
            } else {
                console.log('All alert elements found successfully');
                return true;
            }
        }
        
        // Simple function to show all validation alerts at once (for testing)
        function showAllValidationAlerts() {
            console.log('Showing all validation alerts...');
            const alertIds = ['personalDetailsAlert', 'locationAlert', 'eventDateTimeAlert', 'weatherPhenomenaAlert'];
            
            // Add some test errors to lists
            addErrorToList('personalDetailsErrorList', 'Full Name');
            addErrorToList('personalDetailsErrorList', 'Phone Number');
            addErrorToList('personalDetailsErrorList', 'Email Address');
            
            addErrorToList('locationErrorList', 'City');
            addErrorToList('locationErrorList', 'State');
            addErrorToList('locationErrorList', 'Time Zone');
            
            addErrorToList('eventDateTimeErrorList', 'Date of Weather Event');
            addErrorToList('eventDateTimeErrorList', 'Time of Weather Event');
            
            // Show all alerts
            alertIds.forEach(alertId => {
                console.log('Showing:', alertId);
                showAlert(alertId);
            });
        }
        
        // Simple test that works immediately without waiting for DOM
        function simpleAlertTest() {
            console.log('Running simple alert test...');
            const alert = document.getElementById('personalDetailsAlert');
            if (alert) {
                console.log('Found alert element, forcing display...');
                alert.style.display = 'block';
                alert.style.visibility = 'visible';
                alert.style.opacity = '1';
                alert.style.position = 'relative';
                alert.style.zIndex = '9999';
                alert.classList.add('show');
                console.log('Alert should now be visible');
            } else {
                console.error('Alert element not found!');
            }
        }
        
        // Show media file validation alert with specific error details
        function showMediaFileAlert(invalidFiles, oversizedFiles) {
            const alert = document.getElementById('mediaFileAlert');
            const errorList = document.getElementById('mediaFileErrorList');
            const alertTitle = alert.querySelector('.card-alert-title');
            const alertMessage = alert.querySelector('.card-alert-message');
            
            if (!alert || !errorList) return;
            
            // Clear previous errors
            errorList.innerHTML = '';
            
            // Update alert title and message based on error types using translations
            if (invalidFiles.length > 0 && oversizedFiles.length > 0) {
                alertTitle.textContent = 'File validation errors';
                alertMessage.textContent = 'Some files could not be uploaded due to the following issues:';
            } else if (invalidFiles.length > 0) {
                alertTitle.textContent = currentLanguage === 'ur' ? 'غیر معاون فائل قسم' : 'Unsupported file type';
                alertMessage.textContent = currentLanguage === 'ur' ? 
                    'براہ کرم صرف معاون فائل فارمیٹس اپ لوڈ کریں: JPEG، PNG، GIF تصاویر یا MP4، MOV ویڈیوز۔' :
                    'Please upload only supported file formats: JPEG, PNG, GIF images or MP4, MOV videos.';
            } else if (oversizedFiles.length > 0) {
                alertTitle.textContent = currentLanguage === 'ur' ? 'فائل کا سائز بہت بڑا' : 'File size too large';
                alertMessage.textContent = currentLanguage === 'ur' ? 
                    'فائلیں 10MB سے چھوٹی ہونی چاہیے۔' :
                    'Files must be smaller than 10MB each.';
            }
            
            // Add invalid file type errors
            if (invalidFiles.length > 0) {
                invalidFiles.forEach(fileName => {
                    const li = document.createElement('li');
                    if (currentLanguage === 'ur') {
                        li.innerHTML = `<strong>"${fileName}"</strong> - غیر معاون فائل قسم۔ صرف JPEG، PNG، GIF، MP4، اور MOV فائلیں قبول ہیں۔`;
                    } else {
                        li.innerHTML = `<strong>"${fileName}"</strong> - Unsupported file type. Only JPEG, PNG, GIF, MP4, and MOV files are allowed.`;
                    }
                    errorList.appendChild(li);
                });
            }
            
            // Add oversized file errors
            if (oversizedFiles.length > 0) {
                oversizedFiles.forEach(fileName => {
                    const li = document.createElement('li');
                    if (currentLanguage === 'ur') {
                        li.innerHTML = `<strong>"${fileName}"</strong> - فائل کا سائز 10MB کی حد سے زیادہ ہے۔`;
                    } else {
                        li.innerHTML = `<strong>"${fileName}"</strong> - File size exceeds 10MB limit.`;
                    }
                    errorList.appendChild(li);
                });
            }
            
            // Show the alert
            showAlert('mediaFileAlert');
            
            // Apply RTL styling if needed
            if (currentLanguage === 'ur') {
                alert.style.textAlign = 'right';
                alert.style.direction = 'rtl';
                errorList.style.textAlign = 'right';
                errorList.style.direction = 'rtl';
            }
        }

        // Add test function to window for console testing
        window.testAlerts = testAlerts;
        window.showAlert = showAlert;
        window.hideAlert = hideAlert;
        window.checkAlertElements = checkAlertElements;
        window.showAllValidationAlerts = showAllValidationAlerts;
        window.simpleAlertTest = simpleAlertTest;
        
        // Global form validation function
        function validateForm() {
            console.log('validateForm called'); // Debug log
            
            let isValid = true;
            const errors = {
                personalDetails: [],
                locationDetails: [],
                eventDateTime: [],
                weatherPhenomena: false,
                weatherIncompatibility: false,
                otherDamage: false
            };
            
            // Translation object for global access - simplified version
            const simpleTranslations = {
                'en': {
                    'fullName': 'Full Name',
                    'phoneNumber': 'Phone Number',
                    'emailAddress': 'Email Address',
                    'city': 'City',
                    'state': 'State',
                    'timeZone': 'Time Zone',
                    'dateOfWeatherEvent': 'Date of Weather Event',
                    'timeOfWeatherEvent': 'Time of Weather Event'
                },
                'ur': {
                    'fullName': 'پورا نام',
                    'phoneNumber': 'فون نمبر',
                    'emailAddress': 'ای میل ایڈریس',
                    'city': 'شہر',
                    'state': 'ریاست',
                    'timeZone': 'ٹائم زون',
                    'dateOfWeatherEvent': 'موسمی واقعے کی تاریخ',
                    'timeOfWeatherEvent': 'موسمی واقعے کا وقت'
                }
            };
            
            // Use either current language or fallback to English
            const getCurrentLanguage = () => window.currentLanguage || 'en';
            const getTranslation = (key) => {
                const lang = getCurrentLanguage();
                return simpleTranslations[lang] && simpleTranslations[lang][key] 
                    ? simpleTranslations[lang][key] 
                    : simpleTranslations['en'][key] || key;
            };
            
            // Hide all alerts and clear field errors
            console.log('Hiding all alerts and clearing errors'); // Debug log
            hideAllAlerts();
            removeAllFieldErrors();
            
            // Clear all error lists
            clearErrorList('personalDetailsErrorList');
            clearErrorList('locationErrorList');
            clearErrorList('eventDateTimeErrorList');
            
            // Validate Personal Details
            const personalName = document.getElementById('personal_name');
            const personalPhone = document.getElementById('personal_phone');
            const personalEmail = document.getElementById('personal_email');
            
            if (!personalName || !personalName.value.trim()) {
                errors.personalDetails.push(getTranslation('fullName'));
                if (personalName) addFieldError('personal_name');
                isValid = false;
            }
            
            if (!personalPhone || !personalPhone.value.trim()) {
                errors.personalDetails.push(getTranslation('phoneNumber'));
                if (personalPhone) addFieldError('personal_phone');
                isValid = false;
            }
            
            if (!personalEmail || !personalEmail.value.trim()) {
                errors.personalDetails.push(getTranslation('emailAddress'));
                if (personalEmail) addFieldError('personal_email');
                isValid = false;
            }
            
            // Validate Location Details
            const locationCity = document.getElementById('location_city');
            const locationState = document.getElementById('location_state');
            const timeZone = document.getElementById('time_zone');
            
            if (!locationCity || !locationCity.value.trim()) {
                errors.locationDetails.push(getTranslation('city'));
                if (locationCity) addFieldError('location_city');
                isValid = false;
            }
            
            if (!locationState || !locationState.value.trim()) {
                errors.locationDetails.push(getTranslation('state'));
                if (locationState) addFieldError('location_state');
                isValid = false;
            }
            
            if (!timeZone || !timeZone.value.trim()) {
                errors.locationDetails.push(getTranslation('timeZone'));
                if (timeZone) addFieldError('time_zone');
                isValid = false;
            }
            
            // Validate Event Date and Time
            const eventDate = document.getElementById('event_date');
            const eventTime = document.getElementById('event_time');
            
            if (!eventDate || !eventDate.value.trim()) {
                errors.eventDateTime.push(getTranslation('dateOfWeatherEvent'));
                if (eventDate) addFieldError('event_date');
                isValid = false;
            }
            
            if (!eventTime || !eventTime.value.trim()) {
                errors.eventDateTime.push(getTranslation('timeOfWeatherEvent'));
                if (eventTime) addFieldError('event_time');
                isValid = false;
            }
            
            // Validate Weather Phenomena
            const weatherTypes = document.querySelectorAll('.weather-type:checked');
            if (weatherTypes.length === 0) {
                errors.weatherPhenomena = true;
                isValid = false;
            }
            
            // Check weather incompatibility
            if (!checkWeatherIncompatibility()) {
                errors.weatherIncompatibility = true;
                isValid = false;
            }
            
            // Validate Other Damage Description
            const damageOther = document.getElementById('damage_other');
            const otherDamageDescription = document.getElementById('other_damage_description');
            if (damageOther && damageOther.checked && (!otherDamageDescription || !otherDamageDescription.value.trim())) {
                errors.otherDamage = true;
                if (otherDamageDescription) addFieldError('other_damage_description');
                isValid = false;
            }
            
            // Show ALL applicable alerts simultaneously when validation fails
            const alertsToShow = [];
            
            console.log('Errors object:', errors); // Debug log
            
            if (errors.personalDetails.length > 0) {
                console.log('Adding personal details errors:', errors.personalDetails); // Debug log
                errors.personalDetails.forEach(error => {
                    addErrorToList('personalDetailsErrorList', error);
                });
                alertsToShow.push('personalDetailsAlert');
            }
            
            if (errors.locationDetails.length > 0) {
                console.log('Adding location details errors:', errors.locationDetails); // Debug log
                errors.locationDetails.forEach(error => {
                    addErrorToList('locationErrorList', error);
                });
                alertsToShow.push('locationAlert');
            }
            
            if (errors.eventDateTime.length > 0) {
                console.log('Adding event date/time errors:', errors.eventDateTime); // Debug log
                errors.eventDateTime.forEach(error => {
                    addErrorToList('eventDateTimeErrorList', error);
                });
                alertsToShow.push('eventDateTimeAlert');
            }
            
            if (errors.weatherPhenomena) {
                console.log('Adding weather phenomena error'); // Debug log
                alertsToShow.push('weatherPhenomenaAlert');
            }
            
            if (errors.weatherIncompatibility) {
                console.log('Adding weather incompatibility error'); // Debug log
                alertsToShow.push('weatherIncompatibilityAlert');
            }
            
            if (errors.otherDamage) {
                console.log('Adding other damage error'); // Debug log
                alertsToShow.push('otherDamageAlert');
            }
            
            console.log('Validation result:', isValid, 'Alerts to show:', alertsToShow); // Debug log
            
            // Show all alerts immediately when validation fails
            if (alertsToShow.length > 0) {
                console.log('About to show', alertsToShow.length, 'alerts'); // Debug log
                
                alertsToShow.forEach((alertId) => {
                    console.log('Showing alert immediately:', alertId); // Debug log
                    showAlert(alertId);
                });
                
                // Scroll to the first alert after all are shown
                setTimeout(() => {
                    const firstAlert = document.getElementById(alertsToShow[0]);
                    if (firstAlert) {
                        console.log('Scrolling to first alert:', alertsToShow[0]); // Debug log
                        firstAlert.scrollIntoView({ 
                            behavior: 'smooth', 
                            block: 'start' 
                        });
                    }
                }, 200); // Allow time for all alerts to render
            } else {
                console.log('No alerts to show - form should be valid'); // Debug log
            }
            
            return isValid;
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing validation system...'); // Debug log
            
            // Check that all alert elements exist
            try {
                checkAlertElements();
                console.log('Alert elements check completed'); // Debug log
            } catch (error) {
                console.error('Error checking alert elements:', error);
            }
            
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                offset: 50,
                delay: 100
            });

            // CARD-BASED ALERT SYSTEM FUNCTIONS
            // (Note: Alert functions are now defined globally above)
            
            // LANGUAGE TRANSLATION FUNCTIONALITY
           
            // Language translations object
            const translations = {
                'en': {
                    'weatherObservationReport': 'Weather Observation Report',
                    'locationInformation': 'Location Information',
                    'getMyCurrentLocation': 'Get My Current Location',
                    'state': 'State',
                    'city': 'City',
                    'timeZone': 'Time Zone',
                    'eventDateAndTime': 'Event Date and Time',
                    'dateOfWeatherEvent': 'Date of Weather Event',
                    'timeOfWeatherEvent': 'Time of Weather Event',
                    'weatherPhenomena': 'Weather Phenomena',
                    'selectAllThatApply': 'Select all that apply',
                    'rain': 'Rain',
                    'drizzle': 'Drizzle',
                    'thunderLightning': 'Thunder/Lightning',
                    'hailstorm': 'Hailstorm',
                    'duststorm': 'Duststorm',
                    'fog': 'Fog',
                    'snow': 'Snow',
                    'gustyWind': 'Gusty Wind',
                    'smog': 'Smog',
                    'duststormFogError': 'Duststorm and Fog cannot be selected together.',
                    'damageCaused': 'Damage Caused',
                    'treeBranchesBreaking': 'Tree branches breaking',
                    'smallTreeUprooting': 'Small tree uprooting',
                    'bigTreeUprooting': 'Big tree uprooting',
                    'poleDamagedBending': 'Telephone pole / Transmission tower damaged by bending',
                    'poleUprooting': 'Telephone pole / Transmission tower uprooting',
                    'damageToMakeshiftStructures': 'Damage to Makeshift structures (houses, cowsheds)',
                    'damageToReinforcedStructures': 'Damage to Reinforced structures (houses, shelters)',
                    'floodingOfLand': 'Flooding of land',
                    'damageToLivestock': 'Damage/Death to livestock',
                    'damageToHumans': 'Damage/Death to Humans',
                    'damageToVegetationCrops': 'Damage to vegetation/crops',
                    'other': 'Other',
                    'pleaseDescribeOtherDamage': 'Please describe the other damage:',
                    'description': 'Description',
                    'describeWeatherEvent': 'Describe the weather event in detail',
                    'descriptionPlaceholder': 'Please provide any additional details about the weather event...',
                    'mediaFiles': 'Media Files',
                    'uploadImagesVideos': 'Select Files',
                    'multipleFilesNote': 'Supported formats: JPEG, PNG, GIF, MP4, MOV. Maximum file size: 10MB each.',
                    'selectedFiles': 'Selected Files:',
                    'submitReport': 'Submit Report',
                    'language': 'Language',
                    'requestingLocationAccess': 'Requesting location access...',
                    'locationAcquired': 'Location acquired. Fetching location details...',
                    'locationDetailsRetrieved': 'Location details successfully retrieved.',
                    'errorRetrievingLocation': 'Error retrieving location details. Please enter manually.',
                    'locationAccessDenied': 'Location access denied. Please enter location manually.',
                    'locationUnavailable': 'Location information unavailable.',
                    'locationTimeout': 'Location request timed out.',
                    'unknownLocationError': 'An unknown error occurred while getting location.',
                    'geolocationNotSupported': 'Geolocation is not supported by this browser.',
                    'personalDetails': 'Personal Details',
                    'fullName': 'Full Name',
                    'phoneNumber': 'Phone Number',
                    'emailAddress': 'Email Address',
                    // Alert messages
                    'pleaseCompletePersonalDetails': 'Personal details required',
                    'followingFieldsRequired': 'Please fill in all required personal information to continue:',
                    'locationInfoNeeded': 'Location information required',
                    'clickGetLocationMessage': 'Please click "Get My Current Location" button to automatically detect and fill your location details.',
                    'eventDateTimeRequired': 'Event date and time required',
                    'specifyWhenEventOccurred': 'Please provide the date and time when the weather event occurred:',
                    'weatherTypeSelectionRequired': 'Weather type selection required',
                    'selectAtLeastOneWeather': 'Please select at least one weather phenomenon that you observed.',
                    'incompatibleWeatherTypes': 'Incompatible weather types',
                    'dustStormFogCannotCoexist': 'Duststorm and Fog cannot occur simultaneously. Please select only one of these options.',
                    'descriptionRequiredOtherDamage': 'Description required for "Other" damage',
                    'provideOtherDamageDescription': 'Please provide a description of the other damage you selected.',
                    'mediaFileUnsupportedType': 'Unsupported file type',
                    'mediaFileTypeMessage': 'Please upload only supported file formats: JPEG, PNG, GIF images or MP4, MOV videos (Max: 10MB each).'
                },
                'ur': {
                    'weatherObservationReport': 'موسمی مشاہدہ رپورٹ',
                    'locationInformation': 'مقام کی معلومات',
                    'getMyCurrentLocation': 'میرا موجودہ مقام حاصل کریں',
                    'state': 'ریاست',
                    'city': 'شہر',
                    'timeZone': 'ٹائم زون',
                    'eventDateAndTime': 'واقعے کی تاریخ اور وقت',
                    'dateOfWeatherEvent': 'موسمی واقعے کی تاریخ',
                    'timeOfWeatherEvent': 'موسمی واقعے کا وقت',
                    'weatherPhenomena': 'موسمی مظاہر',
                    'selectAllThatApply': 'جو لاگو ہوں وہ منتخب کریں',
                    'rain': 'بارش',
                    'drizzle': 'پھوار',
                    'thunderLightning': 'گرج چمک',
                    'hailstorm': 'ژالہ باری',
                    'duststorm': 'آندھی',
                    'fog': 'دھند',
                    'snow': 'برف',
                    'gustyWind': 'تیز ہوا',
                    'smog': 'دھواں دھند',
                    'duststormFogError': 'آندھی اور دھند ایک ساتھ منتخب نہیں کی جا سکتی۔',
                    'damageCaused': 'پہنچنے والا نقصان',
                    'treeBranchesBreaking': 'درختوں کی شاخیں ٹوٹنا',
                    'smallTreeUprooting': 'چھوٹے درخت اکھڑنا',
                    'bigTreeUprooting': 'بڑے درخت اکھڑنا',
                    'poleDamagedBending': 'ٹیلیفون پول / ٹرانسمیشن ٹاور کا مڑنا',
                    'poleUprooting': 'ٹیلیفون پول / ٹرانسمیشن ٹاور کا اکھڑنا',
                    'damageToMakeshiftStructures': 'عارضی ڈھانچوں کو نقصان (گھر، گائے کے شیڈ)',
                    'damageToReinforcedStructures': 'مضبوط ڈھانچوں کو نقصان (گھر، پناہ گاہیں)',
                    'floodingOfLand': 'زمین پر سیلاب',
                    'damageToLivestock': 'مویشیوں کو نقصان/موت',
                    'damageToHumans': 'انسانوں کو نقصان/موت',
                    'damageToVegetationCrops': 'نباتات/فصلوں کو نقصان',
                    'other': 'دیگر',
                    'pleaseDescribeOtherDamage': 'براہ کرم دیگر نقصان کی تفصیل بیان کریں:',
                    'description': 'تفصیل',
                    'describeWeatherEvent': 'موسمی واقعے کی تفصیل بیان کریں',
                    'descriptionPlaceholder': 'براہ کرم موسمی واقعے کے بارے میں کوئی اضافی تفصیلات فراہم کریں...',
                    'mediaFiles': 'میڈیا فائلیں',
                    'uploadImagesVideos': 'فائلیں منتخب کریں',
                    'multipleFilesNote': 'تعاون یافتہ فارمیٹس: JPEG، PNG، GIF، MP4، MOV۔ زیادہ سے زیادہ فائل سائز: ہر ایک 10MB۔',
                    'selectedFiles': 'منتخب شدہ فائلیں:',
                    'submitReport': 'رپورٹ جمع کرائیں',
                    'language': 'زبان',
                    'requestingLocationAccess': 'مقام تک رسائی کی درخواست کر رہا ہے...',
                    'locationAcquired': 'مقام حاصل کر لیا گیا۔ مقام کی تفصیلات حاصل کر رہا ہے...',
                    'locationDetailsRetrieved': 'مقام کی تفصیلات کامیابی سے حاصل کر لی گئیں۔',
                    'errorRetrievingLocation': 'مقام کی تفصیلات حاصل کرنے میں خرابی۔ براہ کرم دستی طور پر درج کریں۔',
                    'locationAccessDenied': 'مقام تک رسائی مسترد کر دی گئی۔ براہ کرم مقام دستی طور پر درج کریں۔',
                    'locationUnavailable': 'مقام کی معلومات دستیاب نہیں ہیں۔',
                    'locationTimeout': 'مقام کی درخواست کا وقت ختم ہو گیا۔',
                    'unknownLocationError': 'مقام حاصل کرتے وقت ایک نامعلوم خرابی پیش آئی۔',
                    'geolocationNotSupported': 'جیو لوکیشن اس براؤزر کے ذریعے تعاون یافتہ نہیں ہے۔',
                    'personalDetails': 'ذاتی معلومات',
                    'fullName': 'پورا نام',
                    'phoneNumber': 'فون نمبر',
                    'emailAddress': 'ای میل ایڈریس',
                    // Alert messages
                    'pleaseCompletePersonalDetails': 'ذاتی معلومات ضروری',
                    'followingFieldsRequired': 'براہ کرم جاری رکھنے کے لیے تمام ضروری ذاتی معلومات بھریں:',
                    'locationInfoNeeded': 'مقام کی معلومات ضروری',
                    'clickGetLocationMessage': 'براہ کرم اپنے مقام کی تفصیلات خود کار طریقے سے حاصل کرنے کے لیے "میرا موجودہ مقام حاصل کریں" بٹن پر کلک کریں۔',
                    'eventDateTimeRequired': 'واقعے کی تاریخ اور وقت ضروری',
                    'specifyWhenEventOccurred': 'براہ کرم موسمی واقعے کی تاریخ اور وقت فراہم کریں:',
                    'weatherTypeSelectionRequired': 'موسمی قسم کا انتخاب ضروری',
                    'selectAtLeastOneWeather': 'براہ کرم کم از کم ایک موسمی مظہر منتخب کریں جو آپ نے دیکھا ہو۔',
                    'incompatibleWeatherTypes': 'غیر موافق موسمی اقسام',
                    'dustStormFogCannotCoexist': 'آندھی اور دھند بیک وقت نہیں ہو سکتے۔ براہ کرم ان میں سے صرف ایک آپشن منتخب کریں۔',
                    'descriptionRequiredOtherDamage': '"دیگر" نقصان کے لیے تفصیل ضروری',
                    'provideOtherDamageDescription': 'براہ کرم آپ کے منتخب کردہ دیگر نقصان کی تفصیل فراہم کریں۔',
                    'mediaFileUnsupportedType': 'غیر معاون فائل قسم',
                    'mediaFileTypeMessage': 'براہ کرم صرف معاون فائل فارمیٹس اپ لوڈ کریں: JPEG، PNG، GIF تصاویر یا MP4، MOV ویڈیوز (حد: ہر ایک 10MB)۔'
                }
            };

            // Initialize elements map (for caching translated elements)
            const elementsMap = new Map();

            // Get language dropdown and language buttons
            const languageDropdown = document.getElementById('languageDropdown');
            const languageButtons = document.querySelectorAll('[data-language]');

            // Use global currentLanguage variable (already set to 'en')

            // Apply translations based on selected language
            function applyTranslations(lang) {
                // Update current language (both local and global)
                currentLanguage = lang;
                updateCurrentLanguage(lang);

                // Update dropdown button text
                if (languageDropdown) {
                    languageDropdown.innerHTML = `<i class="bi bi-globe"></i> ${translations[lang]['language']}`;
                }

                // Update active class on language buttons
                languageButtons.forEach(button => {
                    if (button.dataset.language === lang) {
                        button.classList.add('active');
                    } else {
                        button.classList.remove('active');
                    }
                });

                // Apply RTL styling for Urdu with comprehensive coverage
                const bodyElement = document.body;
                const containerElements = document.querySelectorAll('.container:not(.navbar .container)');
                
                if (lang === 'ur') {
                    // Set document and body direction
                    document.documentElement.setAttribute('dir', 'rtl');
                    bodyElement.setAttribute('dir', 'rtl');
                    bodyElement.classList.add('rtl-active');
                    
                    // Apply RTL to all relevant containers
                    containerElements.forEach(container => {
                        if (!container.closest('.navbar')) {
                            container.classList.add('rtl-active');
                            container.setAttribute('dir', 'rtl');
                        }
                    });
                    
                    // Apply RTL to all major content sections
                    const elementsToMakeRTL = [
                        '.page-header',
                        '.card-header',
                        '.card-body',
                        '.form-label',
                        '.form-control',
                        '.form-check',
                        '.form-check-label',
                        '.text-muted',
                        '.form-text',
                        'textarea',
                        'input',
                        '.btn',
                        '.dropdown-menu',
                        '.dropdown-item',
                        'p', 'span', 'div', 'label',
                        'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                    ];
                    
                    elementsToMakeRTL.forEach(selector => {
                        const elements = document.querySelectorAll(selector + ':not(.navbar):not(.navbar *)');
                        elements.forEach(element => {
                            if (element && element.style && !element.closest('.navbar')) {
                                element.classList.add('rtl-active');
                                element.setAttribute('dir', 'rtl');
                                element.style.textAlign = 'right';
                                element.style.direction = 'rtl';
                            }
                        });
                    });
                    
                    // Special handling for form elements
                    const formElements = document.querySelectorAll('input, textarea, select');
                    formElements.forEach(element => {
                        if (element && element.style && !element.closest('.navbar')) {
                            element.style.textAlign = 'right';
                            element.style.direction = 'rtl';
                        }
                    });
                    
                    // Special handling for flex elements
                    const flexElements = document.querySelectorAll('.d-flex, .card-header h3, .form-label, .btn');
                    flexElements.forEach(element => {
                        if (element && element.style && !element.closest('.navbar')) {
                            element.style.flexDirection = 'row-reverse';
                            element.style.justifyContent = 'flex-end';
                        }
                    });
                    
                    // Force navbar to remain LTR
                    const navbar = document.querySelector('.navbar');
                    if (navbar) {
                        navbar.setAttribute('dir', 'ltr');
                        const navbarElements = navbar.querySelectorAll('*');
                        navbarElements.forEach(element => {
                            if (element && element.style) {
                                element.style.direction = 'ltr';
                                element.style.textAlign = 'left';
                            }
                        });
                    }
                    
                    console.log('Comprehensive RTL mode activated for Urdu');
                } else {
                    // Remove all RTL styling for LTR languages
                    document.documentElement.setAttribute('dir', 'ltr');
                    bodyElement.setAttribute('dir', 'ltr');
                    bodyElement.classList.remove('rtl-active');
                    
                    // Remove RTL from containers
                    containerElements.forEach(container => {
                        container.classList.remove('rtl-active');
                        container.setAttribute('dir', 'ltr');
                    });
                    
                    // Remove RTL from all elements
                    const allElements = document.querySelectorAll('*:not(.navbar):not(.navbar *)');
                    allElements.forEach(element => {
                        if (element && element.style && !element.closest('.navbar')) {
                            element.classList.remove('rtl-active');
                            element.setAttribute('dir', 'ltr');
                            element.style.textAlign = '';
                            element.style.direction = '';
                            element.style.flexDirection = '';
                            element.style.justifyContent = '';
                        }
                    });
                    
                    // Ensure navbar is LTR
                    const navbar = document.querySelector('.navbar');
                    if (navbar) {
                        navbar.setAttribute('dir', 'ltr');
                        const navbarElements = navbar.querySelectorAll('*');
                        navbarElements.forEach(element => {
                            if (element && element.style) {
                                element.style.direction = 'ltr';
                                element.style.textAlign = 'left';
                            }
                        });
                    }
                    
                    console.log('LTR mode activated for English');
                }

                // If first time applying translations, build elements map
                if (elementsMap.size === 0) {
                    mapElementsForTranslation();
                }

                // Apply translations to all mapped elements
                for (const [key, elements] of elementsMap.entries()) {
                    if (translations[lang][key]) {
                        elements.forEach(el => {
                            // Add null check to prevent errors
                            if (!el || !el.style) return;
                            
                            if (el.tagName === 'INPUT' && el.type === 'text' || el.tagName === 'TEXTAREA') {
                                if (el.placeholder) {
                                    el.placeholder = translations[lang][key];
                                }
                            } else if (el.dataset && el.dataset.translateAttr === 'innerHTML') {
                                el.innerHTML = translations[lang][key];
                            } else {
                                el.textContent = translations[lang][key];
                            }
                            
                            // Apply RTL styling to translated elements if language is Urdu
                            if (lang === 'ur' && !el.closest('.navbar')) {
                                el.style.textAlign = 'right';
                                el.style.direction = 'rtl';
                                el.setAttribute('dir', 'rtl');
                                el.classList.add('rtl-active');
                            } else if (lang !== 'ur') {
                                el.style.textAlign = '';
                                el.style.direction = '';
                                el.setAttribute('dir', 'ltr');
                                el.classList.remove('rtl-active');
                            }
                        });
                    }
                }
            }

            // Map all translatable elements on the page
            function mapElementsForTranslation() {
                // Map headings
                mapElementByText('h1', 'weatherObservationReport');
                
                // Map card headers
                mapElementByText('.card-header h3', 'personalDetails', 0);
                mapElementByText('.card-header h3', 'locationInformation', 1);
                mapElementByText('.card-header h3', 'eventDateAndTime', 2);
                mapElementByText('.card-header h3', 'weatherPhenomena', 3);
                mapElementByText('.card-header h3', 'damageCaused', 4);
                mapElementByText('.card-header h3', 'description', 5);
                mapElementByText('.card-header h3', 'mediaFiles', 6);
                
                // Map buttons
                mapElementByText('#getLocationBtn', 'getMyCurrentLocation');
                mapElementByText('button[type="submit"]', 'submitReport');
                
                // Map form labels
                mapElementByText('label[for="location_state"]', 'state');
                mapElementByText('label[for="location_city"]', 'city');
                mapElementByText('label[for="time_zone"]', 'timeZone');
                mapElementByText('label[for="event_date"]', 'dateOfWeatherEvent');
                mapElementByText('label[for="event_time"]', 'timeOfWeatherEvent');
                mapElementByText('label[for="personal_name"]', 'fullName');
                mapElementByText('label[for="personal_phone"]', 'phoneNumber');
                mapElementByText('label[for="personal_email"]', 'emailAddress');
                
                // Map weather type labels
                mapElementByText('label[for="weather_rain"]', 'rain');
                mapElementByText('label[for="weather_drizzle"]', 'drizzle');
                mapElementByText('label[for="weather_thunder"]', 'thunderLightning');
                mapElementByText('label[for="weather_hail"]', 'hailstorm');
                mapElementByText('label[for="weather_duststorm"]', 'duststorm');
                mapElementByText('label[for="weather_fog"]', 'fog');
                mapElementByText('label[for="weather_snow"]', 'snow');
                mapElementByText('label[for="weather_gusty_wind"]', 'gustyWind');
                mapElementByText('label[for="weather_smog"]', 'smog');
                
                // Map damage labels
                mapElementByText('label[for="damage_tree_branches"]', 'treeBranchesBreaking');
                mapElementByText('label[for="damage_small_tree"]', 'smallTreeUprooting');
                mapElementByText('label[for="damage_big_tree"]', 'bigTreeUprooting');
                mapElementByText('label[for="damage_pole_bend"]', 'poleDamagedBending');
                mapElementByText('label[for="damage_pole_uproot"]', 'poleUprooting');
                mapElementByText('label[for="damage_makeshift"]', 'damageToMakeshiftStructures');
                mapElementByText('label[for="damage_reinforced"]', 'damageToReinforcedStructures');
                mapElementByText('label[for="damage_flooding"]', 'floodingOfLand');
                mapElementByText('label[for="damage_livestock"]', 'damageToLivestock');
                mapElementByText('label[for="damage_humans"]', 'damageToHumans');
                mapElementByText('label[for="damage_crops"]', 'damageToVegetationCrops');
                mapElementByText('label[for="damage_other"]', 'other');
                mapElementByText('label[for="other_damage_description"]', 'pleaseDescribeOtherDamage');
                
                // Map descriptive text
                mapElementByText('label[for="event_description"]', 'describeWeatherEvent');
                mapElementByText('label[for="media_files"]', 'uploadImagesVideos');
                mapElementByText('#weatherTypeError', 'duststormFogError');
                mapElementByAttribute('#event_description', 'placeholder', 'descriptionPlaceholder');
                
                // Map "Select all that apply" text
                const selectAllTexts = document.querySelectorAll('.card-header p.text-muted');
                selectAllTexts.forEach(el => {
                    addToElementsMap('selectAllThatApply', el);
                });
                
                // Map form text helper
                const helperText = document.querySelector('.form-text');
                if (helperText) {
                    addToElementsMap('multipleFilesNote', helperText);
                }
                
                // Map selected files header
                const selectedFilesHeader = document.querySelector('#selectedFiles h6');
                if (selectedFilesHeader) {
                    addToElementsMap('selectedFiles', { textNode: selectedFilesHeader.firstChild });
                }
                
                // Map alert messages
                mapElementByText('#personalDetailsAlert .card-alert-title', 'pleaseCompletePersonalDetails');
                mapElementByText('#personalDetailsAlert .card-alert-message', 'followingFieldsRequired');
                mapElementByText('#locationAlert .card-alert-title', 'locationInfoNeeded');
                mapElementByText('#locationAlert .card-alert-message', 'clickGetLocationMessage');
                mapElementByText('#eventDateTimeAlert .card-alert-title', 'eventDateTimeRequired');
                mapElementByText('#eventDateTimeAlert .card-alert-message', 'specifyWhenEventOccurred');
                mapElementByText('#weatherPhenomenaAlert .card-alert-title', 'weatherTypeSelectionRequired');
                mapElementByText('#weatherPhenomenaAlert .card-alert-message', 'selectAtLeastOneWeather');
                mapElementByText('#weatherIncompatibilityAlert .card-alert-title', 'incompatibleWeatherTypes');
                mapElementByText('#weatherIncompatibilityAlert .card-alert-message', 'dustStormFogCannotCoexist');
                mapElementByText('#otherDamageAlert .card-alert-title', 'descriptionRequiredOtherDamage');
                mapElementByText('#otherDamageAlert .card-alert-message', 'provideOtherDamageDescription');
                
                // Map status messages that might be set dynamically
                addToElementsMap('requestingLocationAccess', { dataset: { translateText: 'Requesting location access...' }});
                addToElementsMap('locationAcquired', { dataset: { translateText: 'Location acquired. Fetching location details...' }});
                addToElementsMap('locationDetailsRetrieved', { dataset: { translateText: 'Location details successfully retrieved.' }});
                addToElementsMap('errorRetrievingLocation', { dataset: { translateText: 'Error retrieving location details. Please enter manually.' }});
                addToElementsMap('locationAccessDenied', { dataset: { translateText: 'Location access denied. Please enter location manually.' }});
                addToElementsMap('locationUnavailable', { dataset: { translateText: 'Location information unavailable.' }});
                addToElementsMap('locationTimeout', { dataset: { translateText: 'Location request timed out.' }});
                addToElementsMap('unknownLocationError', { dataset: { translateText: 'An unknown error occurred while getting location.' }});
                addToElementsMap('geolocationNotSupported', { dataset: { translateText: 'Geolocation is not supported by this browser.' }});
            }

            // Helper function to map elements by their text content
            function mapElementByText(selector, translationKey, index = null) {
                const elements = document.querySelectorAll(selector);
                if (elements.length > 0) {
                    if (index !== null && elements[index]) {
                        addToElementsMap(translationKey, elements[index]);
                    } else {
                        elements.forEach(el => {
                            addToElementsMap(translationKey, el);
                        });
                    }
                }
            }

            // Helper function to map elements by attribute
            function mapElementByAttribute(selector, attribute, translationKey) {
                const element = document.querySelector(selector);
                if (element) {
                    element.dataset.translateAttr = attribute;
                    addToElementsMap(translationKey, element);
                }
            }

            // Add element to the elements map
            function addToElementsMap(key, element) {
                if (!elementsMap.has(key)) {
                    elementsMap.set(key, []);
                }
                elementsMap.get(key).push(element);
            }

            // GEOLOCATION & MAP FUNCTIONALITY
            
            // Geolocation handling
            const getLocationBtn = document.getElementById('getLocationBtn');
            const locationStatus = document.getElementById('locationStatus');
            const stateInput = document.getElementById('location_state');
            const cityInput = document.getElementById('location_city');
            const timeZoneInput = document.getElementById('time_zone');

            // Mapbox token (should ideally be passed from your Laravel backend)
            const mapboxToken = '{{ config("services.mapbox.token") }}';
            let map = null;
            let marker = null;

            // Initialize empty map
            function initializeMap() {
                if (typeof mapboxgl !== 'undefined') {
                    mapboxgl.accessToken = mapboxToken;
                    map = new mapboxgl.Map({
                        container: 'locationMap',
                        style: 'mapbox://styles/mapbox/streets-v12',
                        center: [0, 0], // Default center (will be updated)
                        zoom: 1 // Default zoom (will be updated)
                    });
                }
            }

            // Initialize the map
            initializeMap();

            // Function to update map with user's location
            function updateMapLocation(longitude, latitude) {
                if (!map) return;
                
                // Update map center and zoom
                map.flyTo({
                    center: [longitude, latitude],
                    zoom: 14,
                    essential: true
                });
                
                // Remove existing marker if any
                if (marker) {
                    marker.remove();
                }
                
                // Add new marker
                marker = new mapboxgl.Marker({
                    color: "#FF0000"
                })
                    .setLngLat([longitude, latitude])
                    .addTo(map);
                    
                // Add coordinates as hidden inputs
                if (!document.getElementById('latitude')) {
                    const latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.id = 'latitude';
                    latInput.name = 'latitude';
                    latInput.value = latitude;
                    document.getElementById('weatherObservationForm').appendChild(latInput);
                    
                    const lngInput = document.createElement('input');
                    lngInput.type = 'hidden';
                    lngInput.id = 'longitude';
                    lngInput.name = 'longitude';
                    lngInput.value = longitude;
                    document.getElementById('weatherObservationForm').appendChild(lngInput);
                } else {
                    document.getElementById('latitude').value = latitude;
                    document.getElementById('longitude').value = longitude;
                }
            }

            // Handle location button click with translation support
            getLocationBtn.addEventListener('click', function() {
                // Set the location status with translation
                const setTranslatedLocationStatus = (messageKey) => {
                    locationStatus.textContent = translations[currentLanguage][messageKey];
                    locationStatus.dataset.messageKey = messageKey;
                    
                    // Apply RTL styling if current language is Urdu
                    if (currentLanguage === 'ur') {
                        locationStatus.style.textAlign = 'right';
                        locationStatus.style.direction = 'rtl';
                        locationStatus.setAttribute('dir', 'rtl');
                    } else {
                        locationStatus.style.textAlign = '';
                        locationStatus.style.direction = '';
                        locationStatus.setAttribute('dir', 'ltr');
                    }
                };
                
                setTranslatedLocationStatus('requestingLocationAccess');
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        // Success callback
                        function(position) {
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            
                            // Update map with location
                            updateMapLocation(longitude, latitude);
                            
                            setTranslatedLocationStatus('locationAcquired');
                            
                            // Use Mapbox Geocoding API for reverse geocoding
                            const mapboxToken = mapboxgl.accessToken;
                            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${longitude},${latitude}.json?access_token=${mapboxToken}&types=place,region`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.features && data.features.length > 0) {
                                        // Extract city and state from features
                                        let city = '';
                                        let state = '';
                                        
                                        // Process features to find city and state
                                        data.features.forEach(feature => {
                                            if (feature.place_type.includes('place')) {
                                                city = feature.text;
                                            }
                                            if (feature.place_type.includes('region')) {
                                                state = feature.text;
                                            }
                                        });
                                        
                                        // Set the values
                                        cityInput.value = city || 'Unknown city';
                                        stateInput.value = state || 'Unknown state';
                                        
                                        // Get timezone in IANA region format
                                        const regionTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                        
                                        // Special case for Pakistan
                                        let timeZoneRegion = regionTimeZone;
                                        if (data.features.some(f => f.text.includes('Islamabad') || 
                                            f.place_name.includes('Pakistan'))) {
                                            timeZoneRegion = 'Asia/Karachi';
                                        }
                                        
                                        // Get timezone offset in GMT format
                                        const date = new Date();
                                        const offsetMinutes = date.getTimezoneOffset();
                                        const offsetHours = Math.abs(Math.floor(offsetMinutes / 60));
                                        const offsetMinutesRemainder = Math.abs(offsetMinutes % 60);
                                        const offsetSign = offsetMinutes <= 0 ? '+' : '-';
                                        const gmtString = `GMT${offsetSign}${offsetHours}${offsetMinutesRemainder > 0 ? ':' + offsetMinutesRemainder.toString().padStart(2, '0') : ''}`;
                                        
                                        // Set combined timezone value
                                        timeZoneInput.value = `${timeZoneRegion} (${gmtString})`;
                                        
                                        setTranslatedLocationStatus('locationDetailsRetrieved');
                                        
                                        // Hide location alert if it's showing since location is now filled
                                        hideAlert('locationAlert');
                                        
                                        // Remove field errors if they exist
                                        removeFieldError('location_city');
                                        removeFieldError('location_state');
                                        removeFieldError('time_zone');
                                    } else {
                                        throw new Error('No location data found');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error fetching location details:', error);
                                    setTranslatedLocationStatus('errorRetrievingLocation');
                                    
                                    // Make fields editable if geocoding fails
                                    cityInput.readOnly = false;
                                    stateInput.readOnly = false;
                                    timeZoneInput.readOnly = false;
                                });
                        },
                        // Error callback
                        function(error) {
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    setTranslatedLocationStatus('locationAccessDenied');
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    setTranslatedLocationStatus('locationUnavailable');
                                    break;
                                case error.TIMEOUT:
                                    setTranslatedLocationStatus('locationTimeout');
                                    break;
                                default:
                                    setTranslatedLocationStatus('unknownLocationError');
                            }
                            
                            // Make fields editable if geolocation fails
                            cityInput.readOnly = false;
                            stateInput.readOnly = false;
                            timeZoneInput.readOnly = false;
                        }
                    );
                } else {
                    setTranslatedLocationStatus('geolocationNotSupported');
                    
                    // Make fields editable if geolocation is not supported
                    cityInput.readOnly = false;
                    stateInput.readOnly = false;
                    timeZoneInput.readOnly = false;
                }
            });

            // DAMAGE OTHER FIELD TOGGLE
            const damageOtherCheckbox = document.getElementById('damage_other');
            const otherDamageContainer = document.getElementById('otherDamageContainer');
            
            if (damageOtherCheckbox && otherDamageContainer) {
                damageOtherCheckbox.addEventListener('change', function() {
                    otherDamageContainer.style.display = this.checked ? 'block' : 'none';
                    
                    // Make the textarea required only when "Other" is checked
                    const otherDamageDescription = document.getElementById('other_damage_description');
                    if (otherDamageDescription) {
                        otherDamageDescription.required = this.checked;
                    }
                });
            }

            // ENHANCED FILE UPLOAD HANDLING
            
            // Enhanced file upload handling
            const fileInput = document.getElementById('media_files');
            const fileUploadZone = document.getElementById('fileUploadZone');
            const selectedFilesGrid = document.getElementById('selectedFilesGrid');
            const selectedFileCount = document.getElementById('selectedFileCount');
            const filesGrid = document.getElementById('filesGrid');
            const clearAllFilesBtn = document.getElementById('clearAllFiles');
            const uploadProgressContainer = document.getElementById('uploadProgressContainer');
            const uploadProgressBar = document.getElementById('uploadProgressBar');
            const uploadProgressText = document.getElementById('uploadProgressText');

            let uploadedFiles = [];

            // Drag and drop functionality
            fileUploadZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('drag-over');
            });

            fileUploadZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
            });

            fileUploadZone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('drag-over');
                
                const files = Array.from(e.dataTransfer.files);
                addFiles(files);
            });

            // Handle file selection via click or browse
            fileInput.addEventListener('change', function() {
                const files = Array.from(this.files);
                addFiles(files);
            });

            // Add files to the upload queue
            function addFiles(files) {
                const invalidFiles = [];
                const oversizedFiles = [];
                const validFiles = [];
                
                files.forEach(file => {
                    // Validate file size (10MB limit)
                    if (file.size > 10 * 1024 * 1024) {
                        oversizedFiles.push(file.name);
                        return;
                    }
                    
                    // Validate file type - only allow specific formats
                    const allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    const allowedVideoTypes = ['video/mp4', 'video/mov', 'video/quicktime'];
                    const allowedTypes = [...allowedImageTypes, ...allowedVideoTypes];
                    
                    if (!allowedTypes.includes(file.type.toLowerCase())) {
                        invalidFiles.push(file.name);
                        return;
                    }
                    
                    validFiles.push(file);
                });
                
                // Show media file alert if there are invalid files
                if (invalidFiles.length > 0 || oversizedFiles.length > 0) {
                    showMediaFileAlert(invalidFiles, oversizedFiles);
                } else {
                    hideAlert('mediaFileAlert');
                }
                
                // Add only valid files to upload queue
                validFiles.forEach(file => {
                    uploadedFiles.push({
                        file: file,
                        id: Date.now() + Math.random(),
                        preview: null
                    });
                });
                
                if (validFiles.length > 0) {
                    updateFilesUI();
                    simulateUploadProgress();
                }
            }

            // Simulate upload progress (for demo purposes)
            function simulateUploadProgress() {
                if (uploadedFiles.length === 0) return;
                
                uploadProgressContainer.style.display = 'flex';
                let progress = 0;
                
                const interval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(interval);
                        setTimeout(() => {
                            uploadProgressContainer.style.display = 'none';
                        }, 1000);
                    }
                    
                    uploadProgressBar.style.width = progress + '%';
                    uploadProgressText.textContent = Math.round(progress) + '%';
                }, 100);
            }

            // Update files UI
            function updateFilesUI() {
                if (uploadedFiles.length > 0) {
                    selectedFilesGrid.style.display = 'block';
                    selectedFileCount.textContent = uploadedFiles.length;
                    
                    // Clear existing grid
                    filesGrid.innerHTML = '';
                    
                    uploadedFiles.forEach((fileObj) => {
                        createFileCard(fileObj);
                    });
                } else {
                    selectedFilesGrid.style.display = 'none';
                    filesGrid.innerHTML = '';
                }
            }

            // Create file card
            function createFileCard(fileObj) {
                const file = fileObj.file;
                const fileId = fileObj.id;
                
                const fileCard = document.createElement('div');
                fileCard.className = 'file-card';
                fileCard.dataset.fileId = fileId;
                
                // File preview
                const filePreview = document.createElement('div');
                filePreview.className = 'file-preview';
                
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = file.name;
                        filePreview.appendChild(img);
                        fileObj.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else if (file.type.match('video.*')) {
                    const videoIcon = document.createElement('i');
                    videoIcon.className = 'bi bi-play-circle-fill file-icon';
                    filePreview.appendChild(videoIcon);
                } else {
                    const fileIcon = document.createElement('i');
                    fileIcon.className = 'bi bi-file-earmark file-icon';
                    filePreview.appendChild(fileIcon);
                }
                
                // File info
                const fileInfo = document.createElement('div');
                fileInfo.className = 'file-info';
                
                const fileName = document.createElement('h6');
                fileName.className = 'file-name';
                fileName.textContent = file.name.length > 20 ? file.name.substring(0, 20) + '...' : file.name;
                fileName.title = file.name;
                
                const fileSize = document.createElement('p');
                fileSize.className = 'file-size';
                fileSize.textContent = formatFileSize(file.size);
                
                // File actions
                const fileActions = document.createElement('div');
                fileActions.className = 'file-actions';
                
                const removeBtn = document.createElement('button');
                removeBtn.className = 'file-action-btn remove-file-btn';
                removeBtn.innerHTML = '<i class="bi bi-trash"></i> Remove';
                removeBtn.addEventListener('click', () => removeFile(fileId));
                
                fileActions.appendChild(removeBtn);
                
                fileInfo.appendChild(fileName);
                fileInfo.appendChild(fileSize);
                fileInfo.appendChild(fileActions);
                
                fileCard.appendChild(filePreview);
                fileCard.appendChild(fileInfo);
                
                filesGrid.appendChild(fileCard);
            }

            // Remove individual file
            function removeFile(fileId) {
                const fileIndex = uploadedFiles.findIndex(f => f.id === fileId);
                if (fileIndex !== -1) {
                    uploadedFiles.splice(fileIndex, 1);
                    updateFilesUI();
                }
            }

            // Clear all files
            clearAllFilesBtn.addEventListener('click', function() {
                if (uploadedFiles.length > 0) {
                    uploadedFiles = [];
                    updateFilesUI();
                    fileInput.value = '';
                }
            });

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Get file type icon
            function getFileTypeIcon(fileType) {
                if (fileType.match('image.*')) return 'bi-image';
                if (fileType.match('video.*')) return 'bi-play-circle-fill';
                return 'bi-file-earmark';
            }

            // FORM VALIDATION WITH CARD-BASED ALERTS
            
            // Weather phenomena incompatibility logic (real-time check)
            const dustStormCheckbox = document.getElementById('weather_duststorm');
            const fogCheckbox = document.getElementById('weather_fog');

            function checkWeatherIncompatibility() {
                if (dustStormCheckbox && fogCheckbox) {
                    if (dustStormCheckbox.checked && fogCheckbox.checked) {
                        showAlert('weatherIncompatibilityAlert');
                        return false;
                    } else {
                        hideAlert('weatherIncompatibilityAlert');
                        return true;
                    }
                }
                return true;
            }

            // Real-time incompatibility checking
            if (dustStormCheckbox && fogCheckbox) {
                dustStormCheckbox.addEventListener('change', checkWeatherIncompatibility);
                fogCheckbox.addEventListener('change', checkWeatherIncompatibility);
            }
            
            // Form validation is now handled by global validateForm function
            
            // Real-time field validation to remove errors when fixed
            function setupRealTimeValidation() {
                // Personal details fields
                const personalFields = ['personal_name', 'personal_phone', 'personal_email'];
                personalFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.addEventListener('input', function() {
                            if (this.value.trim() && this.classList.contains('field-error')) {
                                removeFieldError(fieldId);
                                
                                // Check if all personal fields are now valid
                                const allPersonalValid = personalFields.every(id => {
                                    const f = document.getElementById(id);
                                    return f && f.value.trim();
                                });
                                
                                if (allPersonalValid) {
                                    hideAlert('personalDetailsAlert');
                                }
                            }
                        });
                    }
                });
                
                // Event date and time fields
                const dateTimeFields = ['event_date', 'event_time'];
                dateTimeFields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.addEventListener('change', function() {
                            if (this.value.trim() && this.classList.contains('field-error')) {
                                removeFieldError(fieldId);
                                
                                // Check if all date/time fields are now valid
                                const allDateTimeValid = dateTimeFields.every(id => {
                                    const f = document.getElementById(id);
                                    return f && f.value.trim();
                                });
                                
                                if (allDateTimeValid) {
                                    hideAlert('eventDateTimeAlert');
                                }
                            }
                        });
                    }
                });
                
                // Weather types
                const weatherTypes = document.querySelectorAll('.weather-type');
                weatherTypes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const checkedWeatherTypes = document.querySelectorAll('.weather-type:checked');
                        if (checkedWeatherTypes.length > 0) {
                            hideAlert('weatherPhenomenaAlert');
                        }
                    });
                });
                
                // Other damage description
                const otherDamageDescription = document.getElementById('other_damage_description');
                if (otherDamageDescription) {
                    otherDamageDescription.addEventListener('input', function() {
                        if (this.value.trim() && this.classList.contains('field-error')) {
                            removeFieldError('other_damage_description');
                            hideAlert('otherDamageAlert');
                        }
                    });
                }
            }
            
            // Initialize real-time validation
            setupRealTimeValidation();

            // Enhanced Form validation with loading animation and file upload handling
            const weatherObservationForm = document.getElementById('weatherObservationForm');
            const submitButton = weatherObservationForm?.querySelector('button[type="submit"]');
            
            if (weatherObservationForm) {
                let isSubmitting = false; // Flag to track submission state
                
                weatherObservationForm.addEventListener('submit', function(event) {
                    console.log('Form submit event triggered'); // Debug log
                    
                    // Prevent double submission
                    if (isSubmitting) {
                        console.log('Form already submitting, preventing double submission'); // Debug log
                        event.preventDefault();
                        return false;
                    }
                    
                    // Run comprehensive form validation
                    try {
                        console.log('Running form validation...'); // Debug log
                        const isValid = validateForm();
                        console.log('Validation result:', isValid); // Debug log
                        
                        if (!isValid) {
                            console.log('Form validation failed, preventing submission'); // Debug log
                            event.preventDefault();
                            return false;
                        }
                    } catch (error) {
                        console.error('Error during form validation:', error);
                        event.preventDefault();
                        return false;
                    }
                    
                    // Set submission flag
                    isSubmitting = true;
                    
                    // Add loading state to submit button
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.classList.add('btn-loading');
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Submitting...';
                        
                        // Store original text for potential reset
                        submitButton.setAttribute('data-original-text', originalText);
                        
                        // Prevent any clicking on the button
                        submitButton.style.pointerEvents = 'none';
                        submitButton.style.opacity = '0.7';
                    }
                    
                    // Handle custom file uploads if any files are selected
                    if (uploadedFiles.length > 0) {
                        event.preventDefault();
                        
                        const formData = new FormData(this);
                        
                        // Remove the original file input data and add our custom files
                        formData.delete('media_files[]');
                        
                        uploadedFiles.forEach(fileObj => {
                            formData.append('media_files[]', fileObj.file);
                        });
                        
                        // Submit via fetch
                        fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Form submission failed');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else {
                                alert('Weather observation submitted successfully!');
                                weatherObservationForm.reset();
                                uploadedFiles.length = 0;
                                updateFilesUI();
                                // Reset form state
                                isSubmitting = false;
                                if (submitButton) {
                                    const originalText = submitButton.getAttribute('data-original-text');
                                    if (originalText) {
                                        submitButton.innerHTML = originalText;
                                        submitButton.disabled = false;
                                        submitButton.style.pointerEvents = '';
                                        submitButton.style.opacity = '';
                                        submitButton.classList.remove('btn-loading');
                                    }
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error submitting form:', error);
                            alert('An error occurred while submitting the form. Please try again.');
                            // Reset form state
                            isSubmitting = false;
                            if (submitButton) {
                                const originalText = submitButton.getAttribute('data-original-text');
                                if (originalText) {
                                    submitButton.innerHTML = originalText;
                                    submitButton.disabled = false;
                                    submitButton.style.pointerEvents = '';
                                    submitButton.style.opacity = '';
                                    submitButton.classList.remove('btn-loading');
                                }
                            }
                        });
                    } else {
                        // No custom files, proceed with normal form submission
                        // Reset submission state if form fails to submit (e.g., validation errors)
                        setTimeout(() => {
                            // Only reset if the page hasn't been redirected
                            if (document.contains(submitButton) && isSubmitting) {
                                const originalText = submitButton.getAttribute('data-original-text');
                                if (originalText) {
                                    submitButton.innerHTML = originalText;
                                    submitButton.disabled = false;
                                    submitButton.style.pointerEvents = '';
                                    submitButton.style.opacity = '';
                                    submitButton.classList.remove('btn-loading');
                                    isSubmitting = false;
                                }
                            }
                        }, 5000); // Reset after 5 seconds if no redirect
                    }
                });
                
                // Also prevent double submission on Enter key press
                weatherObservationForm.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' && isSubmitting) {
                        event.preventDefault();
                        return false;
                    }
                });
            }

            // LANGUAGE SELECTION HANDLING
            
            // Handle language selection (let Bootstrap handle dropdown behavior)
            languageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const language = this.dataset.language;
                    applyTranslations(language);
                });
            });

            // Initialize with English
            applyTranslations('en');
        });
    </script>

@endpush