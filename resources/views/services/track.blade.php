@extends('layouts.app')

@section('title', 'Track Filing & Legal Verification | Brands Academy')

@section('content')
<div class="bg-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            Public Registry Verification
        </div>
        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white mb-3">
            Live Case Tracker & Status Verification
        </h1>
        <p class="text-xs sm:text-sm text-slate-300 max-w-xl mx-auto font-light mb-8">
            Enter your official Brands Academy Legal Desk tracking reference code (e.g. <span class="font-mono text-amber-400">BANF-CAC-2026-XXXX</span>) to verify statutory registry progress.
        </p>

        <!-- Search Bar -->
        <form action="{{ route('services.track') }}" method="GET" class="max-w-xl mx-auto">
            <div class="flex items-center gap-2 bg-slate-800 p-1.5 rounded-2xl border border-slate-700 shadow-lg">
                <div class="relative flex-1">
                    <input type="text" name="code" value="{{ $code }}" placeholder="Enter Tracking Code (e.g. BANF-CAC-...)" required class="w-full text-xs sm:text-sm bg-transparent border-0 text-white placeholder-slate-400 focus:ring-0 px-4 py-2 font-mono uppercase">
                </div>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                    Track Case
                </button>
            </div>
        </form>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-8 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($searched && ! $filing)
        <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center shadow-xs">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-500 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1">No Filing Record Found</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto">
                We could not locate any legal or trademark filing matching reference <span class="font-mono font-bold text-slate-800">{{ $code }}</span>. Please double-check your code or contact the Legal Desk.
            </p>
        </div>
    @elseif($filing)
        <!-- Case Found Card -->
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs mb-8">
            <div class="p-6 sm:p-8 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-mono text-xs font-bold text-slate-500">{{ $filing->tracking_code }}</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700">
                            {{ $filing->type_title }}
                        </span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                        {{ $filing->proposed_name_1 }}
                    </h2>
                </div>

                <div>
                    @php
                        $badgeClasses = match($filing->status) {
                            'approved', 'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'queried' => 'bg-amber-50 text-amber-700 border-amber-200',
                            'payment_pending' => 'bg-slate-100 text-slate-700 border-slate-200',
                            default => 'bg-blue-50 text-blue-700 border-blue-200',
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold border {{ $badgeClasses }}">
                        <span class="w-2 h-2 rounded-full mr-2 {{ in_array($filing->status, ['approved', 'delivered']) ? 'bg-emerald-500' : ($filing->status === 'queried' ? 'bg-amber-500' : 'bg-blue-500 animate-pulse') }}"></span>
                        {{ $filing->status_label }}
                    </span>
                </div>
            </div>

            <!-- 5-Stage Visual Stepper -->
            <div class="p-6 sm:p-8 bg-slate-50 border-b border-slate-100">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6">Statutory Filing Lifecycle</h4>
                @php
                    $step = $filing->status_step_index;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-5 gap-3 relative">
                    <!-- Step 1 -->
                    <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                            @if($step >= 1) ✓ @else 1 @endif
                        </div>
                        <div>
                            <div class="text-xs font-bold {{ $step >= 1 ? 'text-slate-900' : 'text-slate-400' }}">Lodge & Paid</div>
                            <div class="text-[10px] text-slate-500">Case Created</div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 2 ? 'bg-emerald-600 text-white' : ($step == 1 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600') }}">
                            @if($step >= 2) ✓ @else 2 @endif
                        </div>
                        <div>
                            <div class="text-xs font-bold {{ $step >= 2 ? 'text-slate-900' : ($step == 1 ? 'text-blue-600' : 'text-slate-400') }}">Name Search</div>
                            <div class="text-[10px] text-slate-500">CAC/IPO Database</div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 3 ? 'bg-emerald-600 text-white' : ($step == 2 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600') }}">
                            @if($step >= 3) ✓ @else 3 @endif
                        </div>
                        <div>
                            <div class="text-xs font-bold {{ $step >= 3 ? 'text-slate-900' : ($step == 2 ? 'text-blue-600' : 'text-slate-400') }}">Registry Filing</div>
                            <div class="text-[10px] text-slate-500">Statutory Lodgement</div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 4 ? 'bg-emerald-600 text-white' : ($step == 3 ? ($filing->isQueried() ? 'bg-amber-500 text-white' : 'bg-blue-600 text-white') : 'bg-slate-200 text-slate-600') }}">
                            @if($step >= 4) ✓ @else 4 @endif
                        </div>
                        <div>
                            <div class="text-xs font-bold {{ $step >= 4 ? 'text-slate-900' : ($step == 3 ? ($filing->isQueried() ? 'text-amber-600' : 'text-blue-600') : 'text-slate-400') }}">
                                {{ $filing->isQueried() ? 'Action Required' : 'Registry Audit' }}
                            </div>
                            <div class="text-[10px] text-slate-500">{{ $filing->isQueried() ? 'Document Query' : 'Compliance Check' }}</div>
                        </div>
                    </div>

                    <!-- Step 5 -->
                    <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 4 && $filing->isApproved() ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                            @if($filing->isApproved()) ✓ @else 5 @endif
                        </div>
                        <div>
                            <div class="text-xs font-bold {{ $filing->isApproved() ? 'text-emerald-700' : 'text-slate-400' }}">Certified</div>
                            <div class="text-[10px] text-slate-500">Certificate Issued</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Case Particulars -->
            <div class="p-6 sm:p-8">
                @if($filing->isQueried())
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <h4 class="text-xs font-bold text-amber-900">Registry Query Notice:</h4>
                                <p class="text-xs text-amber-800 mt-1 font-light">
                                    {{ $filing->client_query_message ?: 'The registry requested an updated document or clarification. Please sign in to your Member Portal to upload the revised file.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-1">Official Registry Number:</span>
                        <span class="font-mono font-bold text-sm text-slate-900">
                            {{ $filing->government_filing_number ?: 'Pending Allocation' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Applicant Name:</span>
                        <span class="font-semibold text-slate-800">{{ $filing->client_first_name }} {{ $filing->client_last_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Operating State:</span>
                        <span class="font-semibold text-slate-800">{{ $filing->headquarters_state }}</span>
                    </div>
                    <div class="sm:col-span-3">
                        <span class="text-slate-400 block mb-1">Nature of Business:</span>
                        <span class="text-slate-700 leading-relaxed font-light">{{ $filing->business_nature }}</span>
                    </div>
                </div>

                @if($filing->isApproved())
                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-emerald-950">Statutory Certificate Issued & Sealed</h4>
                                <p class="text-[11px] text-emerald-700">Official registry credential has been verified and deposited.</p>
                            </div>
                        </div>
                        @auth
                            <a href="{{ route('member.filings.certificate', $filing->tracking_code) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                <span>Download Official Certificate</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-bold text-emerald-800 hover:underline">
                                Sign In to Download Certificate &rarr;
                            </a>
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Activity / Status History -->
            @if($filing->statusLogs->isNotEmpty())
                <div class="bg-slate-50 p-6 sm:p-8 border-t border-slate-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4">Case Activity Log</h4>
                    <div class="space-y-3">
                        @foreach($filing->statusLogs as $log)
                            <div class="flex items-start gap-3 text-xs">
                                <span class="w-2 h-2 rounded-full bg-slate-400 mt-1.5 shrink-0"></span>
                                <div>
                                    <span class="text-slate-500 text-[11px] font-mono mr-2">{{ $log->created_at->format('M d, Y H:i') }}</span>
                                    <span class="text-slate-800 font-medium">{{ $log->remarks }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
