@extends('layouts.member')

@section('title', 'My CAC & Brand IP Filings | Brands Academy')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Legal & Brand IP Filings</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Track CAC business registrations, trademark protections, and intellectual property filings.</p>
        </div>
        <a href="{{ route('services.wizard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Start New Filing (25% Off)</span>
        </a>
    </div>

    <!-- Member Advantage Banner -->
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <div>
                <h4 class="text-xs font-bold text-blue-950">Active Membership Advantage</h4>
                <p class="text-[11px] text-blue-700">Your account is automatically accredited for 25% off all statutory legal desk filings, including CAC BN, Ltd, and Trademarks.</p>
            </div>
        </div>
        <span class="text-xs font-extrabold text-blue-700 bg-white px-3 py-1.5 rounded-lg border border-blue-200 shrink-0 hidden sm:inline">25% Discount Applied</span>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filings Table / Cards -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900">Your Registered Cases ({{ $filings->total() }})</h3>
        </div>

        @if($filings->isEmpty())
            <div class="p-12 text-center">
                <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h4 class="text-sm font-bold text-slate-900 mb-1">No Legal Filings Yet</h4>
                <p class="text-xs text-slate-500 mb-4 max-w-sm mx-auto">Register your business name with CAC or protect your brand mark under statutory trademark law.</p>
                <a href="{{ route('services.wizard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-colors">
                    <span>Initiate First Filing</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                        <tr>
                            <th class="p-4 pl-6">Reference & Name</th>
                            <th class="p-4">Track</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Govt Registration No.</th>
                            <th class="p-4">Documents</th>
                            <th class="p-4">Date</th>
                            <th class="p-4 pr-6 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach($filings as $filing)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 pl-6">
                                    <span class="font-mono text-[11px] text-blue-600 block">{{ $filing->tracking_code }}</span>
                                    <span class="font-bold text-slate-900 text-sm">{{ $filing->proposed_name_1 }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                        {{ $filing->type_title }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @php
                                        $badge = match($filing->status) {
                                            'approved', 'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'queried' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'payment_pending' => 'bg-slate-100 text-slate-600 border-slate-200',
                                            default => 'bg-blue-50 text-blue-700 border-blue-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badge }}">
                                        {{ $filing->status_label }}
                                    </span>
                                </td>
                                <td class="p-4 font-mono font-bold text-slate-900">
                                    {{ $filing->government_filing_number ?: 'In Progress' }}
                                </td>
                                <td class="p-4 text-slate-500">
                                    {{ $filing->documents_count }} Attached
                                </td>
                                <td class="p-4 text-slate-500 whitespace-nowrap">
                                    {{ $filing->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 pr-6 text-right whitespace-nowrap">
                                    @if($filing->status === 'payment_pending')
                                        <a href="{{ route('services.payment', $filing->tracking_code) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs transition-colors">
                                            <span>Pay Fee</span>
                                        </a>
                                    @else
                                        <a href="{{ route('member.filings.show', $filing->tracking_code) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 font-bold text-xs transition-colors">
                                            <span>Case Room &rarr;</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($filings->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $filings->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
