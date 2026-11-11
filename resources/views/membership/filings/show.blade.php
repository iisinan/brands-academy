@extends('layouts.member')

@section('title', 'Case Room: ' . $filing->tracking_code . ' | Brands Academy')

@section('content')
<div class="space-y-8">
    <!-- Top Breadcrumb & Header -->
    <div>
        <a href="{{ route('member.filings.index') }}" class="text-xs text-blue-600 hover:underline flex items-center gap-1 mb-2 font-medium">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Legal Filings
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

    @if(session('error'))
        <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl text-xs text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <!-- 5-Stage Visual Stepper -->
    <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6">Statutory Filing Progress</h4>
        @php
            $step = $filing->status_step_index;
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-4">
            <!-- Step 1 -->
            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 1 ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                    @if($step >= 1) ✓ @else 1 @endif
                </div>
                <div>
                    <div class="text-xs font-bold {{ $step >= 1 ? 'text-slate-900' : 'text-slate-400' }}">Lodge & Paid</div>
                    <div class="text-[10px] text-slate-500">Case Created</div>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 2 ? 'bg-emerald-600 text-white' : ($step == 1 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600') }}">
                    @if($step >= 2) ✓ @else 2 @endif
                </div>
                <div>
                    <div class="text-xs font-bold {{ $step >= 2 ? 'text-slate-900' : ($step == 1 ? 'text-blue-600' : 'text-slate-400') }}">Name Search</div>
                    <div class="text-[10px] text-slate-500">CAC/IPO Database</div>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 3 ? 'bg-emerald-600 text-white' : ($step == 2 ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-600') }}">
                    @if($step >= 3) ✓ @else 3 @endif
                </div>
                <div>
                    <div class="text-xs font-bold {{ $step >= 3 ? 'text-slate-900' : ($step == 2 ? 'text-blue-600' : 'text-slate-400') }}">Registry Filing</div>
                    <div class="text-[10px] text-slate-500">Statutory Lodgement</div>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $step >= 4 ? 'bg-emerald-600 text-white' : ($step == 3 ? ($filing->isQueried() ? 'bg-amber-500 text-white' : 'bg-blue-600 text-white') : 'bg-slate-200 text-slate-600') }}">
                    @if($step >= 4) ✓ @else 4 @endif
                </div>
                <div>
                    <div class="text-xs font-bold {{ $step >= 4 ? 'text-slate-900' : ($step == 3 ? ($filing->isQueried() ? 'text-amber-600' : 'text-blue-600') : 'text-slate-400') }}">
                        {{ $filing->isQueried() ? 'Action Required' : 'Registry Audit' }}
                    </div>
                    <div class="text-[10px] text-slate-500">{{ $filing->isQueried() ? 'Document Query' : 'Compliance Check' }}</div>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="flex sm:flex-col items-center sm:text-center gap-3 sm:gap-2">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $filing->isApproved() ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                    @if($filing->isApproved()) ✓ @else 5 @endif
                </div>
                <div>
                    <div class="text-xs font-bold {{ $filing->isApproved() ? 'text-emerald-700' : 'text-slate-400' }}">Certified</div>
                    <div class="text-[10px] text-slate-500">Certificate Issued</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Official Certificate Ready Card -->
    @if($filing->isApproved())
        <div class="bg-emerald-50 border-2 border-emerald-300 rounded-2xl p-6 sm:p-8 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-100 text-emerald-800 uppercase tracking-wider mb-1">
                        Registration Completed
                    </span>
                    <h3 class="text-lg font-black text-emerald-950">Official Certificate of Registration Issued</h3>
                    <p class="text-xs text-emerald-800 font-light mt-0.5">
                        Government Filing / Registration Number: <strong class="font-mono">{{ $filing->government_filing_number }}</strong>
                    </p>
                </div>
            </div>

            <a href="{{ route('member.filings.certificate', $filing->tracking_code) }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <span>Download Official Certificate</span>
            </a>
        </div>
    @endif

    <!-- Registry Query Action Alert & Upload Form -->
    @if($filing->isQueried())
        <div class="bg-amber-50 border-2 border-amber-300 rounded-2xl p-6 sm:p-8 shadow-xs">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-amber-950">Registry Query: Action Required</h3>
                    <p class="text-xs text-amber-800 font-light mt-1">
                        The registry has requested a modification or updated document for this application. Please read the counsel's note below and upload the requested file to proceed.
                    </p>
                    <div class="mt-3 bg-white p-3.5 rounded-xl border border-amber-200 text-xs text-amber-900 font-medium">
                        "{{ $filing->client_query_message }}"
                    </div>
                </div>
            </div>

            <!-- Upload replacement document -->
            <form action="{{ route('member.filings.upload', $filing->tracking_code) }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 rounded-xl border border-amber-200">
                @csrf
                <h4 class="text-xs font-bold text-slate-900 mb-3">Upload Queried Document / Replacement File</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Document Category *</label>
                        <select name="document_type" required class="w-full text-xs rounded-lg border-slate-300 focus:ring-amber-500 focus:border-amber-500">
                            <option value="nin_slip">National ID / NIN Slip</option>
                            <option value="passport_photo">Passport Photograph</option>
                            <option value="signature_specimen">Specimen Signature</option>
                            <option value="trademark_logo">Brand Logo / Artwork</option>
                            <option value="cac_consent">Consent Letter</option>
                            <option value="other">Other Requested Document</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-700 mb-1">Select File (PDF, JPG, PNG) *</label>
                        <input type="file" name="document_file" required accept=".pdf,.jpg,.jpeg,.png,.zip" class="text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-[11px] font-semibold text-slate-700 mb-1">Optional Note for Legal Counsel</label>
                    <input type="text" name="client_comment" placeholder="e.g. Attached clear color scan of signature" class="w-full text-xs rounded-lg border-slate-300 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs shadow-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    <span>Resubmit Queried Document</span>
                </button>
            </form>
        </div>
    @endif

    <!-- Case Details & Documents Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Particulars (2 cols) -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-6">Case Particulars</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-1">Primary Proposed Name:</span>
                        <span class="font-bold text-slate-900 text-sm">{{ $filing->proposed_name_1 }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Alternative Names:</span>
                        <span class="font-medium text-slate-700">{{ $filing->proposed_name_2 ?: 'None' }} / {{ $filing->proposed_name_3 ?: 'None' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Operating State:</span>
                        <span class="font-medium text-slate-800">{{ $filing->headquarters_state }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Government Filing No:</span>
                        <span class="font-mono font-bold text-slate-900">{{ $filing->government_filing_number ?: 'Pending Assignment' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 block mb-1">Business Address:</span>
                        <span class="font-medium text-slate-800">{{ $filing->business_address }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="text-slate-400 block mb-1">Nature of Business:</span>
                        <span class="text-slate-700 leading-relaxed font-light">{{ $filing->business_nature }}</span>
                    </div>
                </div>
            </div>

            <!-- Uploaded Documents Repository -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Attached Documents ({{ $filing->documents->count() }})</h3>
                <div class="space-y-3">
                    @forelse($filing->documents as $doc)
                        <div class="flex items-center justify-between p-3.5 rounded-xl border border-slate-100 bg-slate-50 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-[10px]">
                                    DOC
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-900">{{ $doc->type_label }}</div>
                                    <div class="text-[11px] text-slate-500">{{ $doc->file_name }} &bull; {{ $doc->formatted_size }}</div>
                                </div>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-500">
                                {{ $doc->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic">No verification documents attached.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar: Activity Timeline & Fees -->
        <div class="space-y-8">
            <!-- Fee Summary -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Fee Breakdown</h4>
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Total Statutory Fee:</span>
                        <span class="font-bold text-slate-900">₦{{ number_format($filing->total_fee, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Amount Paid:</span>
                        <span class="font-bold text-emerald-600">₦{{ number_format($filing->fee_paid, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Payment Reference:</span>
                        <span class="font-mono text-[10px] text-slate-500">{{ $filing->payment_reference ?: 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Case History / Timeline -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Case History</h4>
                <div class="space-y-4">
                    @foreach($filing->statusLogs as $log)
                        <div class="flex items-start gap-3 text-xs">
                            <span class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                            <div>
                                <span class="text-[10px] font-mono text-slate-400 block">{{ $log->created_at->format('M d, H:i') }}</span>
                                <span class="text-slate-800 font-medium">{{ $log->remarks }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
