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

<style>
    /* Weather observation details page specific colors - scoped to avoid global conflicts */
    .weather-details-container {
        --heading-color: #FFAD51;
        --container-bg: #CFE2FF;
        --body-text: #898E8F;
        --border-radius: 12px;
        --success-color: #198754;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        
        /* Form specific colors */
        --form-bg: #FFFFFF;
        --form-border: rgba(255, 173, 81, 0.2);
        --form-focus: #FFAD51;
        --form-text: #495057;
        --form-label: #2c3e50;
    }
    
    /* Dark Theme Variables - scoped to weather details container */
    [data-theme="dark"] .weather-details-container {
        --heading-color: #FFAD51;
        --container-bg: var(--theme-bg-tertiary, #3a3636);
        --body-text: var(--theme-text-secondary, #adb5bd);
        --form-bg: var(--theme-card-bg, #2f2b2b);
        --form-border: rgba(255, 173, 81, 0.3);
        --form-text: var(--theme-text-primary, #ffffff);
        --form-label: var(--theme-text-primary, #ffffff);
    }
    
    /* Weather Details Container */
    .weather-details-container {
        padding: 4rem 0 6rem 0;
        position: relative;
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
    }
    
    .weather-details-container::before {
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
    
    .back-button:hover {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%) !important;
        color: white !important;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(255, 173, 81, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border-color: var(--heading-color) !important;
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
    
    /* Enhanced Button Styles */
    .weather-details-container .btn {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        border-radius: var(--border-radius);
        padding: 0.75rem 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        border: 2px solid transparent;
    }
    
    .weather-details-container .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .weather-details-container .btn-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #218838 100%);
        border-color: var(--success-color);
        color: white;
    }
    
    .weather-details-container .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        color: white;
    }
    
    .weather-details-container .btn-secondary {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #5a6268 100%);
        border-color: var(--secondary-color);
        color: white;
    }
    
    .weather-details-container .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268 0%, #545b62 100%);
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        color: white;
    }
    
    .weather-details-container .btn-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%);
        border-color: var(--danger-color);
        color: white;
    }
    
    .weather-details-container .btn-danger:hover {
        background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
        color: white;
    }
    
    .weather-details-container .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background: transparent;
    }
    
    .weather-details-container .btn-outline-primary:hover {
        background: linear-gradient(135deg, var(--primary-color) 0%, #0b5ed7 100%);
        color: white;
        box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);
    }
    
    /* Enhanced Cards */
    .weather-card {
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
        margin-bottom: 2rem;
    }
    
    .weather-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--heading-color) 0%, #ffb866 100%);
        border-radius: 20px 20px 0 0;
    }
    
    .weather-card:hover {
        transform: translateY(-5px);
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.12),
            0 8px 20px rgba(0, 0, 0, 0.08),
            0 0 0 1px rgba(255, 173, 81, 0.1);
    }
    
    /* Dark mode cards */
    [data-theme="dark"] .weather-card {
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
    
    .card-header h3, .card-header h4 {
        color: var(--theme-text-primary) !important;
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-header h3 i, .card-header h4 i {
        color: var(--heading-color);
        font-size: 1.2rem;
        filter: drop-shadow(0 2px 4px rgba(255, 173, 81, 0.3));
    }
    
    .card-body {
        padding: 2rem;
        position: relative;
        z-index: 1;
    }
    
    /* Status Badge */
    .status-badge {
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        animation: statusPulse 2s infinite;
    }
    
    .status-badge.bg-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #0b5ed7 100%) !important;
    }
    
    .status-badge.bg-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #218838 100%) !important;
    }
    
    .status-badge.bg-secondary {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #5a6268 100%) !important;
    }
    
    .status-badge.bg-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%) !important;
    }
    
    @keyframes statusPulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.9; }
    }
    
    /* List Group Enhancement */
    .list-group-item {
        background: transparent !important;
        border: none !important;
        border-bottom: 1px solid rgba(255, 173, 81, 0.1) !important;
        padding: 1rem 0 !important;
        transition: all 0.3s ease;
    }
    
    .list-group-item:hover {
        background: rgba(255, 173, 81, 0.02) !important;
        border-radius: 8px;
        margin: 0 -1rem;
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }
    
    .list-group-item .fw-bold {
        color: var(--body-text) !important;
        font-weight: 500 !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .list-group-item span:not(.fw-bold) {
        color: var(--theme-text-primary) !important;
        font-weight: 600 !important;
    }
    
    /* Weather Phenomena Badges */
    .weather-badge {
        background: linear-gradient(135deg, var(--heading-color) 0%, #ffb866 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        margin: 0.25rem;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(255, 173, 81, 0.3);
        transition: all 0.3s ease;
    }
    
    .weather-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 173, 81, 0.4);
    }
    
    /* Media Grid */
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-top: 1rem;
    }
    
    .media-item {
        position: relative;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .media-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .media-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: var(--border-radius);
        transition: all 0.3s ease;
    }
    
    .media-item:hover img {
        transform: scale(1.05);
    }
    
    /* Dark theme media files */
    [data-theme="dark"] .media-item {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    
    [data-theme="dark"] .media-item:hover {
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }
    
    /* Alert Enhancement */
    .alert {
        border-radius: var(--border-radius);
        border: none;
        padding: 1.25rem 1.5rem;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);
        color: var(--success-color);
        border: 1px solid rgba(40, 167, 69, 0.2);
    }
    
    .alert::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: currentColor;
        opacity: 0.6;
    }
    
    /* Map Container */
    .map-container {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        height: 300px;
    }
    
    /* Modal Enhancement */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    
    .modal-header {
        border-bottom: 1px solid var(--form-border);
        background: linear-gradient(135deg, var(--form-bg) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-radius: 20px 20px 0 0;
    }
    
    .modal-body {
        background: var(--form-bg);
    }
    
    .modal-footer {
        border-top: 1px solid var(--form-border);
        background: linear-gradient(135deg, var(--form-bg) 0%, rgba(255, 255, 255, 0.95) 100%);
        border-radius: 0 0 20px 20px;
    }
    
    /* Typography */
    .weather-details-container h1, 
    .weather-details-container h2, 
    .weather-details-container h3, 
    .weather-details-container h4, 
    .weather-details-container h5, 
    .weather-details-container h6 {
        color: var(--theme-text-primary);
        font-weight: 600;
        line-height: 1.3;
    }
    
    /* Responsive Design */
    @media (max-width: 991.98px) {
        .page-header {
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 767.98px) {
        .weather-card {
            border-radius: 16px;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            border-radius: 16px 16px 0 0;
            padding: 1.25rem 1.5rem;
        }
        
        .card-body {
            padding: 1.25rem 1.5rem;
        }
        
        .media-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="weather-details-container">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header" data-aos="fade-up">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h1 class="page-title">
                        <i class="bi bi-cloud-rain me-3"></i>Weather Observation Details
                    </h1>
                    <p class="page-subtitle">Detailed information about this weather observation report</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.weather-observations.index', ['status' => $observation->status]) }}" class="back-button">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4" data-aos="fade-up">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <!-- Observation Details -->
                <div class="weather-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="bi bi-file-earmark-text"></i>
                            Observation #{{ $observation->id }}
                        </h3>
                        <span class="status-badge 
                            @if($observation->status == 'pending') bg-primary 
                            @elseif($observation->status == 'approved') bg-success 
                            @elseif($observation->status == 'archived') bg-secondary 
                            @elseif($observation->status == 'flagged') bg-danger 
                            @endif">
                            {{ ucfirst($observation->status) }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-4">
                                <h4 class="mb-3">
                                    <i class="bi bi-calendar-event me-2" style="color: var(--heading-color);"></i>
                                    Event Information
                                </h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-calendar3 me-2" style="color: var(--heading-color);"></i>
                                            Event Date:
                                        </span>
                                        <span>{{ $observation->event_date->format('Y-m-d') }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-clock me-2" style="color: var(--heading-color);"></i>
                                            Event Time:
                                        </span>
                                        <span>{{ $observation->event_time }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-geo-alt me-2" style="color: var(--heading-color);"></i>
                                            Location:
                                        </span>
                                        <span>{{ $observation->location_city }}, {{ $observation->location_state }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-globe me-2" style="color: var(--heading-color);"></i>
                                            Time Zone:
                                        </span>
                                        <span>{{ $observation->time_zone }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="fw-bold">
                                            <i class="bi bi-crosshair me-2" style="color: var(--heading-color);"></i>
                                            Coordinates:
                                        </span>
                                        <span>{{ $observation->latitude }}, {{ $observation->longitude }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4 class="mb-3">
                                    <i class="bi bi-person me-2" style="color: var(--heading-color);"></i>
                                    Submitter Information
                                </h4>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-person-circle me-2" style="color: var(--heading-color);"></i>
                                            Name:
                                        </span>
                                        <span>{{ $observation->user_name }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-person-badge me-2" style="color: var(--heading-color);"></i>
                                            Personal Number:
                                        </span>
                                        <span>{{ $observation->personal_number }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-briefcase me-2" style="color: var(--heading-color);"></i>
                                            Designation:
                                        </span>
                                        <span>{{ $observation->designation }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="fw-bold">
                                            <i class="bi bi-calendar-plus me-2" style="color: var(--heading-color);"></i>
                                            Submitted On:
                                        </span>
                                        <span>{{ $observation->created_at->format('Y-m-d H:i') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">
                                    <i class="bi bi-cloud-lightning me-2" style="color: var(--heading-color);"></i>
                                    Weather Phenomena
                                </h4>
                                <div class="mb-3">
                                    @foreach($observation->weather_types as $type)
                                        <span class="weather-badge">{{ str_replace('_', ' ', ucfirst($type)) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">
                                    <i class="bi bi-exclamation-triangle me-2" style="color: var(--heading-color);"></i>
                                    Damages Reported
                                </h4>
                                <div class="mb-3">
                                    @if(is_array($observation->damages) && count($observation->damages) > 0)
                                        <ul class="list-group">
                                            @foreach($observation->damages as $key => $damage)
                                                @if($key !== 'other_damage_details')
                                                    <li class="list-group-item">
                                                        <i class="bi bi-arrow-right me-2" style="color: var(--heading-color);"></i>
                                                        {{ str_replace('_', ' ', ucfirst($damage)) }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        
                                        @if(isset($observation->damages['other_damage_details']))
                                            <div class="mt-3 p-3" style="background: rgba(255, 173, 81, 0.05); border-radius: var(--border-radius); border-left: 4px solid var(--heading-color);">
                                                <h5 class="mb-2">
                                                    <i class="bi bi-info-circle me-2" style="color: var(--heading-color);"></i>
                                                    Other Damage Details:
                                                </h5>
                                                <p class="mb-0">{{ $observation->damages['other_damage_details'] }}</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-4" style="background: rgba(108, 117, 125, 0.1); border-radius: var(--border-radius);">
                                            <i class="bi bi-shield-check" style="font-size: 2rem; color: var(--success-color);"></i>
                                            <p class="mt-2 mb-0" style="color: var(--success-color); font-weight: 600;">No damages reported</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4 class="mb-3">
                                    <i class="bi bi-file-text me-2" style="color: var(--heading-color);"></i>
                                    Event Description
                                </h4>
                                <div class="p-4" style="background: rgba(255, 173, 81, 0.05); border-radius: var(--border-radius); border: 1px solid var(--form-border);">
                                    <p class="mb-0" style="line-height: 1.6; color: var(--theme-text-primary);">
                                        {{ $observation->event_description ?? 'No description provided' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if(is_array($observation->media_files) && count($observation->media_files) > 0)
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h4 class="mb-3">
                                        <i class="bi bi-images me-2" style="color: var(--heading-color);"></i>
                                        Media Files
                                    </h4>
                                    <div class="media-grid">
                                        @foreach($observation->media_files as $media)
                                            @php
                                                $extension = pathinfo($media, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                            @endphp
                                            
                                            <div class="media-item">
                                                @if($isImage)
                                                    <a href="{{ asset('storage/' . $media) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $media) }}" alt="Weather Event Media">
                                                    </a>
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center" style="height: 200px; background: rgba(255, 173, 81, 0.1); border-radius: var(--border-radius);">
                                                        <a href="{{ asset('storage/' . $media) }}" class="btn btn-outline-primary btn-lg" target="_blank">
                                                            <i class="bi bi-file-earmark-play me-2"></i> View Video
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>

                @if($observation->status === 'flagged' && $observation->flag_reason)
                    <div class="weather-card" style="border-left: 4px solid var(--danger-color);" data-aos="fade-up" data-aos-delay="300">
                        <div class="card-header" style="background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);">
                            <h4 class="mb-0" style="color: var(--danger-color);">
                                <i class="bi bi-flag" style="color: var(--danger-color);"></i>
                                Flag Reason
                            </h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0" style="color: var(--theme-text-primary); line-height: 1.6;">
                                {{ $observation->flag_reason }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <!-- Action Panel -->
                <div class="weather-card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-gear"></i>
                            Actions
                        </h4>
                    </div>
                <div class="card-body">
                    @if($observation->status === 'pending')
                        <form action="{{ route('admin.weather-observations.approve', $observation) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-lg w-100">
                                <i class="bi bi-check-circle"></i> Approve Observation
                            </button>
                        </form>
                    @endif

                    @if($observation->status !== 'archived')
                        <form action="{{ route('admin.weather-observations.archive', $observation) }}" method="POST" class="mb-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary btn-lg w-100">
                                <i class="bi bi-archive"></i> Archive Observation
                            </button>
                        </form>
                    @endif

                    @if($observation->status !== 'flagged')
                        <button type="button" class="btn btn-danger btn-lg w-100" data-bs-toggle="modal" data-bs-target="#flagModal">
                            <i class="bi bi-flag"></i> Flag Observation
                        </button>
                    @endif
                </div>
            </div>

                <!-- Map Card -->
                <div class="weather-card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="bi bi-map"></i>
                            Location Map
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="map" class="map-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flag Modal -->
<div class="modal fade" id="flagModal" tabindex="-1" aria-labelledby="flagModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.weather-observations.flag', $observation) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title" id="flagModalLabel">Flag Observation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="flag_reason" class="form-label">Reason for Flagging</label>
                        <textarea class="form-control" id="flag_reason" name="flag_reason" rows="5" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Flag Observation</button>
                </div>
            </form>
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

    // Initialize Mapbox map
    document.addEventListener('DOMContentLoaded', function() {
        // Check if mapboxgl is loaded
        if (typeof mapboxgl === 'undefined') {
            console.error('Mapbox GL JS not loaded');
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                mapContainer.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100 text-muted">Map service unavailable</div>';
            }
            return;
        }

        // Initialize map with error handling
        try {
            mapboxgl.accessToken = '{{ config("services.mapbox.token") }}';
            
            const lat = {{ $observation->latitude }};
            const lng = {{ $observation->longitude }};
            
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [lng, lat],
                zoom: 13
            });

            // Wait for map to load
            map.on('load', function() {
                console.log('Map loaded successfully');
            });

            map.on('error', function(e) {
                console.error('Map error:', e);
                const mapContainer = document.getElementById('map');
                if (mapContainer) {
                    mapContainer.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100 text-muted">Map loading failed</div>';
                }
            });

            // Add marker
            const marker = new mapboxgl.Marker({
                color: "#FFAD51"
            })
                .setLngLat([lng, lat])
                .addTo(map);

            // Add popup with location info
            const popup = new mapboxgl.Popup({ offset: 25 })
                .setHTML(`
                    <div style="padding: 10px;">
                        <h6 style="margin: 0 0 5px 0; color: #FFAD51;">Weather Event Location</h6>
                        <p style="margin: 0; font-size: 0.9rem;">
                            <strong>Coordinates:</strong><br>
                            ${lat}, ${lng}
                        </p>
                        <p style="margin: 5px 0 0 0; font-size: 0.9rem;">
                            <strong>Location:</strong><br>
                            {{ $observation->location_city }}, {{ $observation->location_state }}
                        </p>
                    </div>
                `);

            marker.setPopup(popup);

        } catch (error) {
            console.error('Error initializing map:', error);
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                mapContainer.innerHTML = '<div class="d-flex align-items-center justify-content-center h-100 text-muted">Map initialization failed</div>';
            }
        }
    });

    // Enhanced button interactions - scoped to weather details container
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.weather-details-container .btn, .back-button');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
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
                ripple.style.background = 'rgba(255, 255, 255, 0.3)';
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
        
        // Enhanced card hover effects
        const cards = document.querySelectorAll('.weather-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.01)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
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
    });
</script>
@endpush 