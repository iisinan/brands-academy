@extends('layouts.app')

@section('title', 'Annual Membership Dues - Brands Academy Nigeria Foundation')

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes pulseRing {
        0% { transform: scale(0.95); opacity: 0.8; }
        50% { transform: scale(1.08); opacity: 0.3; }
        100% { transform: scale(0.95); opacity: 0.8; }
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

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-500/15 text-amber-400 border border-amber-500/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    Annual Dues &amp; Activation &bull; {{ $member->member_number }}
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold font-serif-title tracking-tight text-white">
                    Membership Activation &amp; Dues
                </h1>
                <p class="text-slate-300 text-sm sm:text-base mt-2 max-w-2xl font-light">
                    Finalize your annual foundation dues to immediately unlock your <strong>Member Portal</strong>, open cohort applications, digital credential card, and mentorship network.
                </p>
            </div>

            <!-- Portal Locked Status Badge -->
            <div class="bg-slate-800/80 border border-slate-700/80 p-4 rounded-2xl shrink-0 text-right sm:text-right flex sm:flex-col justify-between items-center sm:items-end">
                <span class="text-[11px] uppercase tracking-wider font-bold text-slate-400">Portal Access</span>
                @if ($member->isUnderReview())
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> Under Verification
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30">
                        <span class="w-2 h-2 rounded-full bg-rose-400"></span> Locked Until Paid
                    </span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Checkout Section -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14" x-data="{ paymentMethod: 'paystack', copiedField: null }">

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
                <span class="font-bold block">Payment Required</span>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl mb-8 text-sm font-medium anim-check-pop flex items-start gap-3 shadow-xs">
            <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <div>
                <span class="font-bold block">Payment Alert</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if ($member->isUnderReview())
        <!-- Under Review Callout -->
        <div class="bg-gradient-to-r from-amber-50 via-amber-100/50 to-amber-50 border-2 border-amber-300 rounded-3xl p-6 sm:p-8 mb-10 shadow-md">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-900 flex items-center justify-center font-bold text-xl shrink-0 shadow-md shadow-amber-500/20">
                        &#9203;
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Bank Transfer Verification In Progress</h3>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-2xl leading-relaxed">
                            Your payment slip for Reference <strong>{{ $member->payment_reference ?? $pendingPayment->reference }}</strong> has been received by the Secretariat. Our accounts desk will verify the credit and activate your dashboard access within 24 business hours.
                        </p>
                        @if ($member->payment_proof)
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $member->payment_proof) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-700 hover:text-amber-800 underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    View Uploaded Transfer Proof
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white/80 border border-amber-200/80 px-4 py-3 rounded-2xl text-center shrink-0">
                    <div class="text-[11px] uppercase tracking-wider text-slate-500 font-bold">Estimated Turnaround</div>
                    <div class="text-sm font-extrabold text-amber-700 mt-0.5">&le; 24 Business Hours</div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
        
        <!-- Left Column: Member Credential & Order Summary (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Summary Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-xl relative overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0"></div>

                <div class="flex items-center justify-between pb-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <x-brand-logo class="w-10 h-10" />
                        <div>
                            <div class="text-xs font-bold text-slate-900 uppercase tracking-wider">Brands Academy</div>
                            <div class="text-[10px] text-amber-600 font-bold uppercase tracking-widest">Nigeria Foundation</div>
                        </div>
                    </div>
                    <span class="text-[10px] font-mono font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md border border-slate-200">
                        {{ $member->member_number }}
                    </span>
                </div>

                <!-- Member Profile Brief -->
                <div class="py-5 border-b border-slate-100 text-xs space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Member Name:</span>
                        <span class="font-bold text-slate-900">{{ $member->full_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Account Email:</span>
                        <span class="font-mono font-semibold text-slate-800">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Category Tier:</span>
                        <span class="font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md text-[11px]">
                            {{ $feeConfig['label'] }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 font-medium">Payment Reference:</span>
                        <span class="font-mono font-bold text-slate-800 text-[11.5px]">{{ $pendingPayment->reference }}</span>
                    </div>
                </div>

                <!-- Pricing Breakdown -->
                <div class="pt-5 space-y-4">
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 text-xs">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-slate-900">{{ $feeConfig['label'] }} Annual Dues</span>
                            <span class="font-extrabold text-slate-900 text-sm">₦{{ number_format($feeConfig['amount']) }}</span>
                        </div>
                        <p class="text-slate-500 text-[11px] leading-relaxed mt-1">
                            {{ $feeConfig['description'] }}
                        </p>
                    </div>

                    <!-- Total Due Banner -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-5 rounded-2xl border border-slate-800 shadow-md">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400">Total Payable Amount</span>
                                <div class="text-2xl sm:text-3xl font-extrabold text-white mt-0.5 tracking-tight font-serif-title">
                                    ₦{{ number_format($feeConfig['amount']) }}
                                </div>
                            </div>
                            <span class="text-[11px] font-medium text-slate-400 pb-1">Valid for 1 Year</span>
                        </div>
                    </div>
                </div>

                <!-- Membership Benefits Unlocked -->
                <div class="mt-6 pt-5 border-t border-slate-100 text-xs">
                    <div class="font-bold text-slate-900 mb-2">Benefits Unlocked Upon Payment:</div>
                    <ul class="space-y-1.5 text-slate-600 text-[11.5px]">
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Full <strong>Member Dashboard</strong> access</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Official <strong>Digital Membership ID Card</strong> with dynamic QR</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Eligibility for open CBA &amp; CBS Cohort masterclasses</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>Tamper-proof Certificate issuance &amp; verification</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sign Out Option -->
            <div class="text-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-slate-500 hover:text-slate-800 transition font-medium cursor-pointer">
                        &larr; Sign out of this account
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Payment Channels (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xl relative overflow-hidden">
                <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0"></div>

                <div class="mb-6">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title tracking-tight">Select Payment Method</h2>
                    <p class="text-xs text-slate-500 mt-1">Choose between instant online payment or direct foundation bank transfer.</p>
                </div>

                <!-- Payment Method Selector Tabs -->
                <div class="grid grid-cols-2 gap-3 mb-8 p-1.5 bg-slate-100 rounded-2xl border border-slate-200">
                    <button 
                        type="button"
                        @click="paymentMethod = 'paystack'"
                        :class="paymentMethod === 'paystack' ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-600 font-medium hover:text-slate-900'"
                        class="py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <span>Card / Paystack (Instant)</span>
                    </button>

                    <button 
                        type="button"
                        @click="paymentMethod = 'bank_transfer'"
                        :class="paymentMethod === 'bank_transfer' ? 'bg-white text-slate-900 shadow-md font-bold' : 'text-slate-600 font-medium hover:text-slate-900'"
                        class="py-3 px-4 rounded-xl text-xs flex items-center justify-center gap-2 transition cursor-pointer"
                    >
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                        </svg>
                        <span>Direct Bank Transfer</span>
                    </button>
                </div>

                <!-- TAB 1: Paystack Online Payment -->
                <div x-show="paymentMethod === 'paystack'" x-cloak class="space-y-6">
                    <div class="bg-emerald-50/70 border border-emerald-200/80 rounded-2xl p-5 text-xs text-emerald-950 space-y-2">
                        <div class="flex items-center gap-2 font-bold text-emerald-900 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            Instant Automated Activation
                        </div>
                        <p class="leading-relaxed text-emerald-800">
                            Pay securely with your <strong>Debit Card</strong>, <strong>Bank Transfer</strong>, <strong>USSD</strong>, or <strong>Apple Pay</strong> via Paystack. Your transaction will be verified in real time, and your member dashboard will unlock immediately.
                        </p>
                    </div>

                    <div class="border border-slate-200 rounded-2xl p-5 text-xs space-y-3">
                        <div class="flex items-center justify-between text-slate-700">
                            <span>Amount to Charge:</span>
                            <span class="font-extrabold text-slate-900 text-sm font-mono">₦{{ number_format($feeConfig['amount']) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-700">
                            <span>Transaction Reference:</span>
                            <span class="font-mono font-bold text-slate-800">{{ $pendingPayment->reference }}</span>
                        </div>
                        <div class="flex items-center justify-between text-slate-700">
                            <span>Channel Security:</span>
                            <span class="font-semibold text-emerald-700 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                256-Bit SSL Encrypted
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('membership.payment.initialize') }}" method="POST">
                        @csrf
                        <button 
                            type="submit"
                            class="w-full py-4 px-6 rounded-2xl font-bold text-sm bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 hover:from-amber-600 hover:to-amber-800 text-white shadow-xl shadow-amber-500/25 transition flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Pay ₦{{ number_format($feeConfig['amount']) }} Online via Paystack &rarr;
                        </button>
                    </form>

                    <p class="text-[11px] text-slate-400 text-center">
                        You will be securely redirected to complete payment and immediately returned to your portal.
                    </p>
                </div>

                <!-- TAB 2: Direct Foundation Bank Transfer -->
                <div x-show="paymentMethod === 'bank_transfer'" x-cloak class="space-y-6">
                    
                    <div class="bg-amber-50/80 border border-amber-200/90 rounded-2xl p-5 text-xs text-amber-950 space-y-2">
                        <div class="flex items-center gap-2 font-bold text-amber-900 text-sm">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            Step 1: Transfer to Official Foundation Account
                        </div>
                        <p class="leading-relaxed text-amber-800">
                            Transfer exact dues of <strong>₦{{ number_format($feeConfig['amount']) }}</strong> to the foundation's corporate bank account. Use your <strong>Payment Reference</strong> or <strong>Member Number</strong> as your transfer remark/narration.
                        </p>
                    </div>

                    <!-- Foundation Bank Details Box -->
                    <div class="bg-slate-900 text-white rounded-2xl p-6 border border-slate-800 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <span class="text-xs uppercase font-bold tracking-wider text-amber-400">Official Foundation Account</span>
                            <span class="text-[10px] font-semibold text-slate-400">{{ $bankDetails['bank_name'] }}</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block text-[11px]">Bank Name</span>
                                <span class="font-bold text-white text-sm">{{ $bankDetails['bank_name'] }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Account Name</span>
                                <span class="font-bold text-white text-sm">{{ $bankDetails['account_name'] }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Account Number</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="font-mono font-extrabold text-amber-300 text-lg">{{ $bankDetails['account_number'] }}</span>
                                    <button 
                                        type="button" 
                                        @click="navigator.clipboard.writeText('{{ $bankDetails['account_number'] }}'); copiedField = 'acc'; setTimeout(() => copiedField = null, 2000)"
                                        class="px-2 py-1 rounded bg-slate-800 hover:bg-slate-700 text-[10px] font-bold text-slate-300 transition cursor-pointer"
                                        x-text="copiedField === 'acc' ? 'Copied!' : 'Copy'"
                                    ></button>
                                </div>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[11px]">Required Narration / Reference</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="font-mono font-bold text-white text-sm">{{ $pendingPayment->reference }}</span>
                                    <button 
                                        type="button" 
                                        @click="navigator.clipboard.writeText('{{ $pendingPayment->reference }}'); copiedField = 'ref'; setTimeout(() => copiedField = null, 2000)"
                                        class="px-2 py-1 rounded bg-slate-800 hover:bg-slate-700 text-[10px] font-bold text-slate-300 transition cursor-pointer"
                                        x-text="copiedField === 'ref' ? 'Copied!' : 'Copy'"
                                    ></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Upload Proof Form -->
                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="text-sm font-bold text-slate-900 mb-1">Step 2: Upload Transfer Receipt / Proof</h3>
                        <p class="text-xs text-slate-500 mb-4">Once you have completed the transfer, upload your payment receipt below for confirmation.</p>

                        <form action="{{ route('membership.payment.bank-transfer') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Sender / Depositor Name <span class="text-rose-500">*</span></label>
                                    <input 
                                        type="text" 
                                        name="sender_name" 
                                        value="{{ old('sender_name', $member->full_name) }}"
                                        required 
                                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none"
                                        placeholder="Full name on sender account"
                                    >
                                    @error('sender_name')
                                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Sender Bank Name <span class="text-rose-500">*</span></label>
                                    <input 
                                        type="text" 
                                        name="sender_bank" 
                                        value="{{ old('sender_bank') }}"
                                        required 
                                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none"
                                        placeholder="e.g. GTBank, Kuda, Access Bank"
                                    >
                                    @error('sender_bank')
                                        <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Transfer Session ID / Bank Reference</label>
                                    <input 
                                        type="text" 
                                        name="transfer_reference" 
                                        value="{{ old('transfer_reference') }}"
                                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none"
                                        placeholder="Session ID or transaction reference"
                                    >
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Date of Transfer</label>
                                    <input 
                                        type="date" 
                                        name="transfer_date" 
                                        value="{{ old('transfer_date', date('Y-m-d')) }}"
                                        class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none"
                                    >
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Upload Receipt / Payment Slip (PNG, JPG, PDF &bull; Max 5MB) <span class="text-rose-500">*</span></label>
                                <input 
                                    type="file" 
                                    name="payment_proof" 
                                    required 
                                    accept=".png,.jpg,.jpeg,.pdf"
                                    class="w-full text-xs px-3 py-2 border border-slate-300 rounded-xl file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-amber-400 hover:file:bg-slate-800 cursor-pointer"
                                >
                                @error('payment_proof')
                                    <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button 
                                type="submit"
                                class="w-full py-3.5 px-5 rounded-2xl font-bold text-xs uppercase tracking-wider bg-slate-900 hover:bg-slate-800 text-amber-400 hover:text-amber-300 border border-slate-800 transition shadow-md flex items-center justify-center gap-2 cursor-pointer mt-4"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Submit Transfer Receipt for Verification
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection
