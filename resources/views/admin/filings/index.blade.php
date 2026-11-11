@extends('layouts.admin')

@section('title', 'Legal Operations & CAC Filings Desk')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Legal Operations & CAC Filings Desk</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Manage Business Name registrations, Company incorporations, and Trademark IP filings.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.filings.export') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-2xs transition-colors">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('services.wizard') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>New Filing Wizard</span>
            </a>
        </div>
    </div>

    <!-- KPI Metric Counters -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Cases</span>
            <span class="text-2xl font-black text-slate-900">{{ $stats['total'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Payment Pending</span>
            <span class="text-2xl font-black text-slate-600">{{ $stats['pending'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block mb-1">In Progress</span>
            <span class="text-2xl font-black text-blue-600">{{ $stats['in_progress'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block mb-1">Queried / Action</span>
            <span class="text-2xl font-black text-amber-600">{{ $stats['queried'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block mb-1">Approved & Issued</span>
            <span class="text-2xl font-black text-emerald-600">{{ $stats['approved'] }}</span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters & Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
        <form action="{{ route('admin.filings') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="w-full sm:w-64">
                <input type="text" name="q" value="{{ $search }}" placeholder="Search name, email, code..." class="w-full text-xs rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="w-full sm:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ empty($selectedStatus) || $selectedStatus === 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="payment_pending" {{ $selectedStatus === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                    <option value="submitted" {{ $selectedStatus === 'submitted' ? 'selected' : '' }}>Submitted (Paid)</option>
                    <option value="search_in_progress" {{ $selectedStatus === 'search_in_progress' ? 'selected' : '' }}>Search In Progress</option>
                    <option value="lodged_at_registry" {{ $selectedStatus === 'lodged_at_registry' ? 'selected' : '' }}>Lodged at Registry</option>
                    <option value="queried" {{ $selectedStatus === 'queried' ? 'selected' : '' }}>Queried</option>
                    <option value="approved" {{ $selectedStatus === 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>

            <div class="w-full sm:w-48">
                <select name="type" onchange="this.form.submit()" class="w-full text-xs rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500">
                    <option value="all" {{ empty($selectedType) || $selectedType === 'all' ? 'selected' : '' }}>All Filing Types</option>
                    <option value="cac_business_name" {{ $selectedType === 'cac_business_name' ? 'selected' : '' }}>CAC Business Name</option>
                    <option value="cac_company_ltd" {{ $selectedType === 'cac_company_ltd' ? 'selected' : '' }}>CAC Company Ltd</option>
                    <option value="trademark" {{ $selectedType === 'trademark' ? 'selected' : '' }}>Trademark</option>
                    <option value="patent" {{ $selectedType === 'patent' ? 'selected' : '' }}>Patent</option>
                    <option value="copyright" {{ $selectedType === 'copyright' ? 'selected' : '' }}>Copyright</option>
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-blue-600 transition-colors">
                Filter
            </button>
        </form>
    </div>

    <!-- Filings Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-semibold border-b border-slate-100">
                    <tr>
                        <th class="p-4 pl-6">Tracking Ref</th>
                        <th class="p-4">Proposed Name</th>
                        <th class="p-4">Track</th>
                        <th class="p-4">Client</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Fee / Gateway</th>
                        <th class="p-4">Govt Reg No.</th>
                        <th class="p-4">Created</th>
                        <th class="p-4 pr-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($filings as $filing)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-6 font-mono font-bold text-blue-600">
                                <a href="{{ route('admin.filings.show', $filing->id) }}" class="hover:underline">
                                    {{ $filing->tracking_code }}
                                </a>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-900 block">{{ $filing->proposed_name_1 }}</span>
                                <span class="text-[10px] text-slate-400">{{ $filing->headquarters_state }}</span>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-700">
                                    {{ $filing->type_title }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-slate-800">{{ $filing->client_first_name }} {{ $filing->client_last_name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $filing->client_email }}</div>
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
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold border {{ $badge }}">
                                    {{ $filing->status_label }}
                                </span>
                            </td>
                            <td class="p-4 font-mono">
                                ₦{{ number_format($filing->total_fee, 0) }}
                                <span class="text-[10px] text-slate-400 block">{{ $filing->payment_gateway ?: 'unpaid' }}</span>
                            </td>
                            <td class="p-4 font-mono font-bold text-slate-900">
                                {{ $filing->government_filing_number ?: '—' }}
                            </td>
                            <td class="p-4 text-slate-500 whitespace-nowrap">
                                {{ $filing->created_at->format('M d, Y') }}
                            </td>
                            <td class="p-4 pr-6 text-right whitespace-nowrap">
                                <a href="{{ route('admin.filings.show', $filing->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-bold text-xs transition-colors">
                                    <span>Manage Case &rarr;</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-12 text-center text-slate-400">
                                No legal service filings matching the selected criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($filings->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $filings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
