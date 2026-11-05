<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SoraCargo — Portal Customer Dashboard</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet CSS for Interactive Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Leaflet custom styling for modern UI */
        .leaflet-container {
            background-color: #070f1e !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1rem !important;
        }
        html:not(.dark) .leaflet-container {
            background-color: #f1f5f9 !important;
        }
        .leaflet-popup-content-wrapper {
            background: rgba(11, 25, 44, 0.95) !important;
            backdrop-filter: blur(12px) !important;
            color: #f8fafc !important;
            border-radius: 1rem !important;
            border: 1px solid rgba(56, 189, 248, 0.25) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
            padding: 4px !important;
        }
        html:not(.dark) .leaflet-popup-content-wrapper {
            background: rgba(255, 255, 255, 0.98) !important;
            color: #0f172a !important;
            border: 1px solid rgba(226, 232, 240, 1) !important;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.15) !important;
        }
        .leaflet-popup-tip {
            background: rgba(11, 25, 44, 0.95) !important;
        }
        html:not(.dark) .leaflet-popup-tip {
            background: rgba(255, 255, 255, 0.98) !important;
        }
        .custom-marker-pulse {
            position: relative;
        }
        .pulse-ring {
            position: absolute;
            top: -6px;
            left: -6px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            animation: pulse-ring 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        }
        @keyframes pulse-ring {
            0% { transform: scale(0.6); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 0.2; }
            100% { transform: scale(1.6); opacity: 0; }
        }
        /* Custom scrollbar */
        .dashboard-scroll::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .dashboard-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .dashboard-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.25);
            border-radius: 9999px;
        }
        .dashboard-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.45);
        }

        /* Bento Card entrance animation & hover glow */
        @keyframes bentoEntrance {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .bento-card {
            animation: bentoEntrance 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
            will-change: transform, box-shadow;
        }
        .bento-card:hover {
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.6), 0 0 20px 1px rgba(56, 189, 248, 0.15) !important;
            transform: translateY(-2px);
        }
        html:not(.dark) .bento-card:hover {
            box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.12), 0 0 20px 1px rgba(14, 165, 233, 0.12) !important;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-[#070f1e] text-slate-100 dark:bg-[#070f1e] dark:text-slate-100 font-sans antialiased h-screen overflow-hidden flex flex-col transition-colors duration-300">

    <!-- ========================================================================= -->
    <!-- TOPBAR: LOGO | {nama user} | (theme mode) | (keluar)                     -->
    <!-- ========================================================================= -->
    <header class="h-13 bg-[#0b192c]/95 dark:bg-[#0b192c]/95 light:bg-white/95 border-b border-sky-950/60 dark:border-sky-950/60 light:border-slate-200 sticky top-0 z-50 backdrop-blur-md px-4 sm:px-6 flex items-center justify-between shrink-0 transition-colors">
        
        <!-- Left: Logo & Portal Tag -->
        <div class="flex items-center gap-6">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-sky-600 via-sky-500 to-cyan-400 flex items-center justify-center shadow-lg shadow-sky-500/20 group-hover:shadow-sky-500/40 transition-all">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-base font-extrabold tracking-tight text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">
                        Sora<span class="text-sky-400">Cargo</span>
                    </span>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-sky-500/20 text-sky-300 border border-sky-400/30">
                        Portal Customer
                    </span>
                </div>
            </a>
        </div>

        <!-- Center: {nama user} -->
        <div class="hidden md:flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/60 dark:bg-slate-900/60 light:bg-slate-100 border border-slate-800 dark:border-slate-800 light:border-slate-300">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="text-xs font-semibold text-slate-200 dark:text-slate-200 light:text-slate-800">Budi Pratama</span>
            <span class="text-[10px] text-slate-400">PT Nusantara Logistik</span>
        </div>

        <!-- Right: (theme mode) + (keluar) -->
        <div class="flex items-center gap-2.5">
            
            <!-- Theme Mode Toggle Button -->
            <button id="themeToggleBtn" 
                    type="button" 
                    onclick="toggleThemeMode()" 
                    title="Ubah Mode Tampilan" 
                    class="p-1.5 px-2.5 rounded-xl bg-slate-800/80 dark:bg-slate-800/80 light:bg-slate-100 text-slate-300 dark:text-slate-300 light:text-slate-700 hover:text-sky-400 hover:bg-slate-800 border border-slate-700/60 dark:border-slate-700/60 light:border-slate-300 transition-all flex items-center gap-1.5">
                <svg id="sunIcon" class="w-3.5 h-3.5 text-amber-400 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg id="moonIcon" class="w-3.5 h-3.5 text-sky-400 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <span class="text-[11px] font-medium hidden sm:inline" id="themeLabelText">Dark Mode</span>
            </button>

            <!-- Keluar (Logout Button) -->
            <a href="{{ url('/') }}" 
               title="Keluar dari Portal" 
               class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 text-xs font-semibold transition-all">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </a>

        </div>
    </header>

    <!-- ========================================================================= -->
    <!-- MAIN WORKSPACE: SIDEBAR + 4 MODEL KONTAINER (FITS 1 SCREEN)              -->
    <!-- ========================================================================= -->
    <div class="flex-1 min-h-0 flex overflow-hidden">
        
        <!-- ===================================================================== -->
        <!-- SIDEBAR (KIRI)                                                        -->
        <!-- ===================================================================== -->
        <aside class="w-60 bg-[#0a182a]/95 dark:bg-[#0a182a]/95 light:bg-slate-50/95 border-r border-sky-950/60 dark:border-sky-950/60 light:border-slate-200 flex flex-col justify-start shrink-0 overflow-y-auto dashboard-scroll transition-colors">
            
            <div class="p-3.5 space-y-4">
                
                <!-- Quick Cargo Search -->
                <div class="relative">
                    <input type="text" 
                           id="quickSearchInput" 
                           onkeyup="filterCargoBySearch(this.value)"
                           placeholder="Cari ID Cargo / Kota..." 
                           class="w-full bg-slate-900/80 dark:bg-slate-900/80 light:bg-white text-xs text-white placeholder-slate-500 border border-slate-800 dark:border-slate-800 light:border-slate-300 rounded-xl px-2.5 py-2 pl-7.5 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition">
                    <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Navigation Menu -->
                <nav class="space-y-1">
                    
                    <!-- 1. Dashboard (Active) -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-xl bg-gradient-to-r from-sky-500/20 to-blue-600/10 text-sky-400 border border-sky-400/30 font-semibold text-xs transition-all shadow-sm">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400 shadow-sm shadow-sky-400"></span>
                    </a>

                    <!-- 2. Cargo (Dropdown) -->
                    <div class="space-y-0.5 pt-0.5">
                        <button type="button" 
                                onclick="toggleCargoSubmenu()" 
                                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                                <span>Cargo</span>
                            </div>
                            <svg id="cargoChevron" class="w-3 h-3 text-slate-400 transform transition-transform duration-200 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Sub-items: Kapal, Pesawat, Truck -->
                        <div id="cargoSubmenu" class="pl-3.5 pr-1 space-y-0.5 block">
                            <button type="button" 
                                    onclick="filterByMode('sea')" 
                                    class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-sky-300 hover:bg-sky-500/10 text-xs transition-colors group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l3 3h10l3-3z"/>
                                    </svg>
                                    <span>Kapal (Sea)</span>
                                </div>
                                <span class="text-[10px] bg-slate-800 px-1.5 py-0.5 rounded text-sky-400 font-bold">7</span>
                            </button>

                            <button type="button" 
                                    onclick="filterByMode('air')" 
                                    class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-sky-300 hover:bg-sky-500/10 text-xs transition-colors group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    <span>Pesawat (Air)</span>
                                </div>
                                <span class="text-[10px] bg-slate-800 px-1.5 py-0.5 rounded text-sky-400 font-bold">4</span>
                            </button>

                            <button type="button" 
                                    onclick="filterByMode('land')" 
                                    class="w-full flex items-center justify-between px-2.5 py-1.5 rounded-lg text-slate-400 hover:text-sky-300 hover:bg-sky-500/10 text-xs transition-colors group">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10h10zm0 0h4l3 3v-3h-7z"/>
                                    </svg>
                                    <span>Truk (Land)</span>
                                </div>
                                <span class="text-[10px] bg-slate-800 px-1.5 py-0.5 rounded text-sky-400 font-bold">7</span>
                            </button>
                        </div>
                    </div>

                    <!-- 3. History -->
                    <button type="button" 
                            onclick="showHistoryNotification()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>History</span>
                        </div>
                        <span class="text-[10px] text-slate-500">142 B/L</span>
                    </button>

                    <!-- 4. Account -->
                    <button type="button" 
                            onclick="showAccountModal()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Account</span>
                        </div>
                        <span class="text-[10px] text-emerald-400">Aktif</span>
                    </button>

                    <!-- 5. CS (Customer Support) -->
                    <button type="button" 
                            onclick="openSupportChat()" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 font-medium text-xs transition-colors">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>CS (Support)</span>
                        </div>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    </button>

                </nav>

            </div>

        </aside>

        <!-- ===================================================================== -->
        <!-- MAIN DASHBOARD CONTENT: BENTO GRID FLOATING CARDS (PAS 1 LAYAR MONITOR)-->
        <!-- ===================================================================== -->
        <main class="flex-1 min-h-0 p-3 sm:p-3.5 flex flex-col gap-3 sm:gap-3.5 overflow-hidden bg-[#070f1e] dark:bg-[#070f1e] light:bg-slate-100">
            
            <!-- ----------------------------------------------------------------- -->
            <!-- BARIS ATAS: KARTU 1 (MAPS) & KOLOM KANAN (KARTU 2A + KARTU 2B)     -->
            <!-- (Tinggi sama persis antara Maps dan Gabungan Trafik + Riwayat)     -->
            <!-- ----------------------------------------------------------------- -->
            <div class="h-[52%] min-h-[300px] flex flex-col lg:flex-row gap-3 sm:gap-3.5 overflow-hidden shrink-0">
                
                <!-- ============================================================= -->
                <!-- KARTU 1: MAPS INTERAKTIF DENGAN FLOATING OVERLAY FILTER       -->
                <!-- ============================================================= -->
                <div class="bento-card flex-1 min-w-0 h-full rounded-2xl bg-[#0b192c]/85 dark:bg-[#0b192c]/85 light:bg-white/95 border border-sky-500/20 hover:border-sky-400/40 dark:border-sky-500/20 dark:hover:border-sky-400/40 light:border-slate-200 shadow-xl shadow-black/40 transition-all duration-300 relative overflow-hidden flex flex-col group">
                    
                    <!-- The Interactive Map Container (Clipped cleanly by rounded-2xl) -->
                    <div id="interactiveMap" class="w-full h-full z-10 rounded-2xl"></div>

                    <!-- Floating Overlay: Top Controls (Status badge, Mode Filter Pills, Reset) -->
                    <div class="absolute top-3 left-3 right-3 z-20 flex items-center justify-between gap-2 pointer-events-none">
                        
                        <!-- Left: Status Counter Badge -->
                        <div class="pointer-events-auto px-2.5 py-1.5 rounded-xl bg-slate-900/90 dark:bg-slate-900/90 light:bg-white/95 border border-sky-500/30 backdrop-blur-md shadow-lg flex items-center gap-2 text-[10px] transition-all">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                            <span class="font-bold text-white dark:text-white light:text-slate-900" id="activeFleetCounter">18 Unit Beroperasi</span>
                        </div>

                        <!-- Center: Mode Filter Pills (Floating with backdrop-blur) -->
                        <div class="pointer-events-auto px-1.5 py-1 rounded-xl bg-slate-900/90 dark:bg-slate-900/90 light:bg-white/95 border border-slate-700/60 dark:border-slate-700/60 light:border-slate-300 backdrop-blur-md shadow-lg flex items-center gap-1 transition-all">
                            <button id="filterBtnAll" 
                                    type="button" 
                                    onclick="filterByMode('all')" 
                                    class="mode-filter-btn flex items-center gap-1 px-2.5 py-1 rounded-lg bg-sky-500 text-white font-semibold text-[11px] shadow-sm transition-all">
                                <span>Semua</span>
                                <span class="text-[9px] bg-white/20 px-1 py-0.5 rounded-full font-bold">18</span>
                            </button>

                            <button id="filterBtnSea" 
                                    type="button" 
                                    onclick="filterByMode('sea')" 
                                    class="mode-filter-btn flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 font-medium text-[11px] transition-all">
                                <svg class="w-3 h-3 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l3 3h10l3-3z"/></svg>
                                <span>Kapal</span>
                                <span class="text-[9px] bg-slate-700 px-1 py-0.5 rounded-full text-sky-400 font-bold">7</span>
                            </button>

                            <button id="filterBtnAir" 
                                    type="button" 
                                    onclick="filterByMode('air')" 
                                    class="mode-filter-btn flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 font-medium text-[11px] transition-all">
                                <svg class="w-3 h-3 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span>Pesawat</span>
                                <span class="text-[9px] bg-slate-700 px-1 py-0.5 rounded-full text-sky-400 font-bold">4</span>
                            </button>

                            <button id="filterBtnLand" 
                                    type="button" 
                                    onclick="filterByMode('land')" 
                                    class="mode-filter-btn flex items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 font-medium text-[11px] transition-all">
                                <svg class="w-3 h-3 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10h10zm0 0h4l3 3v-3h-7z"/></svg>
                                <span>Truk</span>
                                <span class="text-[9px] bg-slate-700 px-1 py-0.5 rounded-full text-sky-400 font-bold">7</span>
                            </button>
                        </div>

                        <!-- Right: Reset Posisi Button -->
                        <button type="button" 
                                onclick="resetMapCenter()" 
                                title="Reset Posisi Nusantara" 
                                class="pointer-events-auto px-2.5 py-1.5 rounded-xl bg-slate-900/90 dark:bg-slate-900/90 light:bg-white/95 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 text-[10px] transition-all backdrop-blur-md shadow-lg flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            <span class="hidden sm:inline">Reset</span>
                        </button>
                    </div>

                </div>

                <!-- ============================================================= -->
                <!-- KOLOM KANAN ATAS: 2 KARTU BENTO TERPISAH (TRAFIK & RIWAYAT)   -->
                <!-- ============================================================= -->
                <div class="w-full lg:w-[440px] xl:w-[480px] shrink-0 flex flex-col gap-3 sm:gap-3.5 h-full overflow-hidden">
                    
                    <!-- KARTU 2A: TRAFIK AKTIFITAS 7 HARI (Bento Card Atas) -->
                    <div class="bento-card h-[48%] shrink-0 rounded-2xl bg-[#0b192c]/85 dark:bg-[#0b192c]/85 light:bg-white/95 border border-sky-500/20 hover:border-sky-400/40 dark:border-sky-500/20 dark:hover:border-sky-400/40 light:border-slate-200 shadow-xl shadow-black/40 transition-all duration-300 p-3 sm:p-3.5 flex flex-col justify-between overflow-hidden">
                        
                        <div class="flex items-center justify-between mb-1 shrink-0">
                            <div class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                <h2 class="text-xs font-bold text-white dark:text-white light:text-slate-900 leading-tight">
                                    Trafik Aktifitas 7 Hari
                                </h2>
                            </div>
                            <span id="chartSubBadge" class="text-[9px] text-sky-400 bg-sky-500/10 px-1.5 py-0.5 rounded border border-sky-400/20 font-semibold">
                                Semua Armada
                            </span>
                        </div>

                        <!-- Dynamic SVG Chart (7 Hari) -->
                        <div class="p-2 rounded-xl bg-slate-900/80 dark:bg-slate-900/80 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 flex-1 flex flex-col justify-between">
                            <div class="flex items-center justify-between text-[9px] text-slate-400">
                                <span>Volume Tonase Harian</span>
                                <span class="text-sky-400 font-semibold">Puncak: 340T</span>
                            </div>

                            <div class="relative h-14 w-full pt-1">
                                <svg class="w-full h-full overflow-visible" viewBox="0 0 350 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="0%" stop-color="#38bdf8" stop-opacity="0.45"/>
                                            <stop offset="100%" stop-color="#38bdf8" stop-opacity="0.0"/>
                                        </linearGradient>
                                    </defs>
                                    
                                    <!-- Bars -->
                                    <g id="chartBars" class="transition-all duration-500">
                                        <rect id="bar0" x="20" y="30" width="12" height="35" rx="2" fill="#1e3a8a" opacity="0.45"/>
                                        <rect id="bar1" x="70" y="20" width="12" height="45" rx="2" fill="#1e3a8a" opacity="0.45"/>
                                        <rect id="bar2" x="120" y="12" width="12" height="53" rx="2" fill="#1e3a8a" opacity="0.45"/>
                                        <rect id="bar3" x="170" y="24" width="12" height="41" rx="2" fill="#1e3a8a" opacity="0.45"/>
                                        <rect id="bar4" x="220" y="10" width="12" height="55" rx="2" fill="#1e3a8a" opacity="0.45"/>
                                        <rect id="bar5" x="270" y="18" width="12" height="47" rx="2" fill="#1e3a8a" opacity="0.45"/>
                                        <rect id="bar6" x="315" y="6"  width="12" height="59" rx="2" fill="#0284c7" opacity="0.8"/>
                                    </g>

                                    <!-- Area & Line -->
                                    <path id="chartAreaPath" d="M 26 35 Q 76 22, 126 14 T 226 12 T 321 8 L 321 65 L 26 65 Z" fill="url(#chartGrad)"/>
                                    <path id="chartLinePath" d="M 26 35 Q 76 22, 126 14 T 226 12 T 321 8" fill="none" stroke="#38bdf8" stroke-width="2" stroke-linecap="round"/>

                                    <!-- Dots -->
                                    <g id="chartDots" class="transition-all duration-500">
                                        <circle id="dot0" cx="26" cy="35" r="2.5" fill="#38bdf8"/>
                                        <circle id="dot1" cx="76" cy="22" r="2.5" fill="#38bdf8"/>
                                        <circle id="dot2" cx="126" cy="14" r="2.5" fill="#38bdf8"/>
                                        <circle id="dot3" cx="176" cy="26" r="2.5" fill="#38bdf8"/>
                                        <circle id="dot4" cx="226" cy="12" r="2.5" fill="#38bdf8"/>
                                        <circle id="dot5" cx="276" cy="20" r="2.5" fill="#38bdf8"/>
                                        <circle id="dot6" cx="321" cy="8"  r="3"   fill="#00d4ff" stroke="#fff" stroke-width="1.5"/>
                                    </g>
                                </svg>
                            </div>

                            <div class="flex justify-between text-[8px] text-slate-400 px-1">
                                <span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span><span class="font-bold text-sky-400">Min</span>
                            </div>
                        </div>

                    </div>

                    <!-- KARTU 2B: RIWAYAT PENGIRIMAN 7 HARI (Bento Card Bawah) -->
                    <div class="bento-card flex-1 min-h-0 rounded-2xl bg-[#0b192c]/85 dark:bg-[#0b192c]/85 light:bg-white/95 border border-sky-500/20 hover:border-sky-400/40 dark:border-sky-500/20 dark:hover:border-sky-400/40 light:border-slate-200 shadow-xl shadow-black/40 transition-all duration-300 p-3 sm:p-3.5 flex flex-col overflow-hidden">
                        
                        <div class="flex items-center justify-between mb-2 shrink-0">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="text-xs font-bold text-white dark:text-white light:text-slate-900 leading-tight">
                                    Riwayat Pengiriman 7 Hari
                                </h3>
                            </div>
                            <span class="text-[9px] text-emerald-400 bg-emerald-500/10 px-1.5 py-0.5 rounded font-semibold border border-emerald-500/20">
                                5 Selesai (Delivered)
                            </span>
                        </div>

                        <!-- Scrollable Delivered History Items -->
                        <div class="space-y-1.5 flex-1 min-h-0 overflow-y-auto dashboard-scroll pr-1">
                            
                            <!-- History 1 -->
                            <div class="p-2 rounded-xl bg-slate-900/60 dark:bg-slate-900/60 light:bg-slate-50 border border-slate-800/80 dark:border-slate-800/80 light:border-slate-200 text-xs flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <div>
                                        <span class="font-bold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">SRA-SEA-7102 • MV Meratus</span>
                                        <span class="text-[9px] text-slate-400">Tg. Priok → Belawan Port</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-emerald-400 block leading-tight">Delivered</span>
                                    <span class="text-[8px] text-slate-400">04 Nov 14:20</span>
                                </div>
                            </div>

                            <!-- History 2 -->
                            <div class="p-2 rounded-xl bg-slate-900/60 dark:bg-slate-900/60 light:bg-slate-50 border border-slate-800/80 dark:border-slate-800/80 light:border-slate-200 text-xs flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <div>
                                        <span class="font-bold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">SRA-AIR-3301 • B737-400F</span>
                                        <span class="text-[9px] text-slate-400">CGK (Jakarta) → SUB (Surabaya)</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-emerald-400 block leading-tight">Delivered</span>
                                    <span class="text-[8px] text-slate-400">03 Nov 18:05</span>
                                </div>
                            </div>

                            <!-- History 3 -->
                            <div class="p-2 rounded-xl bg-slate-900/60 dark:bg-slate-900/60 light:bg-slate-50 border border-slate-800/80 dark:border-slate-800/80 light:border-slate-200 text-xs flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <div>
                                        <span class="font-bold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">SRA-TRK-9011 • Wingbox #05</span>
                                        <span class="text-[9px] text-slate-400">Bandung Hub → Cikarang Dryport</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-emerald-400 block leading-tight">Delivered</span>
                                    <span class="text-[8px] text-slate-400">02 Nov 09:40</span>
                                </div>
                            </div>

                            <!-- History 4 -->
                            <div class="p-2 rounded-xl bg-slate-900/60 dark:bg-slate-900/60 light:bg-slate-50 border border-slate-800/80 dark:border-slate-800/80 light:border-slate-200 text-xs flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    <div>
                                        <span class="font-bold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">SRA-SEA-6019 • KM Sinabung</span>
                                        <span class="text-[9px] text-slate-400">Makassar → Tg. Perak Surabaya</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-emerald-400 block leading-tight">Delivered</span>
                                    <span class="text-[8px] text-slate-400">01 Nov 22:15</span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ----------------------------------------------------------------- -->
            <!-- BARIS BAWAH: KARTU 3 (CARGO SEDANG JALAN) & KARTU 4 (AI CHAT)     -->
            <!-- ----------------------------------------------------------------- -->
            <div class="flex-1 min-h-0 flex flex-col lg:flex-row gap-3 sm:gap-3.5 overflow-hidden">
                
                <!-- ============================================================= -->
                <!-- KARTU 3: DAFTAR CARGO SEDANG JALAN (Bento Card Kiri Bawah)    -->
                <!-- ============================================================= -->
                <div class="bento-card flex-1 min-w-0 h-full rounded-2xl bg-[#0b192c]/85 dark:bg-[#0b192c]/85 light:bg-white/95 border border-sky-500/20 hover:border-sky-400/40 dark:border-sky-500/20 dark:hover:border-sky-400/40 light:border-slate-200 shadow-xl shadow-black/40 transition-all duration-300 p-3.5 flex flex-col overflow-hidden">
                    
                    <div class="flex items-center justify-between mb-2.5 shrink-0">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <h2 class="text-sm font-bold text-white dark:text-white light:text-slate-900">
                                Daftar Cargo Sedang Jalan
                            </h2>
                        </div>
                        <span id="activeCargoCountBadge" class="text-[10px] bg-sky-500/20 text-sky-300 font-bold px-2 py-0.5 rounded-full border border-sky-400/30">
                            7 Aktif
                        </span>
                    </div>

                    <!-- Scrollable Grid / List of Active Cargo Cards -->
                    <div id="cargoListContainer" class="flex-1 min-h-0 overflow-y-auto dashboard-scroll pr-1 grid grid-cols-1 md:grid-cols-2 gap-2.5 content-start">
                        
                        <!-- Cargo 1: Kapal -->
                        <div class="cargo-card mode-sea p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-SEA-8821')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-cyan-500/15 text-cyan-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l3 3h10l3-3z"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-SEA-8821</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">MV Meratus Java (40ft)</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-cyan-500/15 text-cyan-300 border border-cyan-400/30">Berlayar</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Tg. Priok</span><span class="text-[9px] text-slate-400">Jakarta</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-sky-400 to-cyan-400 rounded-full" style="width: 74%"></div></div>
                                    <span class="text-[8px] text-sky-400 font-bold mt-0.5">74%</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Tg. Perak</span><span class="text-[9px] text-slate-400">Surabaya</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">Besok 08:30</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                        <!-- Cargo 2: Pesawat -->
                        <div class="cargo-card mode-air p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-AIR-4092')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-sky-500/15 text-sky-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-AIR-4092</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">B737-800F PK-SRA</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-sky-500/15 text-sky-300 border border-sky-400/30">Mengudara</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">CGK</span><span class="text-[9px] text-slate-400">Jakarta</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-sky-400 to-indigo-400 rounded-full" style="width: 58%"></div></div>
                                    <span class="text-[8px] text-sky-400 font-bold mt-0.5">58% FL280</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">DPS</span><span class="text-[9px] text-slate-400">Bali</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">Hari ini 21:15</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                        <!-- Cargo 3: Truk -->
                        <div class="cargo-card mode-land p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-TRK-1044')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-amber-500/15 text-amber-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10h10zm0 0h4l3 3v-3h-7z"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-TRK-1044</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">Hino 500 Wingbox #12</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-amber-500/15 text-amber-300 border border-amber-400/30">Trans-Jawa</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Cikarang</span><span class="text-[9px] text-slate-400">Bekasi</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-amber-400 to-orange-400 rounded-full" style="width: 65%"></div></div>
                                    <span class="text-[8px] text-amber-400 font-bold mt-0.5">65% KM 372</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Rungkut</span><span class="text-[9px] text-slate-400">Surabaya</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">Besok 04:00</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                        <!-- Cargo 4: Kapal Ro-Ro -->
                        <div class="cargo-card mode-sea p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-SEA-3310')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-cyan-500/15 text-cyan-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l3 3h10l3-3z"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-SEA-3310</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">KM Dharma Rucitra VII</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-cyan-500/15 text-cyan-300 border border-cyan-400/30">Laut Jawa</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Tg. Perak</span><span class="text-[9px] text-slate-400">Surabaya</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-sky-400 to-cyan-400 rounded-full" style="width: 42%"></div></div>
                                    <span class="text-[8px] text-sky-400 font-bold mt-0.5">42% Selat Mksr</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Semayang</span><span class="text-[9px] text-slate-400">Balikpapan</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">07 Nov 14:00</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                        <!-- Cargo 5: Pesawat Kargo -->
                        <div class="cargo-card mode-air p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-AIR-9920')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-sky-500/15 text-sky-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-AIR-9920</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">Airbus A330-300F</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-sky-500/15 text-sky-300 border border-sky-400/30">Approach</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">KNO</span><span class="text-[9px] text-slate-400">Medan</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-sky-400 to-indigo-400 rounded-full" style="width: 88%"></div></div>
                                    <span class="text-[8px] text-sky-400 font-bold mt-0.5">88% Descent</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">CGK</span><span class="text-[9px] text-slate-400">Jakarta</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">Hari ini 20:45</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                        <!-- Cargo 6: Truk Flatbed -->
                        <div class="cargo-card mode-land p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-TRK-7712')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-amber-500/15 text-amber-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10h10zm0 0h4l3 3v-3h-7z"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-TRK-7712</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">Volvo FH16 Multi-Axle #08</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-amber-500/15 text-amber-300 border border-amber-400/30">Lintas Sumut</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Belawan Port</span><span class="text-[9px] text-slate-400">Medan</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-amber-400 to-orange-400 rounded-full" style="width: 48%"></div></div>
                                    <span class="text-[8px] text-amber-400 font-bold mt-0.5">48% Jalur Darat</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Siantar Hub</span><span class="text-[9px] text-slate-400">Sumut</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">Malam ini 23:00</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                        <!-- Cargo 7: Kapal Kontainer Feeder -->
                        <div class="cargo-card mode-sea p-3 rounded-xl bg-slate-900/70 dark:bg-slate-900/70 light:bg-slate-50 border border-slate-800 dark:border-slate-800 light:border-slate-200 hover:border-sky-500/60 transition-all cursor-pointer group shadow-sm hover:-translate-y-0.5"
                             onclick="flyToCargo('SRA-SEA-5501')">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-cyan-500/15 text-cyan-400 flex items-center justify-center shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l3 3h10l3-3z"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-white dark:text-white light:text-slate-900 group-hover:text-sky-400 transition-colors">SRA-SEA-5501</span>
                                        <span class="text-[9px] text-slate-400 block leading-none">Samudera Pacific IV</span>
                                    </div>
                                </div>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded-full bg-cyan-500/15 text-cyan-300 border border-cyan-400/30">Selat Bangka</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-1 px-2 rounded-lg bg-slate-950/40 dark:bg-slate-950/40 light:bg-slate-200/50 mb-1.5">
                                <div><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Batam Port</span><span class="text-[9px] text-slate-400">Kep. Riau</span></div>
                                <div class="flex-1 px-2 flex flex-col items-center">
                                    <div class="w-full h-1 bg-slate-800 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-sky-400 to-cyan-400 rounded-full" style="width: 55%"></div></div>
                                    <span class="text-[8px] text-sky-400 font-bold mt-0.5">55% Transit</span>
                                </div>
                                <div class="text-right"><span class="font-extrabold text-white dark:text-white light:text-slate-900 text-[11px] block leading-tight">Tg. Priok</span><span class="text-[9px] text-slate-400">Jakarta</span></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] pt-0.5">
                                <span class="text-slate-400">ETA: <strong class="text-slate-200 dark:text-slate-200 light:text-slate-800">08 Nov 06:00</strong></span>
                                <span class="text-sky-400 text-[11px] font-semibold group-hover:translate-x-1 transition-transform">Lihat di Peta →</span>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ============================================================= -->
                <!-- KARTU 4: CHAT DENGAN AI (Bento Card Kanan Bawah)              -->
                <!-- ============================================================= -->
                <div class="bento-card w-full lg:w-[440px] xl:w-[480px] shrink-0 h-full rounded-2xl bg-[#0b192c]/85 dark:bg-[#0b192c]/85 light:bg-white/95 border border-sky-500/20 hover:border-sky-400/40 dark:border-sky-500/20 dark:hover:border-sky-400/40 light:border-slate-200 shadow-xl shadow-black/40 transition-all duration-300 p-3.5 flex flex-col overflow-hidden">
                    
                    <!-- Chat Header -->
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-sky-950/60 dark:border-sky-950/60 light:border-slate-200 shrink-0">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-gradient-to-tr from-sky-500 via-indigo-500 to-cyan-400 flex items-center justify-center text-white shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-white dark:text-white light:text-slate-900 leading-tight">Chat dengan AI (SoraBot)</h3>
                                <span class="text-[9px] text-emerald-400 block leading-none">● Online • Logistics Copilot</span>
                            </div>
                        </div>
                        <span class="text-[9px] bg-sky-500/10 text-sky-400 px-2 py-0.5 rounded-full border border-sky-400/20 font-semibold">
                            AI Assistant
                        </span>
                    </div>

                    <!-- Chat Message Area (Scrollable) -->
                    <div id="aiChatMessages" class="flex-1 min-h-0 overflow-y-auto dashboard-scroll space-y-2 pr-1 text-xs">
                        
                        <!-- Bot Message -->
                        <div class="flex items-start gap-2">
                            <div class="w-6 h-6 rounded-full bg-sky-500/20 text-sky-400 border border-sky-400/30 flex items-center justify-center shrink-0 text-[10px] font-bold">
                                AI
                            </div>
                            <div class="p-2 rounded-xl rounded-tl-none bg-slate-900/80 dark:bg-slate-900/80 light:bg-slate-100 border border-slate-800 dark:border-slate-800 light:border-slate-200 text-slate-200 dark:text-slate-200 light:text-slate-800 max-w-[85%] leading-relaxed text-[11px]">
                                Halo Capt. Budi! Saya asisten logistik AI SoraCargo. Tanyakan posisi armada, estimasi cuaca rute laut/udara, atau dokumen B/L Anda.
                            </div>
                        </div>

                    </div>

                    <!-- Quick Suggestions -->
                    <div class="flex items-center gap-1.5 py-1.5 overflow-x-auto no-scrollbar shrink-0">
                        <button type="button" onclick="sendQuickPrompt('Cek status MV Meratus')" class="text-[10px] whitespace-nowrap bg-slate-800/80 hover:bg-slate-700 text-sky-300 px-2 py-0.5 rounded-full border border-slate-700 transition">
                            Cek MV Meratus
                        </button>
                        <button type="button" onclick="sendQuickPrompt('Kondisi cuaca rute Bali')" class="text-[10px] whitespace-nowrap bg-slate-800/80 hover:bg-slate-700 text-sky-300 px-2 py-0.5 rounded-full border border-slate-700 transition">
                            Cuaca Rute Bali
                        </button>
                        <button type="button" onclick="sendQuickPrompt('Kargo mana yang paling dekat tiba?')" class="text-[10px] whitespace-nowrap bg-slate-800/80 hover:bg-slate-700 text-sky-300 px-2 py-0.5 rounded-full border border-slate-700 transition">
                            Kargo Terdekat Tiba
                        </button>
                    </div>

                    <!-- Input Box -->
                    <form onsubmit="handleChatSubmit(event)" class="flex items-center gap-1.5 pt-1 border-t border-sky-950/40 shrink-0">
                        <input type="text" 
                               id="aiChatInput" 
                               placeholder="Tanya AI tentang status pengiriman..." 
                               class="flex-1 bg-slate-900/90 dark:bg-slate-900/90 light:bg-slate-50 text-xs text-white placeholder-slate-500 border border-slate-800 dark:border-slate-800 light:border-slate-300 rounded-xl px-3 py-1.5 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 transition">
                        <button type="submit" 
                                class="px-3 py-1.5 rounded-xl bg-sky-500 hover:bg-sky-400 text-white font-semibold text-xs shadow-sm shadow-sky-500/30 transition flex items-center justify-center shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>

                </div>

            </div>

        </main>

    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Interactive Dashboard Script -->
    <script>
        // Cargo Fleet Data Model (Indonesia Logistics Network)
        const FLEET_DATA = [
            {
                id: 'SRA-SEA-8821',
                mode: 'sea',
                name: 'MV Meratus Java',
                category: 'Kapal Kontainer (40ft)',
                origin: 'Tanjung Priok, Jakarta',
                dest: 'Tanjung Perak, Surabaya',
                lat: -6.550,
                lng: 110.200,
                progress: 74,
                speed: '17.4 Knots',
                eta: 'Besok, 08:30 WIB',
                status: 'Berlayar (In Transit)',
                cargoWeight: '180 Ton (12 TEUs)'
            },
            {
                id: 'SRA-AIR-4092',
                mode: 'air',
                name: 'Boeing 737-800F PK-SRA',
                category: 'Pesawat Kargo Khusus',
                origin: 'Soekarno-Hatta (CGK)',
                dest: 'Ngurah Rai, Bali (DPS)',
                lat: -7.500,
                lng: 112.900,
                progress: 58,
                speed: '460 Knots (FL280)',
                eta: 'Hari ini, 21:15 WIB',
                status: 'Cruising En-Route',
                cargoWeight: '18.5 Ton (Palletized)'
            },
            {
                id: 'SRA-TRK-1044',
                mode: 'land',
                name: 'Hino 500 Wingbox #12',
                category: 'Truk Wingbox Heavy Duty',
                origin: 'Kawasan Industri GIIC Cikarang',
                dest: 'Kawasan SIER Rungkut, Surabaya',
                lat: -6.950,
                lng: 109.800,
                progress: 65,
                speed: '78 km/h',
                eta: 'Besok, 04:00 WIB',
                status: 'Tol Trans-Jawa KM 372',
                cargoWeight: '24 Ton (Fast Moving)'
            },
            {
                id: 'SRA-SEA-3310',
                mode: 'sea',
                name: 'KM Dharma Rucitra VII',
                category: 'Kapal Ro-Ro Cargo',
                origin: 'Tanjung Perak, Surabaya',
                dest: 'Pelabuhan Semayang, Balikpapan',
                lat: -4.200,
                lng: 115.800,
                progress: 42,
                speed: '15.8 Knots',
                eta: '07 Nov, 14:00 WITA',
                status: 'Laut Jawa menuju Selat Makassar',
                cargoWeight: '320 Ton (Alat Berat & Kontainer)'
            },
            {
                id: 'SRA-AIR-9920',
                mode: 'air',
                name: 'Airbus A330-300F',
                category: 'Heavy Freight Cargo',
                origin: 'Kualanamu, Medan (KNO)',
                dest: 'Soekarno-Hatta, Jakarta (CGK)',
                lat: -5.700,
                lng: 105.800,
                progress: 88,
                speed: '310 Knots (Descent)',
                eta: 'Hari ini, 20:45 WIB',
                status: 'Final Descent Approach',
                cargoWeight: '42 Ton (Ekspor Komoditas)'
            },
            {
                id: 'SRA-TRK-7712',
                mode: 'land',
                name: 'Volvo FH16 Multi-Axle #08',
                category: 'Truk Kontainer Flatbed',
                origin: 'Pelabuhan Belawan, Medan',
                dest: 'Pematang Siantar, Sumut',
                lat: 3.400,
                lng: 98.900,
                progress: 48,
                speed: '62 km/h',
                eta: 'Malam ini, 23:00 WIB',
                status: 'Jalan Lintas Sumatera',
                cargoWeight: '28 Ton (Bahan Industri)'
            },
            {
                id: 'SRA-SEA-5501',
                mode: 'sea',
                name: 'Samudera Pacific IV',
                category: 'Container Feeder Vessel',
                origin: 'Batam Port (BTM)',
                dest: 'Tanjung Priok, Jakarta',
                lat: -1.800,
                lng: 106.100,
                progress: 55,
                speed: '14.2 Knots',
                eta: '08 Nov, 06:00 WIB',
                status: 'Selat Bangka Menuju Jawa',
                cargoWeight: '140 Ton'
            }
        ];

        // Map Setup
        let map;
        let currentTileLayer;
        let markersGroup;
        let routeLinesGroup;
        let currentActiveMode = 'all';

        // OpenStreetMap Tile URLs (Standard, Fast, No API Key needed)
        const TILE_OSM = 'https://tile.openstreetmap.org/{z}/{x}/{y}.png';
        const ATTRIBUTION_OSM = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

        // OpenWeatherMap & OpenCage Keys (Loaded from .env config)
        const OPENWEATHER_API_KEY = "{{ config('services.openweather.key', env('OPENWEATHER_API_KEY', '')) }}";
        const GEOCODING_API_KEY = "{{ config('services.geocoding.key', env('GEOCODING_API_KEY', '')) }}";

        // Weather Cache
        const weatherCache = {};

        // Fetch Live Weather from OpenWeatherMap for popup
        async function fetchWeatherForPopup(fleetId, lat, lng) {
            const containerId = `weather-info-${fleetId}`;
            const el = document.getElementById(containerId);
            if (!el) return;

            const cacheKey = `${lat.toFixed(2)},${lng.toFixed(2)}`;
            if (weatherCache[cacheKey]) {
                renderWeatherHTML(el, weatherCache[cacheKey]);
                return;
            }

            try {
                const res = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&appid=${OPENWEATHER_API_KEY}&units=metric&lang=id`);
                if (!res.ok) throw new Error('Weather fetch failed');
                const data = await res.json();
                weatherCache[cacheKey] = data;
                renderWeatherHTML(el, data);
            } catch (err) {
                el.innerHTML = '<span class="text-slate-400">Cuaca: Berawan 29°C</span>';
            }
        }

        function renderWeatherHTML(el, data) {
            const temp = Math.round(data.main.temp);
            const desc = data.weather[0]?.description || 'Cerah';
            const windKm = Math.round((data.wind?.speed || 0) * 3.6);
            const iconCode = data.weather[0]?.icon || '01d';
            
            el.innerHTML = `
                <div class="flex items-center justify-between text-[10px] bg-slate-800/60 dark:bg-slate-800/60 light:bg-slate-100 px-2 py-1 rounded-md border border-slate-700/50">
                    <div class="flex items-center gap-1.5">
                        <img src="https://openweathermap.org/img/wn/${iconCode}.png" alt="weather" class="w-4 h-4 -my-1">
                        <span class="font-bold text-sky-300 capitalize">${desc}</span>
                    </div>
                    <div class="flex items-center gap-2 text-slate-300">
                        <span class="font-extrabold text-amber-300">${temp}°C</span>
                        <span class="text-slate-400">Angin ${windKm} km/j</span>
                    </div>
                </div>
            `;
        }

        function initMap() {
            // Initialize centered on Indonesian archipelago
            map = L.map('interactiveMap', {
                center: [-4.2, 115.5],
                zoom: 5.0,
                zoomControl: false,
                attributionControl: false
            });

            // Zoom control on bottom right
            L.control.zoom({ position: 'bottomright' }).addTo(map);

            // Add OpenStreetMap tile layer
            currentTileLayer = L.tileLayer(TILE_OSM, {
                attribution: ATTRIBUTION_OSM,
                maxZoom: 19
            }).addTo(map);

            markersGroup = L.layerGroup().addTo(map);
            routeLinesGroup = L.layerGroup().addTo(map);

            renderFleetMarkers();
            drawRouteLines();

            setTimeout(() => {
                map.invalidateSize();
            }, 250);
        }

        // Custom HTML Marker Icons with Glowing Pulse
        function createFleetIcon(mode) {
            let colorHex = '#06b6d4';
            let svgPath = '';

            if (mode === 'sea') {
                colorHex = '#06b6d4';
                svgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l3 3h10l3-3z"/>';
            } else if (mode === 'air') {
                colorHex = '#38bdf8';
                svgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>';
            } else {
                colorHex = '#fbbf24';
                svgPath = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10h10zm0 0h4l3 3v-3h-7z"/>';
            }

            const html = `
                <div class="custom-marker-pulse relative flex items-center justify-center cursor-pointer">
                    <div class="pulse-ring" style="background-color: ${colorHex};"></div>
                    <div style="background-color: ${colorHex};" class="w-6 h-6 rounded-full shadow-lg flex items-center justify-center text-slate-900 font-bold border-2 border-white ring-2 ring-black/20">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            ${svgPath}
                        </svg>
                    </div>
                </div>
            `;

            return L.divIcon({
                className: 'custom-leaflet-div',
                html: html,
                iconSize: [24, 24],
                iconAnchor: [12, 12],
                popupAnchor: [0, -14]
            });
        }

        // Render markers based on active mode
        function renderFleetMarkers() {
            markersGroup.clearLayers();

            const filtered = currentActiveMode === 'all' 
                ? FLEET_DATA 
                : FLEET_DATA.filter(f => f.mode === currentActiveMode);

            document.getElementById('activeFleetCounter').innerText = `${filtered.length} Unit Beroperasi`;

            filtered.forEach(fleet => {
                const marker = L.marker([fleet.lat, fleet.lng], {
                    icon: createFleetIcon(fleet.mode)
                });

                const popupContent = `
                    <div class="p-2 min-w-[210px]">
                        <div class="flex items-center justify-between pb-1 mb-1 border-b border-sky-500/20">
                            <div>
                                <span class="text-[9px] uppercase font-bold text-sky-400 block">${fleet.category}</span>
                                <h4 class="text-xs font-extrabold text-white leading-tight">${fleet.name}</h4>
                            </div>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-sky-500/20 text-sky-300 border border-sky-400/30">
                                ${fleet.id}
                            </span>
                        </div>
                        <div class="space-y-1 text-[10px] text-slate-300">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Rute:</span>
                                <span class="font-semibold text-right">${fleet.origin} → ${fleet.dest}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Kecepatan:</span>
                                <span class="font-semibold text-sky-300">${fleet.speed}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">ETA Tujuan:</span>
                                <span class="font-semibold text-emerald-400">${fleet.eta}</span>
                            </div>
                        </div>

                        <!-- Live Weather Section -->
                        <div id="weather-info-${fleet.id}" class="my-1.5">
                            <div class="flex items-center gap-1.5 text-[9px] text-slate-400 bg-slate-800/40 px-2 py-0.5 rounded">
                                <svg class="w-3 h-3 animate-spin text-sky-400" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                <span>Cek cuaca rute...</span>
                            </div>
                        </div>

                        <div class="mt-1.5 pt-1 border-t border-slate-700/50 flex items-center justify-between">
                            <span class="text-[9px] text-slate-400">${fleet.status}</span>
                            <span class="text-[9px] font-bold text-sky-400">${fleet.progress}%</span>
                        </div>
                    </div>
                `;

                marker.bindPopup(popupContent);
                marker.on('popupopen', () => {
                    fetchWeatherForPopup(fleet.id, fleet.lat, fleet.lng);
                });
                fleet._marker = marker;
                markersGroup.addLayer(marker);
            });
        }

        // Draw illustrative route lines on map
        function drawRouteLines() {
            routeLinesGroup.clearLayers();

            const routes = [
                // Priok -> Perak (Sea route)
                [ [-6.10, 106.88], [-5.80, 108.50], [-6.55, 110.20], [-7.20, 112.72] ],
                // CGK -> DPS (Air route)
                [ [-6.12, 106.65], [-7.00, 110.00], [-7.50, 112.90], [-8.74, 115.16] ],
                // Cikarang -> SBY (Land toll)
                [ [-6.30, 107.15], [-6.90, 109.15], [-6.95, 109.80], [-7.30, 112.75] ]
            ];

            routes.forEach((pts, i) => {
                const color = i === 0 ? '#06b6d4' : (i === 1 ? '#38bdf8' : '#fbbf24');
                const polyline = L.polyline(pts, {
                    color: color,
                    weight: 2,
                    opacity: 0.6,
                    dashArray: '6, 8'
                });
                routeLinesGroup.addLayer(polyline);
            });
        }

        // Chart dynamic datasets per mode (7 Hari)
        const CHART_DATA_BY_MODE = {
            all: {
                label: 'Semua Armada (18)',
                bars: [ { y: 30, h: 35 }, { y: 20, h: 45 }, { y: 12, h: 53 }, { y: 24, h: 41 }, { y: 10, h: 55 }, { y: 18, h: 47 }, { y: 6, h: 59 } ],
                dots: [ { cy: 35 }, { cy: 22 }, { cy: 14 }, { cy: 26 }, { cy: 12 }, { cy: 20 }, { cy: 8 } ],
                linePath: 'M 26 35 Q 76 22, 126 14 T 226 12 T 321 8',
                areaPath: 'M 26 35 Q 76 22, 126 14 T 226 12 T 321 8 L 321 65 L 26 65 Z',
                lineColor: '#38bdf8'
            },
            sea: {
                label: 'Kapal Laut (7)',
                bars: [ { y: 45, h: 20 }, { y: 38, h: 27 }, { y: 22, h: 43 }, { y: 28, h: 37 }, { y: 16, h: 49 }, { y: 30, h: 35 }, { y: 12, h: 53 } ],
                dots: [ { cy: 48 }, { cy: 40 }, { cy: 24 }, { cy: 30 }, { cy: 18 }, { cy: 32 }, { cy: 14 } ],
                linePath: 'M 26 48 Q 76 40, 126 24 T 226 18 T 321 14',
                areaPath: 'M 26 48 Q 76 40, 126 24 T 226 18 T 321 14 L 321 65 L 26 65 Z',
                lineColor: '#06b6d4'
            },
            air: {
                label: 'Pesawat Kargo (4)',
                bars: [ { y: 50, h: 15 }, { y: 42, h: 23 }, { y: 35, h: 30 }, { y: 46, h: 19 }, { y: 26, h: 39 }, { y: 32, h: 33 }, { y: 20, h: 45 } ],
                dots: [ { cy: 52 }, { cy: 44 }, { cy: 37 }, { cy: 48 }, { cy: 28 }, { cy: 34 }, { cy: 22 } ],
                linePath: 'M 26 52 Q 76 44, 126 37 T 226 28 T 321 22',
                areaPath: 'M 26 52 Q 76 44, 126 37 T 226 28 T 321 22 L 321 65 L 26 65 Z',
                lineColor: '#38bdf8'
            },
            land: {
                label: 'Truk Armada (7)',
                bars: [ { y: 24, h: 41 }, { y: 16, h: 49 }, { y: 20, h: 45 }, { y: 14, h: 51 }, { y: 18, h: 47 }, { y: 12, h: 53 }, { y: 16, h: 49 } ],
                dots: [ { cy: 26 }, { cy: 18 }, { cy: 22 }, { cy: 16 }, { cy: 20 }, { cy: 14 }, { cy: 18 } ],
                linePath: 'M 26 26 Q 76 18, 126 22 T 226 20 T 321 18',
                areaPath: 'M 26 26 Q 76 18, 126 22 T 226 20 T 321 18 L 321 65 L 26 65 Z',
                lineColor: '#fbbf24'
            }
        };

        function updateTrafficChart(mode) {
            const data = CHART_DATA_BY_MODE[mode] || CHART_DATA_BY_MODE['all'];
            
            const subBadge = document.getElementById('chartSubBadge');
            if (subBadge) {
                subBadge.innerText = data.label;
            }

            const line = document.getElementById('chartLinePath');
            const area = document.getElementById('chartAreaPath');
            if (line) {
                line.setAttribute('d', data.linePath);
                line.setAttribute('stroke', data.lineColor);
            }
            if (area) {
                area.setAttribute('d', data.areaPath);
            }

            data.bars.forEach((b, idx) => {
                const barEl = document.getElementById(`bar${idx}`);
                if (barEl) {
                    barEl.setAttribute('y', b.y);
                    barEl.setAttribute('height', b.h);
                }
            });

            data.dots.forEach((d, idx) => {
                const dotEl = document.getElementById(`dot${idx}`);
                if (dotEl) {
                    dotEl.setAttribute('cy', d.cy);
                    dotEl.setAttribute('fill', data.lineColor);
                }
            });
        }

        // Filter Mode: all | sea | air | land
        function filterByMode(mode) {
            currentActiveMode = mode;

            const buttons = {
                all: document.getElementById('filterBtnAll'),
                sea: document.getElementById('filterBtnSea'),
                air: document.getElementById('filterBtnAir'),
                land: document.getElementById('filterBtnLand'),
            };

            const activeClass = 'bg-sky-500 text-white font-semibold shadow-sm shadow-sky-500/20';
            const inactiveClass = 'bg-slate-800/80 text-slate-300 border border-slate-700/60 font-medium';

            Object.keys(buttons).forEach(k => {
                const btn = buttons[k];
                if (!btn) return;
                if (k === mode) {
                    btn.className = `mode-filter-btn flex items-center gap-1 px-2.5 py-1 rounded-lg ${activeClass} text-[11px] transition-all`;
                } else {
                    btn.className = `mode-filter-btn flex items-center gap-1 px-2.5 py-1 rounded-lg ${inactiveClass} hover:text-white hover:bg-slate-800 text-[11px] transition-all`;
                }
            });

            renderFleetMarkers();
            updateTrafficChart(mode);

            const cards = document.querySelectorAll('.cargo-card');
            let visibleCount = 0;

            cards.forEach(card => {
                if (mode === 'all') {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    if (card.classList.contains(`mode-${mode}`)) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                }
            });

            document.getElementById('activeCargoCountBadge').innerText = `${visibleCount} Aktif`;
        }

        // Fly smoothly to selected cargo marker on map
        function flyToCargo(cargoId) {
            const item = FLEET_DATA.find(f => f.id === cargoId);
            if (!item) return;

            map.flyTo([item.lat, item.lng], 8, {
                duration: 1.0,
                easeLinearity: 0.25
            });

            setTimeout(() => {
                if (item._marker) {
                    item._marker.openPopup();
                }
            }, 1050);
        }

        function resetMapCenter() {
            map.flyTo([-4.2, 115.5], 5.0, { duration: 0.9 });
        }

        function filterCargoBySearch(query) {
            const q = query.toLowerCase();
            const cards = document.querySelectorAll('.cargo-card');
            let count = 0;

            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                if (text.includes(q)) {
                    card.style.display = 'block';
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });

            document.getElementById('activeCargoCountBadge').innerText = `${count} Aktif`;
        }

        function toggleThemeMode() {
            const html = document.documentElement;
            const isDark = html.classList.toggle('dark');
            
            const sunIcon = document.getElementById('sunIcon');
            const moonIcon = document.getElementById('moonIcon');
            const themeLabel = document.getElementById('themeLabelText');

            if (isDark) {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
                themeLabel.innerText = 'Dark Mode';
                localStorage.setItem('soracargo_theme', 'dark');
            } else {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
                themeLabel.innerText = 'Light Mode';
                localStorage.setItem('soracargo_theme', 'light');
            }
        }

        function toggleCargoSubmenu() {
            const submenu = document.getElementById('cargoSubmenu');
            const chevron = document.getElementById('cargoChevron');
            if (submenu.classList.contains('hidden')) {
                submenu.classList.remove('hidden');
                submenu.classList.add('block');
                chevron.classList.add('rotate-180');
            } else {
                submenu.classList.add('hidden');
                submenu.classList.remove('block');
                chevron.classList.remove('rotate-180');
            }
        }

        function showHistoryNotification() {
            alert('Arsip Riwayat Pengiriman: Menampilkan 142 Dokumen B/L, Surat Jalan, dan Delivery Order (DO) tersimpan.');
        }

        function showAccountModal() {
            alert('Pengaturan Akun Shipper: Pengaturan Akun, Kredit Logistik & Tagihan Invoice.');
        }

        function openSupportChat() {
            const confirmed = confirm('Hubungi Petugas Customer Service SoraCargo 24/7 sekarang via WhatsApp / Live Helpdesk?');
            if (confirmed) {
                window.open('https://wa.me/6281234567890?text=Halo%20SoraCargo,%20saya%20butuh%20bantuan%20terkait%20kargo%20saya.', '_blank');
            }
        }

        // =====================================================================
        // AI COPILOT INTERACTION (KONTAINER 4)
        // =====================================================================
        function appendAiMessage(sender, text) {
            const container = document.getElementById('aiChatMessages');
            const isBot = sender === 'AI';

            const msgDiv = document.createElement('div');
            msgDiv.className = `flex items-start gap-2 ${isBot ? '' : 'flex-row-reverse'}`;

            const avatarBg = isBot ? 'bg-sky-500/20 text-sky-400 border border-sky-400/30' : 'bg-indigo-600 text-white';
            const bubbleBg = isBot 
                ? 'bg-slate-900/80 dark:bg-slate-900/80 light:bg-slate-100 border border-slate-800 dark:border-slate-800 light:border-slate-200 text-slate-200 dark:text-slate-200 light:text-slate-800 rounded-tl-none'
                : 'bg-gradient-to-r from-sky-500 to-blue-600 text-white rounded-tr-none';

            msgDiv.innerHTML = `
                <div class="w-6 h-6 rounded-full ${avatarBg} flex items-center justify-center shrink-0 text-[10px] font-bold">
                    ${isBot ? 'AI' : 'BP'}
                </div>
                <div class="p-2 rounded-xl ${bubbleBg} max-w-[85%] leading-relaxed text-[11px] shadow-sm">
                    ${text}
                </div>
            `;

            container.appendChild(msgDiv);
            container.scrollTop = container.scrollHeight;
        }

        function handleChatSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('aiChatInput');
            const query = input.value.trim();
            if (!query) return;

            appendAiMessage('User', query);
            input.value = '';

            // Simulate intelligent AI answer based on Fleet Data
            setTimeout(() => {
                const answer = generateAiAnswer(query);
                appendAiMessage('AI', answer);
            }, 600);
        }

        function sendQuickPrompt(promptText) {
            appendAiMessage('User', promptText);
            setTimeout(() => {
                const answer = generateAiAnswer(promptText);
                appendAiMessage('AI', answer);
            }, 500);
        }

        function generateAiAnswer(query) {
            const q = query.toLowerCase();

            if (q.includes('meratus') || q.includes('8821')) {
                return 'Kapal <strong>MV Meratus Java (SRA-SEA-8821)</strong> saat ini berada di Laut Jawa dengan kecepatan 17.4 Knots (74% rute Priok → Perak). Estimasi tiba besok pukul 08:30 WIB tanpa kendala cuaca.';
            } else if (q.includes('bali') || q.includes('4092') || q.includes('pesawat')) {
                return 'Pesawat kargo <strong>B737-800F (SRA-AIR-4092)</strong> rute Jakarta → Bali sedang cruising FL280. Cuaca di Ngurah Rai cerah 29°C, estimasi mendarat 21:15 WIB.';
            } else if (q.includes('truk') || q.includes('cikarang') || q.includes('1044')) {
                return 'Truk <strong>Hino 500 Wingbox #12 (SRA-TRK-1044)</strong> saat ini melintas di Tol Trans-Jawa KM 372 (Pekalongan) dengan kecepatan 78 km/j. Estimasi tiba di Surabaya pukul 04:00 WIB.';
            } else if (q.includes('cuaca') || q.includes('weather')) {
                return 'Berdasarkan data satelit OpenWeatherMap terkini, perairan Laut Jawa berombak tenang (angin 14 km/j), sedangkan rute udara Jakarta-Bali terpantau cerah tanpa turbulensi signifikan.';
            } else if (q.includes('dekat') || q.includes('tiba')) {
                return 'Pengiriman terdekat yang akan tiba adalah kargo udara <strong>SRA-AIR-9920</strong> rute Kualanamu → Soekarno Hatta yang saat ini sudah tahap final descent (sisa 15 menit).';
            } else {
                return 'Terima kasih atas pertanyaannya. Seluruh 18 armada aktif Anda terpantau aman dan 99.4% tepat waktu sesuai jadwal rute. Anda dapat mengklik "Lihat di Peta" pada kartu cargo untuk memantau radar langsung.';
            }
        }

        // Init on DOM loaded
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('soracargo_theme');
            if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
                document.getElementById('sunIcon').classList.remove('hidden');
                document.getElementById('moonIcon').classList.add('hidden');
                document.getElementById('themeLabelText').innerText = 'Light Mode';
            }

            initMap();

            window.addEventListener('resize', () => {
                if (map) map.invalidateSize();
            });
        });
    </script>

</body>
</html>
