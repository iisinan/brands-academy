@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'CAC & Trademark Statutory Fee Calculator | Brands Academy Legal Desk')
@section('page_title', 'Statutory Fee Calculator')

@section('content')
<!-- Hero -->
<section class="bg-slate-900 text-white py-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                Statutory Regulatory Fee Estimator
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black font-serif-title tracking-tight text-white mb-4">
                Statutory CAC, Trademark &amp; IP Fee Calculator
            </h1>
            <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-light mb-6">
                Calculate transparent statutory registry fees, stamp duties, and accredited representation costs. Certified BANF members automatically save 25% across all legal tracks.
            </p>
            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400">
                <a href="{{ route('services.index') }}" class="text-blue-400 hover:underline flex items-center gap-1 font-medium">
                    &larr; Back to Legal Desk Showcase
                </a>
                <span>•</span>
                <a href="{{ route('services.wizard') }}" class="text-amber-400 hover:underline font-medium">
                    Launch Filing Wizard &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Calculator & Nice Class Explorer Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
        <!-- Interactive Calculator Form -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h2 class="text-xl font-bold font-serif-title text-slate-900 mb-6 flex items-center justify-between">
                    <span>1. Select Filing Track &amp; Parameters</span>
                    <span id="calc-member-tag" class="text-xs px-2.5 py-1 rounded-full font-bold {{ $isMember ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                        {{ $isMember ? '25% Member Rate Active' : 'Regular Statutory Rate' }}
                    </span>
                </h2>

                <!-- Filing Track Selection -->
                <div class="space-y-4 mb-6">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Service Track</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="service-selector">
                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 border-blue-600 bg-blue-50/40 cursor-pointer">
                            <input type="radio" name="calc_type" value="cac_business_name" checked class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-bold text-slate-900 text-xs block">CAC Business Name</span>
                                <span class="text-[11px] text-slate-500 font-light">Sole proprietorship or general partnership registration.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer">
                            <input type="radio" name="calc_type" value="cac_company_ltd" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-bold text-slate-900 text-xs block">CAC Private Ltd Company</span>
                                <span class="text-[11px] text-slate-500 font-light">Full corporate entity with shares and directors.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer">
                            <input type="radio" name="calc_type" value="trademark" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-bold text-slate-900 text-xs block">Trademark Registration</span>
                                <span class="text-[11px] text-slate-500 font-light">Brand name, logo, slogan protection with Trade Ministry.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer">
                            <input type="radio" name="calc_type" value="patent" class="mt-0.5 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="font-bold text-slate-900 text-xs block">Patent Application</span>
                                <span class="text-[11px] text-slate-500 font-light">Proprietary invention and mechanical design utility patent.</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Conditional Parameters -->
                <!-- Ltd Company Share Capital -->
                <div id="company-options" class="hidden space-y-3 mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <label class="block text-xs font-bold text-slate-700">Authorized Share Capital (₦)</label>
                    <select id="share-capital-select" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1000000" selected>₦1,000,000 (Standard Startup Share Capital)</option>
                        <option value="5000000">₦5,000,000 (Medium Enterprise - FMCG/Tech)</option>
                        <option value="10000000">₦10,000,000 (High-Volume Enterprise)</option>
                        <option value="50000000">₦50,000,000 (Institutional Corporation)</option>
                    </select>
                    <span class="text-[11px] text-slate-400 block font-light">Higher share capital incurs statutory graduated FIRS stamp duties.</span>
                </div>

                <!-- Trademark Classes Count -->
                <div id="trademark-options" class="hidden space-y-3 mb-6 p-4 rounded-xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-bold text-slate-700">Number of Nice Trademark Classes</label>
                        <span id="classes-count-badge" class="font-bold text-xs text-blue-600 font-mono">1 Class</span>
                    </div>
                    <input type="range" id="trademark-classes-slider" min="1" max="5" value="1" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                    <span class="text-[11px] text-slate-400 block font-light">Each additional trademark class covers separate categories of goods or services.</span>
                </div>

                <!-- Member Discount Toggle -->
                <div class="p-4 rounded-xl bg-amber-50/60 border border-amber-200 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-amber-950 block">Apply 25% Active Member Rate</span>
                        <span class="text-[11px] text-amber-800 font-light">Available to paid, verified members of Brands Academy.</span>
                    </div>
                    <input type="checkbox" id="member-discount-checkbox" @checked($isMember) class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 rounded border-slate-300">
                </div>
            </div>

            <!-- Nice Classification Explorer (Section 2) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 mb-6 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl font-bold font-serif-title text-slate-900">Trademark Nice Class Explorer</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Explore standard international classification classes for your trademark filing.</p>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <input type="text" id="nice-search-input" placeholder="Search classes (e.g. fashion, food, app)..." class="w-full pl-3 pr-3 py-1.5 text-xs rounded-lg border border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-96 overflow-y-auto pr-1" id="nice-classes-list">
                    @foreach($niceClasses as $num => $cl)
                        <div class="nice-class-item p-3.5 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50/30 transition-all text-left group cursor-pointer" data-class="{{ $num }}" data-title="{{ strtolower($cl['title']) }}" data-desc="{{ strtolower($cl['desc']) }}">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-xs font-black text-blue-700 bg-blue-100 px-2 py-0.5 rounded">Class {{ $num }}</span>
                                <span class="text-[10px] text-slate-400 group-hover:text-blue-600 font-semibold">Select Class</span>
                            </div>
                            <h4 class="text-xs font-bold text-slate-900 mb-1">{{ $cl['title'] }}</h4>
                            <p class="text-[11px] text-slate-500 font-light leading-relaxed">{{ $cl['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Live Cost Estimate Sticky Card -->
        <div class="lg:col-span-1 sticky top-24">
            <div class="bg-slate-950 text-white rounded-2xl p-6 sm:p-8 border border-slate-800 shadow-2xl space-y-6">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-amber-400">Estimated Total Fees</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span id="display-final-fee" class="text-3xl sm:text-4xl font-black font-mono text-white">{{ $isMember ? '₦26,250' : '₦35,000' }}</span>
                    </div>
                    <div id="display-discount-callout" class="mt-2 text-[11px] text-emerald-400 font-bold {{ $isMember ? 'block' : 'hidden' }}">
                        ✓ 25% Member Savings Included
                    </div>
                </div>

                <!-- Fee Breakdown Ledger -->
                <div class="space-y-3 pt-4 border-t border-slate-800 text-xs">
                    <div class="flex items-center justify-between text-slate-400">
                        <span>Statutory Registry Duty:</span>
                        <strong id="display-statutory-fee" class="text-white font-mono">₦20,000</strong>
                    </div>
                    <div class="flex items-center justify-between text-slate-400">
                        <span>Legal Counsel &amp; Filing Desk:</span>
                        <strong id="display-counsel-fee" class="text-white font-mono">₦15,000</strong>
                    </div>
                    <div class="flex items-center justify-between text-slate-400">
                        <span>Official Certified Certificate:</span>
                        <strong class="text-emerald-400 font-mono">Included</strong>
                    </div>
                    <div id="display-discount-row" class="flex items-center justify-between text-emerald-400 {{ $isMember ? 'flex' : 'hidden' }}">
                        <span>Member Discount (25%):</span>
                        <strong id="display-savings" class="font-mono">-₦8,750</strong>
                    </div>
                </div>

                <!-- CTA -->
                <div class="pt-4 border-t border-slate-800">
                    <a id="btn-launch-filing" href="{{ route('services.wizard') }}?type=cac_business_name" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shadow-lg transition-all">
                        <span>Launch Official Filing</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <p class="text-center text-[10px] text-slate-500 mt-2">
                        Accredited statutory agents review all submissions prior to payment.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Regulatory & Legal Disclaimer Notice -->
    <div class="mt-12 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-xs text-xs text-slate-600 space-y-3">
        <div class="flex items-center gap-2 font-bold text-slate-900 text-sm">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Legal Desk Notice &amp; Regulatory Disclaimers</span>
        </div>
        <p>
            <strong>1. Institutional Status:</strong> Brands Academy Nigeria Foundation (CAC/IT/No. 7344471) is an incorporated educational foundation, not a law firm. Filings are processed through accredited Corporate Affairs Commission (CAC) and Federal Ministry of Industry, Trade and Investment (FMITI) certified legal practitioners.
        </p>
        <p>
            <strong>2. Fee Itemization:</strong> Statutory government registry fees (CAC availability, registration duties, stamp duties, trademark filing and publication fees) are itemized separately from professional legal counsel and administrative facilitation fees.
        </p>
        <p>
            <strong>3. Regulatory Discretion:</strong> All name reservations, corporate incorporations, and trademark acceptances remain subject to official availability, prior registered conflicts, and statutory discretion of the respective registries.
        </p>
        <p>
            <strong>4. Data Protection:</strong> All personal, corporate, and identification records are processed in strict compliance with the <strong>Nigeria Data Protection Act (NDPA) 2023</strong>.
        </p>
    </div>
</section>

<!-- Reactive Calculator Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const serviceRadios = document.querySelectorAll('input[name="calc_type"]');
    const memberCheckbox = document.getElementById('member-discount-checkbox');
    const shareSelect = document.getElementById('share-capital-select');
    const classesSlider = document.getElementById('trademark-classes-slider');
    const classesBadge = document.getElementById('classes-count-badge');
    const companyOptions = document.getElementById('company-options');
    const trademarkOptions = document.getElementById('trademark-options');

    const displayFinal = document.getElementById('display-final-fee');
    const displayStatutory = document.getElementById('display-statutory-fee');
    const displayCounsel = document.getElementById('display-counsel-fee');
    const displayDiscountRow = document.getElementById('display-discount-row');
    const displaySavings = document.getElementById('display-savings');
    const displayDiscountCallout = document.getElementById('display-discount-callout');
    const memberTag = document.getElementById('calc-member-tag');
    const launchBtn = document.getElementById('btn-launch-filing');

    // Base pricing tables matching ServiceFiling::allPricing()
    const pricing = {
        cac_business_name: { baseStatutory: 20000, baseCounsel: 15000, regularTotal: 35000 },
        cac_company_ltd: { baseStatutory: 40000, baseCounsel: 35000, regularTotal: 75000 },
        trademark: { baseStatutory: 50000, baseCounsel: 35000, regularTotal: 85000 },
        patent: { baseStatutory: 75000, baseCounsel: 45000, regularTotal: 120000 },
    };

    function recalculate() {
        const selectedType = document.querySelector('input[name="calc_type"]:checked').value;
        const isMember = memberCheckbox.checked;

        // Toggle sub-options
        companyOptions.classList.toggle('hidden', selectedType !== 'cac_company_ltd');
        trademarkOptions.classList.toggle('hidden', selectedType !== 'trademark');

        let statutory = pricing[selectedType].baseStatutory;
        let counsel = pricing[selectedType].baseCounsel;

        if (selectedType === 'cac_company_ltd') {
            const capital = parseInt(shareSelect.value, 10);
            if (capital === 5000000) statutory += 15000;
            else if (capital === 10000000) statutory += 30000;
            else if (capital === 50000000) statutory += 80000;
        } else if (selectedType === 'trademark') {
            const classesCount = parseInt(classesSlider.value, 10);
            classesBadge.innerText = classesCount + (classesCount === 1 ? ' Class' : ' Classes');
            statutory += (classesCount - 1) * 35000;
            counsel += (classesCount - 1) * 15000;
        }

        const totalBeforeDiscount = statutory + counsel;
        let finalFee = totalBeforeDiscount;
        let savings = 0;

        if (isMember) {
            savings = Math.round(totalBeforeDiscount * 0.25);
            finalFee = totalBeforeDiscount - savings;
            displayDiscountRow.classList.remove('hidden');
            displayDiscountCallout.classList.remove('hidden');
            displaySavings.innerText = '-₦' + savings.toLocaleString();
            memberTag.className = 'text-xs px-2.5 py-1 rounded-full font-bold bg-emerald-100 text-emerald-800';
            memberTag.innerText = '25% Member Rate Active';
        } else {
            displayDiscountRow.classList.add('hidden');
            displayDiscountCallout.classList.add('hidden');
            memberTag.className = 'text-xs px-2.5 py-1 rounded-full font-bold bg-slate-100 text-slate-600';
            memberTag.innerText = 'Regular Statutory Rate';
        }

        displayStatutory.innerText = '₦' + statutory.toLocaleString();
        displayCounsel.innerText = '₦' + counsel.toLocaleString();
        displayFinal.innerText = '₦' + finalFee.toLocaleString();

        let wizardUrl = `{{ route('services.wizard') }}?type=${selectedType}`;
        if (selectedType === 'trademark') {
            wizardUrl += `&trademark_class=Class ${classesSlider.value}`;
        }
        launchBtn.href = wizardUrl;
    }

    serviceRadios.forEach(r => r.addEventListener('change', function () {
        document.querySelectorAll('#service-selector label').forEach(l => {
            l.className = 'flex items-start gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-slate-300 cursor-pointer';
        });
        this.closest('label').className = 'flex items-start gap-3 p-4 rounded-xl border-2 border-blue-600 bg-blue-50/40 cursor-pointer';
        recalculate();
    }));

    memberCheckbox.addEventListener('change', recalculate);
    shareSelect.addEventListener('change', recalculate);
    classesSlider.addEventListener('input', recalculate);

    // Search Nice classes
    const searchInput = document.getElementById('nice-search-input');
    const classItems = document.querySelectorAll('.nice-class-item');

    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        classItems.forEach(item => {
            const title = item.getAttribute('data-title');
            const desc = item.getAttribute('data-desc');
            const num = item.getAttribute('data-class');
            const match = num.includes(query) || title.includes(query) || desc.includes(query);
            item.style.display = match ? 'block' : 'none';
        });
    });

    // Selecting a Nice class card
    classItems.forEach(item => {
        item.addEventListener('click', function () {
            const classNum = this.getAttribute('data-class');
            // Switch to trademark
            const tmRadio = document.querySelector('input[name="calc_type"][value="trademark"]');
            if (tmRadio) {
                tmRadio.checked = true;
                tmRadio.dispatchEvent(new Event('change'));
                window.scrollTo({ top: 300, behavior: 'smooth' });
            }
        });
    });

    recalculate();
});
</script>
@endsection
