@extends('layouts.app')

@section('title', 'Users & RBAC Management - Admin')

@section('content')

<!-- Header -->
<section class="bg-slate-900 text-white py-10 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-400 hover:underline block mb-1">&larr; Admin Dashboard</a>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif-title">
                    User Accounts &amp; Smart RBAC
                </h1>
                <p class="text-slate-300 text-xs mt-1">Manage system administrators, members, and access privileges.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.members') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-white/10 hover:bg-white/20 text-white transition-colors">
                    Members Directory &rarr;
                </a>
            </div>
        </div>

        <!-- Role Stats Strip -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
            <div class="bg-slate-800/80 p-4 rounded-xl border border-slate-700/60">
                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Total Accounts</span>
                <span class="text-2xl font-extrabold text-white font-serif-title">{{ $roleCounts['total'] }}</span>
            </div>
            <div class="bg-slate-800/80 p-4 rounded-xl border border-slate-700/60">
                <span class="text-[10px] uppercase font-bold text-amber-400 block tracking-wider">System Administrators</span>
                <span class="text-2xl font-extrabold text-amber-400 font-serif-title">{{ $roleCounts['admin'] }}</span>
            </div>
            <div class="bg-slate-800/80 p-4 rounded-xl border border-slate-700/60">
                <span class="text-[10px] uppercase font-bold text-emerald-400 block tracking-wider">Foundation Members</span>
                <span class="text-2xl font-extrabold text-emerald-400 font-serif-title">{{ $roleCounts['member'] }}</span>
            </div>
        </div>
    </div>
</section>

<!-- Search & Listing -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Search Bar & Filter -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
        <form action="{{ route('admin.users') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input 
                type="text" 
                name="q" 
                value="{{ request('q') }}" 
                placeholder="Search by name or email address..." 
                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500"
            >
            
            <select name="role" class="px-3 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Foundation Member</option>
            </select>

            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white transition-colors">
                Filter Accounts
            </button>
            @if(request()->hasAny(['q', 'role']))
                <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center">
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
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Current Role</th>
                        <th class="px-6 py-4">Linked Member ID</th>
                        <th class="px-6 py-4">Registered Date</th>
                        <th class="px-6 py-4 text-right">RBAC Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-bold flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 text-sm block">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="ml-1 text-[10px] font-semibold text-amber-600 bg-amber-50 border border-amber-200 px-1.5 py-0.2 rounded-full">You</span>
                                            @endif
                                        </span>
                                        <span class="text-slate-500 text-[11px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-900 text-amber-400 border border-slate-800">
                                        <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                        <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Foundation Member
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->member)
                                    <span class="font-mono text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded-md">
                                        {{ $user->member->member_number }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">No linked member record</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($user->id === auth()->id())
                                    <span class="text-slate-400 text-[11px] italic">Active Session</span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.role', $user->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to change the role for {{ $user->name }}?');">
                                        @csrf
                                        @if($user->isAdmin())
                                            <input type="hidden" name="role" value="member">
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-200 transition-colors">
                                                Switch to Member
                                            </button>
                                        @else
                                            <input type="hidden" name="role" value="admin">
                                            <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-amber-400 transition-colors">
                                                Promote to Admin
                                            </button>
                                        @endif
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                No user accounts matching your criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
