<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#090d16">
    <title>@yield('title', 'Brands Academy Nigeria Foundation')</title>
    <meta name="description" content="@yield('meta_description', 'Advancing branding, marketing and professional education across Nigeria and West Africa. Incorporated Trustee CAC/IT/No. 7344471.')">
    
    <!-- OpenGraph & Social Metadata -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Brands Academy Nigeria Foundation">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Brands Academy Nigeria Foundation')">
    <meta property="og:description" content="@yield('meta_description', 'Advancing branding, marketing and professional education across Nigeria and West Africa. Incorporated Trustee CAC/IT/No. 7344471.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo/bran-logo-3d.png'))">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Brands Academy Nigeria Foundation')">
    <meta name="twitter:description" content="@yield('meta_description', 'Advancing branding, marketing and professional education across Nigeria and West Africa. Incorporated Trustee CAC/IT/No. 7344471.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo/bran-logo-3d.png'))">
    
    <!-- Canonical & Favicons -->
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => 'Brands Academy Nigeria Foundation',
        'alternateName' => 'BANF',
        'url' => url('/'),
        'logo' => asset('images/logo/bran-logo-3d.png'),
        'description' => 'Not-for-profit educational foundation incorporated under Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees). CAC/IT/No. 7344471. Advancing branding, marketing and professional education across Nigeria and West Africa.',
        'email' => 'thebrandsacademy@gmail.com',
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => 'NG',
        ],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    
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
                    CAC/IT/No. 7344471
                </span>
                <span class="hidden md:inline truncate text-slate-400 text-[11px]">
                    Not-for-profit educational foundation incorporated under the Companies and Allied Matters Act 2020 (Part F)
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
            <div class="flex justify-between items-center h-20 gap-2 xl:gap-4">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 xl:gap-3 shrink-0 group">
                    <x-brand-logo class="w-10 h-10 sm:w-12 sm:h-12 drop-shadow-xs group-hover:scale-105 transition-transform" />
                    <div class="leading-none">
                        <div class="font-serif-title font-bold text-slate-950 tracking-tight text-sm sm:text-base xl:text-lg uppercase">
                            Brands Academy
                        </div>
                        <div class="text-[9px] xl:text-[10px] font-extrabold tracking-widest text-amber-600 uppercase mt-0.5">
                            Nigeria Foundation
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links (6 Consolidated Groups) -->
                <div class="hidden lg:flex items-center gap-0.5 xl:gap-1.5">
                    <a href="{{ route('home') }}" class="px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('home') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                        Home
                    </a>

                    <!-- 1. Programmes Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('workshops.*', 'courses.*', 'webinars.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                            <span>Programmes</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180 text-amber-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-200/90 p-2 z-50">
                            <a href="{{ route('workshops.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('workshops.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('workshops.*') ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">W</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('workshops.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }} flex items-center gap-1.5">
                                        <span>Workshops &amp; Cohorts</span>
                                        <span class="px-1.5 py-0.2 rounded-full text-[9px] bg-emerald-100 text-emerald-800 font-extrabold uppercase">Live</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Scheduled certification cohorts</div>
                                </div>
                            </a>
                            <a href="{{ route('courses.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('courses.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('courses.*') ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">C</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('courses.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Executive Short Courses</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Self-paced video modules &amp; LMS</div>
                                </div>
                            </a>
                            <a href="{{ route('webinars.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('webinars.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('webinars.*') ? 'bg-purple-600 text-white' : 'bg-purple-100 text-purple-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">M</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('webinars.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Webinars &amp; Masterclasses</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Live sessions with industry fellows</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 2. Certification Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('registry.*', 'verify.*', 'certifications') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                            <span>Certification</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180 text-amber-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-200/90 p-2 z-50">
                            <a href="{{ route('certifications') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('certifications') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">3T</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-amber-800">3-Tier Certification Tracks</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">CBA &bull; CBS &bull; CBE pathway</div>
                                </div>
                            </a>
                            <a href="{{ route('verify.certificate') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('verify.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('verify.*') ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">✓</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('verify.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Verify Credential</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Instant certificate &amp; ID verification</div>
                                </div>
                            </a>
                            <a href="{{ route('registry.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('registry.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('registry.*') ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-900 text-amber-400 font-bold' }} flex items-center justify-center shrink-0 mt-0.5 text-xs">R</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('registry.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Practitioners Register</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Official BANF certified directory</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 3. Membership Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('membership.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                            <span>Membership</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180 text-amber-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-200/90 p-2 z-50">
                            <a href="{{ route('membership.register') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('membership.register') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">+</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('membership.register') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Join Foundation (24/7)</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Student, Professional &amp; Fellow tracks</div>
                                </div>
                            </a>
                            <a href="{{ route('membership.register') }}#benefits" class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-amber-50/60 transition-colors group">
                                <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">★</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-amber-800">Member Privileges</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">25% desk savings, CPD, mentorship</div>
                                </div>
                            </a>
                            <a href="{{ route('verify.certificate') }}" class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-amber-50/60 transition-colors group">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">ID</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-amber-800">Digital Member Pass</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">QR credential &amp; good standing check</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 4. For Institutions Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('partnerships', 'services.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                            <span>For Institutions</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180 text-amber-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-200/90 p-2 z-50">
                            <a href="{{ route('partnerships') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('partnerships') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('partnerships') ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">🏛</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('partnerships') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Institutional Partnerships</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">University licensing &amp; corporate training</div>
                                </div>
                            </a>
                            <a href="{{ route('services.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('services.index', 'services.desk') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('services.index', 'services.desk') ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">§</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('services.index', 'services.desk') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">CAC &amp; Brand IP Desk</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Business name, LTD &amp; trademark filing</div>
                                </div>
                            </a>
                            <a href="{{ route('services.calculator') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('services.calculator') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('services.calculator') ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">₦</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('services.calculator') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Statutory Fee Calculator</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Transparent fee &amp; Nice class tool</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 5. About Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('about', 'faculty', 'legal.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                            <span>About</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180 text-amber-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute left-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-200/90 p-2 z-50">
                            <a href="{{ route('about') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('about') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('about') ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">A</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('about') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">About the Foundation</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Mission, charter &amp; governance</div>
                                </div>
                            </a>
                            <a href="{{ route('faculty') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('faculty') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('faculty') ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">F</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('faculty') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Faculty &amp; Trustees</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Board of Trustees &amp; Fellows</div>
                                </div>
                            </a>
                            <a href="{{ route('about') }}#manifesto" class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-amber-50/60 transition-colors group">
                                <div class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">M</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-amber-800">The Manifesto &amp; Values</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">5 core educational principles</div>
                                </div>
                            </a>
                            <a href="{{ route('legal.ethics') }}" class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-amber-50/60 transition-colors group {{ request()->routeIs('legal.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : '' }}">
                                <div class="w-7 h-7 rounded-lg bg-slate-900 text-amber-400 flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">§</div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 group-hover:text-amber-800">Governance &amp; Charters</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Ethics, privacy &amp; terms</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- 6. Resources Dropdown -->
                    <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.outside="open = false" @keydown.escape.window="open = false">
                        <button type="button" @click="open = !open" class="inline-flex items-center gap-1 px-2 xl:px-2.5 py-2 rounded-lg text-xs xl:text-sm font-semibold whitespace-nowrap transition-colors {{ request()->routeIs('journal.*', 'conferences.*', 'forum.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-100/70' }}">
                            <span>Resources</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-150" :class="open ? 'rotate-180 text-amber-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="absolute right-0 mt-1 w-64 rounded-2xl bg-white shadow-xl border border-slate-200/90 p-2 z-50">
                            <a href="{{ route('journal.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('journal.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('journal.*') ? 'bg-purple-600 text-white' : 'bg-purple-100 text-purple-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">J</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('journal.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">NJBSM Journal</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Nigerian Journal of Brand Strategy</div>
                                </div>
                            </a>
                            <a href="{{ route('conferences.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('conferences.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('conferences.*') ? 'bg-amber-600 text-white' : 'bg-amber-100 text-amber-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">S</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('conferences.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Conferences &amp; Summits</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Nigeria Brand Leadership Summit</div>
                                </div>
                            </a>
                            <a href="{{ route('forum.index') }}" class="flex items-start gap-2.5 p-2 rounded-xl transition-colors group {{ request()->routeIs('forum.*') ? 'bg-amber-500/10 border-l-2 border-amber-500' : 'hover:bg-amber-50/60' }}">
                                <div class="w-7 h-7 rounded-lg {{ request()->routeIs('forum.*') ? 'bg-teal-600 text-white' : 'bg-teal-100 text-teal-800' }} flex items-center justify-center shrink-0 mt-0.5 font-bold text-xs">C</div>
                                <div>
                                    <div class="text-xs font-bold {{ request()->routeIs('forum.*') ? 'text-amber-900' : 'text-slate-900 group-hover:text-amber-800' }}">Community Forum</div>
                                    <div class="text-[11px] text-slate-500 leading-tight">Practitioner discussions &amp; debates</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-2 xl:gap-3 shrink-0">
                    @auth
                        @php
                            $navUnreadCount = auth()->user()->unreadNotifications()->count();
                        @endphp
                        <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-600 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition-colors" title="Notifications">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            @if($navUnreadCount > 0)
                                <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-600 text-[9px] font-bold text-white font-mono animate-pulse">
                                    {{ $navUnreadCount > 9 ? '9+' : $navUnreadCount }}
                                </span>
                            @endif
                        </a>

                        @if(auth()->user()?->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 xl:px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-900 text-amber-400 hover:bg-slate-800 transition-colors shadow-xs whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="hidden xl:inline">Admin Panel</span>
                                <span class="xl:hidden">Admin</span>
                            </a>
                            <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 xl:px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs whitespace-nowrap">
                                <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                <span class="hidden sm:inline">Member Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs whitespace-nowrap">
                                <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
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
                        <a href="{{ route('login') }}" class="hidden sm:inline-block px-2.5 xl:px-3 py-2 text-xs xl:text-sm font-semibold text-slate-700 hover:text-slate-950 hover:bg-slate-100/70 rounded-xl transition-colors whitespace-nowrap">
                            Sign In
                        </a>
                        <a href="{{ route('membership.register') }}" class="inline-flex items-center gap-1.5 xl:gap-2 px-3.5 xl:px-5 py-2 xl:py-2.5 rounded-xl text-xs xl:text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-sm hover:shadow-md transition-all whitespace-nowrap group">
                            <span>Join Foundation</span>
                            <svg class="w-3.5 xl:w-4 h-3.5 xl:h-4 text-slate-950 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-3 shadow-lg max-h-[85vh] overflow-y-auto">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-sm font-bold {{ request()->routeIs('home') ? 'text-amber-700 bg-amber-500/10' : 'text-slate-800 hover:bg-slate-50' }}">
                Home
            </a>

            <!-- Programmes Group -->
            <div class="pt-2 border-t border-slate-100">
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Programmes</div>
                <div class="space-y-0.5">
                    <a href="{{ route('workshops.index') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('workshops.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Workshops &amp; Cohorts</span>
                        <span class="inline-flex items-center gap-1 px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800 uppercase">Live</span>
                    </a>
                    <a href="{{ route('courses.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('courses.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Executive Short Courses &amp; LMS
                    </a>
                    <a href="{{ route('webinars.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('webinars.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Webinars &amp; Masterclasses
                    </a>
                </div>
            </div>

            <!-- Certification Group -->
            <div class="pt-2 border-t border-slate-100">
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Certification &amp; Registry</div>
                <div class="space-y-0.5">
                    <a href="{{ route('certifications') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('certifications') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>3-Tier Certification Framework</span>
                        <span class="text-amber-600 font-bold text-[10px]">CBA &bull; CBS &bull; CBE</span>
                    </a>
                    <a href="{{ route('verify.certificate') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('verify.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        <span>Verify Digital Credential</span>
                        <span class="text-amber-600 font-bold text-[10px]">&check; Verify</span>
                    </a>
                    <a href="{{ route('registry.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('registry.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        BANF Certified Practitioners Register
                    </a>
                </div>
            </div>

            <!-- Membership & Institutions Group -->
            <div class="pt-2 border-t border-slate-100">
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Membership &amp; Institutional</div>
                <div class="space-y-0.5">
                    <a href="{{ route('membership.register') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('membership.register') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Join Ongoing Membership (24/7)
                    </a>
                    <a href="{{ route('partnerships') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('partnerships') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Institutional Licensing &amp; Partnerships
                    </a>
                    <a href="{{ route('services.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('services.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        CAC &amp; Brand IP Filing Desk
                    </a>
                    <a href="{{ route('services.calculator') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('services.calculator') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Statutory Fee Calculator
                    </a>
                </div>
            </div>

            <!-- Resources Group -->
            <div class="pt-2 border-t border-slate-100">
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Resources &amp; Knowledge</div>
                <div class="space-y-0.5">
                    <a href="{{ route('journal.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('journal.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Nigerian Journal of Brand Strategy (NJBSM)
                    </a>
                    <a href="{{ route('conferences.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('conferences.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Leadership Conferences &amp; Summits
                    </a>
                    <a href="{{ route('forum.index') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('forum.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Community &amp; Discussions
                    </a>
                </div>
            </div>

            <!-- Foundation & Governance Group -->
            <div class="pt-2 border-t border-slate-100">
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">About &amp; Governance</div>
                <div class="space-y-0.5">
                    <a href="{{ route('about') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('about') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        About the Foundation &amp; Manifesto
                    </a>
                    <a href="{{ route('faculty') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('faculty') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Faculty &amp; Board of Trustees
                    </a>
                    <a href="{{ route('legal.ethics') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('legal.*') ? 'text-amber-700 bg-amber-500/10 font-bold' : 'text-slate-700 hover:bg-slate-50' }}">
                        Code of Ethics &amp; Governance Charters
                    </a>
                </div>
            </div>

            @auth
                <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ route('notifications.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-900 border border-blue-200">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span>Notifications</span>
                        </span>
                        @if($navUnreadCount > 0)
                            <span class="px-2 py-0.5 rounded-full text-[10px] bg-blue-600 text-white font-mono font-bold">
                                {{ $navUnreadCount }} unread
                            </span>
                        @endif
                    </a>

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

        @if(isset($errors) && $errors->any())
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
    <main class="flex-1 pb-20 lg:pb-0">
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
                        <div><strong class="text-slate-300">CAC Registration:</strong> CAC/IT/No. 7344471</div>
                        <div><strong class="text-slate-300">Incorporation Date:</strong> 12 February 2024</div>
                        <div><strong class="text-slate-300">Governing Body:</strong> Companies and Allied Matters Act 2020 (Part F, Incorporated Trustees)</div>
                    </div>
                </div>

                <!-- Col 2: Certification Tracks -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Certification Tracks</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('certifications') }}#cba" class="hover:text-amber-400 transition-colors">Tier 1: CBA (Associate)</a></li>
                        <li><a href="{{ route('certifications') }}#cbs" class="hover:text-amber-400 transition-colors">Tier 2: CBS (Strategist)</a></li>
                        <li><a href="{{ route('certifications') }}#cbe" class="hover:text-amber-400 transition-colors">Tier 3: CBE (Executive)</a></li>
                        <li><a href="{{ route('workshops.index') }}" class="hover:text-amber-400 transition-colors">Cohort Application Windows</a></li>
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
                <div class="flex flex-wrap items-center gap-4 text-slate-400 text-xs">
                    <a href="{{ route('legal.ethics') }}" class="hover:text-amber-400 transition-colors">Code of Ethics</a>
                    <span>&bull;</span>
                    <a href="{{ route('legal.privacy') }}" class="hover:text-amber-400 transition-colors">Privacy Policy</a>
                    <span>&bull;</span>
                    <a href="{{ route('legal.terms') }}" class="hover:text-amber-400 transition-colors">Terms &amp; Refunds</a>
                </div>
                <p>Governed by Board of Trustees: Prof. Samaila Mande (Chairman), Prof. Imam Yagana Babakura, Dr. Okoli Emmanuel Chibuzo &bull; Titus Eveshoyan (Secretary to the Board)</p>
            </div>
        </div>
    </footer>

    <!-- Mobile App Bottom Navigation Bar -->
    <nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-slate-950/95 backdrop-blur-md border-t border-slate-800 safe-pb shadow-lg">
        <div class="grid grid-cols-5 h-16 items-center px-1">
            <!-- Home -->
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('home') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px]">Home</span>
            </a>
            <!-- Workshops -->
            <a href="{{ route('workshops.index') }}" class="flex flex-col items-center justify-center py-1 transition-colors relative {{ request()->routeIs('workshops.*') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <span class="absolute top-1.5 right-3 w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span class="text-[10px]">Workshops</span>
            </a>
            <!-- Verify -->
            <a href="{{ route('verify.certificate') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('verify.*') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span class="text-[10px]">Verify</span>
            </a>
            <!-- Membership -->
            <a href="{{ route('membership.register') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('membership.register') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span class="text-[10px]">Join</span>
            </a>
            <!-- Portal / Sign In -->
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('member.dashboard') }}" class="flex flex-col items-center justify-center py-1 transition-colors text-amber-400 font-bold">
                    <div class="w-5 h-5 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center text-[10px] font-black mb-0.5">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-[10px]">Portal</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('login') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span class="text-[10px]">Sign In</span>
                </a>
            @endauth
        </div>
    </nav>

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
