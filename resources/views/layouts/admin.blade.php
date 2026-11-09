<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#020617">
    <title>@yield('title', 'Administration Portal') | Brands Academy Nigeria Foundation</title>
    <meta name="description" content="Operational Administration & Governance Portal for Brands Academy Nigeria Foundation (CAC IT No. 7344471).">
    
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
        /* Custom scrollbar for sidebar */
        .admin-sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.6);
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 4px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(245, 158, 11, 0.4);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full bg-slate-100 text-slate-800 antialiased selection:bg-amber-500 selection:text-white"
      x-data="{ 
          mobileSidebarOpen: false, 
          userMenuOpen: false,
          quickActionOpen: false
      }">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div x-show="mobileSidebarOpen" x-cloak
         @click="mobileSidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/80 backdrop-blur-xs lg:hidden transition-opacity"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    <div class="flex min-h-screen">
        
        <!-- ======================= SIDEBAR ======================= -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] bg-slate-950 text-slate-300 flex flex-col border-r border-slate-800/80 transform transition-transform duration-300 ease-in-out lg:translate-x-0 admin-sidebar overflow-y-auto"
               :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header / Brand Badge -->
            <div class="p-5 border-b border-slate-800/80 bg-slate-950/90 sticky top-0 z-10 backdrop-blur-md">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        <x-brand-logo class="w-10 h-10 shrink-0 drop-shadow-md group-hover:scale-105 transition-transform" />
                        <div class="min-w-0">
                            <span class="block text-xs font-extrabold uppercase tracking-widest text-white font-serif-title truncate">
                                Brands Academy
                            </span>
                            <span class="block text-[10px] font-bold tracking-wider text-amber-400 uppercase">
                                Nigeria Foundation
                            </span>
                        </div>
                    </a>

                    <!-- Close button on mobile -->
                    <button @click="mobileSidebarOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Legal Entity Pill -->
                <div class="mt-3 flex items-center justify-between pt-2.5 border-t border-slate-800/60 text-[10px]">
                    <span class="inline-flex items-center gap-1.5 font-bold text-amber-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Admin Control Center
                    </span>
                    <span class="text-slate-400 font-mono">RC 7344471</span>
                </div>
            </div>

            <!-- Sidebar Navigation Links -->
            <nav class="flex-1 p-4 space-y-6 text-xs font-medium">

                <!-- Section: Overview -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        Executive Overview
                    </span>
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.dashboard') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>Dashboard</span>
                        </div>
                    </a>
                </div>

                <!-- Section 1: Workshops & Training -->
                <div>
                    <div class="flex items-center justify-between px-3 mb-2">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                            1. Workshops &amp; Training
                        </span>
                        <a href="{{ route('admin.workshops.create') }}" class="text-[10px] font-bold text-amber-400 hover:text-amber-300 flex items-center gap-0.5" title="New Workshop Cohort">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            <span>Add</span>
                        </a>
                    </div>
                    
                    <div class="space-y-1">
                        <!-- Workshops List -->
                        <a href="{{ route('admin.workshops') }}"
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.workshops*') && !request()->routeIs('admin.workshops.create') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 {{ request()->routeIs('admin.workshops*') && !request()->routeIs('admin.workshops.create') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                <span>Cohorts &amp; Trainings</span>
                            </div>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.workshops*') && !request()->routeIs('admin.workshops.create') ? 'bg-slate-950/20 text-slate-950' : 'bg-slate-800 text-slate-400' }}">
                                {{ \App\Models\Workshop::count() }}
                            </span>
                        </a>

                        <!-- Create New Cohort -->
                        <a href="{{ route('admin.workshops.create') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.workshops.create') ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white pl-8' }}">
                            <svg class="w-3.5 h-3.5 {{ request()->routeIs('admin.workshops.create') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Create Workshop</span>
                        </a>

                        <!-- Admissions Queue / Participants -->
                        <a href="{{ route('admin.applications') }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.applications') ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white pl-8' }}">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 {{ request()->routeIs('admin.applications') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <span>Admissions Queue</span>
                            </div>
                            @php $pendingApps = \App\Models\WorkshopApplication::where('status', 'pending')->count(); @endphp
                            @if($pendingApps > 0)
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-amber-500 text-slate-950">
                                    {{ $pendingApps }}
                                </span>
                            @endif
                        </a>

                        <!-- Portfolios Evaluation -->
                        <a href="{{ route('admin.submissions') }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.submissions') ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white pl-8' }}">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 {{ request()->routeIs('admin.submissions') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Student Portfolios</span>
                            </div>
                            @php $pendingSubs = \App\Models\PortfolioSubmission::where('status', 'submitted')->count(); @endphp
                            @if($pendingSubs > 0)
                                <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-amber-500 text-slate-950">
                                    {{ $pendingSubs }}
                                </span>
                            @endif
                        </a>

                        <!-- Issued Certificates & Bulk Dispatch -->
                        <a href="{{ route('admin.certificates') }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl transition-all {{ request()->routeIs('admin.certificates') ? 'bg-amber-500 text-slate-950 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white pl-8' }}">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 {{ request()->routeIs('admin.certificates') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                <span>Certificate Registry</span>
                            </div>
                            <span class="text-[10px] text-slate-400">
                                {{ \App\Models\Certificate::count() }}
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Section 2: Members Directory -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        2. Members Management
                    </span>
                    <a href="{{ route('admin.members') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.members*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.members*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <span>Members Directory</span>
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.members*') ? 'bg-slate-950/20 text-slate-950' : 'bg-slate-800 text-slate-400' }}">
                            {{ \App\Models\Member::count() }}
                        </span>
                    </a>
                </div>

                <!-- Section 3: Institutional Requests -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        3. Institutional Requests
                    </span>
                    <a href="{{ route('admin.inquiries') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.inquiries*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.inquiries*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>University &amp; Agency Inquiries</span>
                        </div>
                        @php $newInquiries = \App\Models\InstitutionalInquiry::where('status', 'new')->count(); @endphp
                        @if($newInquiries > 0)
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-amber-500 text-slate-950">
                                {{ $newInquiries }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Section 4: Finance & Payment Monitoring -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        4. Finance &amp; Payments
                    </span>
                    <a href="{{ route('admin.finance') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.finance*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.finance*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Payment Monitor</span>
                        </div>
                        @php $pendingPayments = \App\Models\MemberPayment::whereIn('status', ['pending', 'under_review'])->count() + \App\Models\Member::where('payment_status', 'under_review')->count(); @endphp
                        @if($pendingPayments > 0)
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-amber-400 text-slate-950">
                                {{ $pendingPayments }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Section 5: Access Control / RBAC -->
                <div>
                    <span class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">
                        System Administration
                    </span>
                    <a href="{{ route('admin.users') }}"
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users*') ? 'bg-amber-500 text-slate-950 font-bold shadow-md shadow-amber-500/20' : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 {{ request()->routeIs('admin.users*') ? 'text-slate-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Users &amp; RBAC Roles</span>
                        </div>
                    </a>
                </div>

            </nav>

            <!-- Sidebar Footer / Quick Site Actions & Profile -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-950/80 space-y-3">
                <!-- Public Website Shortcuts -->
                <div class="space-y-1">
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-2 rounded-xl text-[11px] font-semibold text-slate-400 hover:text-amber-300 hover:bg-slate-900 transition-colors">
                        <span class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>Landing Page</span>
                        </span>
                        <span>&rarr;</span>
                    </a>

                    <a href="{{ route('member.dashboard') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-[11px] font-semibold text-slate-400 hover:text-amber-300 hover:bg-slate-900 transition-colors">
                        <span class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Member Portal View</span>
                        </span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- Admin Profile & Logout -->
                <div class="pt-3 border-t border-slate-800/60 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/30 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Admin User' }}</span>
                            <span class="block text-[10px] text-amber-400 font-semibold truncate">Administrator</span>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-900 transition-colors" title="Sign Out">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <!-- ======================= MAIN CONTENT WRAPPER ======================= -->
        <div class="flex-1 lg:pl-72 flex flex-col min-h-screen">
            
            <!-- Top Sticky Administrative Bar -->
            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
                
                <div class="flex items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button @click="mobileSidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Breadcrumbs / Context -->
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Governance Portal</span>
                        <h1 class="text-base sm:text-lg font-bold text-slate-900 font-serif-title leading-tight">
                            @yield('page_title', 'Operational Control Center')
                        </h1>
                    </div>
                </div>

                <!-- Top Right Utility Actions -->
                <div class="flex items-center gap-2.5">
                    <!-- Quick New Workshop Cohort -->
                    <a href="{{ route('admin.workshops.create') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>New Cohort</span>
                    </a>

                    <!-- Live Website Button -->
                    <a href="{{ route('home') }}" target="_blank" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors flex items-center gap-1.5 border border-slate-200">
                        <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span class="hidden md:inline">Landing Page</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 transition-colors">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 text-amber-400 font-bold text-xs flex items-center justify-center">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open" x-cloak
                             class="absolute right-0 mt-2 w-56 rounded-2xl bg-white shadow-xl border border-slate-200 py-2 z-50 text-xs text-slate-700"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">
                            
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <span class="block font-bold text-slate-900 truncate">{{ auth()->user()->name }}</span>
                                <span class="block text-[11px] text-slate-400 truncate">{{ auth()->user()->email }}</span>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 font-medium">Administration Home</a>
                                <a href="{{ route('member.dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 font-medium">Switch to Member Portal</a>
                                <a href="{{ route('home') }}" target="_blank" class="block px-4 py-2 hover:bg-slate-50 font-medium">Public Foundation Site</a>
                            </div>

                            <div class="border-t border-slate-100 pt-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-rose-600 hover:bg-rose-50 font-bold flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </header>

            <!-- Alerts & Flash Notifications -->
            <div class="px-4 sm:px-6 lg:px-8 pt-4">
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-xs mb-4" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm font-semibold flex items-center justify-between gap-3 shadow-xs mb-4" x-data="{ show: true }" x-show="show">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs shadow-xs mb-4">
                        <p class="font-bold mb-1">Please address the following requirements:</p>
                        <ul class="list-disc pl-5 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Content Body -->
            <main class="flex-1 pb-24 lg:pb-16">
                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="px-4 sm:px-6 lg:px-8 py-4 pb-20 lg:pb-4 bg-white border-t border-slate-200 text-slate-400 text-xs flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    <strong>Brands Academy Nigeria Foundation</strong> &bull; Incorporated Trustee (CAMA CAP C20 LFN 2004) &bull; RC / IT No. 7344471
                </div>
                <div class="flex items-center gap-4 text-[11px]">
                    <a href="{{ route('home') }}" class="hover:text-amber-600 transition-colors">Public Site</a>
                    <span>&bull;</span>
                    <a href="{{ route('verify.certificate') }}" class="hover:text-amber-600 transition-colors">Verification Registry</a>
                    <span>&bull;</span>
                    <a href="{{ route('admin.finance') }}" class="hover:text-amber-600 transition-colors">Finance Hub</a>
                </div>
            </footer>

        </div>
    </div>

    <!-- Admin Mobile Bottom Navigation Bar -->
    <nav class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-slate-950/95 backdrop-blur-md border-t border-slate-800 safe-pb shadow-lg">
        <div class="grid grid-cols-5 h-16 items-center px-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('admin.dashboard') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px]">Overview</span>
            </a>
            <!-- Workshops -->
            <a href="{{ route('admin.workshops') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('admin.workshops*') || request()->routeIs('admin.applications*') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span class="text-[10px]">Workshops</span>
            </a>
            <!-- Members -->
            <a href="{{ route('admin.members') }}" class="flex flex-col items-center justify-center py-1 transition-colors {{ request()->routeIs('admin.members*') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="text-[10px]">Members</span>
            </a>
            <!-- Inquiries -->
            <a href="{{ route('admin.inquiries') }}" class="flex flex-col items-center justify-center py-1 transition-colors relative {{ request()->routeIs('admin.inquiries*') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                @php $newInqCount = \App\Models\InstitutionalInquiry::where('status', 'new')->count(); @endphp
                @if($newInqCount > 0)
                    <span class="absolute top-1.5 right-3 w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                @endif
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span class="text-[10px]">Inquiries</span>
            </a>
            <!-- Finance -->
            <a href="{{ route('admin.finance') }}" class="flex flex-col items-center justify-center py-1 transition-colors relative {{ request()->routeIs('admin.finance*') ? 'text-amber-400 font-bold' : 'text-slate-400 hover:text-white' }}">
                @php $pendingPayCount = \App\Models\MemberPayment::whereIn('status', ['pending', 'under_review'])->count() + \App\Models\Member::where('payment_status', 'under_review')->count(); @endphp
                @if($pendingPayCount > 0)
                    <span class="absolute top-1.5 right-3 w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                @endif
                <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px]">Finance</span>
            </a>
        </div>
    </nav>

    @stack('scripts')
</body>
</html>
