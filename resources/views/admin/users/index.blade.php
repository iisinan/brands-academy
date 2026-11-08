@extends('layouts.admin')

@section('title', 'Users & RBAC Management - Admin')
@section('page_title', 'Users & Role-Based Access Control')

@section('content')

<div x-data="{ showCreateModal: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title">
                    User Accounts &amp; Smart RBAC
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">Manage system administrators, members, and access privileges.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button 
                type="button" 
                @click="showCreateModal = true" 
                class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors flex items-center gap-1.5 shadow-md shadow-amber-500/20"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Provision New Account</span>
            </button>
            <a href="{{ route('admin.members') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors">
                Members Directory &rarr;
            </a>
        </div>
    </div>

    <!-- Role Stats Strip -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Total Accounts</span>
            <span class="text-2xl font-extrabold text-slate-900 font-serif-title">{{ $roleCounts['total'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] uppercase font-bold text-amber-600 block tracking-wider">System Administrators</span>
            <span class="text-2xl font-extrabold text-amber-600 font-serif-title">{{ $roleCounts['admin'] }}</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-[10px] uppercase font-bold text-emerald-600 block tracking-wider">Foundation Members</span>
            <span class="text-2xl font-extrabold text-emerald-600 font-serif-title">{{ $roleCounts['member'] }}</span>
        </div>
    </div>

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
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Assigned Role</th>
                        <th class="px-6 py-4">Linked Member ID</th>
                        <th class="px-6 py-4">Registered Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
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
                                <div class="flex items-center justify-end gap-2">
                                    @if($user->id === auth()->id())
                                        <span class="text-slate-400 text-[11px] italic">Active Session</span>
                                    @else
                                        <!-- Role Toggle Form -->
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

                                        <!-- Delete Account Form -->
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Permanently delete {{ $user->name }}\'s account?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Account">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
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

    <!-- Role & Permissions Guide Matrix -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <h3 class="text-base font-bold text-slate-900 font-serif-title">Smart RBAC Permission Matrix</h3>
        </div>
        <p class="text-xs text-slate-500 mb-6">
            Brands Academy uses automated role-based routing. Once authenticated, users are granted immediate access to their authorized capabilities without manual toggling.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Admin Role Card -->
            <div class="p-5 rounded-2xl bg-slate-900 text-white border border-slate-800">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-400 text-slate-950">
                        Administrator
                    </span>
                    <span class="text-[11px] text-slate-400 font-mono">admin.dashboard</span>
                </div>
                <p class="text-xs text-slate-300 mb-4 leading-relaxed">
                    {{ \App\Enums\UserRole::Admin->description() }}
                </p>
                <div class="space-y-1.5 border-t border-slate-800 pt-3 text-[11px] text-slate-300">
                    <div class="flex items-center gap-2">✓ User Provisioning &amp; Role Management</div>
                    <div class="flex items-center gap-2">✓ Workshop Creation, Window Logic &amp; Cohort Management</div>
                    <div class="flex items-center gap-2">✓ Review Admissions &amp; Send Offer Letters</div>
                    <div class="flex items-center gap-2">✓ Evaluate Deliverables &amp; Portfolio Scores</div>
                    <div class="flex items-center gap-2">✓ Bulk Issue Digital Certificates &amp; Dispatch PDFs</div>
                    <div class="flex items-center gap-2">✓ Institutional Partnerships &amp; CSV Data Exports</div>
                    <div class="flex items-center gap-2">✓ Member Portal Preview Mode</div>
                </div>
            </div>

            <!-- Member Role Card -->
            <div class="p-5 rounded-2xl bg-amber-50 text-amber-950 border border-amber-200">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-500 text-slate-950">
                        Foundation Member
                    </span>
                    <span class="text-[11px] text-amber-700 font-mono">member.dashboard</span>
                </div>
                <p class="text-xs text-amber-800 mb-4 leading-relaxed">
                    {{ \App\Enums\UserRole::Member->description() }}
                </p>
                <div class="space-y-1.5 border-t border-amber-200/60 pt-3 text-[11px] text-amber-900">
                    <div class="flex items-center gap-2">✓ Personalized Member Services Dashboard</div>
                    <div class="flex items-center gap-2">✓ Digital Member ID Card &amp; QR Slip</div>
                    <div class="flex items-center gap-2">✓ Cohort Fast-Application with Member ID</div>
                    <div class="flex items-center gap-2">✓ Applied Portfolio Deliverable Submission</div>
                    <div class="flex items-center gap-2">✓ Personal Certificate Verification &amp; PDF Download</div>
                </div>
            </div>
        </div>
    </div>

<!-- Provision New Account Modal -->
<div 
    x-show="showCreateModal" 
    x-cloak 
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div 
            x-show="showCreateModal" 
            x-transition.opacity 
            class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs transition-opacity" 
            @click="showCreateModal = false"
        ></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div 
            x-show="showCreateModal" 
            x-transition.scale.origin.bottom 
            class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl border border-slate-200 sm:p-8"
        >
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 font-serif-title">Provision New User Account</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Assign role privileges with automated RBAC detection.</p>
                </div>
                <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name</label>
                    <input type="text" name="name" required placeholder="e.g. Dr. Titus Eveshoyan" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="user@brandsacademy.org" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Initial Password</label>
                    <input type="password" name="password" required minlength="8" placeholder="At least 8 characters" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Assigned Role</label>
                    <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                        <option value="member">Foundation Member (Member Services)</option>
                        <option value="admin">Administrator (Full Control Panel)</option>
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1">
                        When the user signs in with this email and password, the Smart RBAC will immediately identify their role.
                    </p>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button type="button" @click="showCreateModal = false" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-colors shadow-md">
                        Provision Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

@endsection
