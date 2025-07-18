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
    
    /* Dark Theme Variables - Using Global Theme */
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
    
    /* Background pattern overlay */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(255, 173, 81, 0.03) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(207, 226, 255, 0.04) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(255, 173, 81, 0.02) 0%, transparent 50%);
        pointer-events: none;
        z-index: -1;
    }
    
    /* Dark theme background pattern */
    [data-theme="dark"] body::before {
        background: radial-gradient(circle at 20% 50%, rgba(255, 173, 81, 0.05) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(58, 54, 54, 0.1) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(255, 173, 81, 0.03) 0%, transparent 50%);
    }
    
    /* Typography */
    h1, h2, h3, h4, h5, h6 {
        color: var(--black);
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        line-height: 1.3;
    }
    
    /* Thank You Page Container */
    .thank-you-container {
        min-height: calc(100vh - var(--navbar-height));
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
        width: 100%;
    }
    
    /* Enhanced Thank You Card */
    .thank-you-card {
        background: linear-gradient(135deg, 
            var(--white) 0%, 
            rgba(255, 255, 255, 0.98) 50%, 
            var(--white) 100%);
        border-radius: 32px;
        padding: 4rem 3rem;
        margin: 0 auto;
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.15),
            0 10px 32px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        border: 2px solid rgba(255, 173, 81, 0.25);
        transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        max-width: 800px;
        width: 100%;
        text-align: center;
    }
    
    /* Dark theme card */
    [data-theme="dark"] .thank-you-card {
        background: linear-gradient(135deg, 
            var(--theme-card-bg) 0%, 
            rgba(47, 43, 43, 0.98) 50%, 
            var(--theme-card-bg) 100%);
        border: 2px solid rgba(255, 173, 81, 0.3);
        box-shadow: 
            0 25px 80px rgba(0, 0, 0, 0.5),
            0 10px 32px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    /* Decorative top border */
    .thank-you-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, 
            var(--heading-color) 0%, 
            #ffb866 50%, 
            var(--heading-color) 100%);
        border-radius: 32px 32px 0 0;
        animation: headerShine 3s ease-in-out infinite;
    }
    
    @keyframes headerShine {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    /* Success Icon */
    .success-icon {
        margin-bottom: 2.5rem;
        position: relative;
    }
    
    .success-icon i {
        font-size: 6rem;
        color: #22c55e;
        filter: drop-shadow(0 8px 25px rgba(34, 197, 94, 0.3));
        animation: successPulse 2s ease-in-out infinite;
    }
    
    @keyframes successPulse {
        0%, 100% { 
            transform: scale(1);
            filter: drop-shadow(0 8px 25px rgba(34, 197, 94, 0.3));
        }
        50% { 
            transform: scale(1.05);
            filter: drop-shadow(0 12px 35px rgba(34, 197, 94, 0.4));
        }
    }
    
    /* Floating particles around icon */
    .success-icon::before,
    .success-icon::after {
        content: '';
        position: absolute;
        width: 6px;
        height: 6px;
        background: var(--heading-color);
        border-radius: 50%;
        opacity: 0.6;
        animation: floatParticles 4s ease-in-out infinite;
    }
    
    .success-icon::before {
        top: 20%;
        left: 20%;
        animation-delay: 0s;
    }
    
    .success-icon::after {
        top: 30%;
        right: 25%;
        animation-delay: 2s;
    }
    
    @keyframes floatParticles {
        0%, 100% { 
            transform: translateY(0) scale(1);
            opacity: 0.6;
        }
        50% { 
            transform: translateY(-20px) scale(1.2);
            opacity: 1;
        }
    }
    
    /* Main Title */
    .thank-you-title {
        font-weight: 800;
        font-size: clamp(2.5rem, 5vw, 4rem);
        color: var(--black);
        margin-bottom: 1.5rem;
        position: relative;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    [data-theme="dark"] .thank-you-title {
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .thank-you-title::after {
        content: '';
        display: block;
        width: 120px;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 50%, var(--heading-color) 100%);
        margin: 1rem auto 0;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(255, 173, 81, 0.3);
    }
    
    /* Enhanced Alert */
    .enhanced-alert {
        background: linear-gradient(135deg, 
            rgba(34, 197, 94, 0.1) 0%, 
            rgba(34, 197, 94, 0.05) 100%);
        border: 2px solid rgba(34, 197, 94, 0.2);
        border-radius: 20px;
        padding: 1.5rem 2rem;
        margin: 2rem 0;
        color: #15803d;
        font-weight: 600;
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.1);
    }
    
    .enhanced-alert::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent 0%, 
            rgba(34, 197, 94, 0.1) 50%, 
            transparent 100%);
        animation: alertShine 3s ease-in-out infinite;
    }
    
    @keyframes alertShine {
        0%, 100% { left: -100%; }
        50% { left: 100%; }
    }
    
    /* Dark theme alert */
    [data-theme="dark"] .enhanced-alert {
        background: linear-gradient(135deg, 
            rgba(34, 197, 94, 0.2) 0%, 
            rgba(34, 197, 94, 0.1) 100%);
        border: 2px solid rgba(34, 197, 94, 0.3);
        color: #4ade80;
    }
    
    /* Main Description */
    .main-description {
        color: var(--body-text);
        font-size: 1.3rem;
        line-height: 1.8;
        margin: 2rem 0;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 400;
    }
    
    /* Reference ID Section */
    .reference-section {
        background: linear-gradient(135deg, 
            var(--container-bg) 0%, 
            rgba(207, 226, 255, 0.8) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin: 2.5rem 0;
        border: 1px solid rgba(255, 173, 81, 0.15);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
    }
    
    /* Dark theme reference section */
    [data-theme="dark"] .reference-section {
        background: linear-gradient(135deg, 
            var(--theme-bg-tertiary) 0%, 
            rgba(58, 54, 54, 0.8) 100%);
        border: 1px solid rgba(255, 173, 81, 0.2);
    }
    
    .reference-section::before {
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
    
    .reference-label {
        font-size: 1rem;
        color: var(--body-text);
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .reference-id {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--black);
        font-family: 'Courier New', monospace;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
        padding: 0.5rem 1rem;
        background: rgba(255, 173, 81, 0.1);
        border-radius: 12px;
        border: 1px solid rgba(255, 173, 81, 0.2);
        display: inline-block;
    }
    
    [data-theme="dark"] .reference-id {
        color: #ffffff;
        background: rgba(255, 173, 81, 0.2);
        border: 1px solid rgba(255, 173, 81, 0.3);
    }
    
    .reference-note {
        font-size: 0.95rem;
        color: var(--body-text);
        opacity: 0.8;
        font-style: italic;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
        margin-top: 3rem;
    }
    
    .enhanced-btn {
        background: linear-gradient(135deg, 
            var(--heading-color) 0%, 
            #ffb866 100%);
        border: none;
        border-radius: 16px;
        padding: 1rem 2rem;
        color: var(--white);
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        min-width: 200px;
        justify-content: center;
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
    
    .enhanced-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 15px 40px rgba(255, 173, 81, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.4);
        color: var(--white);
        text-decoration: none;
    }
    
    .enhanced-btn:hover::before {
        left: 100%;
    }
    
    .enhanced-btn:active {
        transform: translateY(-1px) scale(1.01);
    }
    
    .enhanced-btn i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }
    
    .enhanced-btn:hover i {
        transform: translateX(3px);
    }
    
    /* Secondary Button */
    .enhanced-btn-secondary {
        background: linear-gradient(135deg, 
            rgba(255, 255, 255, 0.9) 0%, 
            rgba(248, 249, 250, 0.95) 100%);
        border: 2px solid rgba(255, 173, 81, 0.2);
        color: var(--black);
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.08),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
    }
    
    .enhanced-btn-secondary:hover {
        background: linear-gradient(135deg, 
            var(--heading-color) 0%, 
            #ffb866 100%);
        color: var(--white);
        border-color: var(--heading-color);
        box-shadow: 
            0 15px 40px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        text-decoration: none;
    }
    
    /* Dark theme secondary button */
    [data-theme="dark"] .enhanced-btn-secondary {
        background: linear-gradient(135deg, 
            var(--theme-card-bg) 0%, 
            rgba(47, 43, 43, 0.95) 100%);
        border: 2px solid rgba(255, 173, 81, 0.3);
        color: #ffffff;
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }
    
    /* Decorative Elements */
    .decorative-dots {
        position: absolute;
        top: 2rem;
        right: 2rem;
        display: flex;
        gap: 8px;
        opacity: 0.3;
    }
    
    .decorative-dots span {
        width: 8px;
        height: 8px;
        background: var(--heading-color);
        border-radius: 50%;
        animation: dotFloat 3s ease-in-out infinite;
    }
    
    .decorative-dots span:nth-child(2) {
        animation-delay: 0.5s;
    }
    
    .decorative-dots span:nth-child(3) {
        animation-delay: 1s;
    }
    
    @keyframes dotFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* Responsive Design */
    @media (max-width: 991.98px) {
        .thank-you-container {
            padding: 2rem 1rem;
        }
        
        .thank-you-card {
            padding: 3rem 2rem;
            margin: 0 auto;
        }
        
        .thank-you-title {
            font-size: clamp(2rem, 4vw, 3rem);
        }
        
        .main-description {
            font-size: 1.2rem;
        }
        
        .reference-id {
            font-size: 1.2rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .thank-you-container {
            padding: 1rem;
        }
        
        .thank-you-card {
            padding: 2.5rem 1.5rem;
            margin: 0 auto;
            border-radius: 24px;
        }
        
        .success-icon i {
            font-size: 4.5rem;
        }
        
        .thank-you-title {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            margin-bottom: 1rem;
        }
        
        .main-description {
            font-size: 1.1rem;
            margin: 1.5rem 0;
        }
        
        .reference-section {
            padding: 1.5rem;
            margin: 2rem 0;
        }
        
        .reference-id {
            font-size: 1.1rem;
            padding: 0.4rem 0.8rem;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .enhanced-btn {
            width: 100%;
            max-width: 300px;
            padding: 1rem 1.5rem;
        }
        
        .decorative-dots {
            display: none;
        }
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
</style>

<div class="thank-you-container">
    <div class="thank-you-card" data-aos="fade-up" data-aos-duration="800">
                    <!-- Decorative dots -->
                    <div class="decorative-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    
                    <!-- Success Icon -->
                    <div class="success-icon" data-aos="zoom-in" data-aos-delay="200">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    
                    <!-- Main Title -->
                    <h1 class="thank-you-title" data-aos="fade-up" data-aos-delay="300">
                        Thank You!
                    </h1>
                    
                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="enhanced-alert" data-aos="fade-up" data-aos-delay="400">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Main Description -->
                    <p class="main-description" data-aos="fade-up" data-aos-delay="500">
                        Your weather observation report has been successfully submitted. Your contribution is valuable in helping us monitor and understand weather patterns across Pakistan.
                    </p>
                    
                    <!-- Reference ID Section -->
                    <div class="reference-section" data-aos="fade-up" data-aos-delay="600">
                        <div class="reference-label">Reference ID:</div>
                        <div class="reference-id">{{ sprintf('WO-%s', date('YmdHis')) }}</div>
                        <div class="reference-note">Please save this reference ID for any future inquiries about your submission.</div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons" data-aos="fade-up" data-aos-delay="700">
                        <a href="{{ route('public.weather.observation.create') }}" class="enhanced-btn">
                            <i class="fas fa-plus-circle"></i>
                            Submit Another Report
                        </a>
                        <a href="{{ url('/') }}" class="enhanced-btn enhanced-btn-secondary">
                            <i class="fas fa-home"></i>
                            Return to Home
                        </a>
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

    // Enhanced button interactions
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.enhanced-btn');
        
        buttons.forEach(button => {
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
            
            // Enhanced hover effects
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
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
        
        // Auto-copy reference ID on click
        const referenceId = document.querySelector('.reference-id');
        if (referenceId) {
            referenceId.style.cursor = 'pointer';
            referenceId.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent).then(() => {
                    // Show temporary success message
                    const originalText = this.textContent;
                    this.textContent = 'Copied!';
                    this.style.background = 'rgba(34, 197, 94, 0.2)';
                    this.style.borderColor = 'rgba(34, 197, 94, 0.4)';
                    
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.style.background = 'rgba(255, 173, 81, 0.1)';
                        this.style.borderColor = 'rgba(255, 173, 81, 0.2)';
                    }, 2000);
                }).catch(() => {
                    console.log('Failed to copy reference ID');
                });
            });
        }
    });
</script>
@endpush
