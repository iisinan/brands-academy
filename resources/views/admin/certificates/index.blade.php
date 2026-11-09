@extends('layouts.admin')

@section('title', 'Certificates Registry & Email Dispatch - Admin')
@section('page_title', 'Certificate Registry & Verification')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title">
                    Official Certificates &amp; Dispatch Registry
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Audit cryptographically signed credentials, preview PDF certificates, and verify automated email deliveries.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.certificates.export') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-1.5 shadow-md shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export Registry (CSV)</span>
            </a>
            <a href="{{ route('verify.certificate') }}" target="_blank" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                Public Portal &rarr;
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto touch-scroll">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Certificate ID</th>
                        <th class="px-6 py-4">Recipient Name &amp; Email</th>
                        <th class="px-6 py-4">Accredited Course / Tier</th>
                        <th class="px-6 py-4">Date Issued</th>
                        <th class="px-6 py-4">Email Delivery</th>
                        <th class="px-6 py-4 text-right">Certificate Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-amber-700">
                                {{ $cert->certificate_number }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 text-sm block">{{ $cert->recipient_name }}</span>
                                <span class="text-slate-500 text-[11px]">{{ $cert->recipient_email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-slate-800">{{ $cert->course_title }}</div>
                                <div class="text-[10px] text-amber-700 font-bold">{{ $cert->track_tier }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $cert->issued_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Dispatched {{ $cert->email_sent_at ? '(' . $cert->email_sent_at->diffForHumans() . ')' : '' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('certificates.preview', $cert->verification_token) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[11px] inline-block">
                                    Preview PDF
                                </a>
                                <a href="{{ route('certificates.download', $cert->verification_token) }}" class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-bold text-[11px] inline-block">
                                    Download
                                </a>
                                <form action="{{ route('admin.certificates.email', $cert->verification_token) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Resend certificate PDF email to {{ $cert->recipient_email }}?')" class="px-2.5 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-[11px]">
                                        Resend Email
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-500">No certificates generated yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($certificates->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
