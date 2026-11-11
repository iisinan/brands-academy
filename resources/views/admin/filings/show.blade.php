@extends('layouts.admin')

@section('title', 'Case File: ' . $filing->tracking_code)

@section('content')
<div class="space-y-8">
    <!-- Header & Breadcrumbs -->
    <div>
        <a href="{{ route('admin.filings') }}" class="text-xs text-blue-600 hover:underline flex items-center gap-1 mb-2 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Legal Desk
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-mono text-xs font-bold text-slate-500">{{ $filing->tracking_code }}</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700">
                        {{ $filing->type_title }}
                    </span>
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ $filing->proposed_name_1 }}
                </h1>
            </div>

            <div>
                @php
                    $badge = match($filing->status) {
                        'approved', 'delivered' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        'queried' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'payment_pending' => 'bg-slate-100 text-slate-600 border-slate-200',
                        default => 'bg-blue-50 text-blue-700 border-blue-200',
                    };
                @endphp
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badge }}">
                    <span class="w-2 h-2 rounded-full mr-2 {{ in_array($filing->status, ['approved', 'delivered']) ? 'bg-emerald-500' : ($filing->status === 'queried' ? 'bg-amber-500' : 'bg-blue-500 animate-pulse') }}"></span>
                    {{ $filing->status_label }}
                </span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl text-xs text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Case Data (2 cols) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Client & Business Particulars -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-6">Client & Business Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-1">Client Full Name:</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $filing->client_first_name }} {{ $filing->client_last_name }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Email & Phone:</span>
                        <span class="font-medium text-slate-800">{{ $filing->client_email }} | {{ $filing->client_phone }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">National ID (NIN):</span>
                        <span class="font-mono font-bold text-slate-900">{{ $filing->client_nin ?: 'Not Provided' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">State & Address:</span>
                        <span class="font-medium text-slate-800">{{ $filing->headquarters_state }} &bull; {{ $filing->business_address }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 block mb-1">Alternative Name Preferences:</span>
                        <span class="font-medium text-slate-800">{{ $filing->proposed_name_2 ?: 'None' }} / {{ $filing->proposed_name_3 ?: 'None' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 block mb-1">Principal Business Objects:</span>
                        <span class="text-slate-700 leading-relaxed font-light">{{ $filing->business_nature }}</span>
                    </div>
                    @if(!empty($filing->filing_data))
                        <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                            <span class="text-slate-400 block mb-2">Custom Filing Parameters:</span>
                            <pre class="bg-slate-50 p-3 rounded-lg text-[11px] font-mono text-slate-700 overflow-x-auto">{{ json_encode($filing->filing_data, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Uploaded Evidence & Verification Documents -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-sm font-bold text-slate-900">Uploaded Verification Documents ({{ $filing->documents->count() }})</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @forelse($filing->documents as $doc)
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-between text-xs">
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $doc->type_label }}</span>
                                <span class="text-[11px] text-slate-500">{{ $doc->file_name }} &bull; {{ $doc->formatted_size }}</span>
                            </div>
                            <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-xs transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>View</span>
                            </a>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic sm:col-span-2">No documents attached to this filing.</p>
                    @endforelse
                </div>
            </div>

            <!-- Official Certificate Upload (When Ready) -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-7 h-7 rounded-full bg-emerald-600 text-white font-bold text-xs flex items-center justify-center">✓</span>
                    <h3 class="text-sm font-bold text-slate-900">Upload Approved CAC / Trademark Certificate</h3>
                </div>
                <p class="text-xs text-slate-500 mb-6 font-light">
                    Upload the certified government registration certificate (PDF) once issued by the Corporate Affairs Commission or Trademark Registry.
                </p>

                @if($filing->official_certificate_path)
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between mb-6">
                        <div>
                            <span class="text-xs font-bold text-emerald-950 block">Official Certificate Stored</span>
                            <span class="text-[11px] text-emerald-700 font-mono">{{ $filing->government_filing_number }}</span>
                        </div>
                        <a href="{{ asset('storage/' . $filing->official_certificate_path) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 transition-colors">
                            <span>Open Certificate</span>
                        </a>
                    </div>
                @endif

                <form action="{{ route('admin.filings.certificate', $filing->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Government Filing / Registration Number *</label>
                            <input type="text" name="government_filing_number" value="{{ old('government_filing_number', $filing->government_filing_number) }}" required placeholder="e.g. BN 3928172 or RC 1928374 or RTM 9821" class="w-full text-xs rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500 font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Select Certificate PDF *</label>
                            <input type="file" name="official_certificate" required accept=".pdf,.jpg,.jpeg,.png" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Optional Closing Note</label>
                        <input type="text" name="remarks" placeholder="e.g. Certified status report and CAC Certificate sealed." class="w-full text-xs rounded-xl border-slate-300 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <span>Deposit Certificate & Approve Case</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar: Status Actions & Audit History (1 col) -->
        <div class="space-y-8">
            <!-- Action Registry Status Transition -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Update Case Status</h3>
                <form action="{{ route('admin.filings.status', $filing->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Target Status *</label>
                        <select name="status" class="w-full text-xs rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 font-medium">
                            <option value="payment_pending" {{ $filing->status === 'payment_pending' ? 'selected' : '' }}>Payment Pending</option>
                            <option value="submitted" {{ $filing->status === 'submitted' ? 'selected' : '' }}>Submitted (Paid)</option>
                            <option value="search_in_progress" {{ $filing->status === 'search_in_progress' ? 'selected' : '' }}>Search In Progress</option>
                            <option value="lodged_at_registry" {{ $filing->status === 'lodged_at_registry' ? 'selected' : '' }}>Lodged at Registry</option>
                            <option value="queried" {{ $filing->status === 'queried' ? 'selected' : '' }}>Queried (Action Required)</option>
                            <option value="approved" {{ $filing->status === 'approved' ? 'selected' : '' }}>Approved & Certified</option>
                            <option value="delivered" {{ $filing->status === 'delivered' ? 'selected' : '' }}>Delivered to Client</option>
                            <option value="rejected" {{ $filing->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Govt Registration / Filing No.</label>
                        <input type="text" name="government_filing_number" value="{{ $filing->government_filing_number }}" placeholder="e.g. BN 281920" class="w-full text-xs rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Client Query Notice (Visible to Client)</label>
                        <textarea name="client_query_message" rows="3" placeholder="If queried by CAC, describe what document the client must replace..." class="w-full text-xs rounded-xl border-slate-300 focus:ring-amber-500 focus:border-amber-500">{{ $filing->client_query_message }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Internal Remarks (Log)</label>
                        <textarea name="remarks" rows="2" placeholder="Audit note for legal team..." class="w-full text-xs rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs shadow-xs transition-colors">
                        Save Status Transition
                    </button>
                </form>
            </div>

            <!-- Audit Trail -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Audit Trail</h4>
                <div class="space-y-4">
                    @forelse($filing->statusLogs as $log)
                        <div class="flex items-start gap-3 text-xs">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                            <div>
                                <span class="text-[10px] font-mono text-slate-400 block">{{ $log->created_at->format('M d, H:i') }} &bull; {{ $log->changedByUser ? $log->changedByUser->name : 'System' }}</span>
                                <span class="text-slate-800 font-medium">{{ $log->remarks }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic">No transition logs recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
