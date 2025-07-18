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
            /* Global variables for modal compatibility - exactly like welcome.blade.php */
            :root {
                --primary-bg: #FFFFFF;
                --heading-color: #FFAD51;
                --container-bg: #CFE2FF;
                --body-text: #898E8F;
                --white: #FFFFFF;
                --black: #000000;
                --border-radius: 3px;
            }
            
            /* Dark Theme Variables - exactly like welcome.blade.php */
            [data-theme="dark"] {
                --primary-bg: var(--theme-bg-primary, #252222);
                --heading-color: #FFAD51;
                --container-bg: var(--theme-bg-tertiary, #3a3636);
                --body-text: var(--theme-text-secondary, #adb5bd);
                --white: var(--theme-card-bg, #2f2b2b);
                --black: var(--theme-text-primary, #ffffff);
            }
            
            /* Weather observations page specific colors - scoped to avoid global conflicts */
            .weather-observations-container {
                --weather-border-radius: 12px;
                --success-color: #198754;
                --danger-color: #dc3545;
                
                /* Form and card specific colors */
                --form-bg: var(--white);
                --form-border: rgba(255, 173, 81, 0.2);
                --form-focus: #FFAD51;
                --form-text: #495057;
                --form-label: #2c3e50;
                --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                --card-hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            }
            
            /* Dark Theme Variables - scoped to weather observations container */
            [data-theme="dark"] .weather-observations-container {
                --form-bg: var(--white);
                --form-border: rgba(255, 173, 81, 0.3);
                --form-text: var(--black);
                --form-label: var(--black);
                --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
                --card-hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            }
            
            /* Typography - scoped to weather observations container */
            .weather-observations-container h1, 
            .weather-observations-container h2, 
            .weather-observations-container h3, 
            .weather-observations-container h4, 
            .weather-observations-container h5, 
            .weather-observations-container h6 {
                color: var(--black);
                font-weight: 600;
                line-height: 1.3;
            }
            
            /* Weather Observations Container */
            .weather-observations-container {
                padding: 4rem 0 6rem 0;
                position: relative;
                font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
                font-weight: 400;
                line-height: 1.6;
                color: var(--body-text);
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                text-rendering: optimizeLegibility;
            }
            
            .weather-observations-container::before {
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
            .weather-observations-container .page-header {
                text-align: left;
                margin-bottom: 4rem;
                position: relative;
                z-index: 2;
                background: linear-gradient(135deg, 
                    var(--form-bg) 0%, 
                    rgba(255, 255, 255, 0.95) 50%, 
                    var(--form-bg) 100%);
                border-radius: 20px;
                padding: 3rem 2rem;
                box-shadow: var(--card-shadow);
                border: 1px solid var(--form-border);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                overflow: hidden;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .weather-observations-container .page-header::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
                border-radius: 20px 20px 0 0;
            }
            
            /* Dark mode header */
            [data-theme="dark"] .weather-observations-container .page-header {
                background: linear-gradient(135deg, 
                    var(--form-bg) 0%, 
                    rgba(47, 43, 43, 0.95) 50%, 
                    var(--form-bg) 100%);
                box-shadow: var(--card-shadow);
                border: 1px solid var(--form-border);
            }
            
            .weather-observations-container .page-title {
                font-weight: 800;
                font-size: clamp(2.2rem, 4vw, 3rem);
                color: var(--black);
                margin-bottom: 1rem;
                position: relative;
                z-index: 2;
                letter-spacing: -0.02em;
                text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .weather-observations-container .page-title::after {
                content: '';
                display: block;
                width: 80px;
                height: 4px;
                background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
                margin: 1rem 0 0 0;
                border-radius: 2px;
                box-shadow: 0 2px 8px rgba(255, 173, 81, 0.3);
            }
            
            .weather-observations-container .page-title i {
                color: var(--heading-color);
                margin-right: 1rem;
                filter: drop-shadow(0 2px 4px rgba(255, 173, 81, 0.3));
            }
            
            .weather-observations-container .page-subtitle {
                color: var(--body-text);
                font-size: 1.1rem;
                font-weight: 400;
                position: relative;
                z-index: 2;
                max-width: 600px;
                line-height: 1.7;
            }
            
            /* Enhanced New Observation Button */
            .weather-observations-container .btn-new-observation {
                background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%) !important;
                color: white !important;
                border: none !important;
                padding: 0.875rem 2rem !important;
                border-radius: var(--weather-border-radius) !important;
                font-weight: 600 !important;
                font-size: 0.95rem !important;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                box-shadow: 
                    0 4px 15px rgba(255, 173, 81, 0.3),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
                position: relative;
                overflow: hidden;
                cursor: pointer;
            }
            
            .weather-observations-container .btn-new-observation::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
                transition: left 0.5s ease;
            }
            
            .weather-observations-container .btn-new-observation:hover {
                background: linear-gradient(135deg, #e89640 0%, var(--heading-color) 100%) !important;
                transform: translateY(-3px) scale(1.02);
                box-shadow: 
                    0 8px 25px rgba(255, 173, 81, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                color: white !important;
                text-decoration: none;
            }
            
            .weather-observations-container .btn-new-observation:hover::before {
                left: 100%;
            }
            
            .weather-observations-container .btn-new-observation i {
                font-size: 1.1rem;
                transition: transform 0.3s ease;
            }
            
            .weather-observations-container .btn-new-observation:hover i {
                transform: scale(1.1);
            }
            
            /* Success Alert Enhancement */
            .weather-observations-container .alert-success {
                background: linear-gradient(135deg, 
                    rgba(25, 135, 84, 0.1) 0%, 
                    rgba(25, 135, 84, 0.05) 100%) !important;
                border: 1px solid rgba(25, 135, 84, 0.2) !important;
                border-radius: var(--weather-border-radius) !important;
                color: var(--success-color) !important;
                padding: 1.25rem 1.5rem;
                margin-bottom: 2rem;
                font-weight: 500;
                box-shadow: 
                    0 4px 20px rgba(25, 135, 84, 0.1),
                    inset 0 1px 0 rgba(255, 255, 255, 0.8);
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .weather-observations-container .alert-success::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: var(--success-color);
                border-radius: 0 var(--weather-border-radius) var(--weather-border-radius) 0;
            }
            
            .weather-observations-container .alert-success i {
                color: var(--success-color);
                font-size: 1.1rem;
                filter: drop-shadow(0 1px 2px rgba(25, 135, 84, 0.3));
            }
            
            /* No Observations State */
            .weather-observations-container .no-observations {
                text-align: center;
                padding: 6rem 2rem;
                color: var(--body-text);
                background: linear-gradient(135deg, 
                    var(--form-bg) 0%, 
                    rgba(255, 255, 255, 0.95) 50%, 
                    var(--form-bg) 100%);
                border-radius: 24px;
                border: 1px solid var(--form-border);
                box-shadow: var(--card-shadow);
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }
            
            .weather-observations-container .no-observations::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
                border-radius: 24px 24px 0 0;
            }
            
            /* Dark mode no observations */
            [data-theme="dark"] .weather-observations-container .no-observations {
                background: linear-gradient(135deg, 
                    var(--form-bg) 0%, 
                    rgba(47, 43, 43, 0.95) 50%, 
                    var(--form-bg) 100%);
                box-shadow: var(--card-shadow);
                border: 1px solid var(--form-border);
            }
            
            .weather-observations-container .no-observations::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: radial-gradient(circle at center, rgba(255, 173, 81, 0.03) 0%, transparent 70%);
                pointer-events: none;
            }
            
            .weather-observations-container .no-observations i {
                font-size: 5rem;
                color: var(--heading-color);
                margin-bottom: 2rem;
                opacity: 0.8;
                filter: drop-shadow(0 4px 12px rgba(255, 173, 81, 0.2));
                animation: float 3s ease-in-out infinite;
                position: relative;
                z-index: 2;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-8px); }
            }
            
            .weather-observations-container .no-observations h4 {
                font-weight: 700;
                color: var(--black);
                margin-bottom: 1rem;
                font-size: 1.8rem;
                position: relative;
                z-index: 2;
            }
            
            .weather-observations-container .no-observations p {
                font-size: 1.1rem;
                max-width: 500px;
                margin: 0 auto;
                line-height: 1.6;
                opacity: 0.9;
                position: relative;
                z-index: 2;
            }
            
            /* Enhanced Observation Cards */
            .weather-observations-container .observation-card {
                background: linear-gradient(135deg, 
                    var(--form-bg) 0%, 
                    rgba(255, 255, 255, 0.95) 50%, 
                    var(--form-bg) 100%);
                border-radius: 20px;
                padding: 0;
                height: 100%;
                box-shadow: var(--card-shadow);
                border: 1px solid var(--form-border);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                display: flex;
                flex-direction: column;
            }
            
            /* Dark mode observation cards */
            [data-theme="dark"] .weather-observations-container .observation-card {
                background: linear-gradient(135deg, 
                    var(--form-bg) 0%, 
                    rgba(47, 43, 43, 0.95) 50%, 
                    var(--form-bg) 100%);
                border: 1px solid var(--form-border);
                box-shadow: var(--card-shadow);
            }
            
            .weather-observations-container .observation-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
                transform: scaleX(0);
                transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 20px 20px 0 0;
            }
            
            .weather-observations-container .observation-card::after {
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
            
            .weather-observations-container .observation-card:hover {
                transform: translateY(-5px);
                box-shadow: var(--card-hover-shadow);
            }
            
            .weather-observations-container .observation-card:hover::before {
                transform: scaleX(1);
            }
            
            .weather-observations-container .observation-card:hover::after {
                width: 180px;
                height: 180px;
            }
            
            /* Image Slideshow Styles */
            .weather-observations-container .card-slideshow {
                position: relative;
                height: 200px;
                border-radius: 20px 20px 0 0;
                overflow: hidden;
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%);
            }
            
            [data-theme="dark"] .weather-observations-container .card-slideshow {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%);
            }
            
            .weather-observations-container .slideshow-container {
                position: relative;
                width: 100%;
                height: 100%;
            }
            
            .weather-observations-container .slide {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                transition: opacity 0.8s ease-in-out;
            }
            
            .weather-observations-container .slide.active {
                opacity: 1;
            }
            
            .weather-observations-container .slide img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.5s ease;
            }
            
            .weather-observations-container .observation-card:hover .slide img {
                transform: scale(1.05);
            }
            
            .weather-observations-container .no-image-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100%;
                color: var(--heading-color);
                font-size: 3rem;
                opacity: 0.6;
            }
            
            .weather-observations-container .slideshow-nav {
                position: absolute;
                bottom: 10px;
                left: 50%;
                transform: translateX(-50%);
                display: flex;
                gap: 8px;
                z-index: 2;
            }
            
            .weather-observations-container .nav-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.5);
                cursor: pointer;
                transition: all 0.3s ease;
                border: 1px solid rgba(255, 255, 255, 0.8);
            }
            
            .weather-observations-container .nav-dot.active {
                background: var(--heading-color);
                transform: scale(1.2);
                box-shadow: 0 2px 8px rgba(255, 173, 81, 0.4);
            }
            
            .weather-observations-container .slideshow-counter {
                position: absolute;
                top: 10px;
                right: 10px;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                padding: 4px 8px;
                border-radius: var(--border-radius);
                font-size: 0.75rem;
                font-weight: 600;
                z-index: 2;
            }
            
            .weather-observations-container .card-content {
                padding: 2rem;
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            
            /* Card Header */
            .weather-observations-container .card-header-enhanced {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
            }
            
            .weather-observations-container .observation-icon {
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, var(--theme-text-primary, #000000) 0%, rgba(0, 0, 0, 0.9) 100%);
                border-radius: var(--border-radius);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
                color: var(--form-bg);
                font-size: 1.2rem;
                flex-shrink: 0;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 
                    0 4px 15px rgba(0, 0, 0, 0.15),
                    inset 0 1px 0 rgba(255, 255, 255, 0.1);
            }
            
            .weather-observations-container .observation-card:hover .observation-icon {
                background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
                transform: scale(1.1) rotate(5deg);
                box-shadow: 
                    0 6px 20px rgba(255, 173, 81, 0.4),
                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
            }
            
            .weather-observations-container .observation-meta {
                flex: 1;
            }
            
            .weather-observations-container .observation-date {
                font-weight: 700;
                color: var(--black);
                font-size: 1.1rem;
                margin-bottom: 0.25rem;
            }
            
            .weather-observations-container .observation-time {
                color: var(--body-text);
                font-size: 0.9rem;
                font-weight: 500;
            }
            
            /* Location Section */
            .weather-observations-container .location-section {
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
            }
            
            .weather-observations-container .location-info {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--black);
                font-weight: 600;
                font-size: 1rem;
            }
            
            .weather-observations-container .location-info i {
                color: var(--heading-color);
                filter: drop-shadow(0 1px 2px rgba(255, 173, 81, 0.3));
            }
            
            /* Weather Types */
            .weather-observations-container .weather-types-section {
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
            }
            
            .weather-observations-container .weather-types {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .weather-observations-container .weather-badge {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(207, 226, 255, 0.8) 100%);
                color: var(--black);
                padding: 0.4rem 0.8rem;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
                border: 1px solid var(--form-border);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                overflow: hidden;
            }
            
            /* Dark mode weather badge */
            [data-theme="dark"] .weather-observations-container .weather-badge {
                background: linear-gradient(135deg, var(--container-bg) 0%, rgba(58, 54, 54, 0.8) 100%);
                color: var(--black);
                border: 1px solid var(--form-border);
            }
            
            .weather-observations-container .weather-badge::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.3) 50%, transparent 100%);
                transition: left 0.4s ease;
            }
            
            .weather-observations-container .weather-badge:hover {
                background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
                color: white;
                border-color: var(--heading-color);
                transform: translateY(-2px) scale(1.05);
            }
            
            .weather-observations-container .weather-badge:hover::before {
                left: 100%;
            }
            
            /* Description Section */
            .weather-observations-container .description-section {
                margin-bottom: 1.5rem;
                position: relative;
                z-index: 2;
            }
            
            .weather-observations-container .observation-description {
                color: var(--body-text);
                font-size: 0.95rem;
                line-height: 1.6;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                font-weight: 400;
            }
            
            /* Enhanced View Button */
            .weather-observations-container .btn-view {
                background: linear-gradient(135deg, rgba(255, 173, 81, 0.1) 0%, rgba(255, 173, 81, 0.05) 100%);
                color: var(--black);
                border: 1px solid var(--form-border);
                padding: 0.6rem 1.2rem;
                border-radius: var(--weather-border-radius);
                font-size: 0.85rem;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                z-index: 2;
                margin-top: auto;
                cursor: pointer;
                font-family: inherit;
            }
            
            /* Dark mode view button */
            [data-theme="dark"] .weather-observations-container .btn-view {
                color: var(--black);
                background: linear-gradient(135deg, rgba(255, 173, 81, 0.2) 0%, rgba(255, 173, 81, 0.1) 100%);
                border: 1px solid var(--form-border);
            }
            
            .weather-observations-container .observation-card:hover .btn-view {
                background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
                color: white;
                border-color: var(--heading-color);
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 173, 81, 0.3);
            }
            
            .weather-observations-container .btn-view i {
                transition: transform 0.3s ease;
            }
            
            .weather-observations-container .observation-card:hover .btn-view i {
                transform: translateX(4px);
            }
            
            /* Custom Scrollbar - scoped to weather observations container */
            .weather-observations-container ::-webkit-scrollbar {
                width: 8px;
            }
            
            .weather-observations-container ::-webkit-scrollbar-track {
                background: var(--primary-bg);
                border-radius: var(--weather-border-radius);
            }
            
            .weather-observations-container ::-webkit-scrollbar-thumb {
                background: var(--heading-color);
                border-radius: var(--weather-border-radius);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .weather-observations-container ::-webkit-scrollbar-thumb:hover {
                background: #e89640;
            }
            
            /* Responsive Design */
            @media (max-width: 991.98px) {
                .weather-observations-container {
                    padding: 2rem 0 4rem 0;
                }
                
                .weather-observations-container .page-header {
                    padding: 2rem 1.5rem;
                    margin-bottom: 2rem;
                }
                
                .weather-observations-container .page-title {
                    font-size: clamp(1.8rem, 4vw, 2.5rem);
                }
                
                .weather-observations-container .btn-new-observation {
                    padding: 0.75rem 1.5rem !important;
                    font-size: 0.9rem !important;
                }
                
                .weather-observations-container .card-content {
                    padding: 1.5rem;
                }
            }
            
            @media (max-width: 767.98px) {
                .weather-observations-container {
                    padding: 1.5rem 0 3rem 0;
                }
                
                .weather-observations-container .page-header {
                    padding: 1.5rem;
                    margin-bottom: 1.5rem;
                }
                
                .weather-observations-container .card-content {
                    padding: 1.25rem;
                }
                
                .weather-observations-container .card-slideshow {
                    height: 160px;
                }
                
                .weather-observations-container .no-observations {
                    padding: 4rem 1.5rem;
                }
                
                .weather-observations-container .no-observations i {
                    font-size: 3.5rem;
                }
                
                .weather-observations-container .slideshow-counter {
                    font-size: 0.7rem;
                    padding: 3px 6px;
                }
                
                .weather-observations-container .nav-dot {
                    width: 6px;
                    height: 6px;
                }
            }
            
            /* Text Selection - scoped to weather observations container */
            .weather-observations-container ::selection {
                background: rgba(255, 173, 81, 0.2);
                color: var(--heading-color);
            }
            
            .weather-observations-container ::-moz-selection {
                background: rgba(255, 173, 81, 0.2);
                color: var(--heading-color);
            }
            
            /* Professional Modal Styles - exact copy from welcome.blade.php */
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
        </style>

<div class="weather-observations-container">
    <div class="container">
        <!-- Enhanced Header -->
        <div class="page-header" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-cloud-sun"></i>
                        Weather Observations
                    </h1>
                    <p class="page-subtitle">
                        Manage and view your submitted weather observation reports
                    </p>
                </div>
                <a href="{{ route('weather.observation.create') }}" class="btn-new-observation" data-aos="fade-left" data-aos-delay="200">
                    <i class="bi bi-plus-circle"></i>
                    <span>New Weather Observation</span>
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success" role="alert" data-aos="fade-up" data-aos-delay="100">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Observations Content -->
        @if($observations->isEmpty())
            <div class="no-observations" data-aos="fade-up" data-aos-delay="300">
                <i class="fas fa-cloud-rain"></i>
                <h4>No Weather Observations Found</h4>
                <p>You haven't submitted any weather observations yet. Click the "New Weather Observation" button above to create your first report.</p>
            </div>
        @else
            <div class="row g-4" data-aos="fade-up" data-aos-delay="400">
                @foreach($observations as $index => $observation)
                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="{{ 500 + ($index * 100) }}">
                        <div class="observation-card">
                            <!-- Image Slideshow -->
                            <div class="card-slideshow">
                                <div class="slideshow-container">
                                    @php
                                        // Get uploaded images from media_files field
                                        $observationImages = [];
                                        
                                        // Check if observation has media_files
                                        if (isset($observation->media_files) && is_array($observation->media_files) && !empty($observation->media_files)) {
                                            $observationImages = $observation->media_files;
                                        }
                                        
                                        // Filter to get only image files (not videos)
                                        $imageFiles = [];
                                        foreach ($observationImages as $media) {
                                            $extension = strtolower(pathinfo($media, PATHINFO_EXTENSION));
                                            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                $imageFiles[] = $media;
                                            }
                                        }
                                        
                                        // Build proper URLs for the images
                                        $imageUrls = [];
                                        foreach ($imageFiles as $imagePath) {
                                            $imageUrls[] = asset('storage/' . $imagePath);
                                        }
                                    @endphp

                                    @if(count($imageUrls) > 0)
                                        @foreach($imageUrls as $imageIndex => $imageUrl)
                                            <div class="slide {{ $imageIndex === 0 ? 'active' : '' }}">
                                                <img src="{{ $imageUrl }}" alt="Weather observation image {{ $imageIndex + 1 }}" loading="lazy">
                                            </div>
                                        @endforeach
                                        
                                        @if(count($imageUrls) > 1)
                                            <div class="slideshow-counter">
                                                <span class="current-slide">1</span> / {{ count($imageUrls) }}
                                            </div>
                                            <div class="slideshow-nav">
                                                @foreach($imageUrls as $imageIndex => $imageUrl)
                                                    <div class="nav-dot {{ $imageIndex === 0 ? 'active' : '' }}" data-slide="{{ $imageIndex }}"></div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @else
                                        <div class="no-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="card-content">
                                <!-- Card Header -->
                                <div class="card-header-enhanced">
                                    <div class="observation-icon">
                                        <i class="fas fa-cloud-sun"></i>
                                    </div>
                                    <div class="observation-meta">
                                        <div class="observation-date">
                                            {{ $observation->event_date->format('M d, Y') }}
                                        </div>
                                        <div class="observation-time">
                                            {{ $observation->event_time }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="location-section">
                                    <div class="location-info">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $observation->location_city }}, {{ $observation->location_state }}</span>
                                    </div>
                                </div>

                                <!-- Weather Types -->
                                @if($observation->weather_types && count($observation->weather_types) > 0)
                                    <div class="weather-types-section">
                                        <div class="weather-types">
                                            @foreach(array_slice($observation->weather_types, 0, 3) as $type)
                                                <span class="weather-badge">{{ $type }}</span>
                                            @endforeach
                                            @if(count($observation->weather_types) > 3)
                                                <span class="weather-badge">+{{ count($observation->weather_types) - 3 }} more</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Description -->
                                @if($observation->event_description)
                                    <div class="description-section">
                                        <div class="observation-description">
                                            {{ $observation->event_description }}
                                        </div>
                                    </div>
                                @endif

                                <!-- View Button -->
                                <div class="mt-auto">
                                    <button type="button" class="btn-view" onclick="openObservationModal({{ $observation->id }})">
                                        <i class="bi bi-eye"></i>
                                        <span>View Details</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Enhanced Professional Observation Modal -->
