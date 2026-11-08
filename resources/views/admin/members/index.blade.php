@extends('layouts.admin')

@section('title', 'Members Directory - Admin')
@section('page_title', '2. Members Directory Management')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6"
     x-data="{
        editModalOpen: false,
        activeMember: {
            id: null,
            full_name: '',
            first_name: '',
            last_name: '',
            email: '',
            phone: '',
            category: 'professional',
            status: 'active',
            institution_or_company: '',
            designation: '',
            state: '',
            country: 'Nigeria',
            bio: '',
            member_number: '',
            qr_code_token: '',
            payment_status: '',
            has_user: false
        },
        openMember(member, hasUser) {
            this.activeMember = {
                id: member.id,
                full_name: member.first_name + ' ' + member.last_name,
                first_name: member.first_name || '',
                last_name: member.last_name || '',
                email: member.email || '',
                phone: member.phone || '',
                category: member.category || 'professional',
                status: member.status || 'active',
                institution_or_company: member.institution_or_company || '',
                designation: member.designation || '',
                state: member.state || '',
                country: member.country || 'Nigeria',
                bio: member.bio || '',
                member_number: member.member_number || '',
                qr_code_token: member.qr_code_token || '',
                payment_status: member.payment_status || 'pending',
                has_user: hasUser
            };
            this.editModalOpen = true;
        }
     }">

    <!-- Header Actions Strip -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-serif-title">
                    Ongoing Members Directory
                </h1>
            </div>
            <p class="text-xs text-slate-500 mt-1">
                Oversee practitioners, fellows, students, and corporate affiliates; review dues payments, update credentials, and allocate official Member IDs.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('admin.members.export') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all flex items-center gap-1.5 shadow-md shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('admin.users') }}" class="px-4 py-2.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>RBAC Roles</span>
            </a>
            <a href="{{ route('membership.register') }}" target="_blank" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                Public Form &rarr;
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs">
        <form action="{{ route('admin.members') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name, email, or Member ID..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
            
            <select name="category" class="px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
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
                <a href="{{ route('admin.members') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-500 hover:bg-slate-100 transition-colors text-center flex items-center justify-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase font-bold text-[10px]">
                    <tr>
                        <th class="px-6 py-4">Member Name &amp; ID</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Portal Role</th>
                        <th class="px-6 py-4">Contact Info</th>
                        <th class="px-6 py-4">Affiliation &amp; State</th>
                        <th class="px-6 py-4">Dues &amp; Payment</th>
                        <th class="px-6 py-4">Member Since</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $member)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 text-sm block">{{ $member->full_name }}</span>
                                @if($member->member_number)
                                    <span class="font-mono text-[11px] font-bold text-amber-700">{{ $member->member_number }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                        Pending Payment
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $member->category_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($member->user)
                                    @if($member->user->isAdmin())
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-900 text-amber-400">
                                            Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-900 border border-amber-200">
                                            Member
                                        </span>
                                    @endif
                                @else
                                    <span class="text-slate-400 text-[10px] italic">No Account</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-slate-800 font-medium">{{ $member->email }}</div>
                                <div class="text-slate-500 text-[11px]">{{ $member->phone }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                <div class="font-medium text-slate-800">{{ $member->institution_or_company ?? '—' }}</div>
                                <div class="text-[11px] text-slate-500">{{ $member->state }}, {{ $member->country ?? 'Nigeria' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($member->isPaid())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Paid ({{ $member->getFeeFormatted() }})
                                    </span>
                                    <div class="text-[10px] text-slate-400 mt-0.5 font-mono">{{ ucfirst($member->payment_method ?? 'gateway') }}</div>
                                @elseif($member->isUnderReview())
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-50 text-amber-800 border border-amber-300">
                                            Under Review
                                        </span>
                                        @if($member->payment_proof)
                                            <div>
                                                <a href="{{ asset('storage/' . $member->payment_proof) }}" target="_blank" class="text-[10.5px] text-amber-700 hover:underline font-semibold block">
                                                    View Proof &rarr;
                                                </a>
                                            </div>
                                        @endif
                                        <form action="{{ route('admin.members.payment-status', $member->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="payment_status" value="paid">
                                            <button type="submit" class="px-2 py-0.5 text-[10px] font-bold bg-emerald-600 hover:bg-emerald-700 text-white rounded transition cursor-pointer">
                                                Approve
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            Unpaid ({{ $member->getFeeFormatted() }})
                                        </span>
                                        <form action="{{ route('admin.members.payment-status', $member->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="payment_status" value="paid">
                                            <button type="submit" class="px-2 py-0.5 text-[10px] font-bold bg-slate-900 hover:bg-slate-800 text-amber-400 rounded transition cursor-pointer">
                                                Mark Paid
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ $member->joined_at ? $member->joined_at->format('M d, Y') : '—' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Manage / Edit Dossier Button -->
                                    <button type="button"
                                            @click="openMember({{ json_encode($member) }}, {{ $member->user ? 'true' : 'false' }})"
                                            class="px-2.5 py-1.5 rounded-lg text-xs font-bold bg-slate-900 hover:bg-slate-800 text-amber-400 transition-colors flex items-center gap-1 shadow-xs cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>Manage</span>
                                    </button>

                                    <!-- Digital Card Slip Link -->
                                    <a href="{{ route('membership.card', $member->qr_code_token) }}" target="_blank"
                                       class="px-2 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors"
                                       title="View Official Digital Card Slip">
                                        Card &rarr;
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-500">No members found matching your search.</td>
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

    <!-- Alpine.js Slide-over / Modal for Member Dossier & Edit -->
    <div x-show="editModalOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/60 backdrop-blur-sm flex justify-end">

        <div @click.away="editModalOpen = false"
             x-show="editModalOpen"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="relative w-full max-w-xl bg-white min-h-screen shadow-2xl flex flex-col justify-between">

            <!-- Modal Header -->
            <div class="p-6 border-b border-slate-200 bg-slate-50/50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 font-bold font-serif-title flex items-center justify-center text-lg shadow-sm">
                        <span x-text="activeMember.first_name ? activeMember.first_name[0] : 'M'"></span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold font-serif-title text-slate-900" x-text="activeMember.full_name"></h2>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="font-mono text-xs font-bold text-amber-700" x-text="activeMember.member_number || 'ID: Pending Payment'"></span>
                            <span class="inline-block w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="text-xs text-slate-500 capitalize" x-text="activeMember.category"></span>
                        </div>
                    </div>
                </div>

                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 p-2 rounded-xl hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Quick Action Bar Inside Drawer -->
            <div class="px-6 py-3.5 bg-amber-50/60 border-b border-amber-100 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <!-- Resend Welcome Email Form -->
                    <form :action="'{{ url('admin/members') }}/' + activeMember.id + '/resend-welcome'" method="POST" class="inline" onsubmit="return confirm('Re-dispatch official welcome email with Member ID and credentials to ' + activeMember.email + '?')">
                        @csrf
                        <button type="submit"
                                :disabled="!activeMember.has_user"
                                :class="!activeMember.has_user ? 'opacity-50 cursor-not-allowed' : 'hover:bg-amber-100'"
                                class="px-3 py-1.5 rounded-lg text-xs font-bold bg-white text-amber-900 border border-amber-200 transition-colors flex items-center gap-1.5 shadow-xs">
                            <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Resend Welcome Email</span>
                        </button>
                    </form>
                </div>

                <!-- Digital Card Slip Link -->
                <a :href="'{{ url('membership/card') }}/' + activeMember.qr_code_token" target="_blank"
                   class="px-3 py-1.5 rounded-lg text-xs font-bold text-slate-700 hover:text-slate-950 bg-white border border-slate-200 hover:bg-slate-50 transition-colors flex items-center gap-1 shadow-xs">
                    <span>View Digital Card</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>

            <!-- Modal Body: Edit Form -->
            <form :action="'{{ url('admin/members') }}/' + activeMember.id" method="POST" class="p-6 space-y-5 flex-1 overflow-y-auto">
                @csrf
                @method('PUT')

                <!-- Email Display (Read-only) -->
                <div>
                    <label class="block text-[11px] uppercase font-bold text-slate-500 mb-1">Registered Email Address</label>
                    <input type="text" :value="activeMember.email" disabled class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 text-xs font-medium cursor-not-allowed">
                    <span class="text-[10px] text-slate-400 mt-0.5 block">Email is linked to portal login account.</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Membership Category -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Membership Category *</label>
                        <select name="category" x-model="activeMember.category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                            <option value="student">Student Member</option>
                            <option value="professional">Professional Member</option>
                            <option value="corporate">Corporate Member</option>
                            <option value="fellow">Fellow / Academic</option>
                        </select>
                    </div>

                    <!-- Membership Status -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Membership Status *</label>
                        <select name="status" x-model="activeMember.status" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 bg-white">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" x-model="activeMember.phone" placeholder="+234 800 000 0000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Institution or Company -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Institution or Company</label>
                        <input type="text" name="institution_or_company" x-model="activeMember.institution_or_company" placeholder="e.g. Ahmadu Bello University" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Designation / Title -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Designation / Role</label>
                        <input type="text" name="designation" x-model="activeMember.designation" placeholder="e.g. Creative Director" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- State -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">State of Residence *</label>
                        <input type="text" name="state" x-model="activeMember.state" required placeholder="e.g. Kaduna" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Country *</label>
                        <input type="text" name="country" x-model="activeMember.country" required placeholder="e.g. Nigeria" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>

                <!-- Professional Bio -->
                <div>
                    <label class="block text-[11px] uppercase font-bold text-slate-700 mb-1">Professional Bio / Profile Summary</label>
                    <textarea name="bio" rows="4" x-model="activeMember.bio" placeholder="Brief summary of professional experience, branding focus, or academic research..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:outline-none focus:ring-2 focus:ring-amber-500"></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 transition-all shadow-md shadow-amber-500/20">
                        Save Member Dossier
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
