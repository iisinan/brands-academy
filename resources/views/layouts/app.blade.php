<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Brands Academy Nigeria Foundation') | Institutional Portal</title>
    <meta name="description" content="Advancing branding, marketing and professional education across Nigeria and beyond. Incorporated Trustee CAC IT No. 7344471.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col text-slate-800 antialiased selection:bg-amber-500 selection:text-white">

    <!-- Top Institutional Banner -->
    <header class="bg-slate-900 text-slate-300 text-xs py-2 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    RC / IT No. 7344471
                </span>
                <span class="hidden md:inline text-slate-400">A not-for-profit educational foundation incorporated under CAMA CAP C20 LFN 2004</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('verify.certificate') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Verify Credential
                </a>
                <span class="text-slate-700">|</span>
                <a href="mailto:thebrandsacademy@gmail.com" class="hover:text-slate-200">thebrandsacademy@gmail.com</a>
            </div>
        </div>
    </header>

    <!-- Main Navigation Bar -->
    <nav class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                    <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-slate-900 via-blue-950 to-amber-600 flex items-center justify-center text-white shadow-md shadow-slate-900/10 group-hover:scale-105 transition-transform">
                        <span class="font-serif-title font-bold text-xl text-amber-400">B</span>
                    </div>
                    <div>
                        <div class="font-extrabold text-slate-950 tracking-tight text-base sm:text-lg leading-tight uppercase font-serif-title">
                            Brands Academy
                        </div>
                        <div class="text-[11px] font-semibold tracking-wider text-amber-600 uppercase">
                            Nigeria Foundation
                        </div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <div class="hidden lg:flex items-center gap-1 xl:gap-2">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors">
                        Home
                    </a>
                    <a href="{{ route('about') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('about') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors">
                        About
                    </a>
                    <a href="{{ route('faculty') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('faculty') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors">
                        Faculty & Trustees
                    </a>
                    <a href="{{ route('workshops.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('workshops.*') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors flex items-center gap-1.5">
                        Workshops
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Live</span>
                    </a>
                    <a href="{{ route('membership.register') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('membership.register') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors flex items-center gap-1.5">
                        Membership
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">24/7 Open</span>
                    </a>
                    <a href="{{ route('partnerships') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('partnerships') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors">
                        Partnerships
                    </a>
                    <a href="{{ route('verify.certificate') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('verify.*') ? 'text-amber-600 bg-amber-50 font-semibold' : 'text-slate-700 hover:text-slate-950 hover:bg-slate-50' }} transition-colors">
                        Verify Credential
                    </a>
                </div>

                <!-- Right Action Buttons -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold bg-slate-900 text-amber-400 hover:bg-slate-800 transition-colors shadow-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Admin Panel
                            </a>
                        @else
                            <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs font-semibold bg-amber-50 text-amber-900 border border-amber-200 hover:bg-amber-100 transition-colors">
                                <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Member Dashboard
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition-colors" title="Sign Out">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-slate-950 px-3 py-2 rounded-lg hover:bg-slate-50 transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('membership.register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-sm transition-all hover:shadow-md">
                            Join Foundation
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    @endauth
                </div>

            </div>
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
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-900 to-amber-600 flex items-center justify-center text-white">
                            <span class="font-serif-title font-bold text-lg text-amber-400">B</span>
                        </div>
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

</body>
</html>
