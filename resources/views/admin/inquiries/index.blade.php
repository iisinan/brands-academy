@extends('layouts.app')

@section('title', 'Institutional Partnerships & Inquiries - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Admin Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    Institutional Partnerships & Inquiries
                </h1>
                <p class="text-slate-300 text-xs mt-1">Review corporate, university, and government partnership proposals and licensing inquiries.</p>
            </div>
            <a href="{{ route('partnerships') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                Public Partnerships Page &rarr;
            </a>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
        <form action="{{ route('admin.inquiries') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search organization, contact name, or email..." class="flex-1 px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">

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
                <a href="{{ route('admin.inquiries') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Inquiries List -->
    <div class="space-y-6">
        @forelse($inquiries as $inquiry)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs flex flex-col lg:flex-row lg:items-start justify-between gap-6">
                <!-- Info Column -->
                <div class="space-y-3 flex-1">
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs bg-slate-50 p-3.5 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Contact Person</span>
                            <span class="font-bold text-slate-800">{{ $inquiry->contact_person }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Email</span>
                            <a href="mailto:{{ $inquiry->email }}" class="font-semibold text-amber-600 hover:underline">{{ $inquiry->email }}</a>
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
                    <div class="bg-amber-50/50 p-4 rounded-xl border border-amber-100 text-xs text-slate-700 leading-relaxed">
                        <strong class="text-slate-900 block mb-1">Inquiry / Statement of Need:</strong>
                        <p class="whitespace-pre-line">{{ $inquiry->message }}</p>
                    </div>

                    @if($inquiry->admin_notes)
                        <div class="text-xs text-slate-600 bg-slate-100/80 p-3 rounded-lg border border-slate-200">
                            <span class="font-bold text-slate-800 block text-[10px] uppercase">Internal Admin Notes:</span>
                            {{ $inquiry->admin_notes }}
                        </div>
                    @endif
                </div>

                <!-- Update Status Form -->
                <div class="lg:w-72 shrink-0 bg-slate-50 p-4 rounded-xl border border-slate-200">
                    <form action="{{ route('admin.inquiries.status', $inquiry->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-slate-600 mb-1">Update Status</label>
                            <select name="status" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                                <option value="new" {{ $inquiry->status == 'new' ? 'selected' : '' }}>New Inquiry</option>
                                <option value="contacted" {{ $inquiry->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="in_discussion" {{ $inquiry->status == 'in_discussion' ? 'selected' : '' }}>In Discussion</option>
                                <option value="partnered" {{ $inquiry->status == 'partnered' ? 'selected' : '' }}>Partnership Active</option>
                                <option value="closed" {{ $inquiry->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] uppercase font-bold text-slate-600 mb-1">Administrative Notes</label>
                            <textarea name="admin_notes" rows="3" placeholder="Add follow-up notes, agreement terms, or call summary..." class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                        </div>

                        <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-lg text-xs transition-colors shadow-xs">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500">
                <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <h3 class="text-base font-bold text-slate-800 mb-1">No Institutional Inquiries Found</h3>
                <p class="text-xs text-slate-400">Institutional proposals submitted through the portal will be queued here.</p>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $inquiries->links() }}
        </div>
    </div>
</section>

@endsection
