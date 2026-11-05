@extends('layouts.app')

@section('title', 'Certificates Registry & Email Dispatch - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Admin Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    Official Certificates & Dispatch Registry
                </h1>
                <p class="text-slate-300 text-xs mt-1">Audit issued credentials, preview generated PDF certificates, and verify automated email deliveries.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.certificates.export') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export Registry (CSV)
                </a>
                <a href="{{ route('verify.certificate') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                    Public Portal &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Table -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Certificate ID</th>
                        <th class="px-6 py-4">Recipient Name & Email</th>
                        <th class="px-6 py-4">Accredited Course / Tier</th>
                        <th class="px-6 py-4">Date Issued</th>
                        <th class="px-6 py-4">Email Delivery</th>
                        <th class="px-6 py-4 text-right">Certificate Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-slate-50/50">
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
                            <td colspan="6" class="p-8 text-center text-slate-500">No certificates generated yet.</td>
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
</section>

@endsection
