<!DOCTYPE html>
<html lang="en" class="h-full bg-[#2f4a3f]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#3b5d4f">
    <title>Digital Member Credential - {{ $member->full_name }} | Brands Academy</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-serif-title { font-family: 'Playfair Display', serif; }
        .card-preview-glow {
            box-shadow: 0 25px 50px -12px rgba(235, 196, 67, 0.25), 0 0 0 1px rgba(235, 196, 67, 0.25);
        }
        @media print {
            .no-print { display: none !important; }
            body {
                background: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 2px solid #000 !important;
                page-break-inside: avoid !important;
                margin: 20px auto !important;
            }
        }
    </style>
</head>
<body class="min-h-full flex flex-col items-center justify-center p-4 sm:p-6 bg-[#2f4a3f] text-white relative selection:bg-[#ebc443] selection:text-[#141615]"
      x-data="{
          cardSide: 'front',
          copiedUrl: false,
          copiedId: false,
          verificationUrl: @js($verifyUrl ?? route('verify.certificate', $member->qr_code_token)),
          memberNumber: @js($member->member_number),
          copyUrl() {
              if (navigator.clipboard) {
                  navigator.clipboard.writeText(this.verificationUrl);
                  this.copiedUrl = true;
                  setTimeout(() => this.copiedUrl = false, 2500);
              }
          },
          copyId() {
              if (navigator.clipboard && this.memberNumber) {
                  navigator.clipboard.writeText(this.memberNumber);
                  this.copiedId = true;
                  setTimeout(() => this.copiedId = false, 2500);
              }
          }
      }">

    @php
        $memberBarcode = $memberBarcode ?? App\Services\BarcodeService::generateCode128Png($member->member_number ?? 'MEMBER', barWidth: 2, barHeight: 44, showText: true);
        $verifyUrl = $verifyUrl ?? route('verify.certificate', $member->qr_code_token);
        $whatsAppShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode("Verify my official membership with Brands Academy Nigeria Foundation: " . $verifyUrl);
    @endphp

    <!-- Ambient Glow in Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-[#ebc443]/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-[#658275]/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Quick Action Bar (Hidden when printing) -->
    <div class="no-print mb-6 flex flex-wrap items-center justify-center gap-2.5 relative z-10 max-w-xl">
        <a href="{{ route('member.dashboard') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-white/10 text-white hover:bg-white/20 transition-all flex items-center gap-1.5 border border-white/10">
            &larr; Member Portal
        </a>
        <button type="button" @click="cardSide = cardSide === 'front' ? 'back' : 'front'"
                class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 transition-all flex items-center gap-1.5 border border-amber-500/40 cursor-pointer shadow-xs">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            <span x-text="cardSide === 'front' ? 'Flip to Back (Barcode)' : 'Flip to Front'">Flip to Back (Barcode)</span>
        </button>
        <button type="button" @click="copyUrl()" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-white/10 text-amber-300 hover:bg-white/20 transition-all flex items-center gap-1.5 border border-amber-500/30 cursor-pointer">
            <svg x-show="!copiedUrl" class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <svg x-show="copiedUrl" x-cloak class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span x-text="copiedUrl ? 'Copied URL!' : 'Copy Link'">Copy Link</span>
        </button>
        <a href="{{ route('membership.certificate.download', $member->qr_code_token) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-1.5 shadow-lg shadow-amber-500/25">
            <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Download Certificate (PDF)</span>
        </a>
        <a href="{{ $whatsAppShareUrl }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-[#25D366] hover:bg-[#20ba59] text-white transition-all flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.303c-.086.086-.177.18-.076.353.101.173.45 743 965 1.202.664.591 1.224.774 1.397.86.173.086.274.072.375-.043.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
            <span>WhatsApp</span>
        </a>
        <button onclick="window.print()" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-all flex items-center gap-1.5 border border-white/10 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Print Slip</span>
        </button>
    </div>

    <!-- The 3D Digital Card Presentation Container -->
    <div class="print-card w-full max-w-lg bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl border-2 border-amber-500/40 relative overflow-hidden z-10 transition-all card-preview-glow">
        
        <!-- Subtle gold line pattern -->
        <div class="absolute -right-16 -top-16 w-48 h-48 bg-amber-500/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-blue-500/15 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Card Header with Flip Button -->
        <div class="flex items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-800/80 relative z-10">
            <div class="flex items-center gap-3">
                <x-brand-logo class="w-11 h-11 drop-shadow-md shrink-0" />
                <div>
                    <div class="font-extrabold text-sm uppercase tracking-wider text-white font-serif-title">
                        Brands Academy
                    </div>
                    <div class="text-[9px] font-bold tracking-widest text-amber-400 uppercase">
                        Nigeria Foundation
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                    {{ $member->category_label }}
                </span>
                <button type="button" @click="cardSide = cardSide === 'front' ? 'back' : 'front'" class="no-print p-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 border border-amber-500/30 transition-all cursor-pointer shadow-xs" title="Flip Card">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
            </div>
        </div>

        <!-- Front Side View -->
        <div x-show="cardSide === 'front'"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="flex flex-col sm:flex-row items-center sm:items-start justify-between gap-5 mb-6 relative z-10">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 text-center sm:text-left min-w-0">
                    <!-- Monogram Badge -->
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-extrabold text-2xl flex items-center justify-center font-serif-title ring-4 ring-amber-500/30 shadow-lg shrink-0">
                        {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Official Member</span>
                        <div class="text-xl sm:text-2xl font-extrabold text-white font-serif-title truncate">
                            {{ $member->full_name }}
                        </div>
                        <p class="text-xs text-amber-300 font-semibold mt-0.5">
                            {{ $member->designation ?? 'Foundation Member' }}
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5 truncate">
                            {{ $member->institution_or_company ?? 'Brands Academy Nigeria Foundation' }}
                        </p>

                        <!-- Copyable Member ID Callout -->
                        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1 rounded-xl bg-slate-900 border border-slate-700/80">
                            <span class="text-[9px] uppercase font-bold text-slate-400">ID:</span>
                            <span class="text-xs font-mono font-extrabold text-amber-400">{{ $member->member_number }}</span>
                            <button type="button" @click="copyId()" class="no-print text-slate-400 hover:text-white transition-colors cursor-pointer" title="Copy Member ID">
                                <svg x-show="!copiedId" class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <svg x-show="copiedId" x-cloak class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Live 2D QR Code Badge -->
                <div class="p-3 bg-white rounded-2xl border-2 border-amber-500/40 shadow-xl shrink-0 flex flex-col items-center">
                    <div class="w-24 h-24 flex items-center justify-center">
                        {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(96)->errorCorrection('M')->generate($verifyUrl) !!}
                    </div>
                    <span class="text-[8px] font-mono font-bold text-slate-900 mt-1 uppercase tracking-tight">Scan To Verify</span>
                </div>
            </div>

            <!-- Footer Details -->
            <div class="pt-4 border-t border-slate-800/80 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-400 relative z-10">
                <div>
                    <span class="block text-[9px] uppercase font-bold text-slate-400">Jurisdiction</span>
                    <span class="text-slate-200 font-semibold">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</span>
                </div>
                <div>
                    <span class="block text-[9px] uppercase font-bold text-slate-400">Standing</span>
                    <span class="inline-flex items-center gap-1 text-emerald-400 font-bold text-xs">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Active &bull; Dues Paid
                    </span>
                </div>
                <div>
                    <span class="block text-[9px] uppercase font-bold text-slate-400">Member Since</span>
                    <span class="text-slate-200 font-mono">{{ $member->joined_at ? $member->joined_at->format('M d, Y') : date('M d, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Back Side View (Code-128 Linear Barcode & Institutional Authority) -->
        <div x-show="cardSide === 'back'" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="space-y-4 py-2 relative z-10">

            <!-- Authentic Code-128 Linear Barcode Card -->
            <div class="bg-white p-4 rounded-2xl border border-amber-500/40 text-center max-w-sm mx-auto shadow-md">
                <img src="{{ $memberBarcode }}" alt="Official Code-128 Linear Barcode" class="h-10 w-full object-contain mx-auto">
                <span class="block text-[10px] font-mono font-bold text-slate-800 mt-1 uppercase tracking-widest">{{ $member->member_number }}</span>
            </div>

            <!-- Statutory Legal Authority & Notice -->
            <div class="p-3.5 rounded-2xl bg-slate-900/90 border border-slate-800 text-[11px] text-slate-300 leading-relaxed text-center">
                <p class="text-amber-300 font-bold mb-1">Incorporated Trustee &bull; CAC/IT/No. 7344471</p>
                <p class="text-[10px] text-slate-400 leading-relaxed">
                    This official digital credential is issued under the authority of Brands Academy Nigeria Foundation. Governed under Companies and Allied Matters Act 2020 (Part F). Authorised for professional identification and central verification queries.
                </p>
            </div>

            <!-- Central Verification URL & Trustee Sign-Off -->
            <div class="pt-3 border-t border-slate-800/80 flex items-center justify-between text-[10px] text-slate-400">
                <div class="text-left">
                    <span class="block font-bold text-slate-300 uppercase text-[9px]">Central Registry Query:</span>
                    <span class="font-mono text-amber-400">{{ parse_url($verifyUrl, PHP_URL_HOST) ?? 'brandsacademy.org' }}/verify</span>
                </div>
                <div class="text-right">
                    <span class="block font-bold text-slate-200 font-serif-title italic">Dr. Sinan Ismaila Idris</span>
                    <span class="block text-[9px] text-amber-400">Director-General / Trustee</span>
                </div>
            </div>
        </div>

        <div class="text-center text-[8px] text-slate-400 mt-4 uppercase tracking-widest relative z-10">
            Official Credential &bull; Federal Republic of Nigeria &bull; CAMA 2020 (Part F)
        </div>
    </div>

</body>
</html>
