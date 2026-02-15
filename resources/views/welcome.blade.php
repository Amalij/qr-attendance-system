<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <style>
            /* Modern Dashboard Styles */
            :root {
                --primary: #4f46e5;
                --primary-dark: #3730a3;
                --secondary: #8b5cf6;
                --accent: #ec4899;
                --success: #10b981;
                --info: #06b6d4;
                --warning: #f59e0b;
                --background-light: #f8fafc;
                --background-card: #ffffff;
                --text-primary: #1e293b;
                --text-secondary: #64748b;
                --border-light: #e2e8f0;
                --shadow-light: 0 1px 3px 0 rgb(0 0 0 / 0.1);
                --shadow-medium: 0 4px 6px -1px rgb(0 0 0 / 0.1);
                --shadow-large: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            }

            .dark {
                --primary: #6366f1;
                --primary-dark: #4f46e5;
                --secondary: #a78bfa;
                --accent: #f472b6;
                --success: #34d399;
                --info: #22d3ee;
                --warning: #fbbf24;
                --background-light: #0f172a;
                --background-card: #1e293b;
                --text-primary: #f1f5f9;
                --text-secondary: #cbd5e1;
                --border-light: #334155;
                --shadow-light: 0 1px 3px 0 rgb(0 0 0 / 0.3);
                --shadow-medium: 0 4px 6px -1px rgb(0 0 0 / 0.3);
                --shadow-large: 0 10px 15px -3px rgb(0 0 0 / 0.3);
            }

            body {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f8fafc 100%);
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                color: var(--text-primary);
                min-height: 100vh;
                margin: 0;
            }

            .dark body {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            }

            /* Modern Container */
            .dashboard-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }

            /* Header Styles */
            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.5rem 2rem;
                background: var(--background-card);
                border-radius: 1rem;
                box-shadow: var(--shadow-medium);
                margin-bottom: 2rem;
                border: 1px solid var(--border-light);
            }

            .brand {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .brand-icon {
                width: 2.5rem;
                height: 2.5rem;
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: 600;
                font-size: 1.25rem;
            }

            .brand-text h1 {
                font-size: 1.5rem;
                font-weight: 600;
                margin: 0;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .brand-text p {
                font-size: 0.875rem;
                color: var(--text-secondary);
                margin: 0.25rem 0 0;
            }

            /* Navigation */
            .nav-links {
                display: flex;
                gap: 1rem;
                align-items: center;
            }

            .nav-link {
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                text-decoration: none;
                font-weight: 500;
                font-size: 0.875rem;
                transition: all 0.2s ease;
                border: 1px solid var(--border-light);
                color: var(--text-primary);
                background: var(--background-card);
            }

            .nav-link:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-medium);
                border-color: var(--primary);
            }

            .nav-link-primary {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                color: white;
                border: none;
            }

            .nav-link-primary:hover {
                background: linear-gradient(135deg, var(--primary-dark), var(--secondary));
            }

            /* Main Content */
            .main-content {
                display: grid;
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            @media (min-width: 1024px) {
                .main-content {
                    grid-template-columns: 1fr 1fr;
                }
            }

            /* Welcome Card */
            .welcome-card {
                background: var(--background-card);
                border-radius: 1.5rem;
                padding: 2.5rem;
                box-shadow: var(--shadow-large);
                border: 1px solid var(--border-light);
                position: relative;
                overflow: hidden;
            }

            .welcome-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--primary), var(--accent), var(--success));
            }

            .welcome-title {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 1rem;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .welcome-subtitle {
                font-size: 1rem;
                color: var(--text-secondary);
                margin-bottom: 2rem;
                line-height: 1.6;
            }

            /* Features Grid */
            .features-grid {
                display: grid;
                gap: 1.5rem;
                margin-top: 2rem;
            }

            .feature-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                padding: 1.5rem;
                background: rgba(99, 102, 241, 0.05);
                border-radius: 1rem;
                border: 1px solid var(--border-light);
                transition: all 0.3s ease;
            }

            .feature-item:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-medium);
                border-color: var(--primary);
            }

            .feature-icon {
                width: 3rem;
                height: 3rem;
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                color: white;
            }

            .feature-content h3 {
                font-size: 1.125rem;
                font-weight: 600;
                margin: 0 0 0.5rem;
                color: var(--text-primary);
            }

            .feature-content p {
                font-size: 0.875rem;
                color: var(--text-secondary);
                margin: 0;
                line-height: 1.5;
            }

            /* Quick Stats */
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                margin-top: 2rem;
            }

            .stat-card {
                background: var(--background-card);
                border-radius: 1rem;
                padding: 1.5rem;
                text-align: center;
                border: 1px solid var(--border-light);
                transition: all 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-medium);
            }

            .stat-value {
                font-size: 2rem;
                font-weight: 700;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 0.5rem;
            }

            .stat-label {
                font-size: 0.875rem;
                color: var(--text-secondary);
                font-weight: 500;
            }

            /* Graphic Panel */
            .graphic-panel {
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                border-radius: 1.5rem;
                padding: 2.5rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                position: relative;
                overflow: hidden;
                min-height: 400px;
            }

            .graphic-panel::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                right: -50%;
                bottom: -50%;
                background: radial-gradient(circle at 30% 30%, rgba(236, 72, 153, 0.1), transparent 50%),
                          radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.1), transparent 50%);
                animation: rotate 20s linear infinite;
            }

            @keyframes rotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .graphic-title {
                font-size: 2rem;
                font-weight: 700;
                color: white;
                text-align: center;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1;
            }

            .graphic-subtitle {
                font-size: 1rem;
                color: rgba(255, 255, 255, 0.9);
                text-align: center;
                margin-bottom: 2rem;
                position: relative;
                z-index: 1;
                max-width: 400px;
            }

            /* Action Buttons */
            .action-buttons {
                display: flex;
                gap: 1rem;
                margin-top: 2rem;
                flex-wrap: wrap;
                position: relative;
                z-index: 1;
            }

            .action-btn {
                padding: 0.875rem 1.75rem;
                border-radius: 0.75rem;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.875rem;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .action-btn-primary {
                background: white;
                color: var(--primary);
                border: none;
            }

            .action-btn-primary:hover {
                background: rgba(255, 255, 255, 0.9);
                transform: translateY(-2px);
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
            }

            .action-btn-secondary {
                background: rgba(255, 255, 255, 0.1);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.2);
                backdrop-filter: blur(10px);
            }

            .action-btn-secondary:hover {
                background: rgba(255, 255, 255, 0.2);
                transform: translateY(-2px);
                border-color: white;
            }

            /* Footer */
            .footer {
                margin-top: 3rem;
                padding: 2rem;
                text-align: center;
                color: var(--text-secondary);
                font-size: 0.875rem;
                border-top: 1px solid var(--border-light);
            }

            .footer-links {
                display: flex;
                justify-content: center;
                gap: 2rem;
                margin-top: 1rem;
            }

            .footer-link {
                color: var(--text-secondary);
                text-decoration: none;
                transition: color 0.2s ease;
            }

            .footer-link:hover {
                color: var(--primary);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .dashboard-container {
                    padding: 1rem;
                }
                
                .header {
                    flex-direction: column;
                    gap: 1rem;
                    text-align: center;
                }
                
                .nav-links {
                    width: 100%;
                    justify-content: center;
                }
                
                .stats-grid {
                    grid-template-columns: 1fr;
                }
                
                .action-buttons {
                    flex-direction: column;
                }
                
                .action-btn {
                    width: 100%;
                    justify-content: center;
                }
            }

            /* Animation */
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.6s ease-out forwards;
            }

            .delay-100 { animation-delay: 0.1s; }
            .delay-200 { animation-delay: 0.2s; }
            .delay-300 { animation-delay: 0.3s; }
            .delay-400 { animation-delay: 0.4s; }

            /* Utility Classes */
            .opacity-0 { opacity: 0; }
            .opacity-100 { opacity: 1; }
        </style>
    </head>
    <body class="dark">
        <div class="dashboard-container">
            <!-- Header -->
            <header class="header animate-fade-in-up">
                <div class="brand">
                    <div class="brand-icon">
                        A
                    </div>
                    <div class="brand-text">
                        <h1>{{ config('app.name', 'Laravel') }}</h1>
                        <p>Modern Dashboard Platform</p>
                    </div>
                </div>
                
                @if (Route::has('login'))
                    <div class="nav-links">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="nav-link nav-link-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Log In
                            </a>
                            
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link nav-link-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </header>

            <!-- Main Content -->
            <main class="main-content">
                <!-- Welcome Card -->
                <div class="welcome-card animate-fade-in-up delay-100">
                    <h1 class="welcome-title">Welcome to Your Dashboard</h1>
                    <p class="welcome-subtitle">
                        Streamline your workflow with our powerful dashboard. Manage resources, track analytics, 
                        and collaborate efficiently with your team in one unified platform.
                    </p>
                    
                    <div class="features-grid">
                        <div class="feature-item animate-fade-in-up delay-200">
                            <div class="feature-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3>Secure & Reliable</h3>
                                <p>Enterprise-grade security with 99.9% uptime guarantee and data encryption.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item animate-fade-in-up delay-300">
                            <div class="feature-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3>Lightning Fast</h3>
                                <p>Optimized performance with real-time updates and instant data processing.</p>
                            </div>
                        </div>
                        
                        <div class="feature-item animate-fade-in-up delay-400">
                            <div class="feature-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="feature-content">
                                <h3>Advanced Analytics</h3>
                                <p>Comprehensive insights with customizable reports and data visualization.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-card animate-fade-in-up delay-300">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Support Available</div>
                        </div>
                        <div class="stat-card animate-fade-in-up delay-400">
                            <div class="stat-value">99.9%</div>
                            <div class="stat-label">Uptime</div>
                        </div>
                        <div class="stat-card animate-fade-in-up delay-500">
                            <div class="stat-value">50K+</div>
                            <div class="stat-label">Active Users</div>
                        </div>
                        <div class="stat-card animate-fade-in-up delay-600">
                            <div class="stat-value">100+</div>
                            <div class="stat-label">Integrations</div>
                        </div>
                    </div>
                </div>

                <!-- Graphic Panel -->
                <div class="graphic-panel animate-fade-in-up delay-200">
                    <h2 class="graphic-title">Start Building Today</h2>
                    <p class="graphic-subtitle">
                        Join thousands of teams already using our platform to power their business operations 
                        and drive growth through data-driven decisions.
                    </p>
                    
                    <div class="action-buttons">
                        <a href="{{ route('register') }}" class="action-btn action-btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Free Account
                        </a>
                        
                        <a href="https://laravel.com/docs" target="_blank" class="action-btn action-btn-secondary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            View Documentation
                        </a>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="footer animate-fade-in-up delay-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
                <div class="footer-links">
                    <a href="https://laravel.com/docs" target="_blank" class="footer-link">Documentation</a>
                    <a href="https://laracasts.com" target="_blank" class="footer-link">Tutorials</a>
                    <a href="https://laravel-news.com" target="_blank" class="footer-link">News</a>
                    <a href="https://blog.laravel.com" target="_blank" class="footer-link">Blog</a>
                </div>
            </footer>
        </div>

        <script>
            // Add smooth animations
            document.addEventListener('DOMContentLoaded', function() {
                // Add animation classes
                const elements = document.querySelectorAll('.animate-fade-in-up');
                elements.forEach((el, index) => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';
                    
                    setTimeout(() => {
                        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, index * 100);
                });

                // Theme toggle (optional)
                const toggleTheme = () => {
                    document.body.classList.toggle('dark');
                    localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
                };

                // Check for saved theme preference
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme === 'light') {
                    document.body.classList.remove('dark');
                }
            });
        </script>
    </body>
</html>