@extends('layouts.app')

@section('title', 'Sign In - Brands Academy Institutional Portal')

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
    <!-- Subtle ambient glow background accents -->
    <div class="absolute -top-32 -left-32 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div 
        x-data="loginPortalForm()"
        x-init="if (email) checkRole()"
        class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-7 sm:p-10 shadow-2xl relative z-10"
    >
        <!-- Top accent gradient line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0 rounded-t-3xl"></div>

        <!-- Header -->
        <div class="text-center mb-7">
            <x-brand-logo class="w-14 h-14 mx-auto mb-3 drop-shadow-md" />
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title tracking-tight">Portal Sign In</h1>
            <p class="text-xs text-slate-500 mt-1">Access Member Services or Administration</p>
            
            <!-- Smart RBAC Feature Pill -->
            <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-700 border border-amber-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Smart Single Sign-In &bull; Auto Role Detection</span>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <strong class="font-bold">Authentication Notice</strong>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" @submit="isSubmitting = true" class="space-y-4">
            @csrf

            <!-- Email Address with Real-Time Validation & Role Detection -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Email Address <span class="text-rose-500">*</span>
                    </label>

                    <!-- Checking Role Spinner -->
                    <span x-show="isCheckingRole" x-cloak class="text-[11px] text-amber-600 flex items-center gap-1 font-medium">
                        <svg class="animate-spin w-3 h-3 text-amber-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Detecting role...</span>
                    </span>

                    <!-- Valid Format Badge -->
                    <span x-show="isEmailValid && !isCheckingRole" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
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
                        @blur="onEmailInput(true)"
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

                <!-- Typo Suggestion Helper Box with One-Click Fix -->
                <div x-show="emailTypoSuggestion" x-cloak class="mt-2 p-2.5 rounded-xl bg-amber-50 border border-amber-200 text-xs text-amber-900 flex items-center justify-between gap-2.5 anim-check-pop shadow-xs">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span>Did you mean <strong class="underline decoration-amber-400 underline-offset-2" x-text="emailTypoSuggestion"></strong>?</span>
                    </div>
                    <button type="button" @click="applyEmailSuggestion()" class="px-2.5 py-1 rounded-lg bg-amber-600 hover:bg-amber-700 text-white text-[11px] font-bold shrink-0 transition-colors cursor-pointer">
                        Fix &rarr;
                    </button>
                </div>

                <!-- Live Role Detection Visual Card -->
                <div x-show="detectedRole" x-cloak x-transition.opacity.duration.200ms class="mt-2.5 anim-check-pop">
                    <template x-if="detectedRole === 'admin'">
                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-900 text-amber-400 border border-slate-800 shadow-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold text-xs">
                                    🛡️
                                </span>
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-slate-400 block tracking-wider">Account Recognized</span>
                                    <span class="font-bold text-amber-300">Administrator &bull; Control Panel</span>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400 bg-emerald-500/20 px-2 py-0.5 rounded-full border border-emerald-500/30">
                                <svg class="w-2.5 h-2.5 anim-check-stroke" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Verified
                            </span>
                        </div>
                    </template>
                    <template x-if="detectedRole === 'member'">
                        <div class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-semibold bg-amber-50 text-amber-950 border border-amber-200 shadow-sm">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-lg bg-amber-500/20 text-amber-700 flex items-center justify-center font-bold text-xs">
                                    🎓
                                </span>
                                <div>
                                    <span class="text-[9px] uppercase font-bold text-amber-700 block tracking-wider">Account Recognized</span>
                                    <span class="font-bold text-amber-950">Foundation Member &bull; Portal</span>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full border border-emerald-200">
                                <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                Active Member
                            </span>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Password with Show/Hide Toggle & Caps Lock Warning -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Password <span class="text-rose-500">*</span>
                    </label>
                    
                    <!-- Caps Lock Warning -->
                    <span x-show="capsLockOn" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                        <span>⚠️</span> Caps Lock is ON
                    </span>

                    <!-- Entered Check -->
                    <span x-show="password.length >= 1 && !capsLockOn" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>Entered</span>
                    </span>
                </div>

                <div class="relative">
                    <input 
                        :type="showPass ? 'text' : 'password'" 
                        id="password" 
                        name="password" 
                        x-model="password" 
                        @input="touch('password')"
                        @keydown="checkCapsLock($event)"
                        @keyup="checkCapsLock($event)"
                        required 
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 pr-11 field-interactive placeholder-slate-400 focus:outline-none"
                        :class="password.length >= 1 ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'"
                    >
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>

            <!-- Remember me & Forgot Password -->
            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="rounded text-amber-500 focus:ring-amber-500">
                    <span class="font-medium">Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="font-semibold text-amber-600 hover:text-amber-500 hover:underline">
                    Forgot password?
                </a>
            </div>

            <!-- Submit Button with Reactive Feedback -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    :disabled="isSubmitting"
                    class="w-full py-3.5 px-4 rounded-2xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/25 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer hover:scale-[1.01] active:scale-[0.99] disabled:opacity-75 disabled:cursor-not-allowed"
                >
                    <template x-if="!isSubmitting">
                        <span class="flex items-center gap-2">
                            <span>Sign In to Portal</span>
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
                            <span>Authenticating Credentials...</span>
                        </span>
                    </template>
                </button>
            </div>
        </form>

        <!-- Ongoing Membership Registration Callout -->
        <div class="mt-7 pt-5 border-t border-slate-100 text-center">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200 mb-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Ongoing Membership &bull; Open 24/7 Year-Round
            </span>
            <p class="text-xs text-slate-600">
                Don't have a membership account yet?
                <a href="{{ route('membership.register') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline block sm:inline mt-0.5 sm:mt-0">
                    Apply for Membership &rarr;
                </a>
            </p>
        </div>

        <div class="mt-4 text-center text-[10px] text-slate-400">
            CAC IT No. 7344471 &bull; Governed under CAMA CAP C20 LFN 2004
        </div>

    </div>
