@extends('layouts.app')

@section('title', 'Certified Brand Practitioners Register | Brands Academy Nigeria Foundation')

@section('content')
<!-- Hero -->
<section class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Official Statutory Register of Certified Practitioners
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black font-serif-title tracking-tight text-white mb-4">
                National Register of Brand Builders &amp; Fellows
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-light mb-8">
                Verify accredited brand consultants, chief marketing officers, intellectual property attorneys, and Fellows recognized by the Brands Academy Nigeria Foundation.
            </p>
            <div class="flex items-center gap-6 text-xs text-slate-400">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    <span>{{ number_format($totalPractitioners) }} Verified Members in Good Standing</span>
                </div>
                <div class="hidden sm:flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 004 11a7.978 7.978 0 003.046 6.277m1.8-13.136a8.002 8.002 0 0110.308 0"></path></svg>
                    <span>Cryptographic QR Verification</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Filter & Search Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-6 relative z-10">
    <form method="GET" action="{{ route('registry.index') }}" class="bg-white rounded-2xl border border-slate-200 p-4 sm:p-6 shadow-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Keyword search -->
            <div class="lg:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search by practitioner name, company, or Member ID..." class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Category filter -->
            <div>
                <select name="category" onchange="this.form.submit()" class="w-full py-2.5 text-xs rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All Tiers / Categories</option>
                    @foreach($categories as $catKey => $catLabel)
                        <option value="{{ $catKey }}" @selected($category === $catKey)>{{ $catLabel }}</option>
                    @endforeach
                </select>
            </div>

            <!-- State filter -->
            <div class="flex gap-2">
                <select name="state" onchange="this.form.submit()" class="w-full py-2.5 text-xs rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all">All States / Jurisdictions</option>
                    @foreach($states as $st)
                        <option value="{{ $st }}" @selected($state === $st)>{{ $st }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs rounded-xl shadow-xs transition-colors shrink-0">
                    Filter
                </button>
            </div>
        </div>

        @if(!empty($search) || (!empty($category) && $category !== 'all') || (!empty($state) && $state !== 'all'))
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Active filters applied</span>
                <a href="{{ route('registry.index') }}" class="font-bold text-blue-600 hover:underline">Clear all filters</a>
            </div>
        @endif
    </form>
</section>

<!-- Practitioner Grid -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($members as $m)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs hover:shadow-xl transition-all flex flex-col justify-between group">
                <div>
                    <!-- Header with Tier and Verified Badge -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold {{ $m->category === 'fellow' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                            {{ $m->category === 'fellow' ? 'Fellow of Brands Academy (FBA)' : ucwords($m->category) . ' Member' }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200 shrink-0">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Verified
                        </span>
                    </div>

                    <!-- Profile Info -->
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-14 h-14 rounded-full bg-slate-900 text-white font-bold text-base flex items-center justify-center shrink-0 uppercase shadow-xs">
                            {{ substr($m->first_name, 0, 1) }}{{ substr($m->last_name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors">
                                {{ $m->full_name }}
                            </h3>
                            <p class="text-xs text-slate-600 font-medium">{{ $m->designation ?: 'Brand Practitioner' }}</p>
                            <p class="text-[11px] text-slate-400 mt-0.5">{{ $m->institution_or_company ?: 'Independent Practice' }}</p>
                        </div>
                    </div>

                    <!-- Meta Details -->
                    <div class="grid grid-cols-2 gap-2 py-3 border-y border-slate-100 text-[11px] mb-4">
                        <div>
                            <span class="text-slate-400 block">Member Number</span>
                            <span class="font-mono font-bold text-slate-800">{{ $m->member_number }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Jurisdiction</span>
                            <span class="font-bold text-slate-800">{{ $m->state ? $m->state . ', ' . $m->country : $m->country }}</span>
                        </div>
                    </div>

                    @if($m->bio)
                        <p class="text-xs text-slate-600 font-light line-clamp-2 mb-4 leading-relaxed">
                            {{ $m->bio }}
                        </p>
                    @endif
                </div>

                <!-- Footer CTA -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400 font-medium">
                        {{ $m->certificates->count() }} {{ \Illuminate\Support\Str::plural('Credential', $m->certificates->count()) }}
                    </span>
                    <a href="{{ route('registry.show', $m->member_number) }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs transition-colors">
                        <span>View Dossier</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500 shadow-xs">
                <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                <h3 class="text-base font-bold text-slate-900 mb-1">No certified practitioners found</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">No registered practitioners matched your query. Try broadening your keywords or clearing filters.</p>
                <a href="{{ route('registry.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:underline">Reset Search &rarr;</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $members->links() }}
    </div>
</section>
@endsection
