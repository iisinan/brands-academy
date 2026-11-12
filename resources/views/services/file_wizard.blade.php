@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('title', 'Initiate Legal & IP Filing | Brands Academy')
@section('page_title', 'Client Filing Intake Desk')

@section('content')
<div class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('services.index') }}" class="text-xs text-amber-400 hover:underline flex items-center gap-1 mb-2 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Legal Showcase
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">
            Client Filing Intake Desk
        </h1>
        <p class="text-xs sm:text-sm text-slate-300 mt-1 font-light">
            Complete the 5 sections below. Our certified legal counsel will inspect and lodge your statutory filing.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if ($errors->any())
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-8 rounded-r-xl">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h3 class="text-xs font-bold text-rose-800">Please review the form errors:</h3>
                    <ul class="list-disc list-inside text-xs text-rose-700 mt-1 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- SECTION 1: Service Type -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">1</span>
                <h2 class="text-lg font-bold text-slate-900">Select Filing Track</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($allPricing as $key => $plan)
                    @php
                        $isSelected = (old('filing_type', $selectedType) === $key);
                    @endphp
                    <label class="relative flex flex-col p-4 rounded-xl border-2 cursor-pointer transition-all {{ $isSelected ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200 hover:border-slate-300' }}">
                        <input type="radio" name="filing_type" value="{{ $key }}" class="sr-only" {{ $isSelected ? 'checked' : '' }} onchange="window.location.href = '{{ route('services.wizard') }}?type=' + this.value">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-900">{{ $plan['title'] }}</span>
                            <span class="text-[11px] font-semibold text-blue-700 bg-blue-100 px-2 py-0.5 rounded">
                                {{ $plan['timeline'] }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 mb-3 font-light">{{ $plan['description'] }}</p>
                        <div class="mt-auto flex items-baseline gap-2">
                            <span class="text-base font-extrabold text-slate-900">₦{{ number_format($pricing['final_fee'], 0) }}</span>
                            @if($pricing['is_member'])
                                <span class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded">25% Member Rate</span>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- SECTION 2: Proposed Names & Business Description -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">2</span>
                <h2 class="text-lg font-bold text-slate-900">Proposed Business / Brand Names</h2>
            </div>
            <p class="text-xs text-slate-500 mb-6 font-light">
                Provide up to three (3) name options in order of preference. In the event your first choice is unavailable or restricted by CAC/IPO, option 2 or 3 will be reserved.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Option 1 (Primary Choice) *</label>
                    <input type="text" name="proposed_name_1" value="{{ old('proposed_name_1', request()->query('proposed_name_1')) }}" required placeholder="e.g. Acme Brand Consulting" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Option 2 (Alternative)</label>
                    <input type="text" name="proposed_name_2" value="{{ old('proposed_name_2') }}" placeholder="e.g. Acme Brand Services" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Option 3 (Alternative)</label>
                    <input type="text" name="proposed_name_3" value="{{ old('proposed_name_3') }}" placeholder="e.g. Acme Creative Agency" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Industry / Sector</label>
                    <input type="text" name="industry_category" value="{{ old('industry_category') }}" placeholder="e.g. Marketing, FMCG, Technology, Retail" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @if($selectedType === 'trademark')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Trademark Class (Nice Classification, if known)</label>
                        <input type="text" name="trademark_class" value="{{ old('trademark_class') }}" placeholder="e.g. Class 35 (Advertising) or Class 42 (Tech)" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @elseif($selectedType === 'cac_company_ltd')
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Authorized Share Capital</label>
                        <input type="text" name="share_capital" value="{{ old('share_capital', '₦1,000,000') }}" placeholder="e.g. ₦1,000,000" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                @endif
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Nature & Principal Objects of Business *</label>
                <textarea name="business_nature" rows="3" required placeholder="Describe in 2-3 sentences what products or services your enterprise provides..." class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">{{ old('business_nature') }}</textarea>
            </div>
        </div>

        <!-- SECTION 3: Client / Applicant Details -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">3</span>
                <h2 class="text-lg font-bold text-slate-900">Applicant / Proprietor Information</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">First Name *</label>
                    <input type="text" name="client_first_name" value="{{ old('client_first_name', $user?->member?->first_name ?: $user?->name) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Last Name *</label>
                    <input type="text" name="client_last_name" value="{{ old('client_last_name', $user?->member?->last_name) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address *</label>
                    <input type="email" name="client_email" value="{{ old('client_email', $user?->email) }}" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Phone Number *</label>
                    <input type="text" name="client_phone" value="{{ old('client_phone', $user?->member?->phone) }}" required placeholder="+234 80..." class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">National ID Number (NIN)</label>
                    <input type="text" name="client_nin" value="{{ old('client_nin') }}" placeholder="11-digit NIN" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Business Operating Address *</label>
                    <input type="text" name="business_address" value="{{ old('business_address') }}" required placeholder="Physical office or residence address" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Headquarters State *</label>
                    <input type="text" name="headquarters_state" value="{{ old('headquarters_state', 'Lagos') }}" required placeholder="e.g. Lagos, Abuja, Kaduna" class="w-full text-xs rounded-lg border-slate-300 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- SECTION 4: Upload Verification Documents -->
        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-7 h-7 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center">4</span>
                <h2 class="text-lg font-bold text-slate-900">Upload Verification Documents</h2>
            </div>
            <p class="text-xs text-slate-500 mb-6 font-light">
                Regulatory compliance requires clear copies of applicant credentials (JPG, PNG, or PDF).
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50">
                    <label class="block text-xs font-bold text-slate-800 mb-1">National ID / NIN Slip</label>
                    <p class="text-[11px] text-slate-500 mb-2">Government-issued identity card or NIMC slip.</p>
                    <input type="file" name="nin_slip" accept=".pdf,.jpg,.jpeg,.png" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50">
                    <label class="block text-xs font-bold text-slate-800 mb-1">Passport Photograph</label>
                    <p class="text-[11px] text-slate-500 mb-2">Clear portrait with white background.</p>
                    <input type="file" name="passport_photo" accept=".jpg,.jpeg,.png" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50">
                    <label class="block text-xs font-bold text-slate-800 mb-1">Specimen Signature</label>
                    <p class="text-[11px] text-slate-500 mb-2">Signed on a blank white sheet and photographed.</p>
                    <input type="file" name="signature_specimen" accept=".pdf,.jpg,.jpeg,.png" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="p-4 rounded-xl border border-dashed border-slate-300 bg-slate-50">
                    <label class="block text-xs font-bold text-slate-800 mb-1">Brand Logo / Trademark Artwork</label>
                    <p class="text-[11px] text-slate-500 mb-2">Optional for CAC BN; required for Trademark / Device mark.</p>
                    <input type="file" name="trademark_logo" accept=".pdf,.jpg,.jpeg,.png" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
            </div>
        </div>

        <!-- SECTION 5: Fee Summary & Submission -->
        <div class="bg-slate-900 text-white rounded-2xl p-6 sm:p-8 shadow-md">
            <div class="flex items-center gap-2 mb-6">
                <span class="w-7 h-7 rounded-full bg-amber-500 text-slate-950 font-bold text-xs flex items-center justify-center">5</span>
                <h2 class="text-lg font-bold text-white">Summary & Transparent Filing Fees</h2>
            </div>

            <div class="space-y-3 text-xs mb-6 border-b border-slate-800 pb-6">
                <div class="flex justify-between text-slate-300">
                    <span>Filing Service:</span>
                    <span class="font-bold text-white">{{ $pricing['title'] }}</span>
                </div>
                <div class="flex justify-between text-slate-300">
                    <span>Estimated Registry Timeline:</span>
                    <span class="text-amber-400 font-medium">{{ $pricing['timeline'] }}</span>
                </div>
                <div class="flex justify-between text-slate-300">
                    <span>Statutory Base Fee:</span>
                    <span>₦{{ number_format($pricing['regular_fee'], 2) }}</span>
                </div>
                @if($pricing['is_member'])
                    <div class="flex justify-between text-emerald-400 font-semibold">
                        <span>Brands Academy Member Discount (25% Off):</span>
                        <span>-₦{{ number_format($pricing['member_discount'], 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-sm sm:text-base font-extrabold text-white pt-2 border-t border-slate-800">
                    <span>Total Statutory Payable:</span>
                    <span class="text-amber-400">₦{{ number_format($pricing['final_fee'], 2) }}</span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[11px] text-slate-400 max-w-md">
                    By submitting, your case will be registered in our registry queue and assigned a tracking code. You can complete payment instantly via Paystack / SquadCo on the next screen.
                </p>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-md transition-all">
                    Proceed to Payment &rarr;
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