</section>

@push('scripts')
<script>
    function loginPortalForm() {
        return {
            email: '{{ old('email', '') }}',
            password: '',
            showPass: false,
            capsLockOn: false,
            emailTypoSuggestion: '',
            suggestedDomain: '',
            isCheckingRole: false,
            detectedRole: null,
            roleLabel: null,
            roleBadge: '',
            isSubmitting: false,
            touched: {},
            checkDebounceTimer: null,

            touch(field) {
                this.touched[field] = true;
            },

            checkCapsLock(e) {
                if (e.getModifierState) {
                    this.capsLockOn = e.getModifierState('CapsLock');
                }
            },

            get isEmailValid() {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test((this.email || '').trim());
            },

            onEmailInput(immediate = false) {
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

                if (immediate) {
                    this.checkRole();
                } else {
                    clearTimeout(this.checkDebounceTimer);
                    this.checkDebounceTimer = setTimeout(() => {
                        this.checkRole();
                    }, 400);
                }
            },

            applyEmailSuggestion() {
                if (this.emailTypoSuggestion) {
                    this.email = this.emailTypoSuggestion;
                    this.emailTypoSuggestion = '';
                    this.suggestedDomain = '';
                    this.checkRole();
                }
            },

            checkRole() {
                const trimmed = (this.email || '').trim();
                if (!this.isEmailValid || this.emailTypoSuggestion) {
                    this.detectedRole = null;
                    return;
                }

                this.isCheckingRole = true;
                fetch('{{ route('login.detect-role') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ email: trimmed })
                })
                .then(res => res.json())
                .then(data => {
                    if (data && data.detected) {
                        this.detectedRole = data.role;
                        this.roleLabel = data.role_label;
                        this.roleBadge = data.badge_classes;
                    } else {
                        this.detectedRole = null;
                        this.roleLabel = null;
                    }
                })
                .catch(() => {
                    this.detectedRole = null;
                })
                .finally(() => {
                    this.isCheckingRole = false;
                });
            }
        };
    }
</script>
@endpush

@endsection
