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
            
            /* Dark Theme Variables for Welcome Page - Using Global Theme */
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
            
            /* Enhanced Navbar Styles */
            .navbar {
                background: linear-gradient(135deg, var(--navbar-bg) 0%, var(--navbar-bg) 50%, var(--navbar-bg) 100%) !important;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 173, 81, 0.1);
                box-shadow: 
                    0 4px 20px rgba(0, 0, 0, 0.08),
                    0 1px 4px rgba(0, 0, 0, 0.05),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1030;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 0;
                padding: 0.75rem 0;
            }
            
            /* Dark mode navbar adjustments */
            [data-theme="dark"] .navbar {
                background: linear-gradient(135deg, var(--theme-navbar-bg) 0%, var(--theme-bg-tertiary) 50%, var(--theme-navbar-bg) 100%) !important;
                border-bottom: 1px solid rgba(255, 173, 81, 0.2);
                box-shadow: 
                    0 4px 20px rgba(0, 0, 0, 0.5),
                    0 1px 4px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            
            .navbar::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(90deg, 
                    transparent 0%, 
                    rgba(255, 173, 81, 0.03) 20%, 
                    rgba(255, 173, 81, 0.05) 50%, 
                    rgba(255, 173, 81, 0.03) 80%, 
                    transparent 100%);
                pointer-events: none;
                opacity: 0;
                animation: navbarShimmer 6s ease-in-out infinite;
            }
            
            @keyframes navbarShimmer {
                0%, 100% { opacity: 0; }
                50% { opacity: 1; }
            }
            
            /* Enhanced Brand */
            .navbar-brand {
                font-weight: 700 !important;
                font-size: 1.25rem !important;
                color: var(--navbar-text-color) !important;
                text-decoration: none !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                padding: 0.5rem 0 !important;
                position: relative;
                overflow: hidden;
            }
            
            .navbar-brand::before {
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
            
            .navbar-brand:hover::before {
                left: 100%;
            }
            
            .navbar-brand:hover {
                color: var(--heading-color) !important;
                transform: translateY(-1px);
            }
            
            .navbar-brand img {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                filter: brightness(1) contrast(1.1);
            }
            
            .navbar-brand:hover img {
                transform: scale(1.05) rotate(2deg);
                filter: brightness(1.1) contrast(1.2);
            }
            
            /* Logo Container Enhancement */
            .navbar-brand .me-2 {
                background: transparent;
                border-radius: 8px !important;
                padding: 2px;
                box-shadow: none;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .navbar-brand:hover .me-2 {
                background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
                box-shadow: 
                    0 4px 15px rgba(255, 173, 81, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                transform: translateY(-1px);
            }
            
            /* Enhanced Navigation Links */
            .navbar-nav .nav-link {
                font-weight: 500 !important;
                color: var(--navbar-text-color) !important;
                padding: 0.75rem 1.25rem !important;
                margin: 0 0.25rem;
                border-radius: 8px !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                background: transparent;
                border: 1px solid transparent;
            }
            
            .navbar-nav .nav-link::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, 
                    rgba(255, 173, 81, 0.1) 0%, 
                    rgba(255, 173, 81, 0.05) 100%);
                transition: left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: -1;
            }
            
            .navbar-nav .nav-link:hover::before {
                left: 0;
            }
            
            .navbar-nav .nav-link:hover {
                color: var(--heading-color) !important;
                background: rgba(255, 173, 81, 0.08) !important;
                border-color: rgba(255, 173, 81, 0.2) !important;
                transform: translateY(-2px);
                box-shadow: 
                    0 4px 12px rgba(255, 173, 81, 0.15),
                    0 2px 4px rgba(0, 0, 0, 0.05);
            }
            
            .navbar-nav .nav-link:active {
                transform: translateY(0);
            }
            
            /* Enhanced Dropdown */
            .navbar-nav .dropdown-toggle {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%) !important;
                border: 1px solid rgba(255, 173, 81, 0.2) !important;
                box-shadow: 
                    0 2px 8px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.6);
            }
            
            /* Dark mode dropdown toggle */
            [data-theme="dark"] .navbar-nav .dropdown-toggle {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%) !important;
                box-shadow: 
                    0 2px 8px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            
            .navbar-nav .dropdown-toggle:hover {
                background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%) !important;
                color: var(--white) !important;
                border-color: var(--heading-color) !important;
                box-shadow: 
                    0 6px 20px rgba(255, 173, 81, 0.25),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
            }
            
            .navbar-nav .dropdown-toggle img,
            .navbar-nav .dropdown-toggle .rounded-circle {
                border: 2px solid rgba(255, 255, 255, 0.8);
                transition: all 0.3s ease;
            }
            
            .navbar-nav .dropdown-toggle:hover img,
            .navbar-nav .dropdown-toggle:hover .rounded-circle {
                border-color: var(--white);
                transform: scale(1.05);
            }
            
            /* Enhanced Dropdown Menu */
            .dropdown-menu {
                background: var(--navbar-dropdown-bg) !important;
                border: 1px solid rgba(255, 173, 81, 0.1) !important;
                border-radius: 12px !important;
                box-shadow: 
                    0 10px 40px rgba(0, 0, 0, 0.15),
                    0 4px 12px rgba(0, 0, 0, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9) !important;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                padding: 0.75rem 0 !important;
                margin-top: 0.5rem !important;
                min-width: 220px !important;
                animation: dropdownFadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            /* Dark mode dropdown menu */
            [data-theme="dark"] .dropdown-menu {
                background: var(--navbar-dropdown-bg) !important;
                border: 1px solid rgba(255, 173, 81, 0.2) !important;
                box-shadow: 
                    0 10px 40px rgba(0, 0, 0, 0.6),
                    0 4px 12px rgba(0, 0, 0, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
            }
            
            [data-theme="dark"] .dropdown-menu::before {
                background: var(--navbar-dropdown-bg);
                border: 1px solid rgba(255, 173, 81, 0.2);
                border-bottom: none;
                border-right: none;
            }
            
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
            
            .dropdown-menu::before {
                content: '';
                position: absolute;
                top: -6px;
                right: 20px;
                width: 12px;
                height: 12px;
                background: var(--navbar-dropdown-bg);
                border: 1px solid rgba(255, 173, 81, 0.1);
                border-bottom: none;
                border-right: none;
                transform: rotate(45deg);
                border-radius: 2px 0 0 0;
            }
            
            .dropdown-item {
                padding: 0.75rem 1.5rem !important;
                color: var(--navbar-text-color) !important;
                font-weight: 500 !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 8px !important;
                margin: 0 0.5rem !important;
                position: relative;
                overflow: hidden;
            }
            
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
            
            .dropdown-item:hover {
                background: rgba(255, 173, 81, 0.08) !important;
                color: var(--heading-color) !important;
                transform: translateX(4px);
            }
            
            .dropdown-item.text-danger:hover {
                background: rgba(220, 53, 69, 0.08) !important;
                color: #dc3545 !important;
            }
            
            .dropdown-item i {
                width: 18px;
                margin-right: 0.75rem;
                opacity: 0.7;
                transition: all 0.3s ease;
            }
            
            .dropdown-item:hover i {
                opacity: 1;
                transform: scale(1.1);
            }
            
            .dropdown-divider {
                border-color: rgba(255, 173, 81, 0.1) !important;
                margin: 0.5rem 1rem !important;
            }
            
            /* Enhanced Navbar Toggler */
            .navbar-toggler {
                border: 1px solid rgba(255, 173, 81, 0.3) !important;
                border-radius: 8px !important;
                padding: 0.5rem !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: rgba(255, 173, 81, 0.05) !important;
            }
            
            .navbar-toggler:hover {
                background: rgba(255, 173, 81, 0.1) !important;
                border-color: rgba(255, 173, 81, 0.5) !important;
                transform: scale(1.05);
            }
            
            .navbar-toggler:focus {
                box-shadow: 0 0 0 3px rgba(255, 173, 81, 0.25) !important;
            }
            
            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            }
            
            /* Dark mode navbar toggler */
            [data-theme="dark"] .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            }
            
            /* Responsive Navbar Enhancements */
            @media (max-width: 991.98px) {
                .navbar-collapse {
                    background: rgba(255, 255, 255, 0.98);
                    border-radius: 12px;
                    margin-top: 1rem;
                    padding: 1rem;
                    box-shadow: 
                        0 8px 32px rgba(0, 0, 0, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
                    backdrop-filter: blur(10px);
                    -webkit-backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 173, 81, 0.1);
                }
                
                /* Dark mode responsive navbar */
                [data-theme="dark"] .navbar-collapse {
                    background: rgba(58, 54, 54, 0.98);
                    box-shadow: 
                        0 8px 32px rgba(0, 0, 0, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.1);
                    border: 1px solid rgba(255, 173, 81, 0.2);
                }
                
                .navbar-nav .nav-link {
                    margin: 0.25rem 0 !important;
                    text-align: center;
                }
                
                .navbar-brand {
                    font-size: 1.1rem !important;
                }
            }
            

            
            .section-title {
                font-weight: 700;
                font-size: clamp(2.2rem, 4vw, 3.2rem);
                text-align: center;
                margin-bottom: 1rem;
            }
            
            .service-title {
                font-weight: 600;
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
                text-align: center;
            }
            
            /* Services Banner */
            .services-banner {
                background: linear-gradient(135deg, 
                    rgba(207, 226, 255, 0.9) 0%, 
                    rgba(207, 226, 255, 0.7) 50%, 
                    rgba(207, 226, 255, 0.9) 100%);
                padding: 2rem 1.5rem;
                margin-bottom: 4rem;
                border-radius: 16px;
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.06),
                    0 2px 8px rgba(0, 0, 0, 0.04),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
                border: 1px solid rgba(255, 173, 81, 0.1);
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .services-banner::before {
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
                animation: bannerShine 4s ease-in-out infinite;
                pointer-events: none;
            }
            
            @keyframes bannerShine {
                0%, 100% { left: -100%; }
                50% { left: 100%; }
            }
            
            .services-banner .text-muted {
                color: var(--body-text) !important;
                font-size: 1rem;
                line-height: 1.7;
                font-weight: 500;
                text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            }
            
            .services-banner i {
                color: var(--heading-color);
                opacity: 0.9;
                font-size: 1.1rem;
                margin-right: 0.5rem;
                filter: drop-shadow(0 1px 2px rgba(255, 173, 81, 0.3));
            }
            
            .services-banner strong {
                color: var(--black);
                font-weight: 700;
                position: relative;
            }
            
            .services-banner strong::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, var(--heading-color) 0%, transparent 100%);
                border-radius: 1px;
                opacity: 0.6;
            }
            
            /* Enhanced Weather Reports Section */
            .reports-section {
                padding: 2rem 2rem var(--section-padding) 2rem;
                background: linear-gradient(135deg, 
                    var(--primary-bg) 0%, 
                    rgba(207, 226, 255, 0.03) 50%, 
                    var(--primary-bg) 100%);
                border: 2px solid rgba(255, 173, 81, 0.15);
                border-radius: 32px;
                position: relative;
                margin: 2rem 0;
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.06),
                    0 2px 8px rgba(0, 0, 0, 0.04),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .reports-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 200px;
                background: linear-gradient(180deg, 
                    rgba(207, 226, 255, 0.05) 0%, 
                    transparent 100%);
                pointer-events: none;
                border-radius: 30px 30px 0 0;
            }
            
            .section-subtitle {
                color: var(--body-text);
                font-size: 1.25rem;
                text-align: center;
                margin-bottom: 4rem;
                max-width: 800px;
                margin-left: auto;
                margin-right: auto;
                font-weight: 400;
                line-height: 1.8;
                position: relative;
            }
            
            .section-subtitle::before {
                content: '';
                position: absolute;
                top: -1rem;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 3px;
                background: linear-gradient(90deg, var(--heading-color) 0%, rgba(255, 173, 81, 0.3) 100%);
                border-radius: 2px;
            }
            
            .section-title {
                font-weight: 800;
                font-size: clamp(2.5rem, 5vw, 3.5rem);
                text-align: center;
                margin-bottom: 1.5rem;
                color: var(--black);
                position: relative;
                letter-spacing: -0.02em;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            /* Dark mode section title */
            [data-theme="dark"] .section-title {
                color: #ffffff;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            }
            
            /* Dark mode improvements for better text readability */
            [data-theme="dark"] .services-banner {
                background: linear-gradient(135deg, 
                    rgba(30, 58, 95, 0.9) 0%, 
                    rgba(30, 58, 95, 0.7) 50%, 
                    rgba(30, 58, 95, 0.9) 100%);
                border: 1px solid rgba(255, 173, 81, 0.2);
            }
            
            /* Dark mode reports section */
            [data-theme="dark"] .reports-section {
                background: linear-gradient(135deg, 
                    var(--theme-bg-primary) 0%, 
                    rgba(58, 54, 54, 0.3) 50%, 
                    var(--theme-bg-primary) 100%);
                border: 2px solid rgba(255, 173, 81, 0.25);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    0 2px 8px rgba(0, 0, 0, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            
            [data-theme="dark"] .reports-section::before {
                background: linear-gradient(180deg, 
                    rgba(58, 54, 54, 0.2) 0%, 
                    transparent 100%);
            }
            
            [data-theme="dark"] .services-banner strong {
                color: #ffffff;
            }
            
            [data-theme="dark"] .services-banner .text-muted {
                color: var(--theme-text-secondary, #adb5bd) !important;
            }
            
            [data-theme="dark"] .services-banner small {
                color: var(--theme-text-secondary, #adb5bd);
            }
            
            [data-theme="dark"] .services-banner i {
                color: var(--heading-color);
                filter: drop-shadow(0 1px 2px rgba(255, 173, 81, 0.4));
            }
            
            [data-theme="dark"] .report-card {
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
            
            [data-theme="dark"] .report-location {
                color: #ffffff;
            }
            
            [data-theme="dark"] .weather-badge {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%);
                color: #ffffff;
                border: 1px solid rgba(255, 173, 81, 0.3);
            }
            
            [data-theme="dark"] .view-details {
                color: #ffffff;
                background: linear-gradient(135deg, rgba(255, 173, 81, 0.2) 0%, rgba(255, 173, 81, 0.1) 100%);
                border: 1px solid rgba(255, 173, 81, 0.3);
            }
            
            .section-title::after {
                content: '';
                display: block;
                width: 120px;
                height: 4px;
                background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
                margin: 1.5rem auto 0;
                border-radius: 2px;
                box-shadow: 0 2px 8px rgba(255, 173, 81, 0.3);
            }
            
            /* Professional Report Cards */
            .professional-report-card {
                background: linear-gradient(135deg, 
                    var(--white) 0%, 
                    rgba(255, 255, 255, 0.98) 50%, 
                    var(--white) 100%);
                border-radius: 24px;
                height: 680px;
                box-shadow: 
                    0 12px 48px rgba(0, 0, 0, 0.08),
                    0 4px 16px rgba(0, 0, 0, 0.04),
                    inset 0 1px 0 rgba(255, 255, 255, 0.95);
                border: 2px solid rgba(255, 173, 81, 0.25);
                transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
                cursor: pointer;
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                display: flex;
                flex-direction: column;
            }
            
            .professional-report-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, 
                    var(--heading-color) 0%, 
                    #ffb866 50%, 
                    var(--heading-color) 100%);
                transform: scaleX(0);
                transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
                border-radius: 24px 24px 0 0;
            }
            
            .professional-report-card:hover {
                transform: translateY(-16px) scale(1.02);
                box-shadow: 
                    0 24px 80px rgba(0, 0, 0, 0.15),
                    0 8px 32px rgba(0, 0, 0, 0.08),
                    0 0 0 1px rgba(255, 173, 81, 0.4);
                border-color: rgba(255, 173, 81, 0.5);
            }
            
            .professional-report-card:hover::before {
                transform: scaleX(1);
            }
            
            /* Card Header */
            .card-header-pro {
                padding: 1.5rem 2rem 1rem;
                position: relative;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }
            
            .status-indicator {
                position: absolute;
                top: 1.5rem;
                right: 2rem;
                width: 12px;
                height: 12px;
                background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
                border-radius: 50%;
                box-shadow: 
                    0 0 12px rgba(34, 197, 94, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                animation: statusPulse 2s infinite;
            }
            
            @keyframes statusPulse {
                0%, 100% { opacity: 1; transform: scale(1); }
                50% { opacity: 0.7; transform: scale(1.1); }
            }
            
            .header-content {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .location-info {
                flex: 1;
            }
            
            .location-title {
                font-size: 1.4rem;
                font-weight: 700;
                color: var(--black);
                margin-bottom: 0.25rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                line-height: 1.3;
            }
            
            .location-title i {
                color: var(--heading-color);
                font-size: 1.1rem;
                filter: drop-shadow(0 1px 3px rgba(255, 173, 81, 0.3));
            }
            
            .location-subtitle {
                color: var(--body-text);
                font-size: 0.9rem;
                font-weight: 500;
                margin: 0;
                opacity: 0.8;
            }
            
            .date-info {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                gap: 0.5rem;
            }
            
            .date-display {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%);
                border-radius: 12px;
                padding: 0.75rem;
                text-align: center;
                border: 1px solid rgba(255, 173, 81, 0.15);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }
            
            .date-day {
                display: block;
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--black);
                line-height: 1;
            }
            
            .date-month {
                display: block;
                font-size: 0.75rem;
                font-weight: 600;
                color: var(--body-text);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .time-display {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.85rem;
                color: var(--body-text);
                font-weight: 500;
            }
            
            .time-display i {
                color: var(--heading-color);
                font-size: 0.8rem;
            }
            
            /* Professional Slideshow Styles */
            .professional-slideshow {
                position: relative;
                height: 280px;
                border-radius: 0;
                overflow: hidden;
                background: linear-gradient(135deg, 
                    var(--container-bg) 0%, 
                    rgba(207, 226, 255, 0.8) 100%);
            }
            
            .professional-slideshow .carousel {
                height: 100%;
                border-radius: 0;
            }
            
            .professional-slideshow .carousel-inner {
                height: 100%;
                border-radius: 0;
            }
            
            .professional-slideshow .carousel-item {
                height: 100%;
                position: relative;
            }
            
            .image-container {
                position: relative;
                height: 100%;
                width: 100%;
                overflow: hidden;
            }
            
            .image-container img {
                height: 100%;
                width: 100%;
                object-fit: cover;
                object-position: center;
                transition: all 0.8s cubic-bezier(0.23, 1, 0.32, 1);
                filter: brightness(1) contrast(1.1) saturate(1.05);
            }
            
            .professional-report-card:hover .image-container img {
                transform: scale(1.08);
                filter: brightness(1.1) contrast(1.15) saturate(1.15);
            }
            
            .image-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                opacity: 0;
                transition: all 0.4s ease;
                z-index: 2;
            }
            
            .overlay-gradient {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(
                    135deg,
                    rgba(0, 0, 0, 0.4) 0%,
                    transparent 40%,
                    transparent 60%,
                    rgba(0, 0, 0, 0.6) 100%
                );
            }
            
            .image-container:hover .image-overlay {
                opacity: 1;
            }
            
            .image-actions {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            
            .image-expand {
                background: rgba(255, 255, 255, 0.95);
                border: 2px solid var(--heading-color);
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--heading-color);
                font-size: 1.2rem;
                transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                box-shadow: 0 4px 20px rgba(255, 173, 81, 0.3);
            }
            
            .image-expand:hover {
                background: var(--heading-color);
                color: var(--white);
                transform: scale(1.1);
                box-shadow: 0 6px 25px rgba(255, 173, 81, 0.5);
            }
            
            /* Custom Carousel Navigation */
            .carousel-nav {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
                width: 44px;
                height: 44px;
                background: rgba(255, 255, 255, 0.95);
                border: 2px solid rgba(255, 173, 81, 0.3);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--heading-color);
                font-size: 1rem;
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
                opacity: 0;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                z-index: 5;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            }
            
            .carousel-nav.carousel-prev {
                left: 15px;
            }
            
            .carousel-nav.carousel-next {
                right: 15px;
            }
            
            .professional-report-card:hover .carousel-nav {
                opacity: 1;
            }
            
            .carousel-nav:hover {
                background: var(--heading-color);
                color: var(--white);
                border-color: var(--heading-color);
                transform: translateY(-50%) scale(1.1);
                box-shadow: 0 6px 25px rgba(255, 173, 81, 0.4);
            }
            
            /* Enhanced Carousel Dots */
            .carousel-dots {
                position: absolute;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 8px;
                padding: 10px 16px;
                background: rgba(0, 0, 0, 0.5);
                border-radius: 25px;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                z-index: 5;
                transition: all 0.3s ease;
            }
            
            .professional-report-card:hover .carousel-dots {
                background: rgba(0, 0, 0, 0.7);
            }
            
            .carousel-dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.2);
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
                cursor: pointer;
            }
            
            .carousel-dot.active {
                background: var(--heading-color);
                border-color: var(--heading-color);
                transform: scale(1.2);
                box-shadow: 
                    0 0 15px rgba(255, 173, 81, 0.6),
                    0 2px 8px rgba(0, 0, 0, 0.3);
            }
            
            .carousel-dot:hover {
                background: rgba(255, 173, 81, 0.8);
                border-color: var(--heading-color);
                transform: scale(1.1);
            }
            
            /* Image Counter */
            .image-counter {
                position: absolute;
                top: 20px;
                right: 20px;
                background: rgba(0, 0, 0, 0.8);
                color: var(--white);
                padding: 8px 14px;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                backdrop-filter: blur(15px);
                -webkit-backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                z-index: 5;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
                display: flex;
                align-items: center;
                gap: 6px;
            }
            
            .professional-report-card:hover .image-counter {
                background: rgba(255, 173, 81, 0.95);
                border-color: var(--heading-color);
                transform: scale(1.05);
                box-shadow: 0 6px 20px rgba(255, 173, 81, 0.4);
            }
            
            .image-counter i {
                opacity: 0.9;
                filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.3));
            }
            
            /* No Image Placeholder */
            .no-image-placeholder {
                position: relative;
                height: 280px;
                background: linear-gradient(135deg, 
                    var(--container-bg) 0%, 
                    rgba(207, 226, 255, 0.6) 50%,
                    var(--container-bg) 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 0;
            }
            
            .placeholder-content {
                text-align: center;
                color: var(--body-text);
                opacity: 0.7;
            }
            
            .placeholder-content i {
                font-size: 3rem;
                color: var(--heading-color);
                margin-bottom: 1rem;
                opacity: 0.6;
                filter: drop-shadow(0 2px 4px rgba(255, 173, 81, 0.2));
            }
            
            .placeholder-content span {
                display: block;
                font-size: 1rem;
                font-weight: 600;
                color: var(--body-text);
            }
            
            /* Card Content Section */
            .card-content-pro {
                padding: 1.5rem 2rem 0 2rem;
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }
            
            /* Weather Categories */
            .weather-categories {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
            }
            
            .weather-tag {
                background: linear-gradient(135deg, 
                    var(--container-bg) 0%, 
                    rgba(207, 226, 255, 0.9) 100%);
                color: var(--black);
                padding: 0.6rem 1rem;
                border-radius: 20px;
                font-size: 0.8rem;
                font-weight: 600;
                border: 1px solid rgba(255, 173, 81, 0.2);
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
                display: flex;
                align-items: center;
                gap: 0.5rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }
            
            .weather-tag i {
                font-size: 0.7rem;
                opacity: 0.8;
            }
            
            .weather-tag.more-tag {
                background: linear-gradient(135deg, 
                    rgba(255, 173, 81, 0.1) 0%, 
                    rgba(255, 173, 81, 0.05) 100%);
                border-color: rgba(255, 173, 81, 0.3);
                color: var(--heading-color);
            }
            
            .weather-tag:hover {
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                color: var(--white);
                border-color: var(--heading-color);
                transform: translateY(-2px) scale(1.05);
                box-shadow: 0 6px 20px rgba(255, 173, 81, 0.3);
            }
            
            /* Description Section */
            .description-section {
                flex: 0 1 auto;
                min-height: 60px;
            }
            
            .description-text {
                color: var(--body-text);
                font-size: 0.95rem;
                line-height: 1.6;
                margin: 0;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
                font-weight: 400;
                text-overflow: ellipsis;
                max-height: 72px;
            }
            
            /* Observer Information */
            .observer-info {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                background: linear-gradient(135deg, 
                    rgba(255, 255, 255, 0.5) 0%, 
                    rgba(248, 249, 250, 0.8) 100%);
                border-radius: 12px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            }
            
            .observer-details {
                display: flex;
                align-items: center;
                gap: 1rem;
            }
            
            .observer-avatar {
                width: 44px;
                height: 44px;
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                font-size: 1.1rem;
                box-shadow: 0 4px 15px rgba(255, 173, 81, 0.3);
                position: relative;
                overflow: hidden;
            }
            
            .observer-avatar::before {
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
                transition: left 0.6s ease;
            }
            
            .professional-report-card:hover .observer-avatar::before {
                left: 100%;
            }
            
            .observer-meta {
                display: flex;
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .observer-name {
                font-weight: 700;
                color: var(--black);
                font-size: 0.9rem;
                line-height: 1.3;
            }
            
            .observer-role {
                font-size: 0.8rem;
                color: var(--body-text);
                font-weight: 500;
                opacity: 0.8;
            }
            
            .verification-badge {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                background: linear-gradient(135deg, 
                    #22c55e 0%, 
                    #16a34a 100%);
                color: var(--white);
                padding: 0.5rem 0.75rem;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
                box-shadow: 0 2px 8px rgba(34, 197, 94, 0.3);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .verification-badge i {
                font-size: 0.8rem;
            }
            
            /* Action Button */
            .card-actions {
                margin-top: 0.75rem;
                padding: 0 2rem 1.5rem 2rem;
            }
            
            .action-btn {
                width: 100%;
                background: linear-gradient(135deg, 
                    rgba(255, 173, 81, 0.1) 0%, 
                    rgba(255, 173, 81, 0.05) 100%);
                border: 2px solid rgba(255, 173, 81, 0.2);
                border-radius: 14px;
                padding: 0.875rem 1.25rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                color: var(--black);
                font-weight: 700;
                font-size: 0.95rem;
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
                cursor: pointer;
                position: relative;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }
            
            .action-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                transition: left 0.6s cubic-bezier(0.23, 1, 0.32, 1);
                z-index: 1;
            }
            
            .btn-text, .btn-icon {
                position: relative;
                z-index: 2;
                transition: all 0.4s ease;
            }
            
            .btn-icon {
                width: 32px;
                height: 32px;
                background: rgba(255, 173, 81, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--heading-color);
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            }
            
            .professional-report-card:hover .action-btn {
                border-color: var(--heading-color);
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(255, 173, 81, 0.3);
            }
            
            .professional-report-card:hover .action-btn::before {
                left: 0;
            }
            
            .professional-report-card:hover .btn-text {
                color: var(--white);
            }
            
            .professional-report-card:hover .btn-icon {
                background: rgba(255, 255, 255, 0.2);
                color: var(--white);
                transform: translateX(8px) scale(1.1);
            }
            
            /* Dark Mode Adjustments */
            [data-theme="dark"] .professional-report-card {
                background: linear-gradient(135deg, 
                    var(--theme-card-bg) 0%, 
                    rgba(47, 43, 43, 0.98) 50%, 
                    var(--theme-card-bg) 100%);
                border: 2px solid rgba(255, 173, 81, 0.3);
                box-shadow: 
                    0 12px 48px rgba(0, 0, 0, 0.4),
                    0 4px 16px rgba(0, 0, 0, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            
            [data-theme="dark"] .card-header-pro {
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            [data-theme="dark"] .location-title {
                color: #ffffff;
            }
            
            [data-theme="dark"] .date-display {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary) 0%, 
                    rgba(58, 54, 54, 0.8) 100%);
                border: 1px solid rgba(255, 173, 81, 0.2);
            }
            
            [data-theme="dark"] .date-day {
                color: #ffffff;
            }
            
            [data-theme="dark"] .professional-slideshow {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary) 0%, 
                    rgba(58, 54, 54, 0.8) 100%);
            }
            
            [data-theme="dark"] .no-image-placeholder {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary) 0%, 
                    rgba(58, 54, 54, 0.6) 50%,
                    var(--theme-bg-tertiary) 100%);
            }
            
            [data-theme="dark"] .weather-tag {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary) 0%, 
                    rgba(58, 54, 54, 0.9) 100%);
                color: #ffffff;
                border: 1px solid rgba(255, 173, 81, 0.3);
            }
            
            [data-theme="dark"] .observer-info {
                background: linear-gradient(135deg, 
                    rgba(58, 54, 54, 0.5) 0%, 
                    rgba(47, 43, 43, 0.8) 100%);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            [data-theme="dark"] .observer-name {
                color: #ffffff;
            }
            
            [data-theme="dark"] .action-btn {
                background: linear-gradient(135deg, 
                    rgba(255, 173, 81, 0.2) 0%, 
                    rgba(255, 173, 81, 0.1) 100%);
                border: 2px solid rgba(255, 173, 81, 0.3);
                color: #ffffff;
            }
            
            [data-theme="dark"] .btn-icon {
                background: rgba(255, 173, 81, 0.2);
                color: var(--heading-color);
            }
            
            /* Responsive Design */
            @media (max-width: 991.98px) {
                .professional-report-card {
                    height: 620px;
                }
                
                .professional-slideshow {
                    height: 260px;
                }
                
                .no-image-placeholder {
                    height: 260px;
                }
                
                .card-content-pro {
                    padding: 1.25rem 1.5rem 0 1.5rem;
                    gap: 0.75rem;
                }
                
                .card-actions {
                    margin-top: 0.75rem;
                    padding: 0 1.5rem 1.25rem 1.5rem;
                }
                
                .carousel-nav {
                    width: 40px;
                    height: 40px;
                    font-size: 0.9rem;
                }
                
                .carousel-nav.carousel-prev {
                    left: 10px;
                }
                
                .carousel-nav.carousel-next {
                    right: 10px;
                }
                
                .image-counter {
                    top: 15px;
                    right: 15px;
                    padding: 6px 10px;
                    font-size: 0.8rem;
                }
                
                .carousel-dots {
                    bottom: 15px;
                    padding: 8px 12px;
                }
                
                .carousel-dot {
                    width: 8px;
                    height: 8px;
                }
            }
            
            @media (max-width: 767.98px) {
                .professional-report-card {
                    height: 580px;
                }
                
                .professional-slideshow {
                    height: 240px;
                }
                
                .no-image-placeholder {
                    height: 240px;
                }
                
                .card-header-pro {
                    padding: 1.25rem 1.5rem 0.75rem;
                }
                
                .card-content-pro {
                    padding: 1rem 1.5rem 0 1.5rem;
                    gap: 0.5rem;
                }
                
                .card-actions {
                    margin-top: 0.5rem;
                    padding: 0 1.5rem 1rem 1.5rem;
                }
                
                .header-content {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start;
                }
                
                .date-info {
                    flex-direction: row;
                    align-items: center;
                    align-self: flex-end;
                }
                
                .location-title {
                    font-size: 1.2rem;
                }
                
                .carousel-nav {
                    width: 36px;
                    height: 36px;
                    font-size: 0.8rem;
                }
                
                .observer-info {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: flex-start;
                }
                
                .verification-badge {
                    align-self: flex-end;
                }
                
                .action-btn {
                    padding: 0.875rem 1.25rem;
                    font-size: 0.95rem;
                }
            }
            
            /* Enhanced No Reports State */
            .no-reports {
                text-align: center;
                padding: 8rem 2rem;
                color: var(--body-text);
                background: linear-gradient(135deg, 
                    rgba(255, 255, 255, 0.8) 0%, 
                    rgba(207, 226, 255, 0.1) 50%, 
                    rgba(255, 255, 255, 0.8) 100%);
                border-radius: 24px;
                border: 1px solid rgba(255, 173, 81, 0.1);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.04),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
                position: relative;
                overflow: hidden;
            }
            
            .no-reports::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at center, rgba(255, 173, 81, 0.03) 0%, transparent 70%);
                pointer-events: none;
            }
            
            .no-reports i {
                font-size: 6rem;
                color: var(--heading-color);
                margin-bottom: 2.5rem;
                opacity: 0.8;
                filter: drop-shadow(0 4px 12px rgba(255, 173, 81, 0.2));
                animation: float 3s ease-in-out infinite;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            
            .no-reports h4 {
                font-weight: 700;
                color: var(--black);
                margin-bottom: 1.5rem;
                font-size: 2.2rem;
                line-height: 1.3;
            }
            
            .no-reports p {
                font-size: 1.2rem;
                max-width: 600px;
                margin: 0 auto;
                line-height: 1.7;
                font-weight: 400;
                opacity: 0.9;
            }
            
            /* Dark Mode No Reports Styling */
            [data-theme="dark"] .no-reports {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary, #3a3636) 0%, 
                    rgba(58, 54, 54, 0.3) 50%, 
                    var(--theme-bg-tertiary, #3a3636) 100%);
                border: 1px solid rgba(255, 173, 81, 0.2);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
                color: var(--theme-text-secondary, #adb5bd);
            }
            
            [data-theme="dark"] .no-reports::before {
                background: radial-gradient(circle at center, rgba(255, 173, 81, 0.05) 0%, transparent 70%);
            }
            
            [data-theme="dark"] .no-reports h4 {
                color: var(--theme-text-primary, #ffffff);
            }
            
            [data-theme="dark"] .no-reports p {
                color: var(--theme-text-secondary, #adb5bd);
            }
            
            [data-theme="dark"] .no-reports i {
                color: var(--heading-color);
                filter: drop-shadow(0 4px 12px rgba(255, 173, 81, 0.3));
            }
            
            /* Professional Modal Styles */
            .professional-modal-content {
                background: linear-gradient(135deg, 
                    var(--white) 0%, 
                    rgba(255, 255, 255, 0.98) 100%);
                border-radius: 24px;
                border: none;
                box-shadow: 
                    0 25px 80px rgba(0, 0, 0, 0.15),
                    0 10px 32px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
                overflow: hidden;
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 173, 81, 0.1);
            }
            
            .professional-modal-header {
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                color: var(--white);
                padding: 2rem 2.5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: relative;
                overflow: hidden;
            }
            
            .professional-modal-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(90deg, 
                    transparent 0%, 
                    rgba(255, 255, 255, 0.1) 50%, 
                    transparent 100%);
                animation: modalHeaderShine 3s ease-in-out infinite;
            }
            
            @keyframes modalHeaderShine {
                0%, 100% { transform: translateX(-100%); }
                50% { transform: translateX(100%); }
            }
            
            .modal-header-content {
                display: flex;
                align-items: center;
                gap: 1.5rem;
                position: relative;
                z-index: 2;
            }
            
            .modal-icon {
                width: 60px;
                height: 60px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.8rem;
                box-shadow: 
                    0 8px 25px rgba(0, 0, 0, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .modal-title-section h4 {
                font-weight: 700;
                font-size: 1.8rem;
                margin: 0 0 0.5rem 0;
                color: var(--white);
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            }
            
            .modal-subtitle {
                margin: 0;
                opacity: 0.9;
                font-size: 1rem;
                font-weight: 500;
                color: rgba(255, 255, 255, 0.9);
            }
            
            .professional-close-btn {
                width: 44px;
                height: 44px;
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--white);
                font-size: 1.2rem;
                transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                cursor: pointer;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                position: relative;
                z-index: 2;
            }
            
            .professional-close-btn:hover {
                background: rgba(255, 255, 255, 0.9);
                color: var(--heading-color);
                transform: scale(1.1) rotate(90deg);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            
            .professional-modal-body {
                padding: 2.5rem;
                background: var(--primary-bg);
                min-height: 400px;
            }
            
            /* Enhanced Loading State */
            .loading-state {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 4rem 2rem;
                text-align: center;
            }
            
            .loading-icon {
                font-size: 4rem;
                color: var(--heading-color);
                margin-bottom: 2rem;
                opacity: 0.8;
                animation: loadingFloat 3s ease-in-out infinite;
            }
            
            @keyframes loadingFloat {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            
            .loading-spinner {
                width: 40px;
                height: 40px;
                border: 3px solid rgba(255, 173, 81, 0.2);
                border-top: 3px solid var(--heading-color);
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin-bottom: 2rem;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            .loading-state h5 {
                font-weight: 700;
                color: var(--black);
                margin-bottom: 1rem;
                font-size: 1.5rem;
            }
            
            .loading-state p {
                color: var(--body-text);
                font-size: 1.1rem;
                opacity: 0.8;
                max-width: 400px;
            }
            
            /* Professional Detail Items */
            .professional-detail-item {
                background: linear-gradient(135deg, 
                    rgba(255, 255, 255, 0.8) 0%, 
                    rgba(248, 249, 250, 0.9) 100%);
                border-radius: 16px;
                padding: 2rem;
                margin-bottom: 1.5rem;
                border: 1px solid rgba(255, 173, 81, 0.1);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            
            .professional-detail-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                border-radius: 0 2px 2px 0;
            }
            
            .professional-detail-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            }
            
            .professional-detail-label {
                font-weight: 700;
                color: var(--black);
                margin-bottom: 1rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-size: 1.1rem;
            }
            
            .professional-detail-label i {
                color: var(--heading-color);
                font-size: 1rem;
                width: 20px;
                text-align: center;
            }
            
            .professional-detail-value {
                color: var(--body-text);
                font-size: 1rem;
                line-height: 1.7;
                font-weight: 500;
                margin-left: 2.75rem;
            }
            
            .professional-detail-value strong {
                color: var(--black);
                font-weight: 700;
            }
            
            /* Enhanced Media Grid */
            .professional-media-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                gap: 1.5rem;
                margin-top: 1.5rem;
                margin-left: 2.75rem;
            }
            
            .professional-media-item {
                border-radius: 12px;
                overflow: hidden;
                aspect-ratio: 1;
                background: var(--container-bg);
                cursor: pointer;
                transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                position: relative;
                group: true;
            }
            
            .professional-media-item::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, 
                    rgba(255, 173, 81, 0.1) 0%, 
                    transparent 100%);
                opacity: 0;
                transition: opacity 0.3s ease;
                z-index: 2;
            }
            
            .professional-media-item:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            }
            
            .professional-media-item:hover::before {
                opacity: 1;
            }
            
            .professional-media-item img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: all 0.4s ease;
            }
            
            .professional-media-item:hover img {
                transform: scale(1.1);
            }
            
            /* Weather Tags in Modal */
            .modal-weather-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin-left: 2.75rem;
                margin-top: 1rem;
            }
            
            .modal-weather-tag {
                background: linear-gradient(135deg, 
                    var(--container-bg) 0%, 
                    rgba(207, 226, 255, 0.9) 100%);
                color: var(--black);
                padding: 0.75rem 1.25rem;
                border-radius: 25px;
                font-size: 0.9rem;
                font-weight: 600;
                border: 1px solid rgba(255, 173, 81, 0.2);
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            }
            
            .modal-weather-tag:hover {
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                color: var(--white);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 173, 81, 0.3);
            }
            
            /* Dark Mode Modal Adjustments */
            [data-theme="dark"] .professional-modal-content {
                background: linear-gradient(135deg, 
                    var(--theme-card-bg) 0%, 
                    rgba(47, 43, 43, 0.98) 100%);
                border: 1px solid rgba(255, 173, 81, 0.2);
                box-shadow: 
                    0 25px 80px rgba(0, 0, 0, 0.5),
                    0 10px 32px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            
            [data-theme="dark"] .professional-modal-body {
                background: var(--theme-bg-primary);
            }
            
            [data-theme="dark"] .loading-state h5 {
                color: #ffffff;
            }
            
            [data-theme="dark"] .professional-detail-item {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary) 0%, 
                    rgba(58, 54, 54, 0.9) 100%);
                border: 1px solid rgba(255, 173, 81, 0.2);
            }
            
            [data-theme="dark"] .professional-detail-label {
                color: #ffffff;
            }
            
            [data-theme="dark"] .professional-detail-value strong {
                color: #ffffff;
            }
            
            [data-theme="dark"] .modal-weather-tag {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary) 0%, 
                    rgba(58, 54, 54, 0.9) 100%);
                color: #ffffff;
                border: 1px solid rgba(255, 173, 81, 0.3);
            }
            
            /* Responsive Modal Design */
            @media (max-width: 991.98px) {
                .professional-modal-header {
                    padding: 1.5rem 2rem;
                }
                
                .modal-header-content {
                    gap: 1rem;
                }
                
                .modal-icon {
                    width: 50px;
                    height: 50px;
                    font-size: 1.5rem;
                }
                
                .modal-title-section h4 {
                    font-size: 1.5rem;
                }
                
                .professional-modal-body {
                    padding: 2rem;
                }
                
                .professional-media-grid {
                    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                    gap: 1rem;
                }
            }
            
            @media (max-width: 767.98px) {
                .modal-dialog {
                    margin: 1rem;
                }
                
                .professional-modal-header {
                    padding: 1.25rem 1.5rem;
                }
                
                .modal-header-content {
                    flex-direction: column;
                    text-align: center;
                    gap: 1rem;
                }
                
                .modal-title-section h4 {
                    font-size: 1.3rem;
                }
                
                .professional-modal-body {
                    padding: 1.5rem;
                }
                
                .professional-detail-value,
                .professional-media-grid,
                .modal-weather-tags {
                    margin-left: 0;
                }
                
                .professional-detail-label {
                    justify-content: center;
                }
                
                .professional-media-grid {
                    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
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
            
            /* Enhanced Tooltip Styles with Light/Dark Mode Support */
            .tooltip {
                font-size: 0.875rem;
                font-family: 'Poppins', sans-serif;
                z-index: 1070;
            }
            
            /* Light Mode Tooltip Styles */
            .tooltip-inner {
                max-width: 320px;
                padding: 20px 24px;
                background: linear-gradient(135deg, 
                    rgba(255, 255, 255, 0.95) 0%, 
                    rgba(248, 249, 250, 0.95) 100%);
                border: 1px solid rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.15),
                    0 8px 20px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
                text-align: left;
                line-height: 1.5;
                color: #2c3e50;
                position: relative;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            /* Dark Mode Tooltip Styles */
            [data-theme="dark"] .tooltip-inner {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary, #3a3636) 0%, 
                    var(--theme-bg-secondary, #2f2b2b) 100%);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.4),
                    0 8px 20px rgba(0, 0, 0, 0.2),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
                color: #ffffff;
            }
            
            .tooltip-inner::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(255, 173, 81, 0.1) 0%, rgba(255, 173, 81, 0.05) 100%);
                border-radius: 12px;
                pointer-events: none;
            }
            
            .tooltip-inner strong {
                color: var(--heading-color);
                font-weight: 600;
                display: block;
                margin-bottom: 6px;
                font-size: 0.95rem;
                letter-spacing: 0.3px;
            }
            
            .tooltip-inner strong::before {
                content: '';
                display: inline-block;
                width: 6px;
                height: 6px;
                background: var(--heading-color);
                border-radius: 50%;
                margin-right: 8px;
                box-shadow: 0 0 8px rgba(255, 173, 81, 0.6);
                animation: tooltipPulse 2s infinite;
            }
            
            @keyframes tooltipPulse {
                0%, 100% { 
                    opacity: 1; 
                    transform: scale(1);
                }
                50% { 
                    opacity: 0.7; 
                    transform: scale(1.2);
                }
            }
            
            /* Enhanced Arrow Styling */
            .tooltip .tooltip-arrow {
                width: 16px;
                height: 16px;
            }
            
            /* Light Mode Arrow Colors */
            .tooltip.bs-tooltip-top .tooltip-arrow::before {
                border-top-color: rgba(255, 255, 255, 0.95);
                filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.15));
            }
            
            .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
                border-bottom-color: rgba(255, 255, 255, 0.95);
                filter: drop-shadow(0 -3px 6px rgba(0, 0, 0, 0.15));
            }
            
            .tooltip.bs-tooltip-start .tooltip-arrow::before {
                border-left-color: rgba(255, 255, 255, 0.95);
                filter: drop-shadow(3px 0 6px rgba(0, 0, 0, 0.15));
            }
            
            .tooltip.bs-tooltip-end .tooltip-arrow::before {
                border-right-color: rgba(255, 255, 255, 0.95);
                filter: drop-shadow(-3px 0 6px rgba(0, 0, 0, 0.15));
            }
            
            /* Dark Mode Arrow Colors */
            [data-theme="dark"] .tooltip.bs-tooltip-top .tooltip-arrow::before {
                border-top-color: var(--theme-bg-tertiary, #3a3636);
                filter: drop-shadow(0 3px 6px rgba(0, 0, 0, 0.4));
            }
            
            [data-theme="dark"] .tooltip.bs-tooltip-bottom .tooltip-arrow::before {
                border-bottom-color: var(--theme-bg-tertiary, #3a3636);
                filter: drop-shadow(0 -3px 6px rgba(0, 0, 0, 0.4));
            }
            
            [data-theme="dark"] .tooltip.bs-tooltip-start .tooltip-arrow::before {
                border-left-color: var(--theme-bg-tertiary, #3a3636);
                filter: drop-shadow(3px 0 6px rgba(0, 0, 0, 0.4));
            }
            
            [data-theme="dark"] .tooltip.bs-tooltip-end .tooltip-arrow::before {
                border-right-color: var(--theme-bg-tertiary, #3a3636);
                filter: drop-shadow(-3px 0 6px rgba(0, 0, 0, 0.4));
            }
            
            /* Tooltip Animation */
            .tooltip {
                opacity: 0;
                transform: translateY(8px) scale(0.95);
                transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            }
            
            .tooltip.show {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            
            /* Hover effect for tooltip triggers */
            [data-bs-toggle="tooltip"]:hover {
                transition: all 0.2s ease;
            }
            
            .nav-link[data-bs-toggle="tooltip"]:hover {
                color: var(--heading-color) !important;
                transform: translateY(-1px);
            }
            
            .btn[data-bs-toggle="tooltip"]:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }
            
            /* Mobile responsive tooltips */
            @media (max-width: 768px) {
                .tooltip-inner {
                    max-width: 280px;
                    padding: 16px 20px;
                    font-size: 0.85rem;
                }
                
                .tooltip-inner strong {
                    font-size: 0.9rem;
                }
            }
            
            /* Responsive Design */
            @media (max-width: 991.98px) {
                .report-card {
                    margin-bottom: 2rem;
                    padding: 2rem 1.5rem;
                }
                
                :root {
                    --section-padding: 60px;
                }
                
                .section-title {
                    font-size: clamp(2rem, 4vw, 2.8rem);
                }
            }
            
            @media (max-width: 767.98px) {
                .services-banner {
                    margin-bottom: 2rem;
                }
                
                .reports-section {
                    padding: 1.5rem 1.5rem 60px 1.5rem;
                    margin: 1rem 0;
                    border-radius: 24px;
                }
                
                .report-card {
                    padding: 2rem 1.5rem;
                }
                
                .section-subtitle {
                    font-size: 1.1rem;
                    margin-bottom: 2rem;
                }
                
                :root {
                    --section-padding: 40px;
                }
            }
            
            /* Utility Classes */
            .btn-container {
                text-align: center;
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
            
            /* Loading States */
            .spinner-border {
                color: var(--black);
            }
            
            /* Enhanced Filter Section Styles */
            .filter-section {
                background: linear-gradient(135deg, 
                    rgba(255, 255, 255, 0.9) 0%, 
                    rgba(207, 226, 255, 0.1) 50%, 
                    rgba(255, 255, 255, 0.9) 100%);
                border-radius: 20px;
                padding: 2rem;
                margin-bottom: 2rem;
                border: 1px solid rgba(255, 173, 81, 0.15);
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.06),
                    0 2px 8px rgba(0, 0, 0, 0.04),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .filter-section::before {
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
                animation: filterShine 4s ease-in-out infinite;
                pointer-events: none;
            }
            
            @keyframes filterShine {
                0%, 100% { left: -100%; }
                50% { left: 100%; }
            }
            
            .filter-label {
                display: flex;
                align-items: center;
                font-weight: 600;
                color: var(--black);
                font-size: 1.1rem;
                text-shadow: 0 1px 2px rgba(255, 255, 255, 0.8);
            }
            
            .filter-label i {
                color: var(--heading-color);
                opacity: 0.9;
                filter: drop-shadow(0 1px 2px rgba(255, 173, 81, 0.3));
            }
            
            .filter-dropdown {
                position: relative;
            }
            
            .filter-dropdown .form-select {
                background: linear-gradient(135deg, 
                    var(--white) 0%, 
                    rgba(248, 249, 250, 0.95) 100%);
                border: 2px solid rgba(255, 173, 81, 0.2);
                border-radius: 14px;
                padding: 0.75rem 2.5rem 0.75rem 1.25rem;
                font-weight: 600;
                color: var(--black);
                font-size: 1rem;
                min-width: 200px;
                box-shadow: 
                    0 4px 15px rgba(0, 0, 0, 0.08),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
                transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                cursor: pointer;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
            }
            
            /* Light theme arrow */
            :not([data-theme="dark"]) .filter-dropdown .form-select {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FFAD51' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 0.75rem center;
                background-size: 16px 12px;
            }
            
            .filter-dropdown .form-select:focus {
                border-color: var(--heading-color);
                box-shadow: 
                    0 0 0 3px rgba(255, 173, 81, 0.25),
                    0 6px 20px rgba(255, 173, 81, 0.15);
                outline: none;
                transform: translateY(-2px);
            }
            
            .filter-dropdown .form-select:hover {
                border-color: rgba(255, 173, 81, 0.4);
                transform: translateY(-1px);
                box-shadow: 
                    0 6px 20px rgba(0, 0, 0, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.9);
            }
            
            .filter-count .badge {
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%);
                color: var(--white);
                padding: 0.75rem 1.25rem;
                border-radius: 20px;
                font-size: 0.9rem;
                font-weight: 700;
                border: 1px solid rgba(255, 255, 255, 0.2);
                box-shadow: 
                    0 4px 15px rgba(255, 173, 81, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            }
            
            .filter-count .badge::before {
                content: '';
                width: 6px;
                height: 6px;
                background: rgba(255, 255, 255, 0.8);
                border-radius: 50%;
                animation: badgePulse 2s infinite;
            }
            
            @keyframes badgePulse {
                0%, 100% { 
                    opacity: 1; 
                    transform: scale(1);
                }
                50% { 
                    opacity: 0.7; 
                    transform: scale(1.2);
                }
            }
            
            /* Enhanced Dark Mode Filter Styles */
            [data-theme="dark"] .filter-section {
                background: linear-gradient(135deg, 
                    var(--theme-bg-tertiary, #3a3636) 0%, 
                    rgba(58, 54, 54, 0.5) 50%, 
                    var(--theme-bg-tertiary, #3a3636) 100%) !important;
                border: 1px solid rgba(255, 173, 81, 0.3) !important;
                box-shadow: 
                    0 8px 32px rgba(0, 0, 0, 0.5),
                    0 2px 8px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(15px) !important;
                -webkit-backdrop-filter: blur(15px) !important;
            }
            
            [data-theme="dark"] .filter-section::before {
                background: linear-gradient(90deg, 
                    transparent 0%, 
                    rgba(255, 173, 81, 0.15) 50%, 
                    transparent 100%) !important;
            }
            
            [data-theme="dark"] .filter-label {
                color: var(--theme-text-primary, #ffffff) !important;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            }
            
            [data-theme="dark"] .filter-label i {
                color: var(--heading-color) !important;
                filter: drop-shadow(0 1px 2px rgba(255, 173, 81, 0.5));
            }
            
            [data-theme="dark"] .filter-dropdown .form-select {
                background: linear-gradient(135deg, 
                    var(--theme-card-bg, #2f2b2b) 0%, 
                    rgba(47, 43, 43, 0.95) 100%) !important;
                color: #ffffff !important;
                border: 2px solid rgba(255, 173, 81, 0.3) !important;
                box-shadow: 
                    0 4px 15px rgba(0, 0, 0, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1) !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FFAD51' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
                background-repeat: no-repeat !important;
                background-position: right 0.75rem center !important;
                background-size: 16px 12px !important;
            }
            
            [data-theme="dark"] .filter-dropdown .form-select:hover {
                background: linear-gradient(135deg, 
                    rgba(58, 54, 54, 0.9) 0%, 
                    rgba(47, 43, 43, 0.9) 100%) !important;
                border-color: rgba(255, 173, 81, 0.5) !important;
                box-shadow: 
                    0 6px 20px rgba(0, 0, 0, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.15) !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FFAD51' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
                background-repeat: no-repeat !important;
                background-position: right 0.75rem center !important;
                background-size: 16px 12px !important;
            }
            
            [data-theme="dark"] .filter-dropdown .form-select:focus {
                background: linear-gradient(135deg, 
                    var(--theme-card-bg, #2f2b2b) 0%, 
                    rgba(47, 43, 43, 0.95) 100%) !important;
                border-color: var(--heading-color) !important;
                box-shadow: 
                    0 0 0 3px rgba(255, 173, 81, 0.25),
                    0 6px 20px rgba(255, 173, 81, 0.15) !important;
                color: #ffffff !important;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23FFAD51' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
                background-repeat: no-repeat !important;
                background-position: right 0.75rem center !important;
                background-size: 16px 12px !important;
            }
            
            /* Specific dark theme dropdown options styling */
            [data-theme="dark"] .filter-dropdown .form-select option {
                background-color: var(--theme-card-bg, #2f2b2b) !important;
                color: #ffffff !important;
                padding: 8px 12px;
            }
            
            [data-theme="dark"] .filter-dropdown .form-select option:hover {
                background-color: rgba(255, 173, 81, 0.2) !important;
                color: #ffffff !important;
            }
            
            [data-theme="dark"] .filter-dropdown .form-select option:checked {
                background-color: var(--heading-color) !important;
                color: #ffffff !important;
            }
            
            /* Force dark theme for webkit browsers */
            [data-theme="dark"] .filter-dropdown .form-select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }
            
            /* Additional dark theme support for different browsers */
            [data-theme="dark"] .filter-dropdown select {
                background: linear-gradient(135deg, 
                    var(--theme-card-bg, #2f2b2b) 0%, 
                    rgba(47, 43, 43, 0.95) 100%) !important;
                color: #ffffff !important;
                border: 2px solid rgba(255, 173, 81, 0.3) !important;
                background-image: none !important;
            }
            
            [data-theme="dark"] .filter-dropdown select option {
                background: var(--theme-card-bg, #2f2b2b) !important;
                color: #ffffff !important;
            }
            
            /* Dark theme filter count badge */
            [data-theme="dark"] .filter-count .badge {
                background: linear-gradient(135deg, 
                    var(--heading-color) 0%, 
                    #ffb866 100%) !important;
                color: #ffffff !important;
                border: 1px solid rgba(255, 255, 255, 0.3) !important;
                box-shadow: 
                    0 4px 15px rgba(255, 173, 81, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.4) !important;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            }
            
            [data-theme="dark"] .filter-count .badge::before {
                background: rgba(255, 255, 255, 0.9) !important;
            }
            
            /* Additional dark theme overrides for filter section */
            html[data-theme="dark"] .filter-section,
            body[data-theme="dark"] .filter-section,
            .dark-theme .filter-section {
                background: linear-gradient(135deg, 
                    #3a3636 0%, 
                    rgba(58, 54, 54, 0.6) 50%, 
                    #3a3636 100%) !important;
                border: 1px solid rgba(255, 173, 81, 0.4) !important;
                color: #ffffff !important;
            }
            
            html[data-theme="dark"] .filter-label,
            body[data-theme="dark"] .filter-label,
            .dark-theme .filter-label {
                color: #ffffff !important;
            }
            
            html[data-theme="dark"] .filter-label span,
            body[data-theme="dark"] .filter-label span,
            .dark-theme .filter-label span {
                color: #ffffff !important;
            }
            
            /* Force dark theme for the entire filter container */
            [data-theme="dark"] .filter-section * {
                color: inherit;
            }
            
            [data-theme="dark"] .filter-section .d-flex {
                color: #ffffff;
            }
            
            /* Loading indicator for reports */
            .reports-loading {
                text-align: center;
                padding: 4rem 2rem;
                color: var(--body-text);
            }
            
            .reports-loading .loading-spinner {
                width: 40px;
                height: 40px;
                border: 3px solid rgba(255, 173, 81, 0.2);
                border-top: 3px solid var(--heading-color);
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 1.5rem;
            }
            
            .reports-loading h5 {
                color: var(--black);
                margin-bottom: 0.5rem;
                font-weight: 600;
            }
            
            .reports-loading p {
                color: var(--body-text);
                margin: 0;
                opacity: 0.8;
            }
            
            /* Dark mode loading */
            [data-theme="dark"] .reports-loading h5 {
                color: #ffffff;
            }
            
            /* Responsive Design */
            @media (max-width: 767.98px) {
                .filter-section {
                    padding: 1.5rem;
                    margin-bottom: 1.5rem;
                }
                
                .filter-section .d-flex {
                    flex-direction: column;
                    gap: 1rem !important;
                    text-align: center;
                }
                
                .filter-dropdown .form-select {
                    min-width: 250px;
                    width: 100%;
                }
                
                .filter-label {
                    justify-content: center;
                    font-size: 1rem;
                }
            }
        </style>

        <!-- Welcome Page Content Wrapper -->
        <div class="welcome-page-wrapper">

        <div class="container-fluid px-4">
            <!-- Services Banner -->
            <div class="container" style="padding-top: 4rem;">
                <div class="services-banner" data-aos="fade-up" data-aos-delay="200">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Official meteorological staff</strong> can login to submit verified reports. 
                                    <strong>Public contributions</strong> welcome through our citizen science program.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Reports Section -->
            <div class="container">
                <div class="reports-section" data-aos="fade-up" data-aos-delay="300">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="section-title">Latest Weather Reports</h2>
                            <p class="section-subtitle">
                                Weather reports from across Pakistan - submitted by meteorological stations, registered officials, and citizens like you
                            </p>
                        </div>
                    </div>
                    
                    <!-- Region Filter Section -->
                    <div class="row mb-4" data-aos="fade-up" data-aos-delay="350">
                        <div class="col-12">
                            <div class="filter-section">
                                <div class="d-flex justify-content-center align-items-center flex-wrap gap-3">
                                    <div class="filter-label">
                                        <i class="fas fa-filter me-2"></i>
                                        <span>Filter by Reporter's Region:</span>
                                    </div>
                                    <div class="filter-dropdown">
                                        <select id="regionFilter" class="form-select">
                                            <option value="all">All Regions</option>
                                            @foreach($regions as $region)
                                                <option value="{{ $region->name }}">{{ $region->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="filter-count">
                                        <span id="filterCount" class="badge">{{ $latestReports->count() }} reports from all reporters</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($latestReports && $latestReports->count() > 0)
                        <div class="row g-4" id="reportsContainer">
                            @foreach($latestReports as $index => $report)
                                <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="{{ 400 + ($index * 100) }}">
                                    <div class="professional-report-card" data-report-id="{{ $report->id }}">
                                        <!-- Card Header with Status Indicator -->
                                        <div class="card-header-pro">
                                            <div class="status-indicator"></div>
                                            <div class="header-content">
                                                <div class="location-info">
                                                    <h3 class="location-title">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        {{ $report->location_city }}
                                                    </h3>
                                                    <p class="location-subtitle">{{ $report->location_state }}</p>
                                                </div>
                                                <div class="date-info">
                                                    <div class="date-display">
                                                        <span class="date-day">{{ $report->event_date ? $report->event_date->format('d') : '--' }}</span>
                                                        <span class="date-month">{{ $report->event_date ? $report->event_date->format('M') : 'N/A' }}</span>
                                                    </div>
                                                    @if($report->event_time)
                                                        <div class="time-display">
                                                            <i class="fas fa-clock"></i>
                                                            {{ $report->event_time }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Enhanced Image Slideshow -->
                                        @if($report->media_files && is_array($report->media_files) && count($report->media_files) > 0)
                                            <div class="professional-slideshow" onclick="event.stopPropagation();">
                                                <div id="carousel{{ $report->id }}" class="carousel slide" data-bs-ride="false">
                                                    <div class="carousel-inner">
                                                        @foreach($report->media_files as $key => $media)
                                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                                <div class="image-container">
                                                                    <img src="{{ asset('storage/' . $media) }}" alt="Weather observation" loading="lazy">
                                                                    <div class="image-overlay">
                                                                        <div class="overlay-gradient"></div>
                                                                        <div class="image-actions">
                                                                            <button class="image-expand" onclick="event.stopPropagation(); expandImage('{{ asset('storage/' . $media) }}');">
                                                                                <i class="fas fa-expand"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    
                                                    @if(count($report->media_files) > 1)
                                                        <!-- Custom Navigation -->
                                                        <button class="carousel-nav carousel-prev" type="button" onclick="event.stopPropagation();" data-bs-target="#carousel{{ $report->id }}" data-bs-slide="prev">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </button>
                                                        <button class="carousel-nav carousel-next" type="button" onclick="event.stopPropagation();" data-bs-target="#carousel{{ $report->id }}" data-bs-slide="next">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </button>
                                                        
                                                        <!-- Enhanced Indicators -->
                                                        <div class="carousel-dots">
                                                            @foreach($report->media_files as $key => $media)
                                                                <button type="button" class="carousel-dot {{ $key === 0 ? 'active' : '' }}" onclick="event.stopPropagation();" data-bs-target="#carousel{{ $report->id }}" data-bs-slide-to="{{ $key }}"></button>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Image Counter -->
                                                    <div class="image-counter">
                                                        <i class="fas fa-camera"></i>
                                                        <span>{{ count($report->media_files) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Placeholder for reports without images -->
                                            <div class="no-image-placeholder">
                                                <div class="placeholder-content">
                                                    <i class="fas fa-cloud-sun"></i>
                                                    <span>Weather Observation</span>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Card Content -->
                                        <div class="card-content-pro">
                                            <!-- Weather Types Section -->
                                            @if($report->weather_types && is_array($report->weather_types))
                                                <div class="weather-categories">
                                                    @foreach(array_slice($report->weather_types, 0, 3) as $type)
                                                        <span class="weather-tag">
                                                            <i class="fas fa-tag"></i>
                                                            {{ $type }}
                                                        </span>
                                                    @endforeach
                                                    @if(count($report->weather_types) > 3)
                                                        <span class="weather-tag more-tag">
                                                            <i class="fas fa-plus"></i>
                                                            {{ count($report->weather_types) - 3 }} more
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            
                                            <!-- Description Section -->
                                            @if($report->event_description)
                                                <div class="description-section">
                                                    <p class="description-text">{{ $report->event_description }}</p>
                                                </div>
                                            @endif
                                            
                                            <!-- Observer Information -->
                                            <div class="observer-info">
                                                <div class="observer-details">
                                                    <div class="observer-avatar">
                                                        <i class="fas fa-user-tie"></i>
                                                    </div>
                                                    <div class="observer-meta">
                                                        <span class="observer-name">{{ $report->user_name ?? 'Anonymous Observer' }}</span>
                                                        <span class="observer-role">{{ $report->designation ?? 'Weather Observer' }}</span>
                                                    </div>
                                                </div>
                                                <div class="verification-badge">
                                                    <i class="fas fa-shield-check"></i>
                                                    <span>Verified</span>
                                                </div>
                                            </div>
                                            
                                                                                         <!-- Action Button -->
                                             <div class="card-actions">
                                                 <button class="action-btn primary-action" onclick="openReportModal({{ $report->id }})">
                                                     <span class="btn-text">View Full Report</span>
                                                     <div class="btn-icon">
                                                         <i class="fas fa-arrow-right"></i>
                                                     </div>
                                                     <div class="btn-ripple"></div>
                                                 </button>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row g-4" id="reportsContainer">
                            <div class="col-12">
                                <div class="no-reports" data-aos="fade-up" data-aos-delay="400">
                                    <i class="fas fa-cloud-rain"></i>
                                    <h4>No Reports Available</h4>
                                    <p>Weather observation reports will appear here once they are submitted and approved by our meteorological team.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div> <!-- Close welcome-page-wrapper -->

        <!-- Enhanced Professional Report Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="professional-modal-content">
                    <div class="professional-modal-header">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="fas fa-cloud-sun"></i>
                            </div>
                            <div class="modal-title-section">
                                <h4 class="professional-modal-title" id="reportModalLabel">
                                    Weather Observation Report
                                </h4>
                                <p class="modal-subtitle">Detailed meteorological analysis</p>
                            </div>
                        </div>
                        <button type="button" class="professional-close-btn" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="professional-modal-body" id="modalContent">
                        <div class="loading-state">
                            <div class="loading-icon">
                                <i class="fas fa-cloud-rain"></i>
                            </div>
                            <div class="loading-spinner"></div>
                            <h5>Loading Weather Report</h5>
                            <p>Retrieving detailed observation data...</p>
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

            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover focus',
                    delay: { show: 300, hide: 100 },
                    html: true,
                    animation: true,
                    customClass: 'custom-tooltip',
                    boundary: 'viewport',
                    fallbackPlacements: ['top', 'right', 'left']
                });
            });

            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

                            // Date formatting function
                function formatDate(dateString) {
                    if (!dateString) return null;
                    
                    try {
                        const date = new Date(dateString);
                        
                        // Check if date is valid
                        if (isNaN(date.getTime())) return dateString;
                        
                        // Format as readable date (e.g., "June 2, 2025")
                        return date.toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                    } catch (error) {
                        console.error('Date formatting error:', error);
                        return dateString; // Return original if formatting fails
                    }
                }

                            // Professional modal functions
                function displayReportDetails(report) {
                    const modalContent = document.getElementById('modalContent');
                    
                    let sections = [];
                    
                    // Observer Information - only show if we have meaningful data
                    if (report.user_name || report.designation) {
                        let observerInfo = '';
                        if (report.user_name) {
                            observerInfo += `<strong>Name:</strong> ${report.user_name}`;
                        }
                        if (report.designation) {
                            if (observerInfo) observerInfo += '<br>';
                            observerInfo += `<strong>Designation:</strong> ${report.designation}`;
                        }
                        
                        if (observerInfo) {
                            sections.push(`
                                <div class="professional-detail-item">
                                    <div class="professional-detail-label">
                                        <i class="fas fa-user-tie"></i>Observer Information
                                    </div>
                                    <div class="professional-detail-value">
                                        ${observerInfo}
                                    </div>
                                </div>
                            `);
                        }
                    }
                    
                    // Location Details - only show if we have city and state
                    if (report.location_city && report.location_state) {
                        let locationInfo = `<strong>City:</strong> ${report.location_city}<br><strong>State/Province:</strong> ${report.location_state}`;
                        if (report.latitude && report.longitude) {
                            locationInfo += `<br><strong>Coordinates:</strong> ${report.latitude}, ${report.longitude}`;
                        }
                        
                        sections.push(`
                            <div class="professional-detail-item">
                                <div class="professional-detail-label">
                                    <i class="fas fa-map-marker-alt"></i>Location Details
                                </div>
                                <div class="professional-detail-value">
                                    ${locationInfo}
                                </div>
                            </div>
                        `);
                    }
                    
                    // Date & Time Information - only show if we have actual date or time
                    if (report.event_date || report.event_time) {
                        let dateTimeInfo = '';
                        if (report.event_date) {
                            const formattedDate = formatDate(report.event_date);
                            if (formattedDate) {
                                dateTimeInfo += `<strong>Date:</strong> ${formattedDate}`;
                            }
                        }
                        if (report.event_time) {
                            if (dateTimeInfo) dateTimeInfo += '<br>';
                            dateTimeInfo += `<strong>Time:</strong> ${report.event_time}`;
                        }
                        if (report.time_zone) {
                            if (dateTimeInfo) dateTimeInfo += '<br>';
                            dateTimeInfo += `<strong>Timezone:</strong> ${report.time_zone}`;
                        }
                        
                        if (dateTimeInfo) {
                            sections.push(`
                                <div class="professional-detail-item">
                                    <div class="professional-detail-label">
                                        <i class="fas fa-calendar-alt"></i>Date & Time Information
                                    </div>
                                    <div class="professional-detail-value">
                                        ${dateTimeInfo}
                                    </div>
                                </div>
                            `);
                        }
                    }
                    
                    // Weather Phenomena - only show if there are weather types
                    if (report.weather_types && Array.isArray(report.weather_types) && report.weather_types.length > 0) {
                        sections.push(`
                            <div class="professional-detail-item">
                                <div class="professional-detail-label">
                                    <i class="fas fa-cloud"></i>Weather Phenomena
                                </div>
                                <div class="modal-weather-tags">
                                    ${report.weather_types.map(type => 
                                        `<span class="modal-weather-tag"><i class="fas fa-tag"></i>${type}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        `);
                    }
                    
                    // Detailed Description - only show if there's actual content
                    if (report.event_description && report.event_description.trim()) {
                        sections.push(`
                            <div class="professional-detail-item">
                                <div class="professional-detail-label">
                                    <i class="fas fa-file-alt"></i>Detailed Description
                                </div>
                                <div class="professional-detail-value">${report.event_description}</div>
                            </div>
                        `);
                    }
                    
                    // Reported Damages - only show if there are damages
                    if (report.damages && Array.isArray(report.damages) && report.damages.length > 0) {
                        sections.push(`
                            <div class="professional-detail-item">
                                <div class="professional-detail-label">
                                    <i class="fas fa-exclamation-triangle"></i>Reported Damages
                                </div>
                                <div class="modal-weather-tags">
                                    ${report.damages.map(damage => 
                                        `<span class="modal-weather-tag"><i class="fas fa-exclamation"></i>${damage}</span>`
                                    ).join('')}
                                </div>
                            </div>
                        `);
                    }
                    
                    // Media Files - only show if there are files
                    if (report.media_files && Array.isArray(report.media_files) && report.media_files.length > 0) {
                        sections.push(`
                            <div class="professional-detail-item">
                                <div class="professional-detail-label">
                                    <i class="fas fa-images"></i>Media Files
                                </div>
                                <div class="professional-media-grid">
                                    ${report.media_files.map(file => `
                                        <div class="professional-media-item" onclick="expandImage('/storage/${file}')">
                                            <img src="/storage/${file}" alt="Weather observation" loading="lazy">
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `);
                    }
                    
                    // If no sections to show, display a message
                    if (sections.length === 0) {
                        modalContent.innerHTML = `
                            <div class="professional-detail-item" style="text-align: center;">
                                <div class="professional-detail-label" style="justify-content: center;">
                                    <i class="fas fa-info-circle"></i>No Detailed Information Available
                                </div>
                                <div class="professional-detail-value" style="margin-left: 0; text-align: center;">
                                    This report contains minimal information. Additional details may be added by the observer.
                                </div>
                            </div>
                        `;
                    } else {
                        modalContent.innerHTML = sections.join('');
                    }
                }
                
                function showError(message) {
                    const modalContent = document.getElementById('modalContent');
                    modalContent.innerHTML = `
                        <div class="professional-detail-item" style="text-align: center; border-left: 4px solid #ef4444;">
                            <div class="professional-detail-label" style="justify-content: center; color: #ef4444;">
                                <i class="fas fa-exclamation-triangle"></i>Error Loading Report
                            </div>
                            <div class="professional-detail-value" style="margin-left: 0; text-align: center;">
                                ${message}
                            </div>
                        </div>
                    `;
                }

            // Function to open report modal
            function openReportModal(reportId) {
                const modal = new bootstrap.Modal(document.getElementById('reportModal'));
                
                // Show loading state
                const modalContent = document.getElementById('modalContent');
                modalContent.innerHTML = `
                    <div class="loading-state">
                        <div class="loading-icon">
                            <i class="fas fa-cloud-rain"></i>
                        </div>
                        <div class="loading-spinner"></div>
                        <h5>Loading Weather Report</h5>
                        <p>Retrieving detailed observation data...</p>
                    </div>
                `;
                
                modal.show();
                
                // Fetch report details
                fetch(`/observation/${reportId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayReportDetails(data.observation);
                        } else {
                            showError('Failed to load report details.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('An error occurred while loading the report.');
                    });
            }

            // Image expansion function
            function expandImage(imageSrc) {
                // Create modal for image expansion
                const modal = document.createElement('div');
                modal.className = 'image-expansion-modal';
                modal.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.9);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9999;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                
                const img = document.createElement('img');
                img.src = imageSrc;
                img.style.cssText = `
                    max-width: 90%;
                    max-height: 90%;
                    object-fit: contain;
                    border-radius: 12px;
                    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
                `;
                
                const closeBtn = document.createElement('button');
                closeBtn.innerHTML = '<i class="fas fa-times"></i>';
                closeBtn.style.cssText = `
                    position: absolute;
                    top: 20px;
                    right: 20px;
                    background: rgba(255, 255, 255, 0.9);
                    border: none;
                    border-radius: 50%;
                    width: 50px;
                    height: 50px;
                    font-size: 1.2rem;
                    color: #333;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                `;
                
                closeBtn.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(255, 173, 81, 0.9)';
                    this.style.color = 'white';
                    this.style.transform = 'scale(1.1)';
                });
                
                closeBtn.addEventListener('mouseleave', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.9)';
                    this.style.color = '#333';
                    this.style.transform = 'scale(1)';
                });
                
                function closeModal() {
                    modal.style.opacity = '0';
                    setTimeout(() => modal.remove(), 300);
                }
                
                closeBtn.addEventListener('click', closeModal);
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) closeModal();
                });
                
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') closeModal();
                });
                
                modal.appendChild(img);
                modal.appendChild(closeBtn);
                document.body.appendChild(modal);
                
                // Trigger animation
                setTimeout(() => modal.style.opacity = '1', 10);
            }

            // Enhanced Navbar Scroll Effects and Interactions
            document.addEventListener('DOMContentLoaded', function() {
                const navbar = document.querySelector('.navbar');
                const navbarBrand = document.querySelector('.navbar-brand');
                const navLinks = document.querySelectorAll('.nav-link');
                
                // Initialize carousels properly
                const carousels = document.querySelectorAll('.carousel');
                carousels.forEach(carousel => {
                    // Disable auto-slide initially
                    const bsCarousel = new bootstrap.Carousel(carousel, {
                        interval: false,
                        wrap: true,
                        touch: true,
                        keyboard: true
                    });
                    
                    // Add manual controls
                    const prevBtn = carousel.querySelector('.carousel-prev');
                    const nextBtn = carousel.querySelector('.carousel-next');
                    const dots = carousel.querySelectorAll('.carousel-dot');
                    
                    if (prevBtn) {
                        prevBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            bsCarousel.prev();
                        });
                    }
                    
                    if (nextBtn) {
                        nextBtn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            bsCarousel.next();
                        });
                    }
                    
                    if (dots.length > 0) {
                        dots.forEach((dot, index) => {
                            dot.addEventListener('click', function(e) {
                                e.stopPropagation();
                                bsCarousel.to(index);
                            });
                        });
                        
                        // Update active dot on slide change
                        carousel.addEventListener('slid.bs.carousel', function(e) {
                            dots.forEach(dot => dot.classList.remove('active'));
                            if (dots[e.to]) {
                                dots[e.to].classList.add('active');
                            }
                        });
                    }
                });
                

                
                            // Enhanced navbar brand interactions
            if (navbarBrand) {
                navbarBrand.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                
                navbarBrand.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            }
            
            // Region Filter Functionality
            const regionFilter = document.getElementById('regionFilter');
            const reportsContainer = document.getElementById('reportsContainer');
            const filterCount = document.getElementById('filterCount');
            
            if (regionFilter && reportsContainer) {
                regionFilter.addEventListener('change', function() {
                    const selectedRegion = this.value;
                    filterReports(selectedRegion);
                });
            }
            
            function filterReports(region) {
                // Show loading state
                showReportsLoading();
                
                // Make AJAX request to filter reports
                fetch(`{{ route('reports.filter') }}?region=${encodeURIComponent(region)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayFilteredReports(data.reports);
                            updateFilterCount(data.count, region);
                        } else {
                            showReportsError('Failed to filter reports.');
                        }
                    })
                    .catch(error => {
                        console.error('Filter error:', error);
                        showReportsError('An error occurred while filtering reports.');
                    });
            }
            
            function showReportsLoading() {
                reportsContainer.innerHTML = `
                    <div class="col-12">
                        <div class="reports-loading">
                            <div class="loading-spinner"></div>
                            <h5>Filtering Reports</h5>
                            <p>Please wait while we filter the weather reports...</p>
                        </div>
                    </div>
                `;
            }
            
            function displayFilteredReports(reports) {
                if (!reports || reports.length === 0) {
                    reportsContainer.innerHTML = `
                        <div class="col-12">
                                                         <div class="no-reports">
                                 <i class="fas fa-cloud-rain"></i>
                                 <h4>No Reports Found</h4>
                                 <p>No weather observation reports found from reporters in the selected region. Try selecting a different region or "All Regions".</p>
                             </div>
                        </div>
                    `;
                    return;
                }
                
                let reportsHtml = '';
                reports.forEach((report, index) => {
                    reportsHtml += generateReportCard(report, index);
                });
                
                reportsContainer.innerHTML = reportsHtml;
                
                // Reinitialize AOS for new content
                if (typeof AOS !== 'undefined') {
                    AOS.refresh();
                }
                
                // Reinitialize carousels for new content
                initializeCarousels();
            }
            
            function generateReportCard(report, index) {
                const eventDate = report.event_date ? new Date(report.event_date) : null;
                const formattedDate = eventDate ? {
                    day: eventDate.getDate().toString().padStart(2, '0'),
                    month: eventDate.toLocaleDateString('en-US', { month: 'short' })
                } : { day: '--', month: 'N/A' };
                
                // Generate weather types HTML
                let weatherTypesHtml = '';
                if (report.weather_types && Array.isArray(report.weather_types)) {
                    const displayTypes = report.weather_types.slice(0, 3);
                    weatherTypesHtml = displayTypes.map(type => 
                        `<span class="weather-tag"><i class="fas fa-tag"></i>${type}</span>`
                    ).join('');
                    
                    if (report.weather_types.length > 3) {
                        weatherTypesHtml += `<span class="weather-tag more-tag"><i class="fas fa-plus"></i>${report.weather_types.length - 3} more</span>`;
                    }
                }
                
                // Generate media slideshow or placeholder
                let mediaHtml = '';
                if (report.media_files && Array.isArray(report.media_files) && report.media_files.length > 0) {
                    let carouselItems = '';
                    let dots = '';
                    
                    report.media_files.forEach((media, key) => {
                        carouselItems += `
                            <div class="carousel-item ${key === 0 ? 'active' : ''}">
                                <div class="image-container">
                                    <img src="/storage/${media}" alt="Weather observation" loading="lazy">
                                    <div class="image-overlay">
                                        <div class="overlay-gradient"></div>
                                        <div class="image-actions">
                                            <button class="image-expand" onclick="event.stopPropagation(); expandImage('/storage/${media}');">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        dots += `<button type="button" class="carousel-dot ${key === 0 ? 'active' : ''}" onclick="event.stopPropagation();" data-bs-target="#carousel${report.id}" data-bs-slide-to="${key}"></button>`;
                    });
                    
                    const navigation = report.media_files.length > 1 ? `
                        <button class="carousel-nav carousel-prev" type="button" onclick="event.stopPropagation();" data-bs-target="#carousel${report.id}" data-bs-slide="prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="carousel-nav carousel-next" type="button" onclick="event.stopPropagation();" data-bs-target="#carousel${report.id}" data-bs-slide="next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div class="carousel-dots">${dots}</div>
                    ` : '';
                    
                    mediaHtml = `
                        <div class="professional-slideshow" onclick="event.stopPropagation();">
                            <div id="carousel${report.id}" class="carousel slide" data-bs-ride="false">
                                <div class="carousel-inner">${carouselItems}</div>
                                ${navigation}
                                <div class="image-counter">
                                    <i class="fas fa-camera"></i>
                                    <span>${report.media_files.length}</span>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    mediaHtml = `
                        <div class="no-image-placeholder">
                            <div class="placeholder-content">
                                <i class="fas fa-cloud-sun"></i>
                                <span>Weather Observation</span>
                            </div>
                        </div>
                    `;
                }
                
                return `
                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="${400 + (index * 100)}">
                        <div class="professional-report-card" data-report-id="${report.id}">
                            <div class="card-header-pro">
                                <div class="status-indicator"></div>
                                <div class="header-content">
                                    <div class="location-info">
                                        <h3 class="location-title">
                                            <i class="fas fa-map-marker-alt"></i>
                                            ${report.location_city}
                                        </h3>
                                        <p class="location-subtitle">${report.location_state}</p>
                                    </div>
                                    <div class="date-info">
                                        <div class="date-display">
                                            <span class="date-day">${formattedDate.day}</span>
                                            <span class="date-month">${formattedDate.month}</span>
                                        </div>
                                        ${report.event_time ? `
                                            <div class="time-display">
                                                <i class="fas fa-clock"></i>
                                                ${report.event_time}
                                            </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                            
                            ${mediaHtml}
                            
                            <div class="card-content-pro">
                                ${weatherTypesHtml ? `
                                    <div class="weather-categories">
                                        ${weatherTypesHtml}
                                    </div>
                                ` : ''}
                                
                                ${report.event_description ? `
                                    <div class="description-section">
                                        <p class="description-text">${report.event_description}</p>
                                    </div>
                                ` : ''}
                                
                                <div class="observer-info">
                                    <div class="observer-details">
                                        <div class="observer-avatar">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <div class="observer-meta">
                                            <span class="observer-name">${report.user_name || 'Anonymous Observer'}</span>
                                            <span class="observer-role">${report.designation || 'Weather Observer'}</span>
                                        </div>
                                    </div>
                                    <div class="verification-badge">
                                        <i class="fas fa-shield-check"></i>
                                        <span>Verified</span>
                                    </div>
                                </div>
                                
                                <div class="card-actions">
                                    <button class="action-btn primary-action" onclick="openReportModal(${report.id})">
                                        <span class="btn-text">View Full Report</span>
                                        <div class="btn-icon">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <div class="btn-ripple"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
            
            function updateFilterCount(count, region) {
                const regionText = region === 'all' ? 'All Regions' : region;
                filterCount.textContent = `${count} reports from ${regionText} reporters`;
            }
            
            function showReportsError(message) {
                reportsContainer.innerHTML = `
                    <div class="col-12">
                        <div class="no-reports">
                            <i class="fas fa-exclamation-triangle"></i>
                            <h4>Error Loading Reports</h4>
                            <p>${message}</p>
                        </div>
                    </div>
                `;
            }
            
            function initializeCarousels() {
                const carousels = document.querySelectorAll('.carousel');
                carousels.forEach(carousel => {
                    // Skip if already initialized
                    if (carousel.classList.contains('carousel-initialized')) return;
                    
                    carousel.classList.add('carousel-initialized');
                    
                    const bsCarousel = new bootstrap.Carousel(carousel, {
                        interval: false,
                        wrap: true,
                        touch: true,
                        keyboard: true
                    });
                    
                    const dots = carousel.querySelectorAll('.carousel-dot');
                    if (dots.length > 0) {
                        carousel.addEventListener('slid.bs.carousel', function(e) {
                            dots.forEach(dot => dot.classList.remove('active'));
                            if (dots[e.to]) {
                                dots[e.to].classList.add('active');
                            }
                        });
                    }
                });
            }
                
                // Enhanced nav link interactions
                navLinks.forEach(link => {
                    link.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px) scale(1.02)';
                    });
                    
                    link.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                    
                    // Add ripple effect on click
                    link.addEventListener('click', function(e) {
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
                        ripple.style.background = 'rgba(255, 173, 81, 0.3)';
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
                
                // Enhanced dropdown interactions
                const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
                dropdownToggles.forEach(toggle => {
                    toggle.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-1px) scale(1.02)';
                    });
                    
                    toggle.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) scale(1)';
                    });
                });
                
                // Mobile menu enhancement
                const navbarToggler = document.querySelector('.navbar-toggler');
                const navbarCollapse = document.querySelector('.navbar-collapse');
                
                if (navbarToggler && navbarCollapse) {
                    navbarToggler.addEventListener('click', function() {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    });
                    
                    // Close mobile menu when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target)) {
                            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                            if (bsCollapse && navbarCollapse.classList.contains('show')) {
                                bsCollapse.hide();
                            }
                        }
                    });
                }
            });
        </script>
@endpush