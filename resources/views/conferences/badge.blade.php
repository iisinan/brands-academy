@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'Delegate Pass - ' . $delegate->full_name . ' | Brands Academy')
@section('page_title', 'Digital Delegate Summit Pass')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30 mb-3">
            Official Accreditation
        </span>
        <h1 class="text-2xl sm:text-3xl font-black text-white">Digital Delegate Summit Pass</h1>
        <p class="text-xs text-slate-300 mt-1">Present this QR credential token at the plenary check-in desk for accreditation badge dispatch.</p>
    </div>
</div>

<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- The Pass Badge Card -->
    <div class="bg-white rounded-3xl border-2 border-slate-900 overflow-hidden shadow-2xl relative">
        <!-- Top Banner -->
        <div class="bg-slate-950 text-white p-6 text-center border-b-4 border-amber-500">
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-400 block mb-1">Brands Academy Nigeria Foundation</span>
            <h2 class="text-base sm:text-lg font-black text-white uppercase">{{ $conference->title }}</h2>
            <p class="text-[11px] text-slate-400 mt-0.5">{{ $conference->starts_at->format('M d') }} - {{ $conference->ends_at->format('M d, Y') }} &bull; {{ $conference->venue }}</p>
        </div>

        <!-- Middle Body -->
        <div class="p-8 text-center">
            <div class="w-20 h-20 rounded-full bg-slate-100 border-2 border-slate-200 mx-auto mb-4 flex items-center justify-center text-2xl font-black text-slate-700">
                {{ substr($delegate->first_name, 0, 1) }}{{ substr($delegate->last_name, 0, 1) }}
            </div>

            <h3 class="text-2xl font-black text-slate-900">{{ $delegate->full_name }}</h3>
            @if($delegate->designation || $delegate->organization)
                <p class="text-xs font-medium text-slate-600 mt-1">
                    {{ implode(' • ', array_filter([$delegate->designation, $delegate->organization])) }}
                </p>
            @endif

            <div class="mt-4 inline-flex items-center px-4 py-1.5 rounded-full text-xs font-extrabold bg-blue-50 text-blue-800 border border-blue-200">
                {{ $delegate->ticket ? $delegate->ticket->name : 'Accredited Delegate' }}
            </div>

            <!-- QR Simulation / Badge Code -->
            <div class="mt-8 pt-6 border-t border-dashed border-slate-200">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-2">Accreditation Token</span>
                <div class="font-mono text-base font-extrabold text-slate-900 bg-slate-100 py-2.5 px-4 rounded-xl inline-block border border-slate-200">
                    {{ $delegate->badge_code }}
                </div>

                <div class="mt-4 flex items-center justify-center gap-2 text-xs">
                    @if($delegate->checked_in)
                        <span class="inline-flex items-center gap-1.5 text-emerald-700 font-bold bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            Checked In at Venue
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-slate-500 font-medium bg-slate-100 px-3 py-1 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            Awaiting Plenary Check-In
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="bg-slate-50 p-4 border-t border-slate-200 flex items-center justify-between text-xs text-slate-500">
            <span>Pass ID: #{{ $delegate->id }}</span>
            <button onclick="window.print()" class="text-blue-600 font-bold hover:underline flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print / Save PDF
            </button>
        </div>
    </div>
</div>
@endsection
