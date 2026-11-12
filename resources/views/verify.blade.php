@extends(auth()->check() && auth()->user()->member ? 'layouts.member' : 'layouts.app')

@section('page_title', 'Credential & Member Verification')

@if(isset($certificate) && $certificate)
    @section('title', 'Verified Credential: ' . $certificate->recipient_name . ' — ' . $certificate->course_title)
    @section('meta_description', 'Official verifiable credential #' . $certificate->certificate_number . ' awarded to ' . $certificate->recipient_name . ' for completing ' . $certificate->course_title . ' by Brands Academy Nigeria Foundation (CAC/IT/No. 7344471).')
@elseif(isset($member) && $member)
    @section('title', 'Verified Member: ' . $member->full_name . ' (' . $member->member_number . ')')
    @section('meta_description', 'Official active member credential for ' . $member->full_name . ' (' . $member->category_label . ') with Brands Academy Nigeria Foundation (CAC/IT/No. 7344471).')
@else
    @section('title', 'Verify Credential — Brands Academy Nigeria Foundation')
    @section('meta_description', 'Verify the authenticity of any Certificate of Achievement or Member ID issued by Brands Academy Nigeria Foundation (CAC/IT/No. 7344471).')
@endif

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes strokeCheck {
        0% { stroke-dashoffset: 32; }
        100% { stroke-dashoffset: 0; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform-origin: center center;
    }
    .anim-check-stroke {
        stroke-dasharray: 32;
        stroke-dashoffset: 32;
        animation: strokeCheck 0.32s cubic-bezier(0.65, 0, 0.45, 1) 0.08s forwards;
    }
    .field-interactive {
        transition: border-color 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease, transform 0.15s ease;
    }
    .luxury-card-glow {
        box-shadow: 0 25px 50px -12px rgba(245, 158, 11, 0.2), 0 0 0 1px rgba(245, 158, 11, 0.15);
    }
</style>
@endpush

@section('content')

<div x-data="verifyRegistryComponent({
    initialQuery: @js($searchQuery ?? ''),
    shareUrl: @js(
        $certificate ? route('verify.certificate', $certificate->verification_token) :
        ($member ? route('verify.certificate', $member->qr_code_token) : '')
    )
})">

    <!-- Header & Interactive Search Banner -->
    <section class="bg-slate-900 text-white py-14 sm:py-16 border-b border-slate-800 relative overflow-hidden">
        <!-- Ambient decorative lights -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl mx-auto text-center">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-300 border border-amber-500/20 mb-3">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Institutional Public Registry &bull; Federal Republic of Nigeria
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold font-serif-title mb-4 tracking-tight">
                    Verify Digital Credentials
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm leading-relaxed font-light mb-8 max-w-xl mx-auto">
                    Verify the authenticity of any Certificate of Achievement or Member ID issued by Brands Academy Nigeria Foundation (Incorporated Trustee CAC/IT/No. 7344471).
                </p>

                <!-- Search Form -->
                <form action="{{ route('verify.certificate') }}" method="GET" @submit="isSearching = true" class="space-y-3">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <input type="text" name="q" x-model="query" required
                                   placeholder="Enter Certificate # or Member ID (e.g. BANF-CERT-2024-00108)"
                                   class="w-full bg-white/10 text-white placeholder-slate-400 px-4 py-3.5 rounded-2xl border border-white/20 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm font-mono field-interactive">
                            <!-- Clear input icon -->
                            <button type="button" x-show="query.length > 0" @click="query = ''" class="absolute right-3 top-3.5 text-slate-400 hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <button type="submit" :disabled="isSearching" class="px-6 py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold rounded-2xl text-sm transition-all whitespace-nowrap shadow-md flex items-center justify-center gap-2 disabled:opacity-75">
                            <svg x-show="isSearching" class="w-4 h-4 animate-spin text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <svg x-show="!isSearching" class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span>Verify Credential</span>
                        </button>
                    </div>

                    <!-- Live Query Format Badge -->
                    <div x-show="queryType" x-cloak class="anim-check-pop flex items-center justify-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-800 text-amber-300 border border-slate-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                            <span x-text="queryType"></span>
                        </span>
                    </div>

                    <!-- Quick Example Pills -->
                    <div class="flex flex-wrap items-center justify-center gap-2 text-xs pt-1">
                        <span class="text-slate-400 text-[11px]">Quick Samples:</span>
                        <button type="button" @click="setSample('BANF-CERT-2024-00108')" class="px-2.5 py-1 rounded-lg bg-slate-800/80 hover:bg-slate-800 text-amber-300 border border-slate-700/80 transition-colors text-[11px] font-mono">
                            BANF-CERT-2024-00108
                        </button>
                        <button type="button" @click="setSample('BANF-MBR-')" class="px-2.5 py-1 rounded-lg bg-slate-800/80 hover:bg-slate-800 text-slate-300 border border-slate-700/80 transition-colors text-[11px] font-mono">
                            BANF-MBR-...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Result Display Section -->
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        @if($certificate)
            <!-- Case 1: Certificate Found -->
            <div class="bg-white rounded-3xl border-2 border-amber-500/40 luxury-card-glow p-6 sm:p-10 relative overflow-hidden">
                <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Authenticity Banner -->
                <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-emerald-900 mb-8">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-6 h-6 anim-check-stroke" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-extrabold text-sm sm:text-base">Authentic Certificate Verified</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-200/60 text-emerald-800 uppercase">Official</span>
                        </div>
                        <p class="text-xs text-emerald-700">This record is authentic, tamper-evident, and officially ratified by the Brands Academy Nigeria Foundation Board of Trustees.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <span class="text-xs font-bold uppercase text-slate-400 tracking-wider block mb-1">Awarded To</span>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-serif-title">
                            {{ $certificate->recipient_name }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Programme / Workshop</span>
                            <span class="font-bold text-slate-900 text-base">{{ $certificate->course_title }}</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Credential Track</span>
                            <span class="font-bold text-amber-700 text-base">{{ $certificate->track_tier }}</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Certificate Number</span>
                            <span class="font-mono font-bold text-slate-900 text-base">{{ $certificate->certificate_number }}</span>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Date of Issuance</span>
                            <span class="font-bold text-slate-900 text-base">{{ $certificate->issued_at->format('F d, Y') }}</span>
                        </div>
                    </div>

                    @if(!empty($barcode128) || !empty($qrCode))
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if(!empty($qrCode))
                                    <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-2xs shrink-0">
                                        <img src="{{ $qrCode }}" alt="Verification QR Code" class="w-16 h-16 object-contain" />
                                    </div>
                                @endif
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Verification Token</span>
                                    <span class="font-mono text-xs font-bold text-slate-800 break-all">{{ $certificate->verification_token }}</span>
                                    <span class="block text-[10px] text-emerald-600 font-semibold mt-0.5">&bull; Official Central Registry Record</span>
                                </div>
                            </div>
                            @if(!empty($barcode128))
                                <div class="bg-white p-2.5 rounded-xl border border-slate-200 text-center shrink-0 w-full sm:w-auto">
                                    <img src="{{ $barcode128 }}" alt="Code-128 Linear Barcode" class="h-9 max-w-[200px] mx-auto object-contain" />
                                    <span class="block text-[9px] font-mono font-bold text-slate-700 mt-1 uppercase">{{ $certificate->certificate_number }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="p-4 rounded-2xl bg-slate-900 text-slate-300 text-xs space-y-1">
                        <div class="font-bold text-amber-400 uppercase tracking-wider text-[10px]">Ratifying Authority & Seal</div>
                        <div class="font-semibold text-white">Brands Academy Nigeria Foundation &bull; Incorporated Trustee (Companies and Allied Matters Act 2020, Part F)</div>
                        <div class="text-slate-400">CAC/IT/No. 7344471 &bull; Federal Republic of Nigeria &bull; Ratified by the Board of Trustees</div>
                    </div>

                    <!-- Professional Credential Actions -->
                    <div class="pt-4 flex flex-wrap items-center gap-3">
                        <a href="{{ route('certificates.download', $certificate->verification_token) }}" class="px-5 py-3 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download PDF Certificate
                        </a>
                        
                        <a href="{{ route('certificates.preview', $certificate->verification_token) }}" target="_blank" class="px-4 py-3 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                            Preview in Browser
                        </a>

                        <!-- LinkedIn Add to Profile -->
                        @php
                            $linkedInUrl = 'https://www.linkedin.com/profile/add?' . http_build_query([
                                'startTask' => 'CERTIFICATION_NAME',
                                'name' => $certificate->course_title . ' (' . $certificate->track_tier . ')',
                                'organizationName' => 'Brands Academy Nigeria Foundation',
                                'issueYear' => $certificate->issued_at->format('Y'),
                                'issueMonth' => $certificate->issued_at->format('n'),
                                'certUrl' => route('verify.certificate', $certificate->verification_token),
                                'certId' => $certificate->certificate_number,
                            ]);
                        @endphp
                        <a href="{{ $linkedInUrl }}" target="_blank" rel="noopener noreferrer" class="px-4 py-3 rounded-xl text-xs font-bold bg-[#0A66C2] hover:bg-[#004182] text-white shadow-sm transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            Add to LinkedIn
                        </a>

                        <!-- 1-Click Copy Shareable Link (without browser alert) -->
                        <button type="button" @click="copyShareLink()" class="px-4 py-3 rounded-xl text-xs font-bold border border-slate-300 hover:bg-slate-50 text-slate-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" :class="copiedLink ? 'text-emerald-600' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span x-text="copiedLink ? 'Verification Link Copied!' : 'Copy Shareable Link'"></span>
                        </button>
                    </div>
                </div>
            </div>

        @elseif($member)
            <!-- Case 2: Member Credential Found -->
            <div class="bg-white rounded-3xl border-2 border-emerald-500 shadow-2xl p-6 sm:p-10 relative overflow-hidden">
                <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-200 text-emerald-900 mb-8">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 anim-check-stroke" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-sm sm:text-base">Active Member Verified</h3>
                        <p class="text-xs text-emerald-700">Official active member in good standing with Brands Academy Nigeria Foundation.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <span class="text-xs font-bold uppercase text-slate-400 tracking-wider block mb-1">Member Profile</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title">
                            {{ $member->full_name }}
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Member ID Number</span>
                            <span class="font-mono font-bold text-amber-700 text-base">{{ $member->member_number }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Category</span>
                            <span class="font-bold text-slate-900 text-base">{{ $member->category_label }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Jurisdiction / Location</span>
                            <span class="font-bold text-slate-900">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Affiliation / Organization</span>
                            <span class="font-bold text-slate-900">{{ $member->institution_or_company ?? 'Individual Practitioner' }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Member Since</span>
                            <span class="font-bold text-slate-900">{{ $member->joined_at ? \Carbon\Carbon::parse($member->joined_at)->format('F d, Y') : 'Active' }}</span>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="text-xs text-slate-400 block uppercase font-bold mb-1">Registry Standing</span>
                            <span class="inline-flex items-center gap-1.5 font-bold text-emerald-700">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Good Standing &bull; Certified
                            </span>
                        </div>
                    </div>

                    @if(!empty($barcode128) || !empty($qrCode))
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if(!empty($qrCode))
                                    <div class="bg-white p-1.5 rounded-xl border border-slate-200 shadow-2xs shrink-0">
                                        <img src="{{ $qrCode }}" alt="Member Verification QR Code" class="w-16 h-16 object-contain" />
                                    </div>
                                @endif
                                <div>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Registry Member Pass</span>
                                    <span class="font-mono text-xs font-bold text-amber-700">{{ $member->member_number }}</span>
                                    <span class="block text-[10px] text-emerald-600 font-semibold mt-0.5">&bull; Active &amp; Validated Institutional Standing</span>
                                </div>
                            </div>
                            @if(!empty($barcode128))
                                <div class="bg-white p-2.5 rounded-xl border border-slate-200 text-center shrink-0 w-full sm:w-auto">
                                    <img src="{{ $barcode128 }}" alt="Official Code-128 Linear Barcode" class="h-9 max-w-[200px] mx-auto object-contain" />
                                    <span class="block text-[9px] font-mono font-bold text-slate-700 mt-1 uppercase">{{ $member->member_number }}</span>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-xs">
                            <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Download Official Certificate (PDF)</span>
                        </a>

                        <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors shadow-xs">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <span>View Digital ID Card</span>
                        </a>

                        <button type="button" @click="copyShareLink()" class="px-4 py-2.5 rounded-xl text-xs font-bold border border-slate-300 hover:bg-slate-50 text-slate-700 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" :class="copiedLink ? 'text-emerald-600' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span x-text="copiedLink ? 'Link Copied!' : 'Copy Verification Link'"></span>
                        </button>
                    </div>
                </div>
            </div>

        @elseif($hasSearched)
            <!-- Case 3: Searched But Not Found -->
            <div class="bg-white rounded-3xl border border-rose-200 shadow-xl p-8 sm:p-10 text-center max-w-lg mx-auto">
                <div class="w-14 h-14 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Record Not Found</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">
                    No active certificate or membership credential matches the query <strong class="text-slate-900">&quot;{{ $searchQuery }}&quot;</strong>.
                </p>
                <div class="text-left bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs text-slate-600 space-y-2 mb-6">
                    <div class="font-bold text-slate-800">Verification Tips:</div>
                    <ul class="list-disc list-inside space-y-1 text-slate-500">
                        <li>Verify that certificate prefixes match <code class="font-mono text-amber-700">BANF-CERT-</code></li>
                        <li>Ensure member prefixes match <code class="font-mono text-amber-700">BANF-MBR-</code></li>
                        <li>Check for trailing spaces or misplaced punctuation</li>
                    </ul>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <button type="button" @click="query = ''" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                        Clear & Try Again
                    </button>
                    <a href="mailto:thebrandsacademy@gmail.com" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                        Contact Registry Support
                    </a>
                </div>
            </div>

        @else
            <!-- Case 4: Default Initial State -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 text-center max-w-lg mx-auto shadow-xs">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4 border border-amber-200/60 shadow-xs">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Instant Credential Verification</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-6">
                    Enter any Certificate Number (e.g. <span class="font-mono text-slate-700 font-semibold">BANF-CERT-2024-00108</span>), Member ID, or scan the QR code printed on the physical or digital document.
                </p>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>Verify any certificate or member ID issued by the Foundation against our official records.</span>
                </div>
            </div>
        @endif
    </section>

</div>

@endsection

@push('scripts')
<script>
    function verifyRegistryComponent(config) {
        return {
            query: config.initialQuery || '',
            shareUrl: config.shareUrl || '',
            isSearching: false,
            copiedLink: false,

            get queryType() {
                const q = (this.query || '').trim().toUpperCase();
                if (q.startsWith('BANF-CERT')) {
                    return 'Certificate of Achievement Number';
                }
                if (q.startsWith('BANF-MBR')) {
                    return 'Official Member ID';
                }
                if (q.length === 36 && q.includes('-')) {
                    return 'Digital Verification Token';
                }
                return '';
            },

            setSample(val) {
                this.query = val;
            },

            copyShareLink() {
                const url = this.shareUrl || window.location.href;
                if (navigator.clipboard && url) {
                    navigator.clipboard.writeText(url).then(() => {
                        this.copiedLink = true;
                        setTimeout(() => { this.copiedLink = false; }, 2500);
                    });
                }
            }
        };
    }
</script>
@endpush