<div class="modal fade" id="observationModal" tabindex="-1" aria-labelledby="observationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="professional-modal-content">
            <div class="professional-modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon">
                        <i class="fas fa-cloud-sun"></i>
                    </div>
                    <div class="modal-title-section">
                        <h4 class="professional-modal-title" id="observationModalLabel">
                            Weather Observation Report
                        </h4>
                        <p class="modal-subtitle">Detailed meteorological analysis</p>
                    </div>
                </div>
                <button type="button" class="professional-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="professional-modal-body" id="observationModalContent">
                <div class="loading-state">
                    <div class="loading-icon">
                        <i class="fas fa-cloud-rain"></i>
                    </div>
                    <div class="loading-spinner"></div>
                    <h5>Loading Weather Observation</h5>
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

    // Enhanced card interactions and slideshow functionality
    document.addEventListener('DOMContentLoaded', function() {
        const observationCards = document.querySelectorAll('.observation-card');
        
        // Initialize slideshows for each card
        observationCards.forEach((card, cardIndex) => {
            const slides = card.querySelectorAll('.slide');
            const navDots = card.querySelectorAll('.nav-dot');
            const counter = card.querySelector('.current-slide');
            
            if (slides.length > 1) {
                let currentSlide = 0;
                let slideInterval;
                
                // Function to show specific slide
                function showSlide(slideIndex) {
                    // Hide all slides
                    slides.forEach(slide => slide.classList.remove('active'));
                    navDots.forEach(dot => dot.classList.remove('active'));
                    
                    // Show target slide
                    slides[slideIndex].classList.add('active');
                    if (navDots[slideIndex]) {
                        navDots[slideIndex].classList.add('active');
                    }
                    
                    // Update counter
                    if (counter) {
                        counter.textContent = slideIndex + 1;
                    }
                    
                    currentSlide = slideIndex;
                }
                
                // Function to go to next slide
                function nextSlide() {
                    const nextIndex = (currentSlide + 1) % slides.length;
                    showSlide(nextIndex);
                }
                
                // Start auto-slideshow
                function startSlideshow() {
                    slideInterval = setInterval(nextSlide, 3000); // 3 seconds
                }
                
                // Stop auto-slideshow
                function stopSlideshow() {
                    clearInterval(slideInterval);
                }
                
                // Add click handlers to navigation dots
                navDots.forEach((dot, index) => {
                    dot.addEventListener('click', (e) => {
                        e.stopPropagation();
                        showSlide(index);
                        stopSlideshow();
                        setTimeout(startSlideshow, 5000); // Restart after 5 seconds
                    });
                });
                
                // Pause slideshow on hover
                card.addEventListener('mouseenter', stopSlideshow);
                card.addEventListener('mouseleave', startSlideshow);
                
                // Start the slideshow
                startSlideshow();
            }
        });
        
        // Enhanced button hover effects - scoped to weather observations container
        const buttons = document.querySelectorAll('.weather-observations-container .btn-new-observation, .weather-observations-container .btn-view');
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
            
            // Add ripple effect on click
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
        `;
        document.head.appendChild(style);
        
        // Smooth scrolling for any internal links
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
        
        // Auto-hide success alerts after 5 seconds - scoped to weather observations container
        const successAlerts = document.querySelectorAll('.weather-observations-container .alert-success');
        successAlerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'all 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 5000);
        });
    });

    // Professional modal functions for weather observations - enhanced error handling like welcome.blade.php
    function displayObservationDetails(observation) {
        const modalContent = document.getElementById('observationModalContent');
        
        let sections = [];
        
        // Observer Information - only show if we have meaningful data
        if (observation.user_name || observation.designation) {
            let observerInfo = '';
            if (observation.user_name) {
                observerInfo += `<strong>Name:</strong> ${observation.user_name}`;
            }
            if (observation.designation) {
                if (observerInfo) observerInfo += '<br>';
                observerInfo += `<strong>Designation:</strong> ${observation.designation}`;
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
        if (observation.location_city && observation.location_state) {
            let locationInfo = `<strong>City:</strong> ${observation.location_city}<br><strong>State/Province:</strong> ${observation.location_state}`;
            if (observation.latitude && observation.longitude) {
                locationInfo += `<br><strong>Coordinates:</strong> ${observation.latitude}, ${observation.longitude}`;
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
        if (observation.event_date || observation.event_time) {
            let dateTimeInfo = '';
            if (observation.event_date) {
                const formattedDate = formatDate(observation.event_date);
                if (formattedDate) {
                    dateTimeInfo += `<strong>Date:</strong> ${formattedDate}`;
                }
            }
            if (observation.event_time) {
                if (dateTimeInfo) dateTimeInfo += '<br>';
                dateTimeInfo += `<strong>Time:</strong> ${observation.event_time}`;
            }
            if (observation.time_zone) {
                if (dateTimeInfo) dateTimeInfo += '<br>';
                dateTimeInfo += `<strong>Timezone:</strong> ${observation.time_zone}`;
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
        if (observation.weather_types && Array.isArray(observation.weather_types) && observation.weather_types.length > 0) {
            sections.push(`
                <div class="professional-detail-item">
                    <div class="professional-detail-label">
                        <i class="fas fa-cloud"></i>Weather Phenomena
                    </div>
                    <div class="modal-weather-tags">
                        ${observation.weather_types.map(type => 
                            `<span class="modal-weather-tag"><i class="fas fa-tag"></i>${type || 'Unknown'}</span>`
                        ).join('')}
                    </div>
                </div>
            `);
        }
        
        // Detailed Description - only show if there's actual content
        if (observation.event_description && observation.event_description.trim()) {
            sections.push(`
                <div class="professional-detail-item">
                    <div class="professional-detail-label">
                        <i class="fas fa-file-alt"></i>Detailed Description
                    </div>
                    <div class="professional-detail-value">${observation.event_description}</div>
                </div>
            `);
        }
        
        // Reported Damages - only show if there are damages
        if (observation.damages && Array.isArray(observation.damages) && observation.damages.length > 0) {
            sections.push(`
                <div class="professional-detail-item">
                    <div class="professional-detail-label">
                        <i class="fas fa-exclamation-triangle"></i>Reported Damages
                    </div>
                    <div class="modal-weather-tags">
                        ${observation.damages.map(damage => 
                            `<span class="modal-weather-tag"><i class="fas fa-exclamation"></i>${damage || 'Unknown'}</span>`
                        ).join('')}
                    </div>
                </div>
            `);
        }
        
        // Media Files - only show if there are files
        if (observation.media_files && Array.isArray(observation.media_files) && observation.media_files.length > 0) {
            sections.push(`
                <div class="professional-detail-item">
                    <div class="professional-detail-label">
                        <i class="fas fa-images"></i>Media Files
                    </div>
                    <div class="professional-media-grid">
                        ${observation.media_files.map(file => {
                            if (file && typeof file === 'string') {
                                return `
                                    <div class="professional-media-item" onclick="expandImage('/storage/${file}')">
                                        <img src="/storage/${file}" alt="Weather observation" loading="lazy" onerror="this.parentElement.style.display='none'">
                                    </div>
                                `;
                            }
                            return '';
                        }).join('')}
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
                        This observation contains minimal information. Additional details may be added by editing the observation.
                    </div>
                </div>
            `;
        } else {
            modalContent.innerHTML = sections.join('');
        }
    }
    
    function showObservationError(message) {
        const modalContent = document.getElementById('observationModalContent');
        modalContent.innerHTML = `
            <div class="professional-detail-item" style="text-align: center; border-left: 4px solid #ef4444;">
                <div class="professional-detail-label" style="justify-content: center; color: #ef4444;">
                    <i class="fas fa-exclamation-triangle"></i>Error Loading Observation
                </div>
                <div class="professional-detail-value" style="margin-left: 0; text-align: center;">
                    ${message}
                </div>
            </div>
        `;
    }

    // Date formatting function - enhanced like welcome.blade.php
    function formatDate(dateString) {
        if (!dateString || dateString === 'null' || dateString === 'undefined') return null;
        
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

    // Function to open observation modal - enhanced like welcome.blade.php
    function openObservationModal(observationId) {
        const modal = new bootstrap.Modal(document.getElementById('observationModal'));
        
        // Show loading state
        const modalContent = document.getElementById('observationModalContent');
        modalContent.innerHTML = `
            <div class="loading-state">
                <div class="loading-icon">
                    <i class="fas fa-cloud-rain"></i>
                </div>
                <div class="loading-spinner"></div>
                <h5>Loading Weather Observation</h5>
                <p>Retrieving detailed observation data...</p>
            </div>
        `;
        
        modal.show();
        
        // Fetch observation details with enhanced error handling - use user route instead of public route
        fetch(`/user/weather-observation/${observationId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                try {
                    if (data && data.success && data.observation) {
                        displayObservationDetails(data.observation);
                    } else {
                        showObservationError(data.message || 'Failed to load observation details.');
                    }
                } catch (error) {
                    console.error('Error processing observation data:', error);
                    showObservationError('Error processing observation data.');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                if (error.name === 'TypeError' && error.message.includes('fetch')) {
                    showObservationError('Network error. Please check your connection and try again.');
                } else if (error.message.includes('HTTP error')) {
                    showObservationError('Server error. The observation might not exist.');
                } else {
                    showObservationError('An unexpected error occurred while loading the observation.');
                }
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
</script>
@endpush
