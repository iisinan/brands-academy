@extends('layouts.app')

@section('title', 'Start a Discussion | Brands Academy Community')

@section('content')
<div class="bg-slate-950 text-white py-12 border-b border-slate-800">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('forum.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-amber-400 hover:text-amber-300 mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Community Feed
        </a>
        <h1 class="text-2xl sm:text-3xl font-serif-title font-bold text-white">Start a New Discussion</h1>
        <p class="mt-1 text-slate-300 text-xs sm:text-sm">Pose an intellectual brand question, share an empirical case study, or seek practical IP counsel.</p>
    </div>
</div>

<div class="bg-slate-50 py-10 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-xs">
            <form method="POST" action="{{ route('forum.store') }}" class="space-y-6">
                @csrf

                <!-- Channel Selector -->
                <div>
                    <label for="channel_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Select Channel <span class="text-rose-500">*</span>
                    </label>
                    <select name="channel_id" id="channel_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        <option value="">-- Choose Discussion Domain --</option>
                        @foreach($channels as $channel)
                            <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                {{ $channel->name }} {{ $channel->is_member_only ? '(Members Only)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('channel_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discussion Title -->
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Discussion Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Navigating Multi-Class Trademark Filings for Agritech Startups in Nigeria" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    <p class="mt-1 text-[11px] text-slate-500">Keep titles clear, specific, and framed around an actionable problem.</p>
                    @error('title')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Discussion Body -->
                <div>
                    <label for="body" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Discussion Content &amp; Context <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="body" id="body" rows="9" required placeholder="Provide all relevant background, market contexts, research questions, or technical details..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 leading-relaxed">{{ old('body') }}</textarea>
                    <p class="mt-1 text-[11px] text-slate-500">Supports markdown formatting (paragraphs, bullet lists, bold text).</p>
                    @error('body')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-xs text-amber-900 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <div class="font-bold text-amber-950">Foundation Forum Charter:</div>
                        <div class="mt-0.5 text-amber-800">Posts are peer-reviewed by fellow members and faculty. Please adhere to evidence-based discussion standards and avoid overt promotional spam.</div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('forum.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 text-xs font-bold shadow-md shadow-amber-500/20 transition-all hover:scale-[1.02]">
                        Publish Discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
