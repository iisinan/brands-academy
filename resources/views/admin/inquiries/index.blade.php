@extends('layouts.admin')

@section('title', 'Institutional Partnerships & Inquiries - Admin')
@section('page_title', '3. Institutional Requests Management')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title">
                    Institutional Partnerships &amp; Agency Inquiries
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Evaluate partnership proposals, training curriculum requests, and accreditation inquiries from universities, MDAs, and corporate organizations.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.inquiries.export') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-1.5 shadow-md shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('partnerships') }}" target="_blank" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                Public Partnerships Page &rarr;
            </a>
        </div>
    </div>

    <!-- 4-Pillar Metric Strip for Inquiries -->
    @if(isset($stats))
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Total Requests</span>
            <div class="text-2xl font-extrabold text-slate-900 font-serif-title mt-1">{{ $stats['total'] }}</div>
            <span class="text-[11px] text-slate-500">Received via portal</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border {{ $stats['new'] > 0 ? 'border-amber-300 bg-amber-50/20' : 'border-slate-200' }} shadow-xs">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 block">New / Unreviewed</span>
            <div class="text-2xl font-extrabold {{ $stats['new'] > 0 ? 'text-amber-800' : 'text-slate-900' }} font-serif-title mt-1">{{ $stats['new'] }}</div>
            <span class="text-[11px] {{ $stats['new'] > 0 ? 'text-amber-700 font-semibold' : 'text-slate-500' }}">Awaiting initial contact</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold uppercase tracking-wider text-purple-700 block">In Discussion</span>
            <div class="text-2xl font-extrabold text-slate-900 font-serif-title mt-1">{{ $stats['in_discussion'] }}</div>
            <span class="text-[11px] text-slate-500">Active dialogue</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block">Active Partnerships</span>
            <div class="text-2xl font-extrabold text-emerald-700 font-serif-title mt-1">{{ $stats['partnered'] }}</div>
            <span class="text-[11px] text-slate-500">MOU / Cohort onboarded</span>
        </div>
    </div>
    @endif

    <!-- Filter Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs">
        <form action="{{ route('admin.inquiries') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search organization, contact name, or email..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">

            <select name="status" class="px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Statuses</option>
                <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New Inquiry</option>
                <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="in_discussion" {{ request('status') == 'in_discussion' ? 'selected' : '' }}>In Discussion</option>
                <option value="partnered" {{ request('status') == 'partnered' ? 'selected' : '' }}>Partnership Active</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>

            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                Filter Inquiries
            </button>
            @if(request()->hasAny(['q', 'status']))
                <a href="{{ route('admin.inquiries') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Inquiries List -->
    <div class="space-y-6">
        @forelse($inquiries as $inquiry)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-xs flex flex-col lg:flex-row lg:items-start justify-between gap-6 hover:shadow-md transition-shadow">
                <!-- Info Column -->
                <div class="space-y-3.5 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $inquiry->status_badge['class'] }}">
                            {{ $inquiry->status_badge['label'] }}
                        </span>
                        <span class="text-xs font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-700">
                            {{ $inquiry->organization_type_label }}
                        </span>
                        <span class="text-xs text-slate-400">
                            Received on {{ $inquiry->created_at->format('M d, Y &bull; h:i A') }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-slate-900 font-serif-title">
                            {{ $inquiry->organization_name }}
                        </h3>
                        <p class="text-xs text-amber-700 font-semibold mt-0.5">
                            Interest: {{ $inquiry->solution_interest_label }}
                        </p>
                    </div>

                    <!-- Contact & Cohort Details -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Contact Person</span>
                            <span class="font-bold text-slate-800">{{ $inquiry->contact_person }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Email</span>
                            <a href="mailto:{{ $inquiry->email }}?subject=Brands%20Academy%20Nigeria%20Foundation%20%E2%80%94%20Institutional%20Partnership%20%5B{{ rawurlencode($inquiry->organization_name) }}%5D" class="font-semibold text-amber-600 hover:underline flex items-center gap-1">
                                <span>{{ $inquiry->email }}</span>
                                <svg class="w-3 h-3 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </a>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Phone</span>
                            <span class="font-semibold text-slate-800">{{ $inquiry->phone }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Estimated Cohort / Timeline</span>
                            <span class="font-semibold text-slate-800">
                                {{ $inquiry->estimated_cohort_size ? $inquiry->estimated_cohort_size . ' persons' : 'N/A' }} 
                                &bull; {{ $inquiry->target_timeline ?? 'Immediate' }}
                            </span>
                        </div>
                    </div>

                    <!-- Inquiry Message -->
                    <div class="bg-amber-50/50 p-4 rounded-2xl border border-amber-100 text-xs text-slate-700 leading-relaxed">
                        <strong class="text-slate-900 block mb-1">Inquiry / Statement of Need:</strong>
                        <p class="whitespace-pre-line">{{ $inquiry->message }}</p>
                    </div>

                    @if($inquiry->admin_notes)
                        <div class="text-xs text-slate-600 bg-slate-100/80 p-3.5 rounded-xl border border-slate-200">
                            <span class="font-bold text-slate-800 block text-[10px] uppercase">Internal Admin Notes:</span>
                            {{ $inquiry->admin_notes }}
                        </div>
                    @endif

                    <!-- Pre-formatted Email Reply Quick Action -->
                    <div>
                        <a href="mailto:{{ $inquiry->email }}?subject=Brands%20Academy%20Nigeria%20Foundation%20%E2%80%94%20Re:%20Institutional%20Partnership%20Inquiry%20%5B{{ rawurlencode($inquiry->organization_name) }}%5D&body=Dear%20{{ rawurlencode($inquiry->contact_person) }},%0D%0A%0D%0AThank%20you%20for%20reaching%20out%20to%20Brands%20Academy%20Nigeria%20Foundation%20regarding%20{{ rawurlencode($inquiry->solution_interest_label) }}.%0D%0A%0D%0AWe%20have%20reviewed%20your%20request%20on%20behalf%20of%20{{ rawurlencode($inquiry->organization_name) }}%20and%20would%20welcome%20the%20opportunity%20to%20schedule%20an%20executive%20introductory%20briefing.%0D%0A%0D%0ABest%20regards,%0D%0ABrands%20Academy%20Nigeria%20Foundation%20Executive%20Office"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                            <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Compose Official Reply to {{ $inquiry->contact_person }} &rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="lg:w-72 shrink-0 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                    <form action="{{ route('admin.inquiries.status', $inquiry->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-slate-600 mb-1">Update Status</label>
                            <select name="status" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>New Inquiry</option>
                                <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="in_discussion" {{ $inquiry->status == 'in_discussion' ? 'selected' : '' }}>In Discussion</option>
                                <option value="partnered" {{ $inquiry->status == 'partnered' ? 'selected' : '' }}>Partnership Active</option>
                                <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase font-bold text-slate-600 mb-1">Administrative Notes</label>
                            <textarea name="admin_notes" rows="3" placeholder="Add follow-up notes, agreement terms, or call summary..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl text-xs transition-colors shadow-xs">
                            Save Status &amp; Notes
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-500">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <h3 class="text-base font-bold text-slate-800 mb-1">No Institutional Inquiries Found</h3>
                <p class="text-xs text-slate-400">Institutional proposals submitted through the portal will be queued here.</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $inquiries->links() }}
        </div>
    </div>

</div>

@endsection
