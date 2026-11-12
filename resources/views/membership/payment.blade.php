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

        <!-- Payment Channels Selection & Actions -->
        <div class="pt-8" x-data="{ method: 'online' }">
            @if ($pendingPayment && $pendingPayment->status === 'under_review')
                <!-- Transfer Under Review Banner -->
                <div class="bg-amber-50 border border-amber-300 rounded-2xl p-5 mb-8 text-amber-950">
                    <div class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-full bg-amber-200 text-amber-900 flex items-center justify-center font-bold text-sm shrink-0">⏳</span>
                        <div>
                            <h4 class="font-bold text-sm">Direct Bank Transfer Under Secretariat Review</h4>
                            <p class="text-xs text-amber-900/80 mt-1 leading-relaxed">
                                We received your transfer receipt (Ref: <strong class="font-mono text-amber-950">{{ $pendingPayment->reference }}</strong>). The Kaduna secretariat is verifying the deposit. Verification normally takes within 1 to 24 business hours. Once verified, your membership ID will be minted and full portal privileges unlocked.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tabs: Online vs Bank Transfer -->
            <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-slate-100 border border-slate-200 mb-6">
                <button type="button" 
                        @click="method = 'online'"
                        class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer"
                        :class="method === 'online' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Option 1: Pay Online (Instant Activation)</span>
                </button>
                <button type="button" 
                        @click="method = 'transfer'"
                        class="flex-1 py-2.5 px-4 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 cursor-pointer"
                        :class="method === 'transfer' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-600 hover:text-slate-900'">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    <span>Option 2: Direct Bank Transfer (Fallback)</span>
                </button>
            </div>

            <!-- Tab 1: Pay Online -->
            <div x-show="method === 'online'" class="space-y-4">
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
                    Debit &amp; Credit Cards (Visa, Mastercard, Verve), Bank Transfer, USSD Codes. Instant automated activation upon successful confirmation.
                </p>
            </div>

            <!-- Tab 2: Bank Transfer Fallback Form -->
            <div x-show="method === 'transfer'" x-cloak class="space-y-6">
                <!-- Foundation Bank Details Box -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-3">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-800">Foundation Bank Account Details</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800">Kaduna Secretariat</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-500 block">Bank Name</span>
                            <span class="font-bold text-slate-900 text-sm block mt-0.5">{{ $bankDetails['bank_name'] ?? 'Zenith Bank Plc' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Account Name</span>
                            <span class="font-bold text-slate-900 text-sm block mt-0.5">{{ $bankDetails['account_name'] ?? 'Brands Academy Nigeria Foundation' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Account Number</span>
                            <span class="font-mono font-extrabold text-slate-900 text-base block mt-0.5 tracking-wider">{{ $bankDetails['account_number'] ?? '1012345678' }}</span>
                        </div>
                        <div>
                            <span class="text-slate-500 block">Payment Narrative / Ref</span>
                            <span class="font-mono font-bold text-amber-700 text-sm block mt-0.5">{{ $pendingPayment->reference }}</span>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-200">
                        Please include your reference <strong class="font-mono text-slate-700">{{ $pendingPayment->reference }}</strong> in your bank transfer narration so the secretariat can locate your payment quickly.
                    </p>
                </div>

                <!-- Proof of Payment Upload Form -->
                <form action="{{ route('membership.payment.bank-transfer') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-5 space-y-4 shadow-xs">
                    @csrf
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-1">Submit Proof of Transfer</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sender Full Name *</label>
                            <input type="text" name="sender_name" required value="{{ old('sender_name', $member->full_name) }}" placeholder="Name on your bank account" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Sending Bank *</label>
                            <input type="text" name="sender_bank" required value="{{ old('sender_bank') }}" placeholder="e.g. GTBank, Access Bank, Zenith" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Bank Session / Reference ID</label>
                            <input type="text" name="transfer_reference" value="{{ old('transfer_reference') }}" placeholder="e.g. 000013240822..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Transfer Date</label>
                            <input type="date" name="transfer_date" value="{{ old('transfer_date', date('Y-m-d')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs text-slate-900 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Upload Receipt / Transfer Screenshot (JPEG, PNG, or PDF, max 5MB) *</label>
                        <input type="file" name="payment_proof" accept="image/jpeg,image/png,image/jpg,application/pdf" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs text-slate-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-amber-400 hover:file:bg-slate-800 cursor-pointer">
                    </div>

                    <button type="submit" class="w-full py-3.5 px-5 rounded-xl font-bold text-xs bg-slate-900 hover:bg-slate-800 text-amber-400 shadow-md transition flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Submit Transfer Receipt for Verification &rarr;</span>
                    </button>
                </form>
            </div>
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
