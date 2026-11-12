@extends('layouts.member')

@section('title', 'Official CPD Academic Transcript - ' . $member->full_name . ' (' . $member->member_number . ')')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Action Bar (Hidden when printing) -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <a href="{{ route('member.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-800 transition-colors mb-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                <span>Back to Member Dashboard</span>
            </a>
            <h1 class="text-xl font-bold font-serif-title text-slate-900">Continuing Professional Development (CPD) Transcript</h1>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('registry.show', $member->member_number) }}" target="_blank" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors border border-slate-200">
                View Public Registry Page
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs shadow-sm transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Print</span>
            </button>
            <a href="{{ route('member.transcript.download') }}" class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-md transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Download Official PDF</span>
            </a>
        </div>
    </div>

    <!-- Official Document Container -->
    <div class="bg-white rounded-2xl border border-slate-300 p-8 sm:p-12 shadow-xl print:shadow-none print:border-none print:p-0">
        <!-- Header Banner -->
        <div class="border-b-2 border-slate-900 pb-6 mb-8 flex flex-col sm:flex-row sm:items-start justify-between gap-6">
            <div class="space-y-1">
                <div class="text-[11px] font-black tracking-widest uppercase text-blue-700 font-mono">Brands Academy Nigeria Foundation</div>
                <h2 class="text-2xl sm:text-3xl font-black font-serif-title tracking-tight text-slate-950">Official CPD Learning Record &amp; Transcript</h2>
                <p class="text-xs text-slate-500 font-medium">Continuing Professional Development (CPD) Units Registry</p>
            </div>
            <div class="text-right shrink-0">
                <div class="w-14 h-14 rounded-full bg-slate-950 text-amber-400 font-serif-title font-black text-xl flex items-center justify-center ml-auto mb-2 border-2 border-amber-400/40">
                    BA
                </div>
                <div class="text-[10px] text-slate-400 font-mono">Date of Issue: {{ now()->format('d F Y') }}</div>
                <div class="text-[10px] text-slate-400 font-mono">Reg. No: {{ $member->member_number }}</div>
            </div>
        </div>

        <!-- Practitioner Bio Matrix -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-5 rounded-xl bg-slate-50 border border-slate-200 text-xs mb-8">
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Practitioner Name</span>
                <span class="font-bold text-slate-900 text-sm">{{ $member->full_name }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Membership Tier</span>
                <span class="font-bold text-blue-700">{{ $member->category === 'fellow' ? 'Fellow (FBA)' : ucwords($member->category) }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Organization</span>
                <span class="font-bold text-slate-900 truncate block">{{ $member->institution_or_company ?: 'Independent' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block text-[10px] uppercase font-bold">Jurisdiction</span>
                <span class="font-bold text-slate-900">{{ $member->state ?: 'Nigeria' }}</span>
            </div>
        </div>

        <!-- CPD Units Executive Summary -->
        <div class="bg-gradient-to-r from-slate-950 to-slate-900 text-white rounded-2xl p-6 sm:p-8 mb-8 border border-slate-800">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-400">Total Validated Credits</span>
                    <div class="text-4xl sm:text-5xl font-black font-mono text-white mt-1">
                        {{ $totalCpdUnits }} <span class="text-xl sm:text-2xl font-light text-slate-300">CPD Units</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-2 font-light">
                        Approved for professional licensing, academic tenure review, and corporate board qualification.
                    </p>
                </div>
                <!-- Breakdown pills -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs shrink-0">
                    <div class="bg-white/10 p-2.5 rounded-xl border border-white/10 text-center">
                        <span class="text-[10px] text-slate-400 block">Short Courses</span>
                        <strong class="text-white font-mono text-sm">{{ $courseUnits }} pts</strong>
                    </div>
                    <div class="bg-white/10 p-2.5 rounded-xl border border-white/10 text-center">
                        <span class="text-[10px] text-slate-400 block">Conferences</span>
                        <strong class="text-white font-mono text-sm">{{ $conferenceUnits }} pts</strong>
                    </div>
                    <div class="bg-white/10 p-2.5 rounded-xl border border-white/10 text-center">
                        <span class="text-[10px] text-slate-400 block">Workshops</span>
                        <strong class="text-white font-mono text-sm">{{ $workshopUnits }} pts</strong>
                    </div>
                    <div class="bg-white/10 p-2.5 rounded-xl border border-white/10 text-center">
                        <span class="text-[10px] text-slate-400 block">JBSM Papers</span>
                        <strong class="text-white font-mono text-sm">{{ $articleUnits }} pts</strong>
                    </div>
                    <div class="bg-white/10 p-2.5 rounded-xl border border-white/10 text-center">
                        <span class="text-[10px] text-slate-400 block">Masterclasses</span>
                        <strong class="text-white font-mono text-sm">{{ $webinarUnits }} pts</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Ledger Table -->
        <div class="mb-12">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900 pb-3 mb-4 border-b border-slate-200">
                Detailed Academic &amp; Professional Credit Ledger
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 font-bold border-b border-slate-200">
                            <th class="p-3">Program / Credential</th>
                            <th class="p-3">Activity Type</th>
                            <th class="p-3">Completion Date</th>
                            <th class="p-3">Reference / Verification</th>
                            <th class="p-3 text-right">CPD Units</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($completedCourses as $c)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 font-semibold text-slate-900">{{ $c->course->title }}</td>
                                <td class="p-3 text-slate-500">Executive Short Course</td>
                                <td class="p-3 text-slate-600">{{ $c->completed_at ? $c->completed_at->format('M d, Y') : 'Completed' }}</td>
                                <td class="p-3 font-mono text-slate-700">{{ $c->certificate?->certificate_number ?: 'VERIFIED' }}</td>
                                <td class="p-3 text-right font-bold font-mono text-slate-900">10.0</td>
                            </tr>
                        @endforeach

                        @foreach($workshopCertificates as $wc)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 font-semibold text-slate-900">{{ $wc->course_title }}</td>
                                <td class="p-3 text-slate-500">Executive Workshop Cohort</td>
                                <td class="p-3 text-slate-600">{{ $wc->issued_at ? $wc->issued_at->format('M d, Y') : 'Awarded' }}</td>
                                <td class="p-3 font-mono text-slate-700">{{ $wc->certificate_number }}</td>
                                <td class="p-3 text-right font-bold font-mono text-slate-900">25.0</td>
                            </tr>
                        @endforeach

                        @foreach($conferencesAttended as $conf)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 font-semibold text-slate-900">{{ $conf->conference->title }}</td>
                                <td class="p-3 text-slate-500">Annual Plenary Summit</td>
                                <td class="p-3 text-slate-600">{{ $conf->created_at->format('M d, Y') }}</td>
                                <td class="p-3 font-mono text-slate-700">{{ $conf->badge_code }}</td>
                                <td class="p-3 text-right font-bold font-mono text-slate-900">15.0</td>
                            </tr>
                        @endforeach

                        @foreach($publishedArticles as $pub)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 font-semibold text-slate-900">{{ $pub->title }}</td>
                                <td class="p-3 text-purple-700 font-medium">JBSM Research Manuscript</td>
                                <td class="p-3 text-slate-600">{{ $pub->published_at ? $pub->published_at->format('M d, Y') : 'Published' }}</td>
                                <td class="p-3 font-mono text-slate-700">{{ $pub->doi ?: 'DOI-ASSIGNED' }}</td>
                                <td class="p-3 text-right font-bold font-mono text-slate-900">20.0</td>
                            </tr>
                        @endforeach

                        @foreach($webinarsAttended as $wb)
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-3 font-semibold text-slate-900">{{ $wb->webinar->title }}</td>
                                <td class="p-3 text-slate-500">Virtual Masterclass</td>
                                <td class="p-3 text-slate-600">{{ $wb->created_at->format('M d, Y') }}</td>
                                <td class="p-3 font-mono text-slate-700">{{ $wb->token }}</td>
                                <td class="p-3 text-right font-bold font-mono text-slate-900">2.0</td>
                            </tr>
                        @endforeach

                        @if($totalCpdUnits === 0)
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400">
                                    No completed learning units recorded yet. Complete short courses, attend masterclasses, or participate in the annual conference to accumulate CPD credits.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-900 text-white font-bold">
                            <td colspan="4" class="p-3 text-right font-serif-title uppercase text-xs">Total CPD Credit Units Earned:</td>
                            <td class="p-3 text-right font-mono text-amber-400 text-sm">{{ number_format($totalCpdUnits, 1) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Attestation Signature & Seal Block -->
        <div class="pt-8 border-t-2 border-slate-900 grid grid-cols-1 sm:grid-cols-3 gap-8 items-end text-center sm:text-left">
            <div>
                <div class="border-b border-slate-400 pb-1 mb-2 font-serif italic text-sm text-slate-800">Prof. Samaila Mande</div>
                <div class="text-[11px] font-bold text-slate-900 uppercase">Chairman, Board of Trustees</div>
                <div class="text-[10px] text-slate-500">Brands Academy Nigeria Foundation</div>
            </div>

            <div>
                <div class="border-b border-slate-400 pb-1 mb-2 font-serif italic text-sm text-slate-800">Titus Eveshoyan, Esq.</div>
                <div class="text-[11px] font-bold text-slate-900 uppercase">Registrar &amp; Legal Secretariat</div>
                <div class="text-[10px] text-slate-500">Academic &amp; Licensing Council</div>
            </div>

            <div class="text-center sm:text-right">
                <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200 inline-block text-center">
                    <span class="text-[10px] font-bold text-emerald-700 block">Official QR Verification</span>
                    <span class="font-mono text-[9px] text-slate-500 block truncate max-w-[150px]">{{ route('registry.show', $member->member_number) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
