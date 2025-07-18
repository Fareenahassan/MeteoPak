@extends('layouts.app')

@push('styles')
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
        overflow: visible;
        z-index: 10;
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
        z-index: 1050;
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
    
    .btn-lg {
        font-size: 1.1rem;
        padding: 1rem 2rem;
    }
    
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
    
    /* Location Map Styling */
    #locationMap {
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 173, 81, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    #locationMap:hover {
        box-shadow: var(--card-hover-shadow);
        border-color: rgba(255, 173, 81, 0.2);
    }
    
    [data-theme="dark"] #locationMap {
        border-color: rgba(255, 173, 81, 0.2);
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
        
        /* Responsive map adjustments */
        #locationMap {
            height: 280px !important;
            min-height: 250px !important;
            margin-top: 1rem;
        }
    }
    
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
    
    #locationMap {
        border-radius: var(--border-radius);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 2px solid rgba(255, 173, 81, 0.1);
        overflow: hidden;
    }
    
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
    
    #locationStatus {
        color: var(--body-text);
        font-weight: 500;
        padding: 0.5rem 0;
    }
    
    [data-theme="dark"] #locationStatus {
        color: var(--theme-text-secondary, #adb5bd);
    }
    
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
    
    ::selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
    ::-moz-selection {
        background: rgba(255, 173, 81, 0.2);
        color: var(--heading-color);
    }
    
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

    /* RTL Language Support - Enhanced Implementation */
    html[dir="rtl"],
    .rtl-active {
        direction: rtl !important;
        text-align: right !important;
    }
    
    /* Global RTL reset for all text elements */
    html[dir="rtl"] *:not(.navbar):not(.navbar *),
    .rtl-active *:not(.navbar):not(.navbar *) {
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
    
    /* Card body content RTL */
    html[dir="rtl"] .card-body,
    html[dir="rtl"] .card-body *,
    body.rtl-active .card-body,
    body.rtl-active .card-body * {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Row and column RTL adjustments */
    html[dir="rtl"] .row,
    body.rtl-active .row {
        direction: rtl !important;
    }
    
    html[dir="rtl"] .col-md-6,
    html[dir="rtl"] .col-md-3,
    html[dir="rtl"] .col-md-12,
    body.rtl-active .col-md-6,
    body.rtl-active .col-md-3,
    body.rtl-active .col-md-12 {
        direction: rtl !important;
        text-align: right !important;
    }
    
    /* Button alignment RTL */
    html[dir="rtl"] .d-grid.gap-2.d-md-flex.justify-content-md-end,
    body.rtl-active .d-grid.gap-2.d-md-flex.justify-content-md-end {
        justify-content: flex-start !important;
        direction: rtl !important;
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
    body.rtl-active input[type="date"].form-control,
    body.rtl-active input[type="time"].form-control {
        text-align: right !important;
        direction: rtl !important;
    }
    
    /* Ensure all paragraphs and text elements are RTL */
    html[dir="rtl"] p,
    html[dir="rtl"] span,
    html[dir="rtl"] div:not(.navbar):not(.navbar *),
    html[dir="rtl"] label,
    html[dir="rtl"] h1, html[dir="rtl"] h2, html[dir="rtl"] h3, html[dir="rtl"] h4, html[dir="rtl"] h5, html[dir="rtl"] h6,
    body.rtl-active p,
    body.rtl-active span,
    body.rtl-active div:not(.navbar):not(.navbar *),
    body.rtl-active label,
    body.rtl-active h1, body.rtl-active h2, body.rtl-active h3, body.rtl-active h4, body.rtl-active h5, body.rtl-active h6 {
        text-align: right !important;
        direction: rtl !important;
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

    /* Enhanced Card-based Alert System */
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
    
    /* RTL support for card alerts */
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

    /* Field validation styles for enhanced system */
    .field-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        animation: shake 0.4s ease-in-out;
    }
    
    [data-theme="dark"] .field-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.4) !important;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
        20%, 40%, 60%, 80% { transform: translateX(2px); }
    }

    /* Form Validation Styles */
    .field-container {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-control.is-invalid {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6.4.4.4-.4M5.8 8.4l.4-.4.4.4M3.6 5.8l.4.4-.4.4M8.4 5.8l-.4.4.4.4'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        padding-right: 3rem !important;
    }

    [data-theme="dark"] .form-control.is-invalid {
        background-color: var(--theme-bg-secondary, #3a3636) !important;
        color: var(--theme-text-primary, #ffffff) !important;
    }

    .form-control.is-valid {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.54-.54L4.5 7.84l2.66-2.66.54.54L4.5 8.92z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
        padding-right: 3rem !important;
    }

    [data-theme="dark"] .form-control.is-valid {
        background-color: var(--theme-bg-secondary, #3a3636) !important;
        color: var(--theme-text-primary, #ffffff) !important;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #dc3545;
        background: rgba(220, 53, 69, 0.08);
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-radius: 8px;
        position: relative;
        animation: fadeInError 0.3s ease-out;
    }

    [data-theme="dark"] .invalid-feedback {
        color: #ff6b7a;
        background: rgba(220, 53, 69, 0.15);
        border-color: rgba(220, 53, 69, 0.3);
    }

    .invalid-feedback::before {
        content: '';
        position: absolute;
        top: -5px;
        left: 1rem;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 5px solid rgba(220, 53, 69, 0.2);
    }

    /* Valid feedback is no longer used - we use subtle visual indicators only */

    @keyframes fadeInError {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* fadeInSuccess animation removed - no longer needed */

    /* Weather Type Validation */
    .weather-types-container.has-error {
        border: 2px solid #dc3545;
        border-radius: 12px;
        padding: 1rem;
        background: rgba(220, 53, 69, 0.05);
        animation: shake 0.5s ease-in-out;
    }

    [data-theme="dark"] .weather-types-container.has-error {
        background: rgba(220, 53, 69, 0.1);
    }

    /* Weather Type Success */
    .weather-types-container.has-success {
        border: 2px solid #28a745;
        border-radius: 12px;
        padding: 1rem;
        background: rgba(40, 167, 69, 0.05);
        transition: all 0.3s ease;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
    }

    [data-theme="dark"] .weather-types-container.has-success {
        background: rgba(40, 167, 69, 0.1);
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* Loading State for Form */
    .form-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }

    .form-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        border-radius: 20px;
    }

    [data-theme="dark"] .form-loading::after {
        background: rgba(47, 43, 43, 0.8);
    }

    /* Alert Styles */
    .alert {
        border: none;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
        position: relative;
        overflow: hidden;
        animation: slideInAlert 0.4s ease-out;
    }

    .alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
    }

    .alert-danger {
        color: #721c24;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.1) 0%, 
            rgba(220, 53, 69, 0.05) 100%);
        border-left: 4px solid #dc3545;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
    }

    [data-theme="dark"] .alert-danger {
        color: #ff6b7a;
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.2) 0%, 
            rgba(220, 53, 69, 0.1) 100%);
    }

    .alert-success {
        color: #155724;
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.1) 0%, 
            rgba(40, 167, 69, 0.05) 100%);
        border-left: 4px solid #28a745;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
    }

    [data-theme="dark"] .alert-success {
        color: #5dbc6a;
        background: linear-gradient(135deg, 
            rgba(40, 167, 69, 0.2) 0%, 
            rgba(40, 167, 69, 0.1) 100%);
    }

    .alert-warning {
        color: #856404;
        background: linear-gradient(135deg, 
            rgba(255, 193, 7, 0.1) 0%, 
            rgba(255, 193, 7, 0.05) 100%);
        border-left: 4px solid #ffc107;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15);
    }

    [data-theme="dark"] .alert-warning {
        color: #ffe066;
        background: linear-gradient(135deg, 
            rgba(255, 193, 7, 0.2) 0%, 
            rgba(255, 193, 7, 0.1) 100%);
    }

    @keyframes slideInAlert {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        font-weight: bold;
        color: currentColor;
        opacity: 0.7;
        cursor: pointer;
        padding: 0;
        margin-left: auto;
        transition: opacity 0.3s ease;
    }

    .alert .btn-close:hover {
        opacity: 1;
    }

    /* Form Progress Indicator */
    .form-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
        z-index: 10000;
        transition: width 0.3s ease;
    }

    /* Validation Summary */
    .validation-summary {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.08) 0%, 
            rgba(220, 53, 69, 0.05) 100%);
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: none;
    }

    [data-theme="dark"] .validation-summary {
        background: linear-gradient(135deg, 
            rgba(220, 53, 69, 0.15) 0%, 
            rgba(220, 53, 69, 0.1) 100%);
        border-color: rgba(220, 53, 69, 0.3);
    }

    .validation-summary h5 {
        color: #dc3545;
        margin-bottom: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    [data-theme="dark"] .validation-summary h5 {
        color: #ff6b7a;
    }

    .validation-summary ul {
        margin: 0;
        padding-left: 1.5rem;
        list-style-type: none;
    }

    .validation-summary li {
        margin-bottom: 0.5rem;
        color: #721c24;
        font-weight: 500;
        position: relative;
    }

    [data-theme="dark"] .validation-summary li {
        color: #ff6b7a;
    }

    .validation-summary li::before {
        content: '•';
        color: #dc3545;
        font-weight: bold;
        position: absolute;
        left: -1rem;
    }

    [data-theme="dark"] .validation-summary li::before {
        color: #ff6b7a;
    }
</style>
@endpush

@section('content')
    <!-- Form Progress Indicator -->
    <div class="form-progress" id="formProgress"></div>
    
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

        <!-- Validation Summary -->
        <div class="validation-summary" id="validationSummary">
            <h5>
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="validationSummaryTitle">Please correct the following errors:</span>
            </h5>
            <ul id="validationSummaryList"></ul>
        </div>

            <form id="weatherObservationForm" method="POST" action="{{ route('weather.observation.store') }}" enctype="multipart/form-data" data-no-protection="true" novalidate>
        @csrf
        
            <!-- Location Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="200">
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
                                <div class="card-alert-title">Location information required</div>
                                <div class="card-alert-message">Please click "Get My Current Location" button to automatically detect and fill your location details.</div>
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
                            <div id="locationMap" style="width: 100%; height: 400px; border-radius: 12px; min-height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Event Date and Time Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="300">
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
                                <div class="card-alert-title">Event date and time required</div>
                                <div class="card-alert-message">Please provide the date and time when the weather event occurred:</div>
                                <ul class="card-alert-list" id="eventDateTimeErrorList"></ul>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('eventDateTimeAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Future Date Alert -->
                    <div class="card-alert alert-warning" id="futureDateAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="card-alert-text">
                                <div class="card-alert-title" data-translate="futureDateTitle">Future date not allowed</div>
                                <div class="card-alert-message" data-translate="futureDateMessage">Weather events cannot be reported for future dates. Please select today's date or an earlier date.</div>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('futureDateAlert')">
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
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="400">
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
                                <div class="card-alert-title">Weather type selection required</div>
                                <div class="card-alert-message">Please select at least one weather phenomenon that you observed.</div>
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
                                <div class="card-alert-title">Incompatible weather types</div>
                                <div class="card-alert-message">Duststorm and Fog cannot occur simultaneously. Please select only one of these options.</div>
                            </div>
                            <button type="button" class="card-alert-close" onclick="hideAlert('weatherIncompatibilityAlert')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="weather-types-container" id="weatherTypesContainer">
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
                        <div id="weatherTypeError" class="invalid-feedback mt-3" style="display: none;">
                            Duststorm and Fog cannot be selected together.
                        </div>
                        <div id="weatherTypeRequiredError" class="invalid-feedback mt-3" style="display: none;">
                            Please select at least one weather phenomenon.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Damage Caused Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="500">
                <div class="card-header">
                    <h3>Damage Caused</h3>
                    <p class="text-muted">Select all that apply</p>
                </div>
                <div class="card-body">
                    <!-- Other Damage Alert (only shown when Other is selected but no description provided) -->
                    <div class="card-alert alert-danger" id="otherDamageAlert">
                        <div class="card-alert-content">
                            <div class="card-alert-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="card-alert-text">
                                <div class="card-alert-title">Description required</div>
                                <div class="card-alert-message">You selected "Other" damage. Please provide a description of the damage in the text area below.</div>
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
                                <input class="form-check-input" type="checkbox" id="damage_billboard" name="damages[]" value="billboard_signboard_damage">
                                <label class="form-check-label" for="damage_billboard">Billboard/Signboard damage</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_roof" name="damages[]" value="roof_damage">
                                <label class="form-check-label" for="damage_roof">Roof damage</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_vehicle" name="damages[]" value="vehicle_damage">
                                <label class="form-check-label" for="damage_vehicle">Vehicle damage</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_window" name="damages[]" value="window_damage">
                                <label class="form-check-label" for="damage_window">Window damage</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_crops" name="damages[]" value="crop_damage">
                                <label class="form-check-label" for="damage_crops">Crop damage</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_livestock" name="damages[]" value="livestock_injury">
                                <label class="form-check-label" for="damage_livestock">Livestock injury/death</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_human" name="damages[]" value="human_injury">
                                <label class="form-check-label" for="damage_human">Human injury/fatality</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_power" name="damages[]" value="power_disruption">
                                <label class="form-check-label" for="damage_power">Power disruption</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_traffic" name="damages[]" value="traffic_disruption">
                                <label class="form-check-label" for="damage_traffic">Traffic disruption</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_flight" name="damages[]" value="flight_disruption">
                                <label class="form-check-label" for="damage_flight">Flight disruption</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_communication" name="damages[]" value="communication_disruption">
                                <label class="form-check-label" for="damage_communication">Communication disruption</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_flooding" name="damages[]" value="flooding">
                                <label class="form-check-label" for="damage_flooding">Flooding</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_other" name="damages[]" value="other_damage">
                                <label class="form-check-label" for="damage_other">Other</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="damage_none" name="damages[]" value="no_damage">
                                <label class="form-check-label" for="damage_none">No damage</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Other damage details field -->
                    <div class="mt-3" id="other_damage_details_wrapper" style="display: none;">
                        <label for="other_damage_details" class="form-label">Please specify other damage details:</label>
                        <textarea class="form-control" id="other_damage_details" name="other_damage_details" rows="3" placeholder="Describe the other damage..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Event Description Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="600">
                <div class="card-header">
                    <h3>Event Description</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="event_description" class="form-label">
                            <i class="bi bi-file-text"></i>
                            Brief Description of the Weather Event
                        </label>
                        <textarea class="form-control" id="event_description" name="event_description" rows="4" placeholder="Describe what you observed during the weather event..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Media Upload Section -->
            <div class="card mb-4" data-aos="fade-up" data-aos-delay="700">
                <div class="card-header">
                    <h3>Media Upload</h3>
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
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-4" data-aos="fade-up" data-aos-delay="800">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease-out-quart',
                once: true,
                offset: 50,
                delay: 100
            });

            console.log('Weather observation form loaded');
        
        // Check if mapboxgl is loaded
        if (typeof mapboxgl === 'undefined') {
            console.error('Mapbox GL JS not loaded');
            const statusDiv = document.getElementById('locationStatus');
            statusDiv.textContent = translations[currentLanguage]['mapServiceUnavailable'];
            statusDiv.dataset.messageKey = 'mapServiceUnavailable';
            statusDiv.className = 'text-danger';
            return;
        }

        // Initialize map with error handling
        try {
            mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';
            
            const map = new mapboxgl.Map({
                container: 'locationMap',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [0, 0], // Default center (will be updated)
                zoom: 1 // Default zoom (will be updated)
            });

            let marker;

            // Wait for map to load
            map.on('load', function() {
                console.log('Map loaded successfully');
            });

            map.on('error', function(e) {
                console.error('Map error:', e);
                const statusDiv = document.getElementById('locationStatus');
                statusDiv.textContent = translations[currentLanguage]['mapLoadingFailed'];
                statusDiv.dataset.messageKey = 'mapLoadingFailed';
                statusDiv.className = 'text-danger';
            });

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

            // Get location button handler
            document.getElementById('getLocationBtn').addEventListener('click', function() {
                const statusDiv = document.getElementById('locationStatus');
                const button = this;
                
                button.disabled = true;
                button.textContent = 'Getting location...';
                statusDiv.textContent = 'Requesting location access...';
                statusDiv.className = 'text-muted';
                
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            console.log('Location obtained:', position.coords);
                            
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            // Update map
                            updateMapLocation(lng, lat);
                            
                            // Reverse geocoding
                            fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}`)
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Geocoding request failed');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Geocoding data:', data);
                                    
                                    if (data.features && data.features.length > 0) {
                                        const feature = data.features[0];
                                        const context = feature.context || [];
                                        
                                        // Extract city and state
                                        let city = '';
                                        let state = '';
                                        
                                        // Try to get from place name first
                                        if (feature.place_name) {
                                            const parts = feature.place_name.split(', ');
                                            city = parts[0] || '';
                                            state = parts[1] || '';
                                        }
                                        
                                        // Fill in missing info from context
                                        context.forEach(ctx => {
                                            if (ctx.id.includes('place') && !city) {
                                                city = ctx.text;
                                            }
                                            if (ctx.id.includes('region') && !state) {
                                                state = ctx.text;
                                            }
                                        });
                                        
                                        document.getElementById('location_city').value = city;
                                        document.getElementById('location_state').value = state;
                                        
                                        // Get timezone
                                        const timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
                                        document.getElementById('time_zone').value = timeZone;
                                        
                                        // Hide location alert since location fields are now filled
                                        hideAlert('locationAlert');
                                        
                                        // Apply success styling to all location fields
                                        ['location_city', 'location_state', 'time_zone'].forEach(fieldId => {
                                            const field = document.getElementById(fieldId);
                                            if (field) {
                                                field.classList.remove('field-error');
                                                showFieldSuccess(field);
                                            }
                                        });
                                        
                                        setTranslatedStatus('locationDetailsRetrieved');
                                        statusDiv.className = 'text-success';
                                        
                                        setTranslatedButtonText('locationRetrieved');
                                        button.disabled = false;
                                        button.classList.remove('btn-primary');
                                        button.classList.add('btn-success');
                                        
                                        // Trigger location validation
                                        validateLocation();
                                    } else {
                                        throw new Error('No location data found');
                                    }
                                })
                                .catch(error => {
                                    console.error('Geocoding error:', error);
                                    setTranslatedStatus('errorRetrievingLocation');
                                    statusDiv.className = 'text-warning';
                                    
                                    button.disabled = false;
                                    setTranslatedButtonText('getMyCurrentLocation');
                                });
                        },
                        function(error) {
                            console.error('Geolocation error:', error);
                            
                            let errorMessageKey = 'unknownLocationError';
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessageKey = 'locationAccessDenied';
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessageKey = 'locationUnavailable';
                                    break;
                                case error.TIMEOUT:
                                    errorMessageKey = 'locationTimeout';
                                    break;
                            }
                            
                            setTranslatedStatus(errorMessageKey);
                            statusDiv.className = 'text-danger';
                            button.disabled = false;
                            setTranslatedButtonText('getMyCurrentLocation');
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 60000
                        }
                    );
                } else {
                    setTranslatedStatus('geolocationNotSupported');
                    statusDiv.className = 'text-danger';
                    button.disabled = false;
                    setTranslatedButtonText('getMyCurrentLocation');
                }
            });

        } catch (error) {
            console.error('Map initialization error:', error);
            const statusDiv = document.getElementById('locationStatus');
            statusDiv.textContent = translations[currentLanguage]['mapInitializationFailed'];
            statusDiv.dataset.messageKey = 'mapInitializationFailed';
            statusDiv.className = 'text-danger';
        }

        // Weather type incompatibility check
        function checkIncompatibility() {
            const group1 = document.querySelectorAll('.incompatible-group-1:checked');
            if (group1.length > 1) {
                document.getElementById('weatherTypeError').style.display = 'block';
                return false;
            }
            document.getElementById('weatherTypeError').style.display = 'none';
            return true;
        }

        // Add event listeners to weather type checkboxes
        document.querySelectorAll('.weather-type').forEach(checkbox => {
            checkbox.addEventListener('change', checkIncompatibility);
        });

        // Damage handling
        const damageCheckboxes = document.querySelectorAll('input[name="damages[]"]');
        const otherDamageCheckbox = document.getElementById('damage_other');
        const noDamageCheckbox = document.getElementById('damage_none');
        const otherDamageWrapper = document.getElementById('other_damage_details_wrapper');

        damageCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this === noDamageCheckbox && this.checked) {
                    // Uncheck all other damage checkboxes
                    damageCheckboxes.forEach(cb => {
                        if (cb !== noDamageCheckbox) {
                            cb.checked = false;
                        }
                    });
                    otherDamageWrapper.style.display = 'none';
                } else if (this !== noDamageCheckbox && this.checked) {
                    // Uncheck "No damage"
                    noDamageCheckbox.checked = false;
                }

                // Show/hide other damage details
                otherDamageWrapper.style.display = otherDamageCheckbox.checked ? 'block' : 'none';
            });
        });

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
        const languageButtons = document.querySelectorAll('[data-language]');

        let uploadedFiles = [];

        // Drag and drop functionality
        if (fileUploadZone) {
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
        }

        // Handle file selection via click or browse
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const files = Array.from(this.files);
                addFiles(files);
            });
        }

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
                
                // Trigger file validation update
                validateUploadedFiles();
                updateValidationSummary();
                updateFormProgress();
            }
        }

        // Simulate upload progress (for demo purposes)
        function simulateUploadProgress() {
            if (uploadedFiles.length === 0 || !uploadProgressContainer) return;
            
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
                
                if (uploadProgressBar) uploadProgressBar.style.width = progress + '%';
                if (uploadProgressText) uploadProgressText.textContent = Math.round(progress) + '%';
            }, 100);
        }

        // Update files UI
        function updateFilesUI() {
            if (uploadedFiles.length > 0) {
                if (selectedFilesGrid) selectedFilesGrid.style.display = 'block';
                if (selectedFileCount) selectedFileCount.textContent = uploadedFiles.length;
                
                // Clear existing grid
                if (filesGrid) filesGrid.innerHTML = '';
                
                uploadedFiles.forEach((fileObj) => {
                    createFileCard(fileObj);
                });
            } else {
                if (selectedFilesGrid) selectedFilesGrid.style.display = 'none';
                if (filesGrid) filesGrid.innerHTML = '';
            }
        }

        // Create file card
        function createFileCard(fileObj) {
            if (!filesGrid) return;
            
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
        if (clearAllFilesBtn) {
            clearAllFilesBtn.addEventListener('click', function() {
                if (uploadedFiles.length > 0) {
                    uploadedFiles = [];
                    updateFilesUI();
                    if (fileInput) fileInput.value = '';
                }
            });
        }

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

        // Form submission handling
        const weatherObservationForm = document.getElementById('weatherObservationForm');
        if (weatherObservationForm) {
            let isSubmitting = false; // Flag to track submission state
            
            weatherObservationForm.addEventListener('submit', function(event) {
                // Prevent double submission
                if (isSubmitting) {
                    event.preventDefault();
                    return false;
                }
                
                // Validate entire form before submission
                if (!validateForm()) {
                    event.preventDefault();
                    
                    // Scroll to first card with validation alert
                    const firstCardAlert = document.querySelector('.card-validation-alert');
                    if (firstCardAlert) {
                        firstCardAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        // Fallback to first error field
                        const firstError = document.querySelector('.is-invalid, .has-error');
                        if (firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                    return false;
                }
                
                if (!checkIncompatibility()) {
                    event.preventDefault();
                    return false;
                }
                
                // Set submission flag
                isSubmitting = true;
                
                // Show loading state
                const form = document.getElementById('weatherObservationForm');
                form.classList.add('form-loading');
                showFormAlert(getValidationMessage('submittingForm'), 'warning');
                
                if (uploadedFiles.length > 0) {
                    const formData = new FormData(this);
                    
                    formData.delete('media_files[]');
                    
                    uploadedFiles.forEach(fileObj => {
                        formData.append('media_files[]', fileObj.file);
                    });
                    
                    event.preventDefault();
                    
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
                        submitBtn.style.pointerEvents = 'none';
                        submitBtn.style.opacity = '0.7';
                        submitBtn.setAttribute('data-original-text', originalText);
                    }
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Raw server response:', response);
                        
                        if (!response.ok) {
                            throw new Error(`Form submission failed with status: ${response.status}`);
                        }
                        
                        // Check if response is JSON
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json();
                        } else {
                            // If not JSON, it might be a redirect or HTML response
                            console.warn('Server returned non-JSON response, likely a redirect');
                            
                            // Check if it's a redirect
                            if (response.redirected) {
                                window.location.href = response.url;
                                return;
                            }
                            
                            // Return a success object for non-JSON responses
                            return { 
                                success: true, 
                                message: 'Form submitted successfully!',
                                reset_form: true 
                            };
                        }
                    })
                    .then(data => {
                        console.log('Server response:', data);
                        
                        if (data.success === false) {
                            // Handle server-side validation errors
                            throw new Error(data.message || 'Server validation failed');
                        } else if (data.redirect) {
                            // Redirect if URL is provided
                            window.location.href = data.redirect;
                        } else if (data.success === true || data.message) {
                            // Show success message but don't reset form immediately
                            alert(data.message || 'Weather observation submitted successfully!');
                            
                            // Only reset form if explicitly told to do so or after user confirmation
                            if (data.reset_form !== false) {
                                weatherObservationForm.reset();
                                uploadedFiles.length = 0;
                                updateFilesUI();
                            }
                            
                            // Reset form state
                            isSubmitting = false;
                            if (submitBtn) {
                                const originalText = submitBtn.getAttribute('data-original-text');
                                if (originalText) {
                                    submitBtn.innerHTML = originalText;
                                    submitBtn.disabled = false;
                                    submitBtn.style.pointerEvents = '';
                                    submitBtn.style.opacity = '';
                                }
                            }
                        } else {
                            // Fallback: if we get here, something unexpected happened
                            console.warn('Unexpected server response format:', data);
                            alert('Form submitted, but received unexpected response format.');
                            
                            // Reset submission state but don't reset form
                            isSubmitting = false;
                            if (submitBtn) {
                                const originalText = submitBtn.getAttribute('data-original-text');
                                if (originalText) {
                                    submitBtn.innerHTML = originalText;
                                    submitBtn.disabled = false;
                                    submitBtn.style.pointerEvents = '';
                                    submitBtn.style.opacity = '';
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the form. Please try again.');
                        // Reset form state on error
                        isSubmitting = false;
                        if (submitBtn) {
                            const originalText = submitBtn.getAttribute('data-original-text');
                            if (originalText) {
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                                submitBtn.style.pointerEvents = '';
                                submitBtn.style.opacity = '';
                            }
                        }
                    });
                } else {
                    // For regular form submission without file uploads
                    const submitBtn = document.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
                        submitBtn.style.pointerEvents = 'none';
                        submitBtn.style.opacity = '0.7';
                        submitBtn.setAttribute('data-original-text', originalText);
                        
                        // Reset submission state if form fails to submit (e.g., validation errors)
                        setTimeout(() => {
                            if (document.contains(submitBtn) && isSubmitting) {
                                const originalText = submitBtn.getAttribute('data-original-text');
                                if (originalText) {
                                    submitBtn.innerHTML = originalText;
                                    submitBtn.disabled = false;
                                    submitBtn.style.pointerEvents = '';
                                    submitBtn.style.opacity = '';
                                    isSubmitting = false;
                                }
                            }
                        }, 5000); // Reset after 5 seconds if no redirect
                    }
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

        // FORM VALIDATION FUNCTIONALITY
        
        // Validation state
        let validationErrors = {};
        let isFormValid = true;

        // Validation rules and messages
        const validationRules = {
            'location_city': {
                required: true,
                minLength: 2
            },
            'location_state': {
                required: true,
                minLength: 2
            },
            'time_zone': {
                required: true
            },
            'event_date': {
                required: true,
                maxDate: new Date().toISOString().split('T')[0] // Today's date
            },
            'event_time': {
                required: true
            },
            'weather_types': {
                required: true,
                minItems: 1
            },
            'event_description': {
                maxLength: 1000
            }
        };

        const validationMessages = {
            'en': {
                'required': 'This field is required.',
                'minLength': 'Must be at least {min} characters long.',
                'maxLength': 'Cannot exceed {max} characters.',
                'maxDate': 'Date cannot be in the future.',
                'minItems': 'Please select at least one option.',
                'weatherTypeRequired': 'Please select at least one weather phenomenon.',
                'weatherTypeConflict': 'Duststorm and Fog cannot be selected together.',
                'locationRequired': 'Please obtain your location by clicking "Get My Current Location".',
                'invalidFileType': 'Invalid file type. Only JPEG, PNG, GIF, MP4, and MOV files are allowed.',
                'fileSizeExceeded': 'File size cannot exceed 10MB.',
                'validationSummaryTitle': 'Please correct the following errors:',
                'formIncomplete': 'Please complete all required fields before submitting.',
                'submittingForm': 'Submitting your weather observation...'
            },
            'ur': {
                'required': 'یہ فیلڈ ضروری ہے۔',
                'minLength': 'کم از کم {min} حروف ہونے چاہیے۔',
                'maxLength': '{max} حروف سے زیادہ نہیں ہو سکتے۔',
                'maxDate': 'تاریخ مستقبل میں نہیں ہو سکتی۔',
                'minItems': 'براہ کرم کم از کم ایک آپشن منتخب کریں۔',
                'weatherTypeRequired': 'براہ کرم کم از کم ایک موسمی مظہر منتخب کریں۔',
                'weatherTypeConflict': 'آندھی اور دھند ایک ساتھ منتخب نہیں کی جا سکتی۔',
                'locationRequired': 'براہ کرم "میرا موجودہ مقام حاصل کریں" پر کلک کر کے اپنا مقام حاصل کریں۔',
                'invalidFileType': 'غلط فائل قسم۔ صرف JPEG، PNG، GIF، MP4، اور MOV فائلیں قبول ہیں۔',
                'fileSizeExceeded': 'فائل کا سائز 10MB سے زیادہ نہیں ہو سکتا۔',
                'validationSummaryTitle': 'براہ کرم مندرجہ ذیل خرابیاں درست کریں:',
                'formIncomplete': 'جمع کرنے سے پہلے براہ کرم تمام ضروری فیلڈز مکمل کریں۔',
                'submittingForm': 'آپ کا موسمی مشاہدہ جمع کیا جا رہا ہے...'
            }
        };

        // Add validation to form fields
        function initializeValidation() {
            const form = document.getElementById('weatherObservationForm');
            if (!form) return;

            // Location fields - hide location alert when any location field gets filled
            const locationFields = ['location_city', 'location_state', 'time_zone'];
            locationFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', function() {
                        if (this.value.trim()) {
                            hideAlert('locationAlert');
                            this.classList.remove('field-error');
                            // Apply success styling
                            showFieldSuccess(this);
                        } else {
                            // Remove success styling if field becomes empty
                            this.classList.remove('is-valid');
                        }
                    });
                }
            });

            // Event date and time fields - hide event date/time alert when any field is filled
            const eventDateField = document.getElementById('event_date');
            const eventTimeField = document.getElementById('event_time');
            
            if (eventDateField) {
                eventDateField.addEventListener('input', function() {
                    if (this.value.trim()) {
                        hideAlert('eventDateTimeAlert');
                        this.classList.remove('field-error');
                        
                        // Check for future date
                        const selectedDate = new Date(this.value);
                        const today = new Date();
                        today.setHours(0, 0, 0, 0); // Reset time to beginning of day for accurate comparison
                        
                        if (selectedDate > today) {
                            // Show future date alert
                            showAlert('futureDateAlert');
                            this.classList.add('field-error');
                        } else {
                            // Hide future date alert and apply success styling
                            hideAlert('futureDateAlert');
                            showFieldSuccess(this);
                        }
                    } else {
                        // Remove success styling if field becomes empty
                        this.classList.remove('is-valid');
                        hideAlert('futureDateAlert');
                    }
                });
            }
            
            if (eventTimeField) {
                eventTimeField.addEventListener('input', function() {
                    if (this.value.trim()) {
                        hideAlert('eventDateTimeAlert');
                        this.classList.remove('field-error');
                        // Apply success styling
                        showFieldSuccess(this);
                    } else {
                        // Remove success styling if field becomes empty
                        this.classList.remove('is-valid');
                    }
                });
            }

            // Weather type checkboxes - hide weather alerts when any is selected
            const weatherCheckboxes = document.querySelectorAll('.weather-type');
            const weatherContainer = document.getElementById('weatherTypesContainer');
            
            weatherCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedWeatherTypes = document.querySelectorAll('.weather-type:checked');
                    
                    // If any weather type is selected, hide the phenomena alert
                    if (checkedWeatherTypes.length > 0) {
                        hideAlert('weatherPhenomenaAlert');
                        // Apply success styling to weather container
                        if (weatherContainer) {
                            weatherContainer.classList.remove('has-error');
                            weatherContainer.classList.add('has-success');
                        }
                    } else {
                        // Remove success styling if no weather types selected
                        if (weatherContainer) {
                            weatherContainer.classList.remove('has-success');
                        }
                    }
                    
                    // Check for incompatibility and hide/show incompatibility alert
                    const duststormChecked = document.getElementById('weather_duststorm').checked;
                    const fogChecked = document.getElementById('weather_fog').checked;
                    
                    if (duststormChecked && fogChecked) {
                        showAlert('weatherIncompatibilityAlert');
                        // Remove success styling when there's incompatibility
                        if (weatherContainer) {
                            weatherContainer.classList.remove('has-success');
                            weatherContainer.classList.add('has-error');
                        }
                    } else {
                        hideAlert('weatherIncompatibilityAlert');
                        // Restore success styling if weather types are selected and no incompatibility
                        if (weatherContainer && checkedWeatherTypes.length > 0) {
                            weatherContainer.classList.remove('has-error');
                            weatherContainer.classList.add('has-success');
                        }
                    }
                    
                    // Clear weather type validation styling
                    clearWeatherTypeValidation();
                });
            });

            // Other damage description field - hide other damage alert when filled
            const otherDamageDetails = document.getElementById('other_damage_details');
            if (otherDamageDetails) {
                otherDamageDetails.addEventListener('input', function() {
                    if (this.value.trim()) {
                        hideAlert('otherDamageAlert');
                        this.classList.remove('field-error');
                        // Apply success styling
                        showFieldSuccess(this);
                    } else {
                        // Remove success styling if field becomes empty
                        this.classList.remove('is-valid');
                    }
                });
            }

            // Damage checkboxes - handle other damage visibility and alerts
            const damageCheckboxes = document.querySelectorAll('input[name="damages[]"]');
            damageCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const otherDamageCheckbox = document.getElementById('damage_other');
                    const otherDamageWrapper = document.getElementById('other_damage_details_wrapper');
                    const otherDamageField = document.getElementById('other_damage_details');
                    
                    if (otherDamageWrapper) {
                        if (otherDamageCheckbox && otherDamageCheckbox.checked) {
                            otherDamageWrapper.style.display = 'block';
                            // Show alert if "Other" is selected but no description provided
                            if (!otherDamageField || !otherDamageField.value.trim()) {
                                showAlert('otherDamageAlert');
                            }
                        } else {
                            otherDamageWrapper.style.display = 'none';
                            hideAlert('otherDamageAlert');
                        }
                    }
                });
            });

            // Add event listeners for general field validation clearing and success styling
            const allInputs = form.querySelectorAll('input, textarea, select');
            allInputs.forEach(input => {
                // Apply success styling and clear errors when user types in any field
                input.addEventListener('input', function() {
                    if (this.classList.contains('field-error')) {
                        this.classList.remove('field-error');
                    }
                    
                    // Apply success styling for non-required fields that have content
                    // (required fields are handled by specific validators above)
                    if (!this.hasAttribute('required') && this.value.trim() && 
                        !['location_city', 'location_state', 'time_zone', 'event_date', 'event_time', 'other_damage_details'].includes(this.id)) {
                        showFieldSuccess(this);
                    } else if (!this.value.trim()) {
                        // Remove success styling if field becomes empty
                        this.classList.remove('is-valid');
                    }
                });

                // Clear validation on focus
                input.addEventListener('focus', function() {
                    if (this.classList.contains('field-error')) {
                        this.classList.remove('field-error');
                    }
                });
            });
        }

        // Validate individual field
        function validateField(field) {
            const fieldName = field.name || field.id;
            const value = field.value.trim();
            const rule = validationRules[fieldName];
            
            if (!rule) return true;

            let isValid = true;
            let errorMessage = '';

            // Required validation
            if (rule.required && !value) {
                isValid = false;
                errorMessage = getValidationMessage('required');
            }
            // Min length validation
            else if (rule.minLength && value.length < rule.minLength) {
                isValid = false;
                errorMessage = getValidationMessage('minLength').replace('{min}', rule.minLength);
            }
            // Max length validation
            else if (rule.maxLength && value.length > rule.maxLength) {
                isValid = false;
                errorMessage = getValidationMessage('maxLength').replace('{max}', rule.maxLength);
            }
            // Date validation
            else if (rule.maxDate && field.type === 'date' && value > rule.maxDate) {
                isValid = false;
                errorMessage = getValidationMessage('maxDate');
            }

            // Apply validation result
            if (isValid) {
                showFieldSuccess(field);
                delete validationErrors[fieldName];
            } else {
                showFieldError(field, errorMessage);
                validationErrors[fieldName] = errorMessage;
            }

            updateValidationSummary();
            updateFormProgress();
            
            return isValid;
        }

        // Validate weather types (only store errors, don't show immediately)
        function validateWeatherTypes() {
            const weatherCheckboxes = document.querySelectorAll('.weather-type:checked');
            const dustStorm = document.getElementById('weather_duststorm');
            const fog = document.getElementById('weather_fog');
            const container = document.getElementById('weatherTypesContainer');
            const conflictError = document.getElementById('weatherTypeError');
            const requiredError = document.getElementById('weatherTypeRequiredError');
            
            let isValid = true;

            // Check if at least one weather type is selected
            if (weatherCheckboxes.length === 0) {
                isValid = false;
                validationErrors['weather_types'] = getValidationMessage('weatherTypeRequired');
            } else {
                delete validationErrors['weather_types'];
            }

            // Check for duststorm and fog conflict
            if (dustStorm && fog && dustStorm.checked && fog.checked) {
                isValid = false;
                validationErrors['weather_types_conflict'] = getValidationMessage('weatherTypeConflict');
            } else {
                delete validationErrors['weather_types_conflict'];
            }

            // Don't show errors immediately - only clear visual indicators
            if (isValid) {
                container.classList.remove('has-error');
                conflictError.style.display = 'none';
                requiredError.style.display = 'none';
            }

            updateValidationSummary();
            updateFormProgress();
            
            return isValid;
        }

        // Validate damage selection
        function validateDamageSelection() {
            const otherDamageCheckbox = document.getElementById('damage_other');
            const otherDamageDetails = document.getElementById('other_damage_details');
            
            if (otherDamageCheckbox && otherDamageCheckbox.checked) {
                // Make other damage details required
                otherDamageDetails.addEventListener('blur', function() {
                    validateField(this);
                });
                
                if (!otherDamageDetails.value.trim()) {
                    showFieldError(otherDamageDetails, getValidationMessage('required'));
                    validationErrors['other_damage_details'] = getValidationMessage('required');
                } else {
                    showFieldSuccess(otherDamageDetails);
                    delete validationErrors['other_damage_details'];
                }
            } else {
                clearFieldValidation(otherDamageDetails);
                delete validationErrors['other_damage_details'];
            }

            updateValidationSummary();
            updateFormProgress();
        }

        // Validate location
        function validateLocation() {
            const latitude = document.getElementById('latitude');
            const longitude = document.getElementById('longitude');
            const city = document.getElementById('location_city');
            const state = document.getElementById('location_state');
            
            let isValid = true;
            
            if (!latitude || !longitude || !latitude.value || !longitude.value) {
                isValid = false;
                validationErrors['location'] = getValidationMessage('locationRequired');
                
                // Show error on city field as visual indicator
                if (city) {
                    showFieldError(city, getValidationMessage('locationRequired'));
                }
            } else {
                delete validationErrors['location'];
                if (city && city.value) {
                    showFieldSuccess(city);
                }
            }
            
            updateValidationSummary();
            updateFormProgress();
            
            return isValid;
        }

        // Show field error (minimal visual indication only)
        function showFieldError(field, message) {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            
            // Remove existing feedback - no inline error messages
            const existingFeedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            // Store error message for card alerts
            field.dataset.errorMessage = message;
        }

        // Show field success - subtle visual indicator only
        function showFieldSuccess(field) {
            field.classList.remove('is-invalid');
            
            // Only show success state for required fields or fields with content
            // to avoid unnecessary visual noise
            if (field.hasAttribute('required') || field.value.trim() !== '') {
                field.classList.add('is-valid');
            }
            
            // Remove any existing feedback messages
            const existingFeedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            // Success state is communicated purely through visual styling:
            // - Green border, checkmark icon (defined in CSS)
            // - No text messages (follows modern UX best practices)
        }

        // Clear field validation
        function clearFieldValidation(field) {
            field.classList.remove('is-invalid', 'is-valid');
            
            const existingFeedback = field.parentNode.querySelector('.invalid-feedback, .valid-feedback');
            if (existingFeedback) {
                existingFeedback.remove();
            }
            
            // Clear stored error message
            if (field.dataset.errorMessage) {
                delete field.dataset.errorMessage;
            }
        }

        // Update validation summary (only show on submit attempt)
        function updateValidationSummary() {
            // Don't show validation summary automatically
            const summary = document.getElementById('validationSummary');
            if (summary) {
                summary.style.display = 'none';
            }
            
            isFormValid = Object.keys(validationErrors).length === 0;
        }

        // Update form progress
        function updateFormProgress() {
            const progress = document.getElementById('formProgress');
            if (!progress) return;
            
            const totalFields = Object.keys(validationRules).length + 2; // +2 for weather types and location
            const completedFields = totalFields - Object.keys(validationErrors).length;
            const percentage = Math.max(0, Math.min(100, (completedFields / totalFields) * 100));
            
            progress.style.width = percentage + '%';
        }

        // Get validation message
        function getValidationMessage(key) {
            return validationMessages[currentLanguage] ? 
                   validationMessages[currentLanguage][key] || validationMessages['en'][key] :
                   validationMessages['en'][key];
        }

        // Enhanced validation function (adapted from public form)
        function validateForm() {
            console.log('validateForm called'); // Debug log
            
            let isValid = true;
            const errors = {
                locationDetails: [],
                eventDateTime: [],
                weatherPhenomena: false,
                weatherIncompatibility: false,
                otherDamage: false
            };
            
            // Translation object for global access - simplified version
            const simpleTranslations = {
                'en': {
                    'city': 'City',
                    'state': 'State',
                    'timeZone': 'Time Zone',
                    'dateOfWeatherEvent': 'Date of Weather Event',
                    'timeOfWeatherEvent': 'Time of Weather Event'
                },
                'ur': {
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
            clearErrorList('locationErrorList');
            clearErrorList('eventDateTimeErrorList');
            
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
            
            // Check for future date
            if (eventDate && eventDate.value.trim()) {
                const selectedDate = new Date(eventDate.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Reset time to beginning of day for accurate comparison
                
                if (selectedDate > today) {
                    errors.futureDate = true;
                    if (eventDate) addFieldError('event_date');
                    isValid = false;
                }
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
            
            // Validate Other Damage Description if "Other" is checked
            const damageOther = document.getElementById('damage_other');
            const otherDamageDetails = document.getElementById('other_damage_details');
            if (damageOther && damageOther.checked && (!otherDamageDetails || !otherDamageDetails.value.trim())) {
                errors.otherDamage = true;
                if (otherDamageDetails) addFieldError('other_damage_details');
                isValid = false;
            }
            
            // File validation
            validateUploadedFiles();
            
            // Show ALL applicable alerts simultaneously when validation fails
            const alertsToShow = [];
            
            console.log('Errors object:', errors); // Debug log
            
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
            
            if (errors.futureDate) {
                console.log('Adding future date error'); // Debug log
                alertsToShow.push('futureDateAlert');
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

        // Support functions for enhanced validation system
        function hideAllAlerts() {
            const alerts = document.querySelectorAll('.card-alert');
            alerts.forEach(alert => hideAlert(alert.id));
        }

        function removeAllFieldErrors() {
            const fieldsWithErrors = document.querySelectorAll('.field-error');
            fieldsWithErrors.forEach(field => {
                field.classList.remove('field-error');
            });
        }

        function addFieldError(fieldId) {
            const field = document.getElementById(fieldId);
            if (field) {
                field.classList.add('field-error');
            }
        }

        function clearErrorList(listId) {
            const list = document.getElementById(listId);
            if (list) {
                list.innerHTML = '';
            }
        }

        function addErrorToList(listId, errorText) {
            const list = document.getElementById(listId);
            if (list) {
                const li = document.createElement('li');
                li.textContent = errorText;
                list.appendChild(li);
            }
        }

        function checkWeatherIncompatibility() {
            const duststormChecked = document.getElementById('weather_duststorm').checked;
            const fogChecked = document.getElementById('weather_fog').checked;
            
            return !(duststormChecked && fogChecked);
        }

        // Validate uploaded files
        function validateUploadedFiles() {
            uploadedFiles.forEach((fileObj, index) => {
                const file = fileObj.file;
                
                // File type validation
                if (!file.type.match(/^(image|video)\//)) {
                    validationErrors[`file_${index}_type`] = getValidationMessage('invalidFileType');
                }
                
                // File size validation (10MB = 10 * 1024 * 1024 bytes)
                if (file.size > 10 * 1024 * 1024) {
                    validationErrors[`file_${index}_size`] = getValidationMessage('fileSizeExceeded');
                }
            });
        }

        // Show form alert with appropriate timing and prominence
        function showFormAlert(message, type = 'danger') {
            const existingAlert = document.querySelector('.form-alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} form-alert d-flex justify-content-between align-items-center`;
            alert.innerHTML = `
                <span>${message}</span>
                <button type="button" class="btn-close" onclick="this.parentElement.remove();">&times;</button>
            `;
            
            const form = document.getElementById('weatherObservationForm');
            form.parentNode.insertBefore(alert, form);
            
            // Auto-remove timing based on alert type for better UX
            let autoRemoveTime;
            switch(type) {
                case 'success':
                    autoRemoveTime = 3000; // Success messages disappear faster
                    break;
                case 'warning':
                    autoRemoveTime = 4000; // Warning messages stay a bit longer
                    break;
                case 'danger':
                    autoRemoveTime = 6000; // Error messages stay longest
                    break;
                default:
                    autoRemoveTime = 4000;
            }
            
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, autoRemoveTime);
        }

        // LANGUAGE TRANSLATION FUNCTIONALITY
           
        // Language translations object - Updated with validation messages
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
                'billboardSignboardDamage': 'Billboard/Signboard damage',
                'roofDamage': 'Roof damage',
                'vehicleDamage': 'Vehicle damage',
                'windowDamage': 'Window damage',
                'cropDamage': 'Crop damage',
                'livestockInjury': 'Livestock injury/death',
                'humanInjury': 'Human injury/fatality',
                'powerDisruption': 'Power disruption',
                'trafficDisruption': 'Traffic disruption',
                'flightDisruption': 'Flight disruption',
                'communicationDisruption': 'Communication disruption',
                'flooding': 'Flooding',
                'other': 'Other',
                'noDamage': 'No damage',
                'pleaseSpecifyOtherDamage': 'Please specify other damage details:',
                'eventDescription': 'Event Description',
                'briefDescriptionOfWeatherEvent': 'Brief Description of the Weather Event',
                'descriptionPlaceholder': 'Describe what you observed during the weather event...',
                'mediaUpload': 'Media Upload',
                'uploadPhotosVideos': 'Upload photos or videos related to the weather event (Optional)',
                'selectFiles': 'Select Files',
                'supportedFormats': 'Supported formats: JPEG, PNG, GIF, MP4, MOV. Maximum file size: 10MB each.',
                'selectedFiles': 'Selected Files:',
                'submitReport': 'Submit Report',
                'language': 'Language',
                'requestingLocationAccess': 'Requesting location access...',
                'gettingLocation': 'Getting location...',
                'locationAcquired': 'Location acquired. Fetching location details...',
                'locationDetailsRetrieved': 'Location details successfully retrieved.',
                'locationRetrieved': 'Location Retrieved',
                'errorRetrievingLocation': 'Location retrieved, but address lookup failed.',
                'locationAccessDenied': 'Location access denied by user.',
                'locationUnavailable': 'Location information is unavailable.',
                'locationTimeout': 'Location request timeout.',
                'unknownLocationError': 'Location access failed.',
                'geolocationNotSupported': 'Geolocation is not supported by this browser.',
                'mapServiceUnavailable': 'Map service unavailable',
                'mapLoadingFailed': 'Map loading failed',
                'mapInitializationFailed': 'Map initialization failed',
                // Validation messages
                'required': 'This field is required.',
                'minLength': 'Must be at least {min} characters long.',
                'maxLength': 'Cannot exceed {max} characters.',
                'maxDate': 'Date cannot be in the future.',
                'minItems': 'Please select at least one option.',
                'weatherTypeRequired': 'Please select at least one weather phenomenon.',
                'weatherTypeConflict': 'Duststorm and Fog cannot be selected together.',
                'locationRequired': 'Please obtain your location by clicking "Get My Current Location".',
                'invalidFileType': 'Invalid file type. Only JPEG, PNG, GIF, MP4, and MOV files are allowed.',
                'fileSizeExceeded': 'File size cannot exceed 10MB.',
                'validationSummaryTitle': 'Please correct the following errors:',
                'formIncomplete': 'Please complete all required fields before submitting.',
                'submittingForm': 'Submitting your weather observation...'
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
                'billboardSignboardDamage': 'بل بورڈ/سائن بورڈ کو نقصان',
                'roofDamage': 'چھت کو نقصان',
                'vehicleDamage': 'گاڑی کو نقصان',
                'windowDamage': 'کھڑکی کو نقصان',
                'cropDamage': 'فصل کو نقصان',
                'livestockInjury': 'مویشیوں کو زخم/موت',
                'humanInjury': 'انسانوں کو زخم/موت',
                'powerDisruption': 'بجلی کی خرابی',
                'trafficDisruption': 'ٹریفک کی خرابی',
                'flightDisruption': 'پرواز کی خرابی',
                'communicationDisruption': 'رابطے کی خرابی',
                'flooding': 'سیلاب',
                'other': 'دیگر',
                'noDamage': 'کوئی نقصان نہیں',
                'pleaseSpecifyOtherDamage': 'براہ کرم دیگر نقصان کی تفصیل بیان کریں:',
                'eventDescription': 'واقعے کی تفصیل',
                'briefDescriptionOfWeatherEvent': 'موسمی واقعے کی مختصر تفصیل',
                'descriptionPlaceholder': 'موسمی واقعے کے دوران آپ نے جو کچھ دیکھا اس کی تفصیل بیان کریں...',
                'mediaUpload': 'میڈیا اپ لوڈ',
                'uploadPhotosVideos': 'موسمی واقعے سے متعلق تصاویر یا ویڈیوز اپ لوڈ کریں (اختیاری)',
                'selectFiles': 'فائلیں منتخب کریں',
                'supportedFormats': 'تعاون یافتہ فارمیٹس: JPEG، PNG، GIF، MP4، MOV۔ زیادہ سے زیادہ فائل سائز: ہر ایک 10MB۔',
                'selectedFiles': 'منتخب شدہ فائلیں:',
                'submitReport': 'رپورٹ جمع کرائیں',
                'language': 'زبان',
                'requestingLocationAccess': 'مقام تک رسائی کی درخواست کر رہا ہے...',
                'gettingLocation': 'مقام حاصل کر رہا ہے...',
                'locationAcquired': 'مقام حاصل کر لیا گیا۔ مقام کی تفصیلات حاصل کر رہا ہے...',
                'locationDetailsRetrieved': 'مقام کی تفصیلات کامیابی سے حاصل کر لی گئیں۔',
                'locationRetrieved': 'مقام حاصل کر لیا گیا',
                'errorRetrievingLocation': 'مقام حاصل کر لیا گیا، لیکن پتے کی تلاش ناکام۔',
                'locationAccessDenied': 'صارف نے مقام تک رسائی مسترد کر دی۔',
                'locationUnavailable': 'مقام کی معلومات دستیاب نہیں ہیں۔',
                'locationTimeout': 'مقام کی درخواست کا وقت ختم ہو گیا۔',
                'unknownLocationError': 'مقام تک رسائی ناکام۔',
                'geolocationNotSupported': 'جیو لوکیشن اس براؤزر کے ذریعے تعاون یافتہ نہیں ہے۔',
                'mapServiceUnavailable': 'نقشہ سروس دستیاب نہیں',
                'mapLoadingFailed': 'نقشہ لوڈ کرنا ناکام',
                'mapInitializationFailed': 'نقشہ شروع کرنا ناکام',
                // Validation messages in Urdu
                'required': 'یہ فیلڈ ضروری ہے۔',
                'minLength': 'کم از کم {min} حروف ہونے چاہیے۔',
                'maxLength': '{max} حروف سے زیادہ نہیں ہو سکتے۔',
                'maxDate': 'تاریخ مستقبل میں نہیں ہو سکتی۔',
                'minItems': 'براہ کرم کم از کم ایک آپشن منتخب کریں۔',
                'weatherTypeRequired': 'براہ کرم کم از کم ایک موسمی مظہر منتخب کریں۔',
                'weatherTypeConflict': 'آندھی اور دھند ایک ساتھ منتخب نہیں کی جا سکتی۔',
                'locationRequired': 'براہ کرم "میرا موجودہ مقام حاصل کریں" پر کلک کر کے اپنا مقام حاصل کریں۔',
                'invalidFileType': 'غلط فائل قسم۔ صرف JPEG، PNG، GIF، MP4، اور MOV فائلیں قبول ہیں۔',
                'fileSizeExceeded': 'فائل کا سائز 10MB سے زیادہ نہیں ہو سکتا۔',
                'validationSummaryTitle': 'براہ کرم مندرجہ ذیل خرابیاں درست کریں:',
                'formIncomplete': 'جمع کرنے سے پہلے براہ کرم تمام ضروری فیلڈز مکمل کریں۔',
                'submittingForm': 'آپ کا موسمی مشاہدہ جمع کیا جا رہا ہے...'
            }
        };

        // Initialize elements map (for caching translated elements)
        const elementsMap = new Map();

        // Set current language (default: English)
        let currentLanguage = 'en';

        // Apply translations based on selected language
        function applyTranslations(lang) {
            // Update current language
            currentLanguage = lang;

            // Update dropdown button text
            const languageDropdown = document.getElementById('languageDropdown');
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
                        if (!element.closest('.navbar')) {
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
                    if (!element.closest('.navbar')) {
                        element.style.textAlign = 'right';
                        element.style.direction = 'rtl';
                    }
                });
                
                // Special handling for flex elements
                const flexElements = document.querySelectorAll('.d-flex, .card-header h3, .form-label, .btn');
                flexElements.forEach(element => {
                    if (!element.closest('.navbar')) {
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
                        element.style.direction = 'ltr';
                        element.style.textAlign = 'left';
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
                    if (!element.closest('.navbar')) {
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
                        element.style.direction = 'ltr';
                        element.style.textAlign = 'left';
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
                        if (el.tagName === 'INPUT' && el.type === 'text' || el.tagName === 'TEXTAREA') {
                            if (el.placeholder) {
                                el.placeholder = translations[lang][key];
                            }
                        } else if (el.dataset.translateAttr === 'innerHTML') {
                            el.innerHTML = translations[lang][key];
                        } else {
                            el.textContent = translations[lang][key];
                        }
                    });
                }
            }

            // Update status messages that might be set dynamically
            const locationStatus = document.getElementById('locationStatus');
            if (locationStatus && locationStatus.dataset.messageKey) {
                const messageKey = locationStatus.dataset.messageKey;
                if (translations[lang][messageKey]) {
                    locationStatus.textContent = translations[lang][messageKey];
                }
            }
        }

        // Map all translatable elements on the page
        function mapElementsForTranslation() {
            // Map headings
            mapElementByText('h1', 'weatherObservationReport');
            
            // Map card headers
            mapElementByText('.card-header h3', 'locationInformation', 0);
            mapElementByText('.card-header h3', 'eventDateAndTime', 1);
            mapElementByText('.card-header h3', 'weatherPhenomena', 2);
            mapElementByText('.card-header h3', 'damageCaused', 3);
            mapElementByText('.card-header h3', 'eventDescription', 4);
            mapElementByText('.card-header h3', 'mediaUpload', 5);
            
            // Map buttons
            mapElementByText('#getLocationBtn', 'getMyCurrentLocation');
            mapElementByText('#weatherObservationForm button[type="submit"]', 'submitReport');
            
            // Map form labels
            mapElementByText('label[for="location_state"]', 'state');
            mapElementByText('label[for="location_city"]', 'city');
            mapElementByText('label[for="time_zone"]', 'timeZone');
            mapElementByText('label[for="event_date"]', 'dateOfWeatherEvent');
            mapElementByText('label[for="event_time"]', 'timeOfWeatherEvent');
            
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
            mapElementByText('label[for="damage_billboard"]', 'billboardSignboardDamage');
            mapElementByText('label[for="damage_roof"]', 'roofDamage');
            mapElementByText('label[for="damage_vehicle"]', 'vehicleDamage');
            mapElementByText('label[for="damage_window"]', 'windowDamage');
            mapElementByText('label[for="damage_crops"]', 'cropDamage');
            mapElementByText('label[for="damage_livestock"]', 'livestockInjury');
            mapElementByText('label[for="damage_human"]', 'humanInjury');
            mapElementByText('label[for="damage_power"]', 'powerDisruption');
            mapElementByText('label[for="damage_traffic"]', 'trafficDisruption');
            mapElementByText('label[for="damage_flight"]', 'flightDisruption');
            mapElementByText('label[for="damage_communication"]', 'communicationDisruption');
            mapElementByText('label[for="damage_flooding"]', 'flooding');
            mapElementByText('label[for="damage_other"]', 'other');
            mapElementByText('label[for="damage_none"]', 'noDamage');
            mapElementByText('label[for="other_damage_details"]', 'pleaseSpecifyOtherDamage');
            
            // Map descriptive text
            mapElementByText('label[for="event_description"]', 'briefDescriptionOfWeatherEvent');
            mapElementByText('label[for="media_files"]', 'selectFiles');
            mapElementByText('#weatherTypeError', 'duststormFogError');
            mapElementByAttribute('#event_description', 'placeholder', 'descriptionPlaceholder');
            mapElementByAttribute('#other_damage_details', 'placeholder', 'pleaseSpecifyOtherDamage');
            
            // Map "Select all that apply" text
            const selectAllTexts = document.querySelectorAll('.card-header p.text-muted');
            selectAllTexts.forEach((el, index) => {
                if (index < 2) { // Weather phenomena and damage sections
                    addToElementsMap('selectAllThatApply', el);
                } else if (index === 2) { // Media upload section
                    addToElementsMap('uploadPhotosVideos', el);
                }
            });
            
            // Map form text helper
            const helperText = document.querySelector('.form-text');
            if (helperText) {
                addToElementsMap('supportedFormats', helperText);
            }

            // Map selected files text
            const selectedFilesHeader = document.querySelector('#selectedFiles h6');
            if (selectedFilesHeader) {
                // We'll handle this dynamically when files are selected
                addToElementsMap('selectedFiles', { textNode: selectedFilesHeader.firstChild });
            }
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

        // Helper functions for setting translated status and button text
        function setTranslatedStatus(messageKey) {
            const statusDiv = document.getElementById('locationStatus');
            if (statusDiv && translations[currentLanguage][messageKey]) {
                statusDiv.textContent = translations[currentLanguage][messageKey];
                statusDiv.dataset.messageKey = messageKey;
                // Apply RTL if needed
                if (currentLanguage === 'ur') {
                    statusDiv.style.textAlign = 'right';
                    statusDiv.style.direction = 'rtl';
                }
            }
        }

        function setTranslatedButtonText(messageKey) {
            const button = document.getElementById('getLocationBtn');
            if (button && translations[currentLanguage][messageKey]) {
                button.textContent = translations[currentLanguage][messageKey];
                // Apply RTL if needed
                if (currentLanguage === 'ur') {
                    button.style.textAlign = 'center';
                    button.style.direction = 'rtl';
                }
            }
        }

        // Handle language selection
        languageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const language = this.dataset.language;
                applyTranslations(language);
            });
        });

        // Initialize with English
        applyTranslations('en');
        
        // CARD ALERT SYSTEM - Show alerts on specific cards for validation errors
        
        // Create card alert element
        function createCardAlert(message, type = 'danger') {
            const alert = document.createElement('div');
            alert.className = `card-validation-alert alert alert-${type} d-flex justify-content-between align-items-center`;
            alert.style.cssText = `
                margin: 0 0 1rem 0;
                border-radius: 8px;
                font-size: 0.9rem;
                font-weight: 500;
                animation: slideInAlert 0.3s ease-out;
                border: none;
                box-shadow: 0 2px 8px rgba(220, 53, 69, 0.15);
            `;
            alert.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span>${message}</span>
                </div>
                <button type="button" class="btn-close btn-sm" onclick="this.parentElement.remove();" style="padding: 0; background: none; border: none; font-size: 1rem; opacity: 0.7;">&times;</button>
            `;
            return alert;
        }
        
        // Show card alerts for validation errors
        function showCardAlertsForErrors() {
            const cardMappings = {
                'location': 0,          // Location Information card
                'weather_types': 2,     // Weather Phenomena card
                'weather_types_conflict': 2, // Weather Phenomena card
                'event_date': 1,        // Event Date and Time card
                'event_time': 1,        // Event Date and Time card
                'event_description': 4,  // Event Description card
                'other_damage_details': 3 // Damage Caused card
            };
            
            const cards = document.querySelectorAll('.card');
            
            // Group errors by card
            const cardErrors = {};
            
            // Check for field errors
            Object.keys(validationErrors).forEach(errorKey => {
                const cardIndex = cardMappings[errorKey];
                if (cardIndex !== undefined) {
                    if (!cardErrors[cardIndex]) {
                        cardErrors[cardIndex] = [];
                    }
                    cardErrors[cardIndex].push(validationErrors[errorKey]);
                }
            });
            
            // Check for field-specific errors
            const invalidFields = document.querySelectorAll('.is-invalid[data-error-message]');
            invalidFields.forEach(field => {
                const card = field.closest('.card');
                if (card) {
                    const cardIndex = Array.from(cards).indexOf(card);
                    if (cardIndex !== -1) {
                        if (!cardErrors[cardIndex]) {
                            cardErrors[cardIndex] = [];
                        }
                        cardErrors[cardIndex].push(field.dataset.errorMessage);
                    }
                }
            });
            
            // Show alerts on relevant cards
            Object.keys(cardErrors).forEach(cardIndex => {
                const card = cards[cardIndex];
                if (card) {
                    const cardBody = card.querySelector('.card-body');
                    if (cardBody) {
                        // Remove duplicate messages
                        const uniqueErrors = [...new Set(cardErrors[cardIndex])];
                        const message = uniqueErrors.length === 1 ? 
                            uniqueErrors[0] : 
                            `Please complete the required fields in this section.`;
                        
                        const alert = createCardAlert(message);
                        cardBody.insertBefore(alert, cardBody.firstChild);
                        
                        // Apply RTL styling if needed
                        if (currentLanguage === 'ur') {
                            alert.style.textAlign = 'right';
                            alert.style.direction = 'rtl';
                        }
                    }
                }
            });
            
            // Special handling for weather types conflict
            if (validationErrors['weather_types_conflict']) {
                const weatherCard = cards[2]; // Weather Phenomena card
                if (weatherCard) {
                    const container = document.getElementById('weatherTypesContainer');
                    if (container) {
                        container.classList.add('has-error');
                        const conflictError = document.getElementById('weatherTypeError');
                        const requiredError = document.getElementById('weatherTypeRequiredError');
                        if (conflictError) conflictError.style.display = 'block';
                        if (requiredError && validationErrors['weather_types']) {
                            requiredError.style.display = 'block';
                        }
                    }
                }
            }
        }
        
        // Clear card alert from specific field's card
        function clearCardAlert(field) {
            const card = field.closest('.card');
            if (card) {
                const alert = card.querySelector('.card-validation-alert');
                if (alert) {
                    alert.remove();
                }
            }
        }
        
        // Clear all card alerts
        function clearAllCardAlerts() {
            const alerts = document.querySelectorAll('.card-validation-alert');
            alerts.forEach(alert => alert.remove());
            
            // Clear weather type error displays
            const container = document.getElementById('weatherTypesContainer');
            if (container) {
                container.classList.remove('has-error');
                const conflictError = document.getElementById('weatherTypeError');
                const requiredError = document.getElementById('weatherTypeRequiredError');
                if (conflictError) conflictError.style.display = 'none';
                if (requiredError) requiredError.style.display = 'none';
            }
        }
        
        // Clear weather type validation
        function clearWeatherTypeValidation() {
            const container = document.getElementById('weatherTypesContainer');
            if (container) {
                container.classList.remove('has-error');
                const conflictError = document.getElementById('weatherTypeError');
                const requiredError = document.getElementById('weatherTypeRequiredError');
                if (conflictError) conflictError.style.display = 'none';
                if (requiredError) requiredError.style.display = 'none';
            }
            
            // Clear from validation errors
            delete validationErrors['weather_types'];
            delete validationErrors['weather_types_conflict'];
            
            // Clear card alert
            const weatherCard = document.querySelectorAll('.card')[2]; // Weather Phenomena card
            if (weatherCard) {
                const alert = weatherCard.querySelector('.card-validation-alert');
                if (alert) {
                    alert.remove();
                }
            }
        }

        // Initialize form validation
        initializeValidation();
        
        // Don't run initial validation - only update progress
        setTimeout(() => {
            updateFormProgress();
        }, 1000);

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

        // Core alert system functions
        function showAlert(alertId) {
            console.log('showAlert called for:', alertId); // Debug log
            const alert = document.getElementById(alertId);
            if (alert) {
                // Remove any existing inline styles that might interfere
                alert.style.display = '';
                alert.style.visibility = '';
                alert.style.opacity = '';
                // Add the show class to trigger CSS animation
                alert.classList.remove('hide');
                alert.classList.add('show');
                console.log('Alert shown:', alertId); // Debug log
            } else {
                console.error('Alert element not found:', alertId);
            }
        }

        function hideAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('hide');
                setTimeout(() => {
                    // Remove the element from display after animation
                    alert.classList.remove('hide');
                    alert.style.display = '';
                    alert.style.visibility = '';
                    alert.style.opacity = '';
                }, 300);
            }
        }
    });
</script>
@endpush