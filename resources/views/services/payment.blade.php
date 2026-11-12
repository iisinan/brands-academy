@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'Payment & Summary - ' . $filing->tracking_code . ' | Brands Academy')
@section('page_title', 'Statutory Payment & Case Summary')

@section('content')
<div class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
            Case Reference: {{ $filing->tracking_code }}
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
            Statutory Payment & Case Summary
        </h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1 font-light">
            Review your legal filing particulars below and complete fee checkout to commence registry search.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-6 rounded-r-xl text-xs text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs mb-8">
        <div class="p-6 sm:p-8 border-b border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Service Category</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                    {{ $filing->type_title }}
                </span>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mb-1">
                {{ $filing->proposed_name_1 }}
            </h2>
            @if($filing->proposed_name_2 || $filing->proposed_name_3)
                <p class="text-xs text-slate-500 mb-4 font-light">
                    Alternative choices: {{ implode(', ', array_filter([$filing->proposed_name_2, $filing->proposed_name_3])) }}
                </p>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs pt-4 border-t border-slate-100">
                <div>
                    <span class="text-slate-400 block mb-0.5">Applicant Name:</span>
                    <span class="font-semibold text-slate-800">{{ $filing->client_first_name }} {{ $filing->client_last_name }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Applicant Contact:</span>
                    <span class="font-semibold text-slate-800">{{ $filing->client_email }} | {{ $filing->client_phone }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Headquarters State:</span>
                    <span class="font-semibold text-slate-800">{{ $filing->headquarters_state }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block mb-0.5">Uploaded Documents:</span>
                    <span class="font-semibold text-slate-800">{{ $filing->documents->count() }} Attached</span>
                </div>
            </div>
        </div>

        <!-- Invoice Breakdown -->
        <div class="bg-slate-50 p-6 sm:p-8">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4">Fee Summary</h3>
            <div class="space-y-2 text-xs mb-6">
                <div class="flex justify-between text-slate-600">
                    <span>Statutory & Legal Filing Fee:</span>
                    <span>₦{{ number_format($filing->total_fee + $filing->member_discount, 2) }}</span>
                </div>
                @if($filing->member_discount > 0)
                    <div class="flex justify-between text-emerald-600 font-medium">
                        <span>Brands Academy Member Discount (25% Off):</span>
                        <span>-₦{{ number_format($filing->member_discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-extrabold text-slate-900 pt-3 border-t border-slate-200">
                    <span>Total Amount Payable:</span>
                    <span class="text-blue-600">₦{{ number_format($filing->total_fee, 2) }}</span>
                </div>
            </div>

            <form action="{{ route('services.pay', $filing->tracking_code) }}" method="POST">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Pay Statutory Fee (₦{{ number_format($filing->total_fee, 2) }})</span>
                </button>
            </form>
            <p class="text-[11px] text-center text-slate-400 mt-3">
                Secure 256-bit encrypted transaction processed via Paystack / SquadCo.
            </p>
        </div>
    </div>
</div>
@endsection
