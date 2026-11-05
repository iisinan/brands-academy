@extends('layouts.app')

@section('title', 'Members Directory - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Admin Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    Ongoing Members Directory
                </h1>
                <p class="text-slate-300 text-xs mt-1">Manage practitioners, students, and corporate fellows in good standing.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.members.export') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export CSV
                </a>
                <a href="{{ route('membership.register') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                    Public Form &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Search & Listing -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Search Bar & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
        <form action="{{ route('admin.members') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email, or Member ID..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
            
            <select name="category" class="px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Categories</option>
                <option value="student" {{ request('category') == 'student' ? 'selected' : '' }}>Student Member</option>
                <option value="professional" {{ request('category') == 'professional' ? 'selected' : '' }}>Professional Member</option>
                <option value="corporate" {{ request('category') == 'corporate' ? 'selected' : '' }}>Corporate Member</option>
                <option value="fellow" {{ request('category') == 'fellow' ? 'selected' : '' }}>Fellow / Academic</option>
            </select>

            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                Filter Directory
            </button>
            @if(request()->hasAny(['q', 'category']))
                <a href="{{ route('admin.members') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Member Name & ID</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Contact Info</th>
                        <th class="px-6 py-4">Affiliation & State</th>
                        <th class="px-6 py-4">Member Since</th>
                        <th class="px-6 py-4 text-right">Digital Card</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 text-sm block">{{ $member->full_name }}</span>
                                <span class="font-mono text-[11px] font-bold text-amber-700">{{ $member->member_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $member->category_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-800 font-medium">{{ $member->email }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $member->phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="font-medium text-slate-800">{{ $member->institution_or_company ?? '—' }}</div>
                                <div class="text-[11px] text-slate-500">{{ $member->state }}, Nigeria</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $member->joined_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank" class="font-bold text-amber-600 hover:underline">
                                    View Slip &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">No members found matching your search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($members->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $members->links() }}
            </div>
        @endif
    </div>

</section>

@endsection
