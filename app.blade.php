<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Critical Theme Script - Must load before any styles to prevent flash -->
    <script>
        (function() {
            // Immediately apply saved theme or system preference before page renders
            const savedTheme = localStorage.getItem('pmd-theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            
            // Apply theme attributes immediately to html element
            document.documentElement.setAttribute('data-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
            
            // Add class to body for immediate styling
            if (theme === 'dark') {
                document.documentElement.classList.add('dark-theme');
            }
        })();
    </script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form-protection.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container-fluid">
                @auth
                    <!-- Sidebar toggle button for authenticated users -->
                    <button class="btn btn-outline-secondary me-2 d-lg-block" type="button" id="sidebarToggle" 
                            title="Open Sidebar" aria-label="Open sidebar navigation" aria-expanded="false">
                        <i class="bi bi-list"></i>
                    </button>
                @endauth

                <!-- Logo and brand name -->
                <a class="navbar-brand d-flex align-items-center me-auto" href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard')) : url('/') }}">
                    <div class="me-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                        <img src="{{ asset('images/pmd-logo.png') }}" alt="PMD Logo" style="width: 38px; height: 38px; object-fit: contain;">
                    </div>
                    <span class="fw-bold navbar-brand-text">Pakistan Meteorological Department</span>
                </a>

                <!-- Theme toggle for mobile - placed before navbar toggler -->
                <div class="d-lg-none me-2">
                    <div class="theme-toggle-container">
                        <input type="checkbox" id="themeToggleMobile" class="toggle-input">
                        <label for="themeToggleMobile" class="toggle-switch mobile-toggle" title="Toggle Dark/Light Mode">
                            <div class="light-bg"></div>
                            <div class="stars-layer-1"></div>
                            <div class="stars-layer-2"></div>
                            <div class="stars-layer-3"></div>
                            <div class="cloud"></div>
                            <div class="cloud"></div>
                            <div class="cloud"></div>
                            <div class="cloud"></div>
                            <div class="toggle-circle">
                                <div class="sun-rays"></div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <!-- Premium Animated Theme Toggle Switch for Desktop -->
                        <li class="nav-item d-none d-lg-flex align-items-center me-2">
                            <div class="theme-toggle-container">
                                <input type="checkbox" id="themeToggle" class="toggle-input">
                                <label for="themeToggle" class="toggle-switch" title="Toggle Dark/Light Mode">
                                    <div class="light-bg"></div>
                                    <div class="stars-layer-1"></div>
                                    <div class="stars-layer-2"></div>
                                    <div class="stars-layer-3"></div>
                                    <div class="cloud"></div>
                                    <div class="cloud"></div>
                                    <div class="cloud"></div>
                                    <div class="cloud"></div>
                                    <div class="toggle-circle">
                                        <div class="sun-rays"></div>
                                    </div>
                                </label>
                            </div>
                        </li>
                        
                        @guest
                            <!-- Guest navigation (non-authenticated users) -->
                            @if(request()->routeIs('welcome'))
                            <li class="nav-item">
                                <a href="{{ route('login') }}" 
                                   class="nav-link responsive-tooltip"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="bottom" 
                                   data-tooltip-desktop="<strong>Organization Portal</strong><br>Access comprehensive weather data analytics, submit official meteorological observations, and manage your institutional dashboard with advanced reporting tools."
                                   data-tooltip-tablet="<strong>Organization Portal</strong><br>Access weather analytics and manage your dashboard."
                                   data-tooltip-mobile="Login for weather data access"
                                   data-bs-html="true">
                                   Official Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('public.weather.observation.create') }}" 
                                   class="nav-link responsive-tooltip"
                                   data-bs-toggle="tooltip" 
                                   data-bs-placement="bottom" 
                                   data-tooltip-desktop="<strong>Citizen Science</strong><br>Contribute to Pakistan's weather monitoring network by submitting local observations. Help create a comprehensive national weather database through community participation."
                                   data-tooltip-tablet="<strong>Citizen Science</strong><br>Submit local weather observations to help build our national database."
                                   data-tooltip-mobile="Submit weather observations"
                                   data-bs-html="true">
                                   Public Form
                                </a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Signup</a>
                            </li>
                            @endif
                        @else
                            <!-- Authenticated user - profile display only -->
                            <li class="nav-item">
                                <span class="nav-link profile-display d-flex align-items-center">
                                    @if(auth()->user()->profile_image)
                                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                            <i class="bi bi-person-fill text-white"></i>
                                        </div>
                                    @endif
                                    {{ auth()->user()->username }}
                                </span>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Sidebar for authenticated users -->
        @auth
        <div id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center p-3">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="bi bi-person-fill text-white fs-4"></i>
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-0">{{ auth()->user()->username }}</h6>
                        @if(auth()->user()->role !== 'admin')
                            <small class="text-muted">{{ auth()->user()->designation }}</small>
                        @else
                            <small class="text-muted">System Administrator</small>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="sidebar-content">
                @if(auth()->user()->role === 'admin')
                    <!-- Admin Sidebar -->
                    <div class="sidebar-section">
                        <h6 class="sidebar-title">Dashboard</h6>
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Overview</span>
                        </a>
                    </div>

                    <div class="sidebar-section">
                        <h6 class="sidebar-title">User Management</h6>
                        <a href="{{ route('admin.users.index') }}" class="sidebar-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                            <i class="bi bi-people"></i>
                            <span>All Users</span>
                        </a>
                        <a href="{{ route('admin.users.index', ['status' => 'inactive']) }}" class="sidebar-item {{ request()->routeIs('admin.users.index') && request()->get('status') === 'inactive' ? 'active' : '' }}">
                            <i class="bi bi-person-exclamation"></i>
                            <span>Pending Approvals</span>
                        </a>
                        <a href="{{ route('admin.users.index', ['status' => 'active']) }}" class="sidebar-item {{ request()->routeIs('admin.users.index') && request()->get('status') === 'active' ? 'active' : '' }}">
                            <i class="bi bi-person-check"></i>
                            <span>Active Users</span>
                        </a>
                    </div>

                    <div class="sidebar-section">
                        <h6 class="sidebar-title">Weather Data</h6>
                        <a href="{{ route('admin.weather-observations.index') }}" class="sidebar-item {{ request()->routeIs('admin.weather-observations.index') && !request()->get('status') ? 'active' : '' }}">
                            <i class="bi bi-cloud-rain"></i>
                            <span>All Observations</span>
                        </a>
                        <a href="{{ route('admin.weather-observations.index', ['status' => 'pending']) }}" class="sidebar-item {{ request()->routeIs('admin.weather-observations.index') && request()->get('status') === 'pending' ? 'active' : '' }}">
                            <i class="bi bi-clock"></i>
                            <span>Pending Review</span>
                        </a>
                        <a href="{{ route('admin.weather-observations.index', ['status' => 'approved']) }}" class="sidebar-item {{ request()->routeIs('admin.weather-observations.index') && request()->get('status') === 'approved' ? 'active' : '' }}">
                            <i class="bi bi-check-circle"></i>
                            <span>Approved</span>
                        </a>
                        <a href="{{ route('admin.weather-observations.index', ['status' => 'flagged']) }}" class="sidebar-item {{ request()->routeIs('admin.weather-observations.index') && request()->get('status') === 'flagged' ? 'active' : '' }}">
                            <i class="bi bi-flag"></i>
                            <span>Flagged</span>
                        </a>
                    </div>

                    <div class="sidebar-section">
                        <h6 class="sidebar-title">My Account</h6>
                        <a href="{{ route('admin.profile.edit') }}" class="sidebar-item {{ request()->routeIs('admin.profile.edit') ? 'active' : '' }}">
                            <i class="bi bi-person-gear"></i>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                @else
                    <!-- Regular User Sidebar -->
                    <div class="sidebar-section">
                        <h6 class="sidebar-title">Dashboard</h6>
                        <a href="{{ route('user.dashboard') }}" class="sidebar-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Overview</span>
                        </a>
                    </div>

                    <div class="sidebar-section">
                        <h6 class="sidebar-title">Weather Data</h6>
                        <a href="{{ route('user.weather.observation.create') }}" class="sidebar-item {{ request()->routeIs('user.weather.observation.create') ? 'active' : '' }}">
                            <i class="bi bi-cloud-plus"></i>
                            <span>Submit Observation</span>
                        </a>
                        <a href="{{ route('weather.observations') }}" class="sidebar-item {{ request()->routeIs('weather.observations') ? 'active' : '' }}">
                            <i class="bi bi-cloud-rain"></i>
                            <span>View Observations</span>
                        </a>
                    </div>

                    <div class="sidebar-section">
                        <h6 class="sidebar-title">My Account</h6>
                        <a href="{{ route('user.profile.edit') }}" class="sidebar-item {{ request()->routeIs('user.profile.edit') ? 'active' : '' }}">
                            <i class="bi bi-person-gear"></i>
                            <span>Edit Profile</span>
                        </a>
                        <a href="{{ route('user.password.change.form') }}" class="sidebar-item {{ request()->routeIs('user.password.change.form') ? 'active' : '' }}">
                            <i class="bi bi-key"></i>
                            <span>Change Password</span>
                        </a>
                    </div>
                @endif



                <div class="sidebar-footer">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-item logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar overlay for mobile -->
        <div id="sidebarOverlay" class="sidebar-overlay"></div>
        @endauth

        <!-- Main content wrapper -->
        <div id="content-wrapper" class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Management Script -->
    <script>
        // Theme Management System
        const ThemeManager = {
            init() {
                this.themeToggle = document.getElementById('themeToggle');
                this.themeToggleMobile = document.getElementById('themeToggleMobile');
                this.themeContainer = document.querySelector('.theme-toggle-container');
                this.syncToggleWithCurrentTheme();
                this.bindEvents();
            },
            
            syncToggleWithCurrentTheme() {
                // Sync toggle switches with the current theme (already applied by critical script)
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
                this.updateToggleSwitches(currentTheme);
            },
            
            bindEvents() {
                // Bind both desktop and mobile theme toggles
                if (this.themeToggle) {
                    this.themeToggle.addEventListener('change', () => {
                        this.toggleTheme();
                    });
                }
                
                if (this.themeToggleMobile) {
                    this.themeToggleMobile.addEventListener('change', () => {
                        this.toggleTheme();
                    });
                }
                
                // Listen for system theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('pmd-theme')) {
                        this.applyTheme(e.matches ? 'dark' : 'light');
                    }
                });
            },
            
            toggleTheme() {
                const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                this.applyTheme(newTheme);
            },
            
            applyTheme(theme) {
                // Apply theme to document
                document.documentElement.setAttribute('data-theme', theme);
                
                // Save preference
                localStorage.setItem('pmd-theme', theme);
                
                // Update toggle switches
                this.updateToggleSwitches(theme);
                
                // Update Bootstrap theme if applicable
                this.updateBootstrapTheme(theme);
                
                // Update dark-theme class for immediate styling
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark-theme');
                } else {
                    document.documentElement.classList.remove('dark-theme');
                }
                
                // Trigger custom event for other components
                window.dispatchEvent(new CustomEvent('themeChanged', { 
                    detail: { theme: theme } 
                }));
            },
            
            updateToggleSwitches(theme) {
                const isLight = (theme === 'light');
                
                if (this.themeToggle) {
                    this.themeToggle.checked = isLight;
                    const toggleSwitch = this.themeToggle.nextElementSibling;
                    if (toggleSwitch) {
                        toggleSwitch.title = isLight ? 'Switch to Dark Mode' : 'Switch to Light Mode';
                    }
                }
                
                if (this.themeToggleMobile) {
                    this.themeToggleMobile.checked = isLight;
                    const toggleSwitch = this.themeToggleMobile.nextElementSibling;
                    if (toggleSwitch) {
                        toggleSwitch.title = isLight ? 'Switch to Dark Mode' : 'Switch to Light Mode';
                    }
                }
            },
            
            updateBootstrapTheme(theme) {
                // Update data-bs-theme attribute for Bootstrap 5.3+ dark mode support
                document.documentElement.setAttribute('data-bs-theme', theme);
                
                // Update any existing modals, dropdowns, etc.
                const modals = document.querySelectorAll('.modal');
                const dropdowns = document.querySelectorAll('.dropdown-menu');
                
                modals.forEach(modal => {
                    modal.setAttribute('data-bs-theme', theme);
                });
                
                dropdowns.forEach(dropdown => {
                    dropdown.setAttribute('data-bs-theme', theme);
                });
            },
            
            getCurrentTheme() {
                return document.documentElement.getAttribute('data-theme') || 'light';
            }
        };
        
        // Initialize theme system when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            ThemeManager.init();
        });
        
        // Make ThemeManager globally available
        window.ThemeManager = ThemeManager;
    </script>
    
    <!-- Global Navbar Scroll Effect -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.querySelector('.navbar');
            const navbarCollapse = document.getElementById('navbarNav');
            const navbarToggler = document.querySelector('.navbar-toggler');
            
            // Global navbar scroll effect
            let scrollTimeout;
            function handleScroll() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }, 10);
            }
            
            window.addEventListener('scroll', handleScroll, { passive: true });
            
            // Enhanced mobile navigation
            if (navbarCollapse && navbarToggler) {
                // Close navbar when clicking nav links on mobile
                const navLinks = navbarCollapse.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (window.innerWidth < 992) {
                            const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                                hide: true
                            });
                            bsCollapse.hide();
                        }
                    });
                });
                
                // Close navbar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        const isClickInsideNav = navbar.contains(e.target);
                        const isNavOpen = navbarCollapse.classList.contains('show');
                        
                        if (!isClickInsideNav && isNavOpen) {
                            const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                                hide: true
                            });
                            bsCollapse.hide();
                        }
                    }
                });
                
                // Handle escape key to close navbar
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                            hide: true
                        });
                        bsCollapse.hide();
                    }
                });
            }
        });
    </script>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const contentWrapper = document.getElementById('content-wrapper');
            
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                contentWrapper.classList.toggle('sidebar-active');
                
                // Update toggle button state and icon
                const icon = sidebarToggle.querySelector('i');
                if (sidebar.classList.contains('active')) {
                    sidebarToggle.classList.add('active');
                    icon.className = 'bi bi-x-lg';
                    sidebarToggle.setAttribute('title', 'Close Sidebar');
                    sidebarToggle.setAttribute('aria-label', 'Close sidebar navigation');
                    sidebarToggle.setAttribute('aria-expanded', 'true');
                } else {
                    sidebarToggle.classList.remove('active');
                    icon.className = 'bi bi-list';
                    sidebarToggle.setAttribute('title', 'Open Sidebar');
                    sidebarToggle.setAttribute('aria-label', 'Open sidebar navigation');
                    sidebarToggle.setAttribute('aria-expanded', 'false');
                }
            }
            
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking overlay
            overlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                    toggleSidebar();
                }
            });
            
            // Auto-close sidebar on mobile when clicking a link
            const sidebarLinks = document.querySelectorAll('.sidebar-item');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768 && sidebar.classList.contains('active')) {
                        setTimeout(toggleSidebar, 100);
                    }
                });
            });
        });
        </script>
    @endauth

    @stack('scripts')
    
    <!-- Universal Form Double Submission Protection -->
    <script src="{{ asset('js/form-protection.js') }}"></script>
    
    <!-- Enhanced Responsive Tooltips for Welcome Page -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Responsive Tooltip Management System
            const ResponsiveTooltips = {
                tooltips: [],
                
                // Define breakpoints
                breakpoints: {
                    mobile: 576,
                    tablet: 992,
                    desktop: Infinity
                },
                
                init() {
                    this.initializeTooltips();
                    this.bindResizeHandler();
                },
                
                getScreenSize() {
                    const width = window.innerWidth;
                    if (width < this.breakpoints.mobile) {
                        return 'mobile';
                    } else if (width < this.breakpoints.tablet) {
                        return 'tablet';
                    } else {
                        return 'desktop';
                    }
                },
                
                getTooltipContent(element) {
                    const screenSize = this.getScreenSize();
                    const contentAttr = `data-tooltip-${screenSize}`;
                    return element.getAttribute(contentAttr) || element.getAttribute('data-tooltip-desktop') || element.getAttribute('title') || '';
                },
                
                initializeTooltips() {
                    // Dispose existing tooltips
                    this.disposeTooltips();
                    
                    // Find all responsive tooltip elements
                    const tooltipElements = document.querySelectorAll('.responsive-tooltip[data-bs-toggle="tooltip"]');
                    
                    tooltipElements.forEach(element => {
                        // Set the appropriate content based on screen size
                        const content = this.getTooltipContent(element);
                        element.setAttribute('data-bs-original-title', content);
                        element.setAttribute('title', content);
                        
                        // Create new tooltip instance
                        const tooltip = new bootstrap.Tooltip(element, {
                            html: true,
                            placement: 'bottom',
                            trigger: 'hover focus',
                            delay: { show: 300, hide: 100 },
                            animation: true,
                            boundary: 'viewport'
                        });
                        
                        this.tooltips.push(tooltip);
                    });
                    
                    // Also initialize any other tooltips
                    const otherTooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]:not(.responsive-tooltip)');
                    otherTooltipElements.forEach(element => {
                        const tooltip = new bootstrap.Tooltip(element);
                        this.tooltips.push(tooltip);
                    });
                },
                
                disposeTooltips() {
                    // Dispose all existing tooltips
                    this.tooltips.forEach(tooltip => {
                        if (tooltip && typeof tooltip.dispose === 'function') {
                            tooltip.dispose();
                        }
                    });
                    this.tooltips = [];
                },
                
                updateTooltips() {
                    const responsiveElements = document.querySelectorAll('.responsive-tooltip[data-bs-toggle="tooltip"]');
                    
                    responsiveElements.forEach(element => {
                        // Find the tooltip instance for this element
                        const tooltipInstance = bootstrap.Tooltip.getInstance(element);
                        
                        if (tooltipInstance) {
                            // Get new content based on current screen size
                            const newContent = this.getTooltipContent(element);
                            
                            // Update the tooltip content
                            tooltipInstance.setContent({ '.tooltip-inner': newContent });
                            
                            // Update the element's attributes
                            element.setAttribute('data-bs-original-title', newContent);
                            element.setAttribute('title', newContent);
                        }
                    });
                },
                
                bindResizeHandler() {
                    let resizeTimeout;
                    
                    window.addEventListener('resize', () => {
                        // Debounce resize events
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(() => {
                            // Only update if screen size category actually changed
                            const currentScreenSize = this.getScreenSize();
                            if (this.lastScreenSize !== currentScreenSize) {
                                this.lastScreenSize = currentScreenSize;
                                this.updateTooltips();
                            }
                        }, 150);
                    });
                    
                    // Set initial screen size
                    this.lastScreenSize = this.getScreenSize();
                }
            };
            
            // Initialize the responsive tooltip system
            ResponsiveTooltips.init();
            
            // Make it globally available for debugging
            window.ResponsiveTooltips = ResponsiveTooltips;
        });
    </script>
</body>
</html>
