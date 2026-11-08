<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Brands Academy Nigeria Foundation') | Institutional Portal</title>
    <meta name="description" content="@yield('meta_description', 'Advancing branding, marketing and professional education across Nigeria and beyond. Incorporated Trustee CAC IT No. 7344471.')">
    
    <!-- OpenGraph & Social Metadata -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Brands Academy Nigeria Foundation">
    <meta property="og:title" content="@yield('title', 'Brands Academy Nigeria Foundation | Institutional Portal')">
    <meta property="og:description" content="@yield('meta_description', 'Advancing branding, marketing and professional education across Nigeria and beyond. Incorporated Trustee CAC IT No. 7344471.')">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:image" content="{{ asset('images/logo/bran-logo-3d.png') }}?v=3">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-amber-500 selection:text-white">

    <!-- Top Institutional Banner -->
    <header class="bg-slate-950 text-slate-300 text-xs py-2 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center gap-4">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-300 border border-amber-500/30 shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    RC / IT No. 7344471
                </span>
                <span class="hidden md:inline truncate text-slate-400 text-[11px]">
                    Not-for-profit educational foundation incorporated under CAMA CAP C20 LFN 2004
                </span>
            </div>
            <div class="flex items-center gap-3 sm:gap-4 shrink-0 text-[11px]">
                <a href="{{ route('verify.certificate') }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-amber-300 hover:text-white bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 transition-all font-semibold shadow-2xs">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Verify Credential
                </a>
                <span class="text-slate-800">|</span>
                <a href="mailto:thebrandsacademy@gmail.com" class="hover:text-slate-200 transition-colors hidden sm:inline-flex items-center gap-1 text-slate-400">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    thebrandsacademy@gmail.com
                </a>
            </div>
        </div>
    </header>

    <!-- Main Navigation Bar -->
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 gap-4">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group">
                    <x-brand-logo class="w-12 h-12 drop-shadow-xs group-hover:scale-105 transition-transform" />
                    <div class="leading-none">
                        <div class="font-serif-title font-bold text-slate-950 tracking-tight text-base sm:text-lg uppercase">
                            Brands Academy
                        </div>
                        <div class="text-[10px] font-extrabold tracking-widest text-amber-600 uppercase mt-0.5">
                            Nigeria Foundation
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center gap-1 xl:gap-1.5">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('home') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('about') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        About
                    </a>
                    <a href="{{ route('faculty') }}" class="px-3 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('faculty') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        Faculty & Trustees
                    </a>
                    <a href="{{ route('workshops.index') }}" class="px-3 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors flex items-center gap-1.5 {{ request()->routeIs('workshops.*') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        <span>Workshops</span>
                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wide bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                            Live
                        </span>
                    </a>
                    <a href="{{ route('membership.register') }}" class="px-3 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('membership.register') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        Membership
                    </a>
                    <a href="{{ route('partnerships') }}" class="px-3 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('partnerships') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        Partnerships
                    </a>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-900 text-amber-400 hover:bg-slate-800 transition-colors shadow-xs whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>Admin Panel</span>
                            </a>
                            <a href="{{ route('member.dashboard') }}" title="Preview Member Dashboard" class="hidden xl:inline-flex items-center gap-1 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-950 hover:bg-slate-100 transition-colors whitespace-nowrap">
                                <span>Member View</span>
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200 hover:bg-amber-100 transition-colors whitespace-nowrap">
                                <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Member Dashboard</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition-colors" title="Sign Out">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:inline-block px-3 py-2 text-xs xl:text-sm font-semibold text-slate-700 hover:text-slate-950 hover:bg-slate-100/70 rounded-xl transition-colors whitespace-nowrap">
                            Sign In
                        </a>
                        <a href="{{ route('membership.register') }}" class="inline-flex items-center gap-2 px-4 xl:px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-sm hover:shadow-md transition-all whitespace-nowrap group">
                            <span>Join Foundation</span>
                            <svg class="w-4 h-4 text-slate-950 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth

                    <!-- Mobile Hamburger Toggle Button -->
                    <button type="button" id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-slate-700 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-amber-500" aria-label="Toggle Navigation">
                        <svg id="hamburger-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg id="close-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-1 shadow-lg">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                Home
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('about') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                About & Manifesto
            </a>
            <a href="{{ route('faculty') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('faculty') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                Faculty & Trustees
            </a>
            <a href="{{ route('workshops.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('workshops.*') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                <span>Workshops & Cohorts</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Live</span>
            </a>
            <a href="{{ route('membership.register') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('membership.register') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                Ongoing Membership (24/7)
            </a>
            <a href="{{ route('partnerships') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('partnerships') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                Institutional Partnerships
            </a>
            <a href="{{ route('verify.certificate') }}" class="block px-3 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('verify.*') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-700 hover:bg-slate-50' }}">
                Verify Credential
            </a>

            @auth
                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block text-center py-2.5 rounded-xl text-xs font-bold bg-slate-900 text-amber-400">
                            Admin Control Panel
                        </a>
                        <a href="{{ route('admin.users') }}" class="block text-center py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            Users &amp; Smart RBAC
                        </a>
                        <a href="{{ route('member.dashboard') }}" class="block text-center py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            Member Portal Preview
                        </a>
                    @else
                        <a href="{{ route('member.dashboard') }}" class="block text-center py-2.5 rounded-xl text-xs font-bold bg-amber-50 text-amber-900 border border-amber-200">
                            Member Dashboard
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-center py-2 rounded-xl text-xs font-bold text-rose-600 hover:bg-rose-50">
                            Sign Out
                        </button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="block text-center py-2.5 rounded-xl text-xs font-bold text-slate-700 border border-slate-200 hover:bg-slate-50">
                        Sign In
                    </a>
                    <a href="{{ route('membership.register') }}" class="block text-center py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-sm">
                        Join Foundation
                    </a>
                </div>
            @endguest
        </div>
    </nav>

    <!-- Global Alerts / Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 mb-4 flex items-start gap-3 text-emerald-900 shadow-xs">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium leading-relaxed">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-4 flex items-start gap-3 text-rose-900 shadow-xs">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div class="text-sm font-medium leading-relaxed">{{ session('error') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 mb-4 text-rose-900 shadow-xs">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1 text-rose-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Please correct the following errors:
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content Slot -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Institutional Footer -->
    <footer class="bg-slate-950 text-slate-400 mt-20 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- Col 1: Organization Overview -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <x-brand-logo class="w-12 h-12 drop-shadow-md" />
                        <div>
                            <div class="font-bold text-white tracking-wide text-base uppercase font-serif-title">
                                Brands Academy
                            </div>
                            <div class="text-[10px] font-semibold tracking-wider text-amber-500 uppercase">
                                Nigeria Foundation
                            </div>
                        </div>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        A not-for-profit, non-political educational foundation incorporated under the laws of the Federal Republic of Nigeria. Advancing branding, marketing, communications and professional education across Nigeria and West Africa.
                    </p>
                    <div class="pt-2 text-xs space-y-1 text-slate-400">
                        <div><strong class="text-slate-300">CAC IT Registration:</strong> RC / IT No. 7344471</div>
                        <div><strong class="text-slate-300">Incorporation Date:</strong> 12 February 2024</div>
                        <div><strong class="text-slate-300">Governing Body:</strong> Incorporated Trustees (CAMA, CAP C20 LFN 2004)</div>
                    </div>
                </div>

                <!-- Col 2: Certification Tracks -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Certification Tracks</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('workshops.index') }}" class="hover:text-amber-400 transition-colors">Tier 1: CBA (Associate)</a></li>
                        <li><a href="{{ route('workshops.index') }}" class="hover:text-amber-400 transition-colors">Tier 2: CBS (Strategist)</a></li>
                        <li><a href="{{ route('workshops.index') }}" class="hover:text-amber-400 transition-colors">Tier 3: CBE (Executive)</a></li>
                        <li><a href="{{ route('workshops.index') }}" class="hover:text-amber-400 transition-colors">Community Free-Access Track</a></li>
                        <li><a href="{{ route('partnerships') }}" class="hover:text-amber-400 transition-colors">Institutional Licensing</a></li>
                    </ul>
                </div>

                <!-- Col 3: Portal & Services -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('membership.register') }}" class="hover:text-amber-400 transition-colors">Ongoing Membership (24/7)</a></li>
                        <li><a href="{{ route('workshops.index') }}" class="hover:text-amber-400 transition-colors">Cohort Application Windows</a></li>
                        <li><a href="{{ route('verify.certificate') }}" class="hover:text-amber-400 transition-colors">Digital Credential Verification</a></li>
                        <li><a href="{{ route('faculty') }}" class="hover:text-amber-400 transition-colors">Faculty & Trustees</a></li>
                        <li><a href="{{ route('partnerships') }}" class="hover:text-amber-400 transition-colors">Institutional Partnerships</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-amber-400 transition-colors">Our Manifesto & Core Values</a></li>
                    </ul>
                </div>

                <!-- Col 4: Registered Office -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Registered Office</h4>
                    <address class="not-italic text-sm text-slate-400 space-y-2">
                        <p>No. 27C, Ilorin Crescent,</p>
                        <p>Ali-Akilu West, Marafa,</p>
                        <p>Kaduna State, Nigeria.</p>
                        <p class="pt-2">
                            <a href="mailto:thebrandsacademy@gmail.com" class="text-amber-400 hover:underline">thebrandsacademy@gmail.com</a>
                        </p>
                    </address>
                </div>

            </div>

            <!-- Bottom bar -->
            <div class="mt-12 pt-8 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Brands Academy Nigeria Foundation. All rights reserved.</p>
                <p>Governed by Board of Trustees: Prof. Samaila Mande (Chairman), Prof. Imam Yagana Babakura, Dr. Okoli Emmanuel Chibuzo, Titus Eveshoyan (Secretary).</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function () {
                const isHidden = mobileMenu.classList.contains('hidden');
                if (isHidden) {
                    mobileMenu.classList.remove('hidden');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                } else {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
