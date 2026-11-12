@extends('layouts.app')

@section('title', 'Brand IP & CAC Registration Desk | Brands Academy')

@section('content')
<div class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Accredited Legal & IP Operations Desk
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-4">
                Brand Intellectual Property & CAC Business Registration
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed mb-6 font-light">
                Secure your venture's legal identity, trademark your brand name, and protect proprietary product designs with the Corporate Affairs Commission (CAC) and the Federal Ministry of Trade & Investment.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('services.wizard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-md hover:shadow-lg transition-all text-sm">
                    <span>Initiate Legal Filing</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
                <a href="{{ route('services.track') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-medium border border-slate-700 text-sm transition-all">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Track Existing Filing</span>
                </a>
                <a href="{{ route('services.calculator') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-amber-300 font-medium border border-amber-500/30 text-sm transition-all">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>Statutory Fee Calculator</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Instant Brand Name & Trademark Pre-Check Widget -->
<div class="max-w-4xl mx-auto -mt-8 px-4 sm:px-6 relative z-10">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <div>
                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">Fast Registry Search</span>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Instant Brand Name &amp; Trademark Pre-Check</h3>
                <p class="text-xs text-slate-500 mt-0.5">Check if your proposed business name or trademark has conflict in our registry database.</p>
            </div>
            <div class="flex items-center gap-1.5 text-xs text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-200 shrink-0">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="font-bold">Live Registry Pre-Check</span>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" id="precheck-name-input" placeholder="Enter proposed brand or business name (e.g. Zenith Analytics)..." class="w-full pl-10 pr-4 py-3 text-xs sm:text-sm rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
            </div>
            <button type="button" id="precheck-submit-btn" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all shrink-0">
                Check Availability
            </button>
        </div>

        <!-- Result Box -->
        <div id="precheck-result-box" class="mt-4 hidden p-4 rounded-xl border text-xs leading-relaxed"></div>
    </div>
</div>

<!-- Active Member Discount Alert -->
<div class="bg-amber-500/10 border-b border-amber-500/20 py-3 mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between text-xs sm:text-sm text-amber-900">
        <div class="flex items-center gap-2 font-medium">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            <span><strong>Brands Academy Member Advantage:</strong> Certified members enjoy an automatic <strong>25% legal fee discount</strong> across all CAC, Trademark, and Patent filings.</span>
        </div>
        <a href="{{ route('membership.register') }}" class="underline font-bold text-amber-950 hover:text-black hidden md:inline">Learn about Membership &rarr;</a>
    </div>
</div>

