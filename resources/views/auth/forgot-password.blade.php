@extends('layouts.app')

@section('title', 'Forgot Password - Brands Academy Institutional Portal')

@push('styles')
<style>
    @keyframes checkmarkPop {
        0% { transform: scale(0) rotate(-15deg); opacity: 0; }
        60% { transform: scale(1.2) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }
    @keyframes strokeCheck {
        0% { stroke-dashoffset: 32; }
        100% { stroke-dashoffset: 0; }
    }
    .anim-check-pop {
        animation: checkmarkPop 0.36s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        transform-origin: center center;
    }
    .anim-check-stroke {
        stroke-dasharray: 32;
        stroke-dashoffset: 32;
        animation: strokeCheck 0.32s cubic-bezier(0.65, 0, 0.45, 1) 0.08s forwards;
    }
    .field-interactive {
        transition: border-color 0.22s ease, box-shadow 0.22s ease, background-color 0.22s ease, transform 0.15s ease;
    }
</style>
@endpush

@section('content')

<section class="min-h-[75vh] flex items-center justify-center py-14 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Ambient glow lights -->
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div 
        x-data="forgotPasswordForm()"
        class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-7 sm:p-10 shadow-2xl relative z-10"
    >
        <!-- Top accent gradient line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0 rounded-t-3xl"></div>

        <div class="text-center mb-7">
            <x-brand-logo class="w-14 h-14 mx-auto mb-3 drop-shadow-md" />
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title tracking-tight">Password Recovery</h1>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Enter your registered email address and we will generate a secure reset link for your Brands Academy account.
            </p>
        </div>

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop flex items-start gap-2.5 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <div>
                    <span class="font-bold block">Reset Link Dispatched</span>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <strong class="font-bold">Recovery Notice</strong>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST" @submit="isSubmitting = true" class="space-y-4">
            @csrf

            <!-- Email Address with Real-Time Validation & Typo Detection -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Registered Email <span class="text-rose-500">*</span>
                    </label>

                    <!-- Valid Format Badge -->
                    <span x-show="isEmailValid" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>Valid Email</span>
                    </span>

                    <!-- Typo Warning Badge -->
                    <span x-show="emailTypoSuggestion" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                        Typo in domain?
                    </span>
                </div>

                <div class="relative">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        x-model="email" 
                        @input="onEmailInput()"
                        @blur="onEmailInput()"
                        required 
                        autofocus 
                        placeholder="name@example.com"
                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 field-interactive placeholder-slate-400 focus:outline-none"
                        :class="{
                            'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10': isEmailValid && !emailTypoSuggestion,
                            'border-amber-400 ring-2 ring-amber-400/20 bg-amber-50/15': emailTypoSuggestion,
                            'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10': touched['email'] && !isEmailValid && !emailTypoSuggestion,
                            'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20': !touched['email']
                        }"
                    >
                </div>

                <!-- Typo Suggestion Box with One-Click Fix -->
                <div x-show="emailTypoSuggestion" x-cloak class="mt-2 p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-center justify-between gap-2.5 anim-check-pop shadow-xs">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span>Did you mean <strong class="underline decoration-amber-400 underline-offset-2" x-text="emailTypoSuggestion"></strong>?</span>
                    </div>
                    <button type="button" @click="applyEmailSuggestion()" class="px-2.5 py-1 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-[11px] font-bold shrink-0 transition-colors cursor-pointer">
                        Fix &rarr;
                    </button>
                </div>
            </div>

            <!-- Submit Button with Reactive Feedback -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    :disabled="isSubmitting || !isEmailValid"
                    class="w-full py-3.5 px-4 rounded-2xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/25 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer hover:scale-[1.01] active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <template x-if="!isSubmitting">
                        <span class="flex items-center gap-2">
                            <span>Send Recovery Link</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </template>
                    <template x-if="isSubmitting">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            <span>Generating Recovery Link...</span>
                        </span>
                    </template>
                </button>
            </div>
        </form>

        <div class="mt-7 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            Remembered your credentials?
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline">
                Back to Sign In &rarr;
            </a>
        </div>

        <div class="mt-4 text-center text-[10px] text-slate-400">
            CAC IT No. 7344471 &bull; Governed under CAMA CAP C20 LFN 2004
        </div>

    </div>
</section>

@push('scripts')
<script>
    function forgotPasswordForm() {
        return {
            email: '{{ old('email', '') }}',
            emailTypoSuggestion: '',
            suggestedDomain: '',
            isSubmitting: false,
            touched: {},

            touch(field) {
                this.touched[field] = true;
            },

            get isEmailValid() {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((this.email || '').trim());
            },

            onEmailInput() {
                this.touch('email');
                this.emailTypoSuggestion = '';
                this.suggestedDomain = '';

                const trimmed = (this.email || '').trim();
                const parts = trimmed.split('@');
                if (parts.length === 2) {
                    const user = parts[0];
                    const domain = parts[1].toLowerCase();
                    const typoMap = {
                        'gmial.com': 'gmail.com',
                        'gamil.com': 'gmail.com',
                        'gmaill.com': 'gmail.com',
                        'gmai.com': 'gmail.com',
                        'yaho.com': 'yahoo.com',
                        'yahooo.com': 'yahoo.com',
                        'hotmial.com': 'hotmail.com',
                        'hotmaill.com': 'hotmail.com',
                        'outlok.com': 'outlook.com',
                        'outllok.com': 'outlook.com'
                    };
                    if (typoMap[domain]) {
                        this.suggestedDomain = typoMap[domain];
                        this.emailTypoSuggestion = user + '@' + typoMap[domain];
                    }
                }
            },

            applyEmailSuggestion() {
                if (this.emailTypoSuggestion) {
                    this.email = this.emailTypoSuggestion;
                    this.emailTypoSuggestion = '';
                    this.suggestedDomain = '';
                }
            }
        };
    }
</script>
@endpush

@endsection
