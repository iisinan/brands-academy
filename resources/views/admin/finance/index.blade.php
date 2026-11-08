@extends('layouts.admin')

@section('title', 'Finance & Payment Monitoring - Brands Academy')
@section('page_title', 'Finance & Payment Monitor')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" x-data="{ reviewModalOpen: false, activePayment: null }">

    <!-- Header Section with Quick Stats -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold font-serif-title text-slate-900">
                Treasury &amp; Collections Ledger
            </h2>
            <p class="text-xs text-slate-500 mt-1">
                Real-time monitoring of all membership dues, workshop cohort fees, and institutional grants across Paystack, SquadCo, and Direct Bank Transfers.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.finance.export') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export Ledger (CSV)</span>
            </a>
        </div>
    </div>

    <!-- 4-Card Primary Financial KPI Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Revenue -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Gross Collections</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                    ₦
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title mt-2">
                ₦{{ number_format($stats['total_revenue']) }}
            </div>
            <div class="mt-2 text-[11px] text-emerald-700 font-semibold flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                <span>{{ $stats['successful_count'] }} successful verified transactions</span>
            </div>
        </div>

        <!-- This Month Inflow -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">This Month's Inflow</span>
                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title mt-2">
                ₦{{ number_format($stats['this_month_revenue']) }}
            </div>
            <div class="mt-2 text-[11px] text-slate-500">
                Period: {{ now()->format('F Y') }}
            </div>
        </div>

        <!-- Awaiting Bank Transfer Review -->
        <div class="bg-white p-5 rounded-2xl border {{ $stats['pending_reviews_count'] > 0 ? 'border-amber-300 bg-amber-50/20' : 'border-slate-200' }} shadow-xs">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800">Awaiting Admin Verification</span>
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-xs">
                    !
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-extrabold {{ $stats['pending_reviews_count'] > 0 ? 'text-amber-800' : 'text-slate-900' }} font-serif-title mt-2">
                {{ $stats['pending_reviews_count'] }}
            </div>
            <div class="mt-2 text-[11px] font-medium {{ $stats['pending_reviews_count'] > 0 ? 'text-amber-700' : 'text-slate-400' }}">
                {{ $stats['pending_reviews_count'] > 0 ? 'Bank transfer slips requiring approval' : 'All payment slips up to date' }}
            </div>
        </div>

        <!-- Gateway Breakdown Pill Strip -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-2">Processed By Channel</span>
            <div class="space-y-1.5 text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Paystack</span>
                    <span class="font-mono font-bold text-slate-900">₦{{ number_format($stats['paystack_revenue']) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">SquadCo</span>
                    <span class="font-mono font-bold text-slate-900">₦{{ number_format($stats['squad_revenue']) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Bank Transfer</span>
                    <span class="font-mono font-bold text-slate-900">₦{{ number_format($stats['bank_transfer_revenue']) }}</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form action="{{ route('admin.finance') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search reference, payer name, or email..."
                   class="lg:col-span-2 px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">

            <!-- Gateway -->
            <select name="gateway" class="px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Gateways</option>
                <option value="paystack" {{ request('gateway') == 'paystack' ? 'selected' : '' }}>Paystack</option>
                <option value="squad" {{ request('gateway') == 'squad' ? 'selected' : '' }}>SquadCo (HabariPay)</option>
                <option value="bank_transfer" {{ request('gateway') == 'bank_transfer' ? 'selected' : '' }}>Direct Bank Transfer</option>
            </select>

            <!-- Status -->
            <select name="status" class="px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Statuses</option>
                <option value="successful" {{ request('status') == 'successful' ? 'selected' : '' }}>Successful / Paid</option>
                <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review (Slip Uploaded)</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Payment</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed / Rejected</option>
                <option value="waived" {{ request('status') == 'waived' ? 'selected' : '' }}>Waived / Grant</option>
            </select>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                    Filter Ledger
                </button>
                @if(request()->hasAny(['q', 'gateway', 'status', 'category']))
                    <a href="{{ route('admin.finance') }}" class="px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Financial Transactions Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="font-bold text-sm text-slate-900 font-serif-title">Payment Transactions &amp; Receipts</h3>
                <span class="text-xs text-slate-400">({{ $payments->total() }} total entries)</span>
            </div>
            <span class="text-[11px] text-slate-400 font-medium">Automatic NIBSS &amp; Gateway reconciliation</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Reference &amp; Date</th>
                        <th class="px-6 py-4">Payer / Member</th>
                        <th class="px-6 py-4">Item / Category</th>
                        <th class="px-6 py-4">Gateway &amp; Channel</th>
                        <th class="px-6 py-4">Amount</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            
                            <!-- Reference & Date -->
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-slate-900 block text-xs">{{ $payment->reference }}</span>
                                <span class="text-[10px] text-slate-400 block mt-0.5">
                                    {{ $payment->created_at->format('M d, Y &bull; h:i A') }}
                                </span>
                            </td>

                            <!-- Payer / Member -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 block">
                                    {{ $payment->member?->full_name ?? $payment->user?->name ?? 'Direct Payer' }}
                                </span>
                                <span class="text-[11px] text-slate-500 block truncate max-w-xs">
                                    {{ $payment->member?->email ?? $payment->user?->email }}
                                </span>
                                @if($payment->member?->member_number)
                                    <span class="font-mono text-[10px] text-amber-700 font-semibold block">
                                        ID: {{ $payment->member->member_number }}
                                    </span>
                                @endif
                            </td>

                            <!-- Item / Category -->
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    {{ ucfirst($payment->category) }} Dues
                                </span>
                            </td>

                            <!-- Gateway & Channel -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 font-semibold text-slate-800">
                                    @if($payment->payment_gateway === 'paystack')
                                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                                        <span>Paystack</span>
                                    @elseif($payment->payment_gateway === 'squad')
                                        <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                        <span>SquadCo</span>
                                    @else
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span>Bank Transfer</span>
                                    @endif
                                </div>
                                @if($payment->gateway_reference)
                                    <span class="font-mono text-[9px] text-slate-400 block truncate max-w-[120px]">
                                        Ref: {{ $payment->gateway_reference }}
                                    </span>
                                @endif
                            </td>

                            <!-- Amount -->
                            <td class="px-6 py-4">
                                <span class="font-mono font-extrabold text-sm text-slate-900 block">
                                    {{ $payment->formatted_amount }}
                                </span>
                                <span class="text-[9px] uppercase font-bold text-slate-400">{{ $payment->currency }}</span>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4">
                                @if($payment->status === 'successful')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Successful</span>
                                    </span>
                                @elseif($payment->status === 'under_review')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        <span>Under Review</span>
                                    </span>
                                @elseif($payment->status === 'waived')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                        <span>Waived / Grant</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <span>{{ ucfirst($payment->status) }}</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- View Receipt Proof Modal -->
                                    @if($payment->receipt_path)
                                        <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank"
                                           class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 transition-colors flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Slip</span>
                                        </a>
                                    @endif

                                    <!-- Quick Review / Approve Form for under_review/pending payments -->
                                    @if(in_array($payment->status, ['pending', 'under_review']))
                                        <form action="{{ route('admin.finance.verify', $payment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Approve payment {{ $payment->reference }} and activate member?');">
                                            @csrf
                                            <input type="hidden" name="status" value="successful">
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition-colors">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <svg class="w-10 h-10 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="font-bold text-slate-700 text-xs">No transactions match your query.</p>
                                    <p class="text-[11px] text-slate-400">Payments initiated through online checkout or manual transfer uploads will automatically appear here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
            <div class="p-4 border-t border-slate-100 bg-slate-50">
                {{ $payments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