<!-- Main Services Grid -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center max-w-3xl mx-auto mb-14">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-3">
            Accredited Legal & IP Protection Tracks
        </h2>
        <p class="text-sm sm:text-base text-slate-600">
            End-to-end statutory representation managed by certified legal practitioners. Transparent pricing, no hidden costs.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($allPricing as $key => $plan)
            @php $cost = $pricingDetails[$key]; @endphp
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl transition-all flex flex-col justify-between group">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                            {{ $plan['badge'] }}
                        </span>
                        <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $plan['timeline'] }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-3">
                        {{ $plan['title'] }}
                    </h3>

                    <p class="text-xs text-slate-600 leading-relaxed mb-6 font-light">
                        {{ $plan['description'] }}
                    </p>

                    <div class="pt-6 border-t border-slate-100 mb-6">
                        <div class="text-xs text-slate-500 mb-1">Statutory & Professional Fee</div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl sm:text-3xl font-black text-slate-900">
                                ₦{{ number_format($cost['final_fee'], 0) }}
                            </span>
                            @if($cost['is_member'])
                                <span class="text-xs text-slate-400 line-through">₦{{ number_format($cost['regular_fee'], 0) }}</span>
                                <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">Member Rate (25% Off)</span>
                            @else
                                <span class="text-xs text-slate-500">Regular Rate</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-2 text-xs text-slate-600 mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Preliminary Name & Availability Search</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Statutory Government Stamp Duties & Filings</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>Digital Certificate & Certified Status Report</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 pt-0">
                    <a href="{{ route('services.wizard', ['type' => $key]) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs transition-colors shadow-sm">
                        <span>Start Filing for {{ $plan['title'] }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- 5-Step Process Section -->
<div class="bg-slate-50 border-t border-b border-slate-200 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl font-extrabold text-slate-900">How Our Legal Operations Desk Works</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">Zero bureaucracy. We interface directly with Nigerian regulatory bodies on your behalf.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs relative">
                <span class="text-2xl font-black text-amber-500 mb-2 block">01</span>
                <h4 class="text-sm font-bold text-slate-900 mb-1">Submit Details</h4>
                <p class="text-xs text-slate-500">Provide 3 proposed business names and upload valid identification.</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs relative">
                <span class="text-2xl font-black text-amber-500 mb-2 block">02</span>
                <h4 class="text-sm font-bold text-slate-900 mb-1">Pay Fee</h4>
                <p class="text-xs text-slate-500">Secure checkout via Paystack / SquadCo with instant receipt generation.</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs relative">
                <span class="text-2xl font-black text-amber-500 mb-2 block">03</span>
                <h4 class="text-sm font-bold text-slate-900 mb-1">Registry Search</h4>
                <p class="text-xs text-slate-500">Our accredited counsel conducts availability search and name reservation.</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs relative">
                <span class="text-2xl font-black text-amber-500 mb-2 block">04</span>
                <h4 class="text-sm font-bold text-slate-900 mb-1">Audit & Review</h4>
                <p class="text-xs text-slate-500">Registry audit of articles, share structure, and specimen signatures.</p>
            </div>
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-2xs relative">
                <span class="text-2xl font-black text-amber-500 mb-2 block">05</span>
                <h4 class="text-sm font-bold text-slate-900 mb-1">Certificate Issued</h4>
                <p class="text-xs text-slate-500">Official government certificate and certified status report issued.</p>
            </div>
        </div>

        <!-- Regulatory & Legal Desk Disclaimer -->
        <div class="mt-12 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs text-xs text-slate-600 space-y-3">
            <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Legal Desk Notice &amp; Regulatory Disclaimers</span>
            </div>
            <p>
                <strong>1. Institutional Status:</strong> Brands Academy Nigeria Foundation (CAC/IT/No. 7344471) is an incorporated educational foundation, not a law firm. Filings are processed through accredited Corporate Affairs Commission (CAC) and Federal Ministry of Industry, Trade and Investment (FMITI) certified legal practitioners.
            </p>
            <p>
                <strong>2. Fee Transparency:</strong> Statutory government fees (CAC availability, registration duties, stamp duties, trademark filing and publication fees) are itemized separately from legal counsel and administrative facilitation fees.
            </p>
            <p>
                <strong>3. Regulatory Discretion:</strong> All name reservations, corporate incorporations, and trademark acceptances remain subject to official availability, prior registered conflicts, and statutory discretion of the respective registries.
            </p>
            <p>
                <strong>4. Data Protection:</strong> All personal, corporate, and identification records are processed in strict compliance with the <strong>Nigeria Data Protection Act (NDPA) 2023</strong>.
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('precheck-name-input');
    const btn = document.getElementById('precheck-submit-btn');
    const resultBox = document.getElementById('precheck-result-box');

    async function runCheck() {
        const name = input.value.trim();
        if (!name) {
            resultBox.className = 'mt-4 p-4 rounded-xl border border-amber-300 bg-amber-50 text-amber-900 text-xs';
            resultBox.innerHTML = '<span class="font-bold">Please enter a name to check.</span>';
            resultBox.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.innerText = 'Searching...';
        resultBox.classList.add('hidden');

        try {
            const res = await fetch(`{{ route('services.precheck') }}?name=${encodeURIComponent(name)}`);
            const data = await res.json();

            resultBox.classList.remove('hidden');
            if (data.available) {
                resultBox.className = 'mt-4 p-4 rounded-xl border border-emerald-300 bg-emerald-50 text-emerald-950 text-xs';
                resultBox.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</div>
                        <div class="space-y-1">
                            <div class="font-bold text-sm text-emerald-900">Name is available for reservation!</div>
                            <p>${data.message}</p>
                            <div class="pt-2">
                                <a href="{{ route('services.wizard') }}?proposed_name_1=${encodeURIComponent(name)}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-xs transition-colors">
                                    <span>Proceed to File "${name}"</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                let similarList = '';
                if (data.similar && data.similar.length > 0) {
                    similarList = '<div class="mt-2 text-[11px] text-amber-800">Similar existing filings: <span class="font-semibold">' + data.similar.join(', ') + '</span></div>';
                }
                resultBox.className = 'mt-4 p-4 rounded-xl border border-amber-300 bg-amber-50 text-amber-950 text-xs';
                resultBox.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">!</div>
                        <div class="space-y-1">
                            <div class="font-bold text-sm text-amber-900">Potential Registry Conflict Detected (${data.matches_count} matches)</div>
                            <p>${data.message}</p>
                            ${similarList}
                            <div class="pt-2">
                                <a href="{{ route('services.wizard') }}?proposed_name_1=${encodeURIComponent(name)}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs shadow-xs transition-colors">
                                    <span>File with Alternative Options (Names 2 & 3)</span>
                                    <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }
        } catch (err) {
            resultBox.className = 'mt-4 p-4 rounded-xl border border-rose-300 bg-rose-50 text-rose-900 text-xs';
            resultBox.innerHTML = '<span class="font-bold">Search failed. Please try again.</span>';
            resultBox.classList.remove('hidden');
        } finally {
            btn.disabled = false;
            btn.innerText = 'Check Availability';
        }
    }

    btn.addEventListener('click', runCheck);
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            runCheck();
        }
    });
});
</script>
@endsection
