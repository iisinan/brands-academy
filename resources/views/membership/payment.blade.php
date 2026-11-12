@extends('layouts.app')

@section('title', 'Annual Membership Dues - Secure Online Checkout - Brands Academy')

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }
</style>
@endpush

@section('content')

<!-- Header Banner -->
<section class="bg-slate-900 text-white py-12 sm:py-16 border-b border-slate-800 relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 text-amber-400 border border-amber-500/30 mb-4">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            Annual Dues Checkout &bull; {{ $member->isPaid() && $member->member_number ? $member->member_number : 'Activation Required' }}
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title tracking-tight text-white">
            Complete Membership Payment
        </h1>
        <p class="text-slate-300 text-sm sm:text-base mt-3 max-w-2xl mx-auto font-light leading-relaxed">
            Pay your annual foundation dues securely online to immediately activate your account and unlock direct access to your <strong>Member Dashboard</strong>.
        </p>
    </div>
</section>

<!-- Main Checkout Card -->
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-8 text-sm font-medium anim-check-pop flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <div>
                <span class="font-bold block">Status Update</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('warning'))
        <div class="bg-amber-50 border border-amber-200 text-amber-900 px-5 py-4 rounded-2xl mb-8 text-sm font-medium anim-check-pop flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <span class="font-bold block">Membership Payment Required</span>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    @if (session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-950 px-5 py-4 rounded-2xl mb-8 text-sm font-medium anim-check-pop flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <span class="font-bold block">Account Recognized</span>
                <span>{{ session('info') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl mb-8 text-sm font-medium anim-check-pop flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <div>
                <span class="font-bold block">Payment Notice</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif


    <!-- Main Payment Container -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl p-6 sm:p-10 relative overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0"></div>

        <!-- Top Header: Crest & Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
            <div class="flex items-center gap-3.5">
                <x-brand-logo class="w-12 h-12 drop-shadow-sm" />
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 uppercase tracking-wider">Brands Academy Nigeria Foundation</h2>
                    <p class="text-[11px] text-amber-600 font-bold uppercase tracking-widest">Incorporated Trustee &bull; CAC/IT/No. 7344471</p>
                </div>
            </div>
            
            <div class="text-left sm:text-right">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-200">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    Portal Locked &bull; Dues Pending
                </span>
            </div>
        </div>

        <!-- Order & Member Details Table -->
        <div class="py-6 border-b border-slate-100 space-y-4 text-xs">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                    <span class="text-slate-500 font-medium block text-[11px]">Member Name</span>
                    <span class="text-sm font-extrabold text-slate-900 block mt-0.5">{{ $member->full_name }}</span>
                    <span class="text-slate-500 font-mono text-[11px] block mt-1">{{ $user->email }}</span>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
                    <span class="text-slate-500 font-medium block text-[11px]">Member ID &bull; Category</span>
                    @if ($member->isPaid() && $member->member_number)
                        <span class="font-mono text-sm font-extrabold text-amber-700 block mt-0.5">{{ $member->member_number }}</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-100 text-amber-900 border border-amber-300 block mt-1 w-fit">
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Issued After Payment
                        </span>
                    @endif
                    <span class="inline-block mt-1 text-[11px] font-bold text-slate-700">{{ $feeConfig['label'] }} ({{ $feeConfig['badge'] }})</span>
                </div>
            </div>

            <!-- Fee Breakdown Box -->
            <div class="border border-slate-200 rounded-2xl p-5 space-y-3">
                <div class="flex justify-between items-center text-slate-600">
                    <span class="font-medium">Annual Membership Dues ({{ $feeConfig['label'] }}):</span>
                    <span class="font-bold text-slate-900 font-mono text-sm">₦{{ number_format($feeConfig['amount']) }}</span>
                </div>
                <div class="flex justify-between items-center text-slate-600">
                    <span class="font-medium">Validity Period:</span>
                    <span class="font-semibold text-slate-800">1 Full Year (12 Months)</span>
                </div>
                <div class="flex justify-between items-center text-slate-600">
                    <span class="font-medium">Transaction Reference:</span>
                    <span class="font-mono font-bold text-slate-800">{{ $pendingPayment->reference }}</span>
                </div>
                <div class="flex justify-between items-center text-slate-600">
                    <span class="font-medium">Payment Gateway:</span>
                    <span class="font-semibold text-emerald-700 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Official Online Checkout
                    </span>
                </div>
            </div>

            <!-- Payable Total Card -->
            <div class="bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white rounded-2xl p-6 border border-slate-800 shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-400">Total Payable Amount</span>
                        <div class="text-3xl sm:text-4xl font-extrabold text-white mt-1 tracking-tight font-serif-title">
                            ₦{{ number_format($feeConfig['amount']) }}
                        </div>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="inline-flex items-center gap-1 text-[11px] text-emerald-400 font-semibold">
                            &check; Instant Automated Portal Activation
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Channels & Security Banner -->
        <div class="py-6 border-b border-slate-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50 border border-slate-200 rounded-2xl p-4 sm:p-5">
                <div>
                    <span class="text-xs font-bold text-slate-900 block">Accepted Payment Methods:</span>
                    <span class="text-[11.5px] text-slate-600 block mt-0.5">
                        Debit &amp; Credit Cards (Visa, Mastercard, Verve), Bank Transfer (Virtual Account), USSD Codes, Apple Pay.
                    </span>
                </div>
                <div class="shrink-0 flex items-center gap-2 text-slate-400 text-xs font-semibold">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span>256-Bit SSL Encrypted</span>
                </div>
            </div>
        </div>

        <!-- Payment Action Form -->
        <div class="pt-8 space-y-4">
            <form action="{{ route('membership.payment.initialize') }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="w-full py-4 sm:py-5 px-6 rounded-2xl font-bold text-sm sm:text-base bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:from-amber-600 hover:to-amber-800 text-white shadow-xl shadow-amber-500/25 transition-all flex items-center justify-center gap-3 cursor-pointer hover:scale-[1.01]"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    <span>Pay ₦{{ number_format($feeConfig['amount']) }} Securely Online &rarr;</span>
                </button>
            </form>

            <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                You will be securely redirected to complete your payment. Once approved, your member credentials and dashboard access will unlock immediately.
            </p>
        </div>

        <!-- Signout Link -->
        <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="hover:text-slate-900 transition font-medium cursor-pointer">
                    &larr; Sign out of this account
                </button>
            </form>

            <span>Need support? <a href="mailto:info@brandsacademy.org" class="text-amber-600 hover:underline font-semibold">info@brandsacademy.org</a></span>
        </div>

    </div>

</section>

@endsection
