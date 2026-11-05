<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voyago — Travel More, Live Bolder</title>
    
    <!-- Google Fonts: Plus Jakarta Sans & Caveat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-script {
            font-family: 'Caveat', cursive;
        }
        .hero-gradient-overlay {
            background: linear-gradient(90deg, #021226 0%, rgba(2, 18, 38, 0.95) 42%, rgba(2, 18, 38, 0.65) 60%, rgba(2, 18, 38, 0.15) 85%, transparent 100%);
        }
        @media (max-width: 1024px) {
            .hero-gradient-overlay {
                background: linear-gradient(180deg, rgba(2, 18, 38, 0.92) 0%, rgba(2, 18, 38, 0.78) 55%, rgba(2, 18, 38, 0.9) 100%);
            }
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-[#021226] overflow-x-hidden selection:bg-sky-500 selection:text-white">

    <!-- ========================================================================= -->
    <!-- 1. HERO SECTION & NAVBAR                                                  -->
    <!-- ========================================================================= -->
    <section class="relative min-h-[720px] lg:min-h-[820px] flex flex-col justify-between overflow-hidden">
        
        <!-- Background Imagery -->
        <div class="absolute inset-0 z-0">
            <!-- Scenery image positioned on right -->
            <img src="{{ asset('images/hero-view.jpg') }}" 
                 alt="Scenic Mediterranean infinity pool sunset" 
                 class="w-full h-full object-cover object-right md:object-center opacity-90 scale-105 transform origin-top-right transition-transform duration-1000">
            
            <!-- Dark Navy Gradient Overlay on left side -->
            <div class="absolute inset-0 hero-gradient-overlay"></div>
            
            <!-- Bottom edge fade to seamless white for next section -->
            <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
        </div>

        <!-- Handwritten cursive note in sky -->
        <div class="absolute top-24 right-12 lg:right-40 z-10 hidden sm:block pointer-events-none select-none">
            <span class="font-script text-2xl lg:text-3xl text-amber-100/90 font-bold tracking-wide -rotate-6 block drop-shadow-md">
                Good<br>
                Places<br>
                Brighter<br>
                People
            </span>
        </div>

        <!-- Floating Santorini Badge (interactive replica of template's badge) -->
        <div class="absolute bottom-36 lg:bottom-44 right-8 lg:right-28 z-10 hidden md:flex items-center gap-2.5 px-4 py-2 rounded-full glass-dark-pill text-white shadow-xl hover:scale-105 transition-all duration-300 border border-white/25 cursor-pointer group">
            <div class="w-2.5 h-2.5 rounded-full bg-sky-400 animate-pulse"></div>
            <div class="flex flex-col">
                <span class="text-xs font-bold leading-tight group-hover:text-sky-300 transition-colors">Santorini</span>
                <span class="text-[10px] text-slate-300 leading-none">Greece</span>
            </div>
            <svg class="w-3.5 h-3.5 text-white/70 group-hover:text-white group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </div>

        <!-- Navigation Bar -->
        <header class="relative z-20 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="flex items-center justify-between">
                
                <!-- Logo: Stylized Mountain Icon + Voyago -->
                <a href="/" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-gradient-to-tr from-sky-600 via-sky-500 to-cyan-400 shadow-lg shadow-sky-500/25 group-hover:shadow-sky-400/40 transition-all duration-300">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L2 20h20L12 3zm0 4.8l5.8 10.2H6.2L12 7.8z" opacity="0.3"/>
                            <path d="M12 5.5l-6 10.5h12L12 5.5z"/>
                            <path d="M15 11l-3 5h6l-3-5z" fill="#bae6fd"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-white group-hover:text-sky-300 transition-colors">
                        Voyago
                    </span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#destinations" class="text-sm font-medium text-slate-200 hover:text-white transition-colors">Destinations</a>
                    <a href="#packages" class="text-sm font-medium text-slate-200 hover:text-white transition-colors">Packages</a>
                    <a href="#app" class="text-sm font-medium text-slate-200 hover:text-white transition-colors">About</a>
                    <a href="#help" class="text-sm font-medium text-slate-200 hover:text-white transition-colors">Help</a>
                </nav>

                <!-- Right Actions: Search Icon + Sign In -->
                <div class="flex items-center gap-4">
                    <button type="button" aria-label="Search" class="p-2 text-slate-200 hover:text-white hover:bg-white/10 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                    
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-2 text-sm font-medium text-white border border-white/30 rounded-full hover:bg-white/15 hover:border-white/60 backdrop-blur-md transition-all duration-200 shadow-sm">
                        Portal Customer
                    </a>
                </div>
            </div>
        </header>

        <!-- Hero Main Content -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20 flex flex-col justify-center flex-grow">
            <div class="max-w-2xl">
                
                <!-- Eyebrow Tagline -->
                <div class="inline-flex items-center gap-2 mb-4">
                    <span class="text-[11px] sm:text-xs font-bold tracking-[0.2em] text-sky-400 uppercase">
                        Explore A Brighter Tomorrow
                    </span>
                </div>

                <!-- Main Bold Headline -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-[1.08] mb-4">
                    Travel More<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-sky-300 to-cyan-300">Live Bolder</span>
                </h1>

                <!-- Subtitle -->
                <p class="text-slate-300 text-sm sm:text-base lg:text-lg max-w-lg mb-8 leading-relaxed font-normal">
                    Extraordinary places. Meaningful journeys.<br class="hidden sm:inline">
                    All in one seamless experience.
                </p>

                <!-- Floating Frosted Search Bar -->
                <div class="bg-white/95 backdrop-blur-2xl rounded-3xl md:rounded-full p-2.5 md:p-3 shadow-2xl border border-white/60 mb-10 max-w-xl">
                    <form action="#search" method="GET" class="flex flex-col md:flex-row md:items-center gap-2 md:gap-3">
                        
                        <!-- Field 1: Where to? -->
                        <div class="flex-1 flex items-center gap-3 px-3 py-1.5 hover:bg-slate-50/80 rounded-2xl md:rounded-full transition cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-tight">Where to?</span>
                                <input type="text" placeholder="Any destination" class="w-full text-xs sm:text-sm font-semibold text-slate-800 placeholder-slate-700 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none">
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                        <!-- Field 2: Dates -->
                        <div class="flex-1 flex items-center gap-3 px-3 py-1.5 hover:bg-slate-50/80 rounded-2xl md:rounded-full transition cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-tight">Dates</span>
                                <input type="text" placeholder="Add dates" class="w-full text-xs sm:text-sm font-semibold text-slate-800 placeholder-slate-700 bg-transparent border-0 p-0 focus:ring-0 focus:outline-none">
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="hidden md:block w-px h-8 bg-slate-200"></div>

                        <!-- Field 3: Travelers -->
                        <div class="flex-1 flex items-center gap-3 px-3 py-1.5 hover:bg-slate-50/80 rounded-2xl md:rounded-full transition cursor-pointer">
                            <div class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 leading-tight">Travelers</span>
                                <span class="block text-xs sm:text-sm font-semibold text-slate-800">2 travelers</span>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" aria-label="Search flights and packages" class="w-12 h-12 rounded-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-400 hover:to-blue-500 text-white flex items-center justify-center shadow-lg shadow-sky-500/35 hover:shadow-sky-500/50 hover:scale-105 active:scale-95 transition-all duration-200 shrink-0 self-center md:self-auto">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Trust Metrics / Badges -->
                <div class="flex flex-wrap items-center gap-8 text-white">
                    
                    <!-- Metric 1: 500+ Destinations -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold leading-tight">500+</span>
                            <span class="block text-xs text-slate-300">Destinations</span>
                        </div>
                    </div>

                    <!-- Metric 2: Trusted -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold leading-tight">Trusted</span>
                            <span class="block text-xs text-slate-300">by 1M+ travelers</span>
                        </div>
                    </div>

                    <!-- Metric 3: Rating -->
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-sky-500/20 border border-sky-400/30 flex items-center justify-center text-sky-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="block text-sm font-bold leading-tight">4.9/5</span>
                            <span class="block text-xs text-slate-300">Customer rating</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </section>

    <!-- ========================================================================= -->
    <!-- 2. POPULAR DESTINATIONS SECTION (Clean White Background)                  -->
    <!-- ========================================================================= -->
    <section id="destinations" class="relative z-10 bg-white py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header + Controls -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block mb-2">
                        Top Destinations
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight">
                        Popular <span class="text-sky-500">Destinations</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base mt-2">
                        Iconic places. Unforgettable experiences.
                    </p>
                </div>

                <!-- Navigation arrow controls -->
                <div class="flex items-center gap-3">
                    <button type="button" aria-label="Previous destination" class="w-10 h-10 rounded-full border border-slate-200 text-slate-600 hover:bg-slate-900 hover:text-white hover:border-slate-900 transition flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" aria-label="Next destination" class="w-10 h-10 rounded-full bg-slate-900 text-white hover:bg-sky-500 transition flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Destination Cards Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                
                <!-- Destination 1: Bali -->
                <div class="group relative rounded-3xl overflow-hidden aspect-[3/4] bg-slate-100 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ asset('images/dest-bali.jpg') }}" 
                         alt="Bali, Indonesia" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-5 flex items-end justify-between">
                        <div>
                            <h3 class="text-white font-bold text-base sm:text-lg leading-tight group-hover:text-sky-300 transition-colors">Bali</h3>
                            <span class="text-slate-300 text-xs sm:text-sm font-medium">Indonesia</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/90 group-hover:bg-sky-400 group-hover:text-white text-slate-900 flex items-center justify-center transition-all duration-300 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Destination 2: Kyoto -->
                <div class="group relative rounded-3xl overflow-hidden aspect-[3/4] bg-slate-100 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ asset('images/dest-kyoto.jpg') }}" 
                         alt="Kyoto, Japan" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-5 flex items-end justify-between">
                        <div>
                            <h3 class="text-white font-bold text-base sm:text-lg leading-tight group-hover:text-sky-300 transition-colors">Kyoto</h3>
                            <span class="text-slate-300 text-xs sm:text-sm font-medium">Japan</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/90 group-hover:bg-sky-400 group-hover:text-white text-slate-900 flex items-center justify-center transition-all duration-300 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Destination 3: Swiss Alps -->
                <div class="group relative rounded-3xl overflow-hidden aspect-[3/4] bg-slate-100 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ asset('images/dest-swiss.jpg') }}" 
                         alt="Swiss Alps, Switzerland" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-5 flex items-end justify-between">
                        <div>
                            <h3 class="text-white font-bold text-base sm:text-lg leading-tight group-hover:text-sky-300 transition-colors">Swiss Alps</h3>
                            <span class="text-slate-300 text-xs sm:text-sm font-medium">Switzerland</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/90 group-hover:bg-sky-400 group-hover:text-white text-slate-900 flex items-center justify-center transition-all duration-300 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Destination 4: Santorini -->
                <div class="group relative rounded-3xl overflow-hidden aspect-[3/4] bg-slate-100 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <img src="{{ asset('images/dest-santorini.jpg') }}" 
                         alt="Santorini, Greece" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-transparent"></div>
                    
                    <div class="absolute bottom-0 left-0 right-0 p-4 sm:p-5 flex items-end justify-between">
                        <div>
                            <h3 class="text-white font-bold text-base sm:text-lg leading-tight group-hover:text-sky-300 transition-colors">Santorini</h3>
                            <span class="text-slate-300 text-xs sm:text-sm font-medium">Greece</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/90 group-hover:bg-sky-400 group-hover:text-white text-slate-900 flex items-center justify-center transition-all duration-300 shadow-sm shrink-0">
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 3. CURATED TRIPS FOR EVERY EXPLORER (Deep Navy Background)                -->
    <!-- ========================================================================= -->
    <section id="packages" class="relative z-10 bg-[#040e1b] py-16 lg:py-24 border-t border-sky-950/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Column: Title & CTA -->
                <div class="lg:col-span-4">
                    <span class="text-xs font-bold uppercase tracking-widest text-sky-400 block mb-3">
                        Smart Packages
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                        Curated Trips<br>
                        for <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-cyan-300">Every Explorer</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed mb-8 max-w-md">
                        Premium experiences. Transparent pricing.<br class="hidden sm:inline">
                        No hidden fees.
                    </p>
                    <a href="#all-packages" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-sky-500/40 bg-sky-500/10 text-white text-sm font-semibold hover:bg-sky-500/25 hover:border-sky-400 transition-all duration-300 group shadow-lg shadow-sky-950/50">
                        <span>View All Packages</span>
                        <svg class="w-4 h-4 text-sky-400 group-hover:text-white transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Right Column: 3 Packages Grid -->
                <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-3 gap-5">
                    
                    <!-- Package 1: Island Escape -->
                    <div class="group relative rounded-2xl bg-[#091b30]/80 backdrop-blur-md p-3 border border-sky-900/40 hover:border-sky-400/60 shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Image Container with Badge -->
                        <div class="relative rounded-xl overflow-hidden aspect-[16/10] mb-3.5 bg-slate-800">
                            <img src="{{ asset('images/pkg-island.jpg') }}" alt="Island Escape" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-2.5 left-2.5 text-[10px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full bg-sky-400 text-white shadow-md">
                                Most Popular
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <div class="px-1 pb-1">
                            <h3 class="text-white font-bold text-base leading-snug mb-1 group-hover:text-sky-300 transition-colors">Island Escape</h3>
                            <div class="flex items-center gap-2 text-slate-400 text-xs mb-4">
                                <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>5 Days</span>
                                <span>•</span>
                                <span>4 Nights</span>
                            </div>

                            <div class="flex items-center justify-between pt-2 border-t border-sky-950/80">
                                <div>
                                    <span class="text-white font-extrabold text-lg">$799</span>
                                    <span class="text-slate-400 text-[11px] font-normal"> / person</span>
                                </div>
                                <button type="button" aria-label="Book Island Escape" class="w-8 h-8 rounded-full bg-white text-slate-900 group-hover:bg-sky-400 group-hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Package 2: Japan Discovery -->
                    <div class="group relative rounded-2xl bg-[#091b30]/80 backdrop-blur-md p-3 border border-sky-900/40 hover:border-sky-400/60 shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Image Container with Badge -->
                        <div class="relative rounded-xl overflow-hidden aspect-[16/10] mb-3.5 bg-slate-800">
                            <img src="{{ asset('images/pkg-japan.jpg') }}" alt="Japan Discovery" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-2.5 left-2.5 text-[10px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full bg-blue-600 text-white shadow-md">
                                Culture
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <div class="px-1 pb-1">
                            <h3 class="text-white font-bold text-base leading-snug mb-1 group-hover:text-sky-300 transition-colors">Japan Discovery</h3>
                            <div class="flex items-center gap-2 text-slate-400 text-xs mb-4">
                                <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>7 Days</span>
                                <span>•</span>
                                <span>6 Nights</span>
                            </div>

                            <div class="flex items-center justify-between pt-2 border-t border-sky-950/80">
                                <div>
                                    <span class="text-white font-extrabold text-lg">$1,299</span>
                                    <span class="text-slate-400 text-[11px] font-normal"> / person</span>
                                </div>
                                <button type="button" aria-label="Book Japan Discovery" class="w-8 h-8 rounded-full bg-white text-slate-900 group-hover:bg-sky-400 group-hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Package 3: Alpine Explorer -->
                    <div class="group relative rounded-2xl bg-[#091b30]/80 backdrop-blur-md p-3 border border-sky-900/40 hover:border-sky-400/60 shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Image Container with Badge -->
                        <div class="relative rounded-xl overflow-hidden aspect-[16/10] mb-3.5 bg-slate-800">
                            <img src="{{ asset('images/pkg-alpine.jpg') }}" alt="Alpine Explorer" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-2.5 left-2.5 text-[10px] font-bold tracking-wider uppercase px-2.5 py-0.5 rounded-full bg-sky-500 text-white shadow-md">
                                Adventure
                            </span>
                        </div>
                        
                        <!-- Content -->
                        <div class="px-1 pb-1">
                            <h3 class="text-white font-bold text-base leading-snug mb-1 group-hover:text-sky-300 transition-colors">Alpine Explorer</h3>
                            <div class="flex items-center gap-2 text-slate-400 text-xs mb-4">
                                <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>6 Days</span>
                                <span>•</span>
                                <span>5 Nights</span>
                            </div>

                            <div class="flex items-center justify-between pt-2 border-t border-sky-950/80">
                                <div>
                                    <span class="text-white font-extrabold text-lg">$1,099</span>
                                    <span class="text-slate-400 text-[11px] font-normal"> / person</span>
                                </div>
                                <button type="button" aria-label="Book Alpine Explorer" class="w-8 h-8 rounded-full bg-white text-slate-900 group-hover:bg-sky-400 group-hover:text-white flex items-center justify-center transition-all duration-200 shadow-sm">
                                    <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 4. EVERYTHING YOU NEED IN ONE APP (Light Ice Blue Background)             -->
    <!-- ========================================================================= -->
    <section id="app" class="relative z-10 bg-gradient-to-b from-[#f3f8fd] via-[#eaf2f8] to-[#f4f9fd] py-16 lg:py-24 overflow-hidden border-t border-slate-200">
        
        <!-- Faint dotted flight route SVG background overlay -->
        <div class="absolute inset-0 pointer-events-none opacity-40">
            <svg class="w-full h-full" viewBox="0 0 1200 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 350 C 350 200, 600 400, 850 150 C 950 50, 1100 80, 1150 120" stroke="#38bdf8" stroke-width="2" stroke-dasharray="6 6"/>
                <circle cx="850" cy="150" r="4" fill="#0284c7" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left Column: Copy & Action -->
                <div class="lg:col-span-4 text-center lg:text-left">
                    <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block mb-3">
                        Travel Smarter
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                        Everything You<br>
                        Need in <span class="text-sky-500">One App</span>
                    </h2>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed mb-8 max-w-sm mx-auto lg:mx-0">
                        Plan. Book. Explore. All in one place.
                    </p>
                    <a href="#download-app" class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-slate-300 bg-white text-slate-800 text-sm font-semibold hover:border-sky-500 hover:text-sky-600 shadow-sm hover:shadow-md transition-all duration-300 group">
                        <span>Learn More</span>
                        <svg class="w-4 h-4 text-slate-500 group-hover:text-sky-500 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                <!-- Center Column: Smartphone Mockup -->
                <div class="lg:col-span-4 flex justify-center relative">
                    <!-- Subtle ambient glow behind phone -->
                    <div class="absolute -inset-4 bg-sky-400/20 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 max-w-[280px] sm:max-w-[320px] transform hover:scale-[1.02] transition-transform duration-500">
                        <img src="{{ asset('images/app-phone.png') }}" 
                             alt="Voyago Mobile App" 
                             class="w-full h-auto drop-shadow-[0_25px_35px_rgba(2,132,199,0.25)] rounded-[40px]">
                        
                        <!-- Floating Airplane Graphic over phone route -->
                        <div class="absolute -top-3 -right-3 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center text-sky-600 border border-sky-100 animate-bounce duration-1000">
                            <svg class="w-5 h-5 -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Right Column: 4 Key Features -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Feature 1: Easy Booking -->
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/70 transition-colors">
                        <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight mb-1">Easy Booking</h3>
                            <p class="text-slate-500 text-xs sm:text-sm">Flights, hotels & tours</p>
                        </div>
                    </div>

                    <!-- Feature 2: Flexible Plans -->
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/70 transition-colors">
                        <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight mb-1">Flexible Plans</h3>
                            <p class="text-slate-500 text-xs sm:text-sm">Free changes, less stress</p>
                        </div>
                    </div>

                    <!-- Feature 3: Safe & Secure -->
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/70 transition-colors">
                        <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight mb-1">Safe & Secure</h3>
                            <p class="text-slate-500 text-xs sm:text-sm">Your journey, our priority</p>
                        </div>
                    </div>

                    <!-- Feature 4: Exclusive Deals -->
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/70 transition-colors">
                        <div class="w-11 h-11 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l4-2 4 2 4-2 4 2V4a2 2 0 00-2-2H5zm2 5a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm0 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-base leading-tight mb-1">Exclusive Deals</h3>
                            <p class="text-slate-500 text-xs sm:text-sm">Members get more</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 5. REAL PEOPLE BRIGHTER STORIES (Dark Navy Background)                    -->
    <!-- ========================================================================= -->
    <section class="relative z-10 bg-[#040e1b] py-16 lg:py-24 border-t border-sky-950/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-sky-400 block mb-2">
                        Travelers Love Us
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                        Real People <span class="text-sky-400">Brighter Stories</span>
                    </h2>
                    <p class="text-slate-400 text-sm sm:text-base mt-2">
                        Millions of happy travelers around the world.
                    </p>
                </div>

                <!-- Testimonial Slider Controls -->
                <div class="flex items-center gap-3">
                    <button type="button" aria-label="Previous testimonial" class="w-10 h-10 rounded-full border border-slate-700 text-slate-400 hover:text-white hover:border-slate-500 transition flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" aria-label="Next testimonial" class="w-10 h-10 rounded-full border border-slate-700 text-slate-400 hover:text-white hover:border-slate-500 transition flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- 3 Testimonial Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Review 1: Emily Carter -->
                <div class="rounded-2xl bg-[#091b30]/60 backdrop-blur-md border border-sky-900/30 p-6 flex flex-col justify-between hover:border-sky-500/40 transition-all duration-300">
                    <div>
                        <!-- User Header -->
                        <div class="flex items-center gap-3.5 mb-4">
                            <img src="{{ asset('images/avatar-emily.jpg') }}" alt="Emily Carter" class="w-11 h-11 rounded-full object-cover border-2 border-sky-400/40">
                            <div>
                                <h3 class="text-white font-bold text-sm">Emily Carter</h3>
                                <span class="text-slate-400 text-xs">New York, USA</span>
                            </div>
                        </div>

                        <!-- Quote -->
                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed italic mb-6">
                            &ldquo;Seamless booking and an unforgettable trip! Voyago made everything easy.&rdquo;
                        </p>
                    </div>

                    <!-- 5 Stars -->
                    <div class="flex items-center gap-1 text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>

                <!-- Review 2: Daniel Kim -->
                <div class="rounded-2xl bg-[#091b30]/60 backdrop-blur-md border border-sky-900/30 p-6 flex flex-col justify-between hover:border-sky-500/40 transition-all duration-300">
                    <div>
                        <!-- User Header -->
                        <div class="flex items-center gap-3.5 mb-4">
                            <img src="{{ asset('images/avatar-daniel.jpg') }}" alt="Daniel Kim" class="w-11 h-11 rounded-full object-cover border-2 border-sky-400/40">
                            <div>
                                <h3 class="text-white font-bold text-sm">Daniel Kim</h3>
                                <span class="text-slate-400 text-xs">Seoul, South Korea</span>
                            </div>
                        </div>

                        <!-- Quote -->
                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed italic mb-6">
                            &ldquo;Amazing destinations and top-notch support. Highly recommended!&rdquo;
                        </p>
                    </div>

                    <!-- 5 Stars -->
                    <div class="flex items-center gap-1 text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>

                <!-- Review 3: Sophia Martinez -->
                <div class="rounded-2xl bg-[#091b30]/60 backdrop-blur-md border border-sky-900/30 p-6 flex flex-col justify-between hover:border-sky-500/40 transition-all duration-300">
                    <div>
                        <!-- User Header -->
                        <div class="flex items-center gap-3.5 mb-4">
                            <img src="{{ asset('images/avatar-sophia.jpg') }}" alt="Sophia Martinez" class="w-11 h-11 rounded-full object-cover border-2 border-sky-400/40">
                            <div>
                                <h3 class="text-white font-bold text-sm">Sophia Martinez</h3>
                                <span class="text-slate-400 text-xs">Barcelona, Spain</span>
                            </div>
                        </div>

                        <!-- Quote -->
                        <p class="text-slate-300 text-xs sm:text-sm leading-relaxed italic mb-6">
                            &ldquo;The best travel app I've ever used. Beautiful experiences, great value!&rdquo;
                        </p>
                    </div>

                    <!-- 5 Stars -->
                    <div class="flex items-center gap-1 text-amber-400">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- 6. LET'S PLAN YOUR NEXT ADVENTURE (CTA Panoramic Banner)                  -->
    <!-- ========================================================================= -->
    <section class="relative bg-white overflow-hidden py-16 lg:py-20">
        
        <!-- Panoramic Background Image with Woman Opening Arms -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/cta-banner.jpg') }}" 
                 alt="Scenic traveler looking at ocean" 
                 class="w-full h-full object-cover object-right md:object-center opacity-95">
            <!-- Smooth gradient fade from left to ensure text legibility -->
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/85 to-transparent"></div>
        </div>

        <!-- Handwritten cursive note in sky -->
        <div class="absolute top-10 right-28 lg:right-72 z-10 hidden sm:block pointer-events-none select-none">
            <span class="font-script text-2xl lg:text-3xl text-slate-700/80 font-bold tracking-wide -rotate-6 block">
                Same<br>
                World<br>
                Brighter<br>
                You
            </span>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-xl">
                
                <span class="text-xs font-bold uppercase tracking-widest text-sky-600 block mb-3">
                    Ready For Your Next Story?
                </span>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                    Let's Plan<br>
                    Your <span class="text-sky-500">Next Adventure</span>
                </h2>

                <p class="text-slate-600 text-sm sm:text-base leading-relaxed mb-8 max-w-md">
                    Extraordinary places are closer than you think.
                </p>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-4">
                    <a href="#get-started" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-gradient-to-r from-sky-500 to-blue-600 text-white font-semibold text-sm shadow-xl shadow-sky-500/25 hover:shadow-sky-500/40 hover:scale-105 active:scale-95 transition-all duration-200">
                        <span>Get Started</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>

                    <a href="#contact" class="inline-flex items-center px-7 py-3.5 rounded-full bg-white/80 hover:bg-white text-slate-700 font-semibold text-sm border border-slate-300 hover:border-slate-400 shadow-sm transition-all duration-200">
                        Contact Us
                    </a>
                </div>

            </div>
        </div>

    </section>

    <!-- ========================================================================= -->
    <!-- 7. FOOTER                                                                 -->
    <!-- ========================================================================= -->
    <footer class="bg-[#020b15] text-slate-400 py-12 border-t border-sky-950/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 pb-8 border-b border-slate-800">
                
                <!-- Logo -->
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-gradient-to-tr from-sky-600 to-cyan-400">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 3L2 20h20L12 3zm0 4.8l5.8 10.2H6.2L12 7.8z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">Voyago</span>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-wrap items-center justify-center gap-8 text-sm">
                    <a href="#destinations" class="hover:text-white transition-colors">Destinations</a>
                    <a href="#packages" class="hover:text-white transition-colors">Packages</a>
                    <a href="#app" class="hover:text-white transition-colors">Mobile App</a>
                    <a href="#about" class="hover:text-white transition-colors">About Us</a>
                    <a href="#help" class="hover:text-white transition-colors">Help & FAQ</a>
                </div>

                <!-- Social Links -->
                <div class="flex items-center gap-4 text-slate-400">
                    <a href="#" aria-label="Twitter" class="hover:text-sky-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" aria-label="Instagram" class="hover:text-sky-400 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>

            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; 2026 Voyago. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-slate-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">Terms of Service</a>
                    <a href="#" class="hover:text-slate-400 transition-colors">Cookie Preferences</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
