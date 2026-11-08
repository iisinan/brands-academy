<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Member Credential - {{ $member->full_name }} | Brands Academy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-title { font-family: 'Playfair Display', serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: transparent !important; }
        }
    </style>
</head>
<body class="min-h-full flex flex-col items-center justify-center p-4 sm:p-6 text-slate-800 relative selection:bg-amber-500 selection:text-white"
      x-data="{ copied: false, copyLink() { navigator.clipboard.writeText('{{ route('verify.certificate', $member->qr_code_token) }}'); this.copied = true; setTimeout(() => this.copied = false, 2500); } }">

    <!-- Ambient Glow in Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Quick Action Bar (Hidden when printing) -->
    <div class="no-print mb-6 flex flex-wrap items-center justify-center gap-3 relative z-10">
        <a href="{{ route('member.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 text-white hover:bg-white/20 transition-all flex items-center gap-1.5 border border-white/10">
            &larr; Back to Dashboard
        </a>
        <button type="button" @click="copyLink()" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 text-amber-300 hover:bg-white/20 transition-all flex items-center gap-1.5 border border-amber-500/30 cursor-pointer">
            <template x-if="!copied">
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>Copy Verification URL</span>
                </span>
            </template>
            <template x-if="copied">
                <span class="flex items-center gap-1.5 text-emerald-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>Verification Link Copied!</span>
                </span>
            </template>
        </button>
        <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-1.5 shadow-lg shadow-amber-500/25">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Download Certificate (PDF)</span>
        </a>
        <button onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-all flex items-center gap-1.5 border border-white/10 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Slip
        </button>
    </div>

    <!-- The Digital Card -->
    <div class="w-full max-w-md bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white rounded-3xl p-7 sm:p-8 shadow-2xl border-2 border-amber-500/40 relative overflow-hidden z-10 transition-all hover:scale-[1.01]">
        
        <!-- Subtle gold line pattern -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-amber-500/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-blue-500/15 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Card Header -->
        <div class="flex items-center justify-between gap-4 mb-6 pb-5 border-b border-white/10 relative z-10">
            <div class="flex items-center gap-3">
                <x-brand-logo class="w-12 h-12 drop-shadow-md" />
                <div>
                    <div class="font-extrabold text-sm uppercase tracking-wider text-white font-serif-title">
                        Brands Academy
                    </div>
                    <div class="text-[9px] font-bold tracking-widest text-amber-400 uppercase">
                        Nigeria Foundation
                    </div>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Active Member
                </span>
                <span class="block text-[8px] text-slate-400 mt-0.5">RC/IT 7344471</span>
            </div>
        </div>

        <!-- Member Info -->
        <div class="space-y-4 mb-6 relative z-10">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Official Member Name</span>
                <div class="text-xl sm:text-2xl font-extrabold text-white font-serif-title mt-0.5">
                    {{ $member->full_name }}
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Membership Track</span>
                    <span class="text-xs font-bold text-amber-400 block">{{ $member->category_label }}</span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Member Since</span>
                    <span class="text-xs font-semibold text-slate-200 block">{{ $member->joined_at ? $member->joined_at->format('M Y') : date('M Y') }}</span>
                </div>
            </div>

            @if($member->institution_or_company)
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Affiliation</span>
                    <span class="text-xs text-slate-300 font-medium block">{{ $member->designation ? $member->designation . ' • ' : '' }}{{ $member->institution_or_company }}</span>
                </div>
            @endif
        </div>

        <!-- Footer / QR Code Verification Section -->
        <div class="pt-5 border-t border-white/10 flex items-center justify-between gap-4 relative z-10">
            <div>
                <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Member ID Number</span>
                <div class="text-sm sm:text-base font-extrabold font-mono text-amber-400 tracking-wider">
                    {{ $member->member_number }}
                </div>
                <div class="text-[9px] text-slate-400 mt-1">
                    {{ ($member->country ?? 'Nigeria') === 'Nigeria' ? 'State: ' : 'Region: ' }}{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}
                </div>
            </div>

            <div class="p-2 bg-white rounded-xl shadow-md shrink-0 flex items-center justify-center">
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(70)->errorCorrection('M')->generate(route('verify.certificate', $member->qr_code_token)) !!}
            </div>
        </div>

        <div class="text-center text-[8px] text-slate-400 mt-4 uppercase tracking-widest relative z-10">
            Official Credential &bull; Governed under CAMA CAP C20 LFN 2004
        </div>
    </div>

</body>
</html>
