<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Member Credential - {{ $member->full_name }} | Brands Academy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-title { font-family: 'Playfair Display', serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: transparent !important; }
        }
    </style>
</head>
<body class="min-h-full flex flex-col items-center justify-center p-4 sm:p-6 text-slate-800">

    <div class="no-print mb-6 flex items-center gap-4">
        <a href="{{ route('member.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 text-white hover:bg-white/20 transition-colors">
            &larr; Back to Dashboard
        </a>
        <button onclick="window.print()" class="px-5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Credential Slip
        </button>
    </div>

    <!-- The Digital Card -->
    <div class="w-full max-w-md bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white rounded-3xl p-7 shadow-2xl border-2 border-amber-500/40 relative overflow-hidden">
        
        <!-- Subtle gold line pattern -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Card Header -->
        <div class="flex items-center justify-between gap-4 mb-6 pb-5 border-b border-white/10 relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 font-bold flex items-center justify-center font-serif-title text-xl">
                    B
                </div>
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
                <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 uppercase">
                    Active Member
                </span>
                <span class="block text-[8px] text-slate-400 mt-0.5">RC/IT 7344471</span>
            </div>
        </div>

        <!-- Member Info -->
        <div class="space-y-4 mb-6 relative z-10">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Member Name</span>
                <div class="text-xl font-extrabold text-white font-serif-title mt-0.5">
                    {{ $member->full_name }}
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Category</span>
                    <span class="text-xs font-bold text-amber-400">{{ $member->category_label }}</span>
                </div>
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Member Since</span>
                    <span class="text-xs font-semibold text-slate-200">{{ $member->joined_at->format('M Y') }}</span>
                </div>
            </div>

            @if($member->institution_or_company)
                <div>
                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Affiliation</span>
                    <span class="text-xs text-slate-300 font-medium">{{ $member->designation ? $member->designation . ' &bull; ' : '' }}{{ $member->institution_or_company }}</span>
                </div>
            @endif
        </div>

        <!-- Footer / QR Code Verification Section -->
        <div class="pt-5 border-t border-white/10 flex items-center justify-between gap-4 relative z-10">
            <div>
                <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Member ID Number</span>
                <div class="text-sm font-extrabold font-mono text-amber-400 tracking-wider">
                    {{ $member->member_number }}
                </div>
                <div class="text-[9px] text-slate-400 mt-1">
                    State: {{ $member->state }}, Nigeria
                </div>
            </div>

            <div class="p-2 bg-white rounded-xl shadow-md shrink-0">
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(64)->errorCorrection('M')->generate(route('verify.certificate', $member->qr_code_token)) !!}
            </div>
        </div>

        <div class="text-center text-[8px] text-slate-500 mt-4 uppercase tracking-widest relative z-10">
            Official Credential &bull; Incorporated under CAMA CAP C20 LFN 2004
        </div>
    </div>

</body>
</html>
