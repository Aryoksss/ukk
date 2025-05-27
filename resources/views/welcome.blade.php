<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Praktik Kerja Lapangan</title>

    <!-- Favicon -->
    <link rel="icon" href="https://aryok.tech/assets/img/yktp-logo.png" type="image/png">

        <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css'])
    
    <!-- Alpine.js (already in dependencies) -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Extra small screen */
        @media (max-width: 475px) {
            .xs\:inline {
                display: inline;
            }
            .xs\:hidden {
                display: none;
            }
        }
    </style>
    </head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 h-screen flex flex-col overflow-hidden">
    <div class="flex flex-col flex-grow" x-data="{ 
        mobileMenuOpen: false,
        scrolled: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
            });
            
            // Animate elements on load
            setTimeout(() => {
                const elements = document.querySelectorAll('.animate-on-scroll');
                elements.forEach(el => {
                    el.classList.add('animate-show');
                });
            }, 100);
        }
    }" x-init="init()">
        <!-- Navbar -->
        <nav class="sticky top-0 left-0 w-full z-50 transition-all duration-300" 
             :class="{ 'py-3 bg-white/95 backdrop-blur-md shadow-sm': scrolled, 'py-4 bg-white/90 backdrop-blur-md': !scrolled }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <a href="#" class="flex items-center gap-2">
                    <div class="p-1.5 bg-indigo-600 rounded-lg shadow-md transform transition-transform duration-300 hover:scale-105">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white">
                            <!-- Briefcase shape for PKL/internship -->
                            <rect x="8" y="12" width="32" height="28" rx="3" fill="white"/>
                            <rect x="8" y="18" width="32" height="4" fill="#3730A3"/>
                            <path d="M18 12V8C18 6.34315 19.3431 5 21 5H27C28.6569 5 30 6.34315 30 8V12" stroke="#4338CA" stroke-width="2"/>
                            <!-- Document icons representing internship records -->
                            <rect x="14" y="26" width="8" height="10" rx="1" fill="#4F46E5" opacity="0.9"/>
                            <rect x="26" y="26" width="8" height="10" rx="1" fill="#4F46E5" opacity="0.9"/>
                            <path d="M16 29H20" stroke="white" stroke-width="1" stroke-linecap="round"/>
                            <path d="M16 31H20" stroke="white" stroke-width="1" stroke-linecap="round"/>
                            <path d="M16 33H20" stroke="white" stroke-width="1" stroke-linecap="round"/>
                            <path d="M28 29H32" stroke="white" stroke-width="1" stroke-linecap="round"/>
                            <path d="M28 31H32" stroke="white" stroke-width="1" stroke-linecap="round"/>
                            <path d="M28 33H32" stroke="white" stroke-width="1" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-indigo-600">SI-PKL</span>
                </a>
                
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-3 sm:px-5 py-1.5 sm:py-2 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700 transition transform hover:-translate-y-0.5 hover:shadow-md text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 sm:mr-1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span class="hidden xs:inline">Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="hidden md:inline-flex items-center px-5 py-2 bg-white text-indigo-600 border border-indigo-200 rounded-md font-semibold hover:bg-indigo-50 transition transform hover:-translate-y-0.5 hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1.5">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                            Register
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center px-3 sm:px-5 py-1.5 sm:py-2 bg-indigo-600 text-white rounded-md font-semibold hover:bg-indigo-700 transition transform hover:-translate-y-0.5 hover:shadow-md text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1 sm:mr-1.5">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            <span class="hidden xs:inline">Login</span>
                        </a>
                    @endauth
                    
                    <button class="md:hidden border-none bg-transparent cursor-pointer" @click="mobileMenuOpen = !mobileMenuOpen">
                        <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                        <svg x-show="mobileMenuOpen" style="display: none;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" style="display: none;" class="py-3 bg-white shadow-md" @click.away="mobileMenuOpen = false">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col space-y-2">
                    <hr class="my-1">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-indigo-600 font-semibold py-2 flex items-center text-sm sm:text-base" @click="mobileMenuOpen = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="text-indigo-600 font-semibold py-2 flex items-center text-sm sm:text-base" @click="mobileMenuOpen = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                                Register
                        </a>
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold py-2 flex items-center text-sm sm:text-base" @click="mobileMenuOpen = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow flex items-center">
            <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-8 md:gap-12">
                    <!-- Left Content -->
                    <div class="md:w-1/2 space-y-4 sm:space-y-6 animate-on-scroll animate-from-left">
                        <div class="inline-flex items-center px-3 py-1.5 rounded-full bg-indigo-100 text-indigo-800 text-xs sm:text-sm font-medium mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Platform Manajemen PKL
                        </div>
                        
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight mb-2 bg-gradient-to-r from-indigo-600 to-emerald-500 bg-clip-text text-transparent animate-pulse-slow">
                            Sistem Informasi PKL
                        </h1>
                        <p class="text-base sm:text-lg text-gray-600 mb-2">
                            Platform manajemen Praktik Kerja Lapangan yang modern dan efisien untuk sekolah, siswa, dan industri.
                            Tingkatkan produktivitas dan pengelolaan data PKL dengan solusi digital terpadu.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition transform hover:-translate-y-0.5 hover:shadow-lg text-center text-sm sm:text-base w-full sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="3" y1="9" x2="21" y2="9"></line>
                                        <line x1="9" y1="21" x2="9" y2="9"></line>
                                    </svg>
                                    Buka Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition transform hover:-translate-y-0.5 hover:shadow-lg text-center text-sm sm:text-base w-full sm:w-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Mulai Sekarang
                                </a>
                            @endauth
                        </div>
                        
                        <div class="flex flex-wrap gap-2">
                            <span class="flex items-center gap-1 bg-indigo-100 text-indigo-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium animate-bounce-subtle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Manajemen Siswa
                            </span>
                            <span class="flex items-center gap-1 bg-indigo-100 text-indigo-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium animate-bounce-subtle" style="animation-delay: 0.2s">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                Pemetaan Industri
                            </span>
                            <span class="flex items-center gap-1 bg-indigo-100 text-indigo-600 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs sm:text-sm font-medium animate-bounce-subtle" style="animation-delay: 0.4s">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                Monitoring PKL
                            </span>
                        </div>
                    </div>
                    
                    <!-- Right Content - Dashboard Preview -->
                    <div class="md:w-1/2 animate-on-scroll animate-from-right mt-6 md:mt-0">
                        <div class="relative">
                            <img 
                                src="{{ asset('img/hutao.jpg') }}" 
                                alt="PKL Management Dashboard" 
                                class="relative w-full max-w-md mx-auto h-auto rounded-xl shadow-lg transition-transform duration-500 hover:scale-[1.02] object-cover"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer - Minimalist -->
        <footer class="bg-white py-3 sm:py-4 mt-4 sm:mt-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <p class="text-xs sm:text-sm text-gray-500">
                        &copy; {{ date('Y') }} SI-PKL
                    </p>
                    <div class="flex items-center space-x-3">
                        <a href="https://github.com/aryoksss" target="_blank" rel="noopener noreferrer" class="text-gray-500 hover:text-gray-700 transition-colors">
                            <span class="sr-only">GitHub</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="transform transition-transform duration-300 hover:scale-110">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        </div>

    <style>
        /* Animasi scroll */
        .animate-on-scroll {
            opacity: 0;
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        
        .animate-from-bottom {
            transform: translateY(40px);
        }
        
        .animate-from-left {
            transform: translateX(-40px);
        }
        
        .animate-from-right {
            transform: translateX(40px);
        }
        
        .animate-show {
            opacity: 1;
            transform: translate(0, 0);
        }
        
        /* Ensure the animation shows on page load */
        .animate-on-scroll {
            animation: showContent 1s forwards;
        }
        
        @keyframes showContent {
            to {
                opacity: 1;
                transform: translate(0, 0);
            }
        }
        
        /* Subtle bounce animation for tags */
        .animate-bounce-subtle {
            animation: bounceTiny 3s infinite;
        }
        
        @keyframes bounceTiny {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }
        
        /* Slow pulse animation */
        .animate-pulse-slow {
            animation: pulseSlow 3s infinite;
        }
        
        @keyframes pulseSlow {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.8;
            }
        }
    </style>
    </body>
</html>
