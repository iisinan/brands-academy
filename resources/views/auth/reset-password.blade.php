@extends('layouts.app')

@section('title', 'Set New Password - Brands Academy Nigeria Foundation')

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
        x-data="resetPasswordForm()"
        class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-7 sm:p-10 shadow-2xl relative z-10"
    >
        <!-- Top accent gradient line -->
        <div class="h-1.5 w-full bg-gradient-to-r from-amber-500 via-amber-400 to-emerald-500 absolute top-0 left-0 rounded-t-3xl"></div>

        <div class="text-center mb-7">
            <x-brand-logo class="w-14 h-14 mx-auto mb-3 drop-shadow-md" />
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-serif-title tracking-tight">Set New Password</h1>
            <p class="text-xs text-slate-500 mt-2">
                Choose a strong new password to restore access to your Brands Academy account.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-2xl mb-6 text-xs font-medium anim-check-pop">
                <div class="flex items-center gap-2 mb-1">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    <strong class="font-bold">Password Notice</strong>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST" @submit="isSubmitting = true" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Address (Read-only verification) -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Account Email</label>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400">
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Locked
                    </span>
                </div>
                <input type="email" name="email" value="{{ old('email', $email) }}" readonly class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-500 text-sm cursor-not-allowed">
            </div>

            <!-- New Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        New Password <span class="text-rose-500">*</span>
                    </label>

                    <!-- Caps Lock Warning -->
                    <span x-show="capsLockOn" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                        <span>⚠️</span> Caps Lock is ON
                    </span>

                    <span x-show="password.length >= 8 && !capsLockOn" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>8+ chars</span>
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
                        autofocus 
                        placeholder="Minimum 8 characters"
                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 pr-11 field-interactive placeholder-slate-400 focus:outline-none"
                        :class="password.length >= 8 ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20'"
                    >
                    <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>

                <!-- Password Strength Meter -->
                <div x-show="password.length > 0" x-cloak class="mt-2.5">
                    <div class="flex items-center justify-between text-[11px] mb-1">
                        <span class="text-slate-500">Security strength:</span>
                        <span class="font-bold uppercase tracking-wider"
                              :class="{
                                  'text-rose-500': passwordStrength <= 1,
                                  'text-amber-500': passwordStrength === 2,
                                  'text-blue-500': passwordStrength === 3,
                                  'text-emerald-600': passwordStrength >= 4
                              }"
                              x-text="['Too Short', 'Weak', 'Good', 'Strong', 'Excellent'][passwordStrength] || 'Weak'"></span>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5 h-1.5">
                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 1 ? (passwordStrength === 1 ? 'bg-rose-500' : (passwordStrength === 2 ? 'bg-amber-500' : 'bg-emerald-500')) : 'bg-slate-200'"></div>
                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 2 ? (passwordStrength === 2 ? 'bg-amber-500' : 'bg-emerald-500') : 'bg-slate-200'"></div>
                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 3 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                        <div class="rounded-full transition-all duration-300" :class="passwordStrength >= 4 ? 'bg-emerald-500' : 'bg-slate-200'"></div>
                    </div>
                </div>
            </div>

            <!-- Confirm New Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                        Confirm New Password <span class="text-rose-500">*</span>
                    </label>

                    <span x-show="password_confirmation.length >= 8 && password === password_confirmation" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600">
                        <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-2.5 h-2.5 anim-check-stroke text-emerald-600" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span>Passwords Match</span>
                    </span>

                    <span x-show="password_confirmation.length > 0 && password !== password_confirmation" x-cloak class="anim-check-pop inline-flex items-center gap-1 text-[11px] font-bold text-rose-600">
                        <span class="w-3.5 h-3.5 rounded-full bg-rose-100 flex items-center justify-center text-[10px]">✕</span>
                        <span>Mismatch</span>
                    </span>
                </div>

                <div class="relative">
                    <input 
                        :type="showConfirm ? 'text' : 'password'" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        x-model="password_confirmation" 
                        @input="touch('password_confirmation')"
                        @keydown="checkCapsLock($event)"
                        @keyup="checkCapsLock($event)"
                        required 
                        placeholder="Re-enter password"
                        class="w-full px-4 py-3 rounded-xl border text-sm text-slate-900 pr-11 field-interactive placeholder-slate-400 focus:outline-none"
                        :class="password_confirmation.length >= 8 && password === password_confirmation ? 'border-emerald-500/80 ring-2 ring-emerald-500/15 bg-emerald-50/10' : (password_confirmation && password !== password_confirmation ? 'border-rose-400 ring-2 ring-rose-400/15 bg-rose-50/10' : 'border-slate-300 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20')"
                    >
                    <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                        <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showConfirm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button with Reactive Feedback -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    :disabled="isSubmitting || password.length < 8 || password !== password_confirmation"
                    class="w-full py-3.5 px-4 rounded-2xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/25 transition-all duration-200 flex items-center justify-center gap-2 group cursor-pointer hover:scale-[1.01] active:scale-[0.99] disabled:opacity-60 disabled:cursor-not-allowed"
                >
                    <template x-if="!isSubmitting">
                        <span class="flex items-center gap-2">
                            <span>Update Password &amp; Sign In</span>
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
                            <span>Updating Password...</span>
                        </span>
                    </template>
                </button>
            </div>
        </form>

        <div class="mt-7 pt-5 border-t border-slate-100 text-center text-xs text-slate-500">
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline">
                &larr; Back to Sign In
            </a>
        </div>

        <div class="mt-4 text-center text-[10px] text-slate-400">
            CAC/IT/No. 7344471 &bull; Governed under CAMA 2020 (Part F)
        </div>

    </div>
</section>

@push('scripts')
<script>
    function resetPasswordForm() {
        return {
            password: '',
            password_confirmation: '',
            showPass: false,
            showConfirm: false,
            capsLockOn: false,
            isSubmitting: false,
            touched: {},

            touch(field) {
                this.touched[field] = true;
            },

            checkCapsLock(e) {
                if (e.getModifierState) {
                    this.capsLockOn = e.getModifierState('CapsLock');
                }
            },

            get passwordStrength() {
                if (!this.password) return 0;
                let score = 0;
                if (this.password.length >= 8) score++;
                if (/[A-Z]/.test(this.password) && /[a-z]/.test(this.password)) score++;
                if (/[0-9]/.test(this.password)) score++;
                if (/[^A-Za-z0-9]/.test(this.password) || this.password.length >= 12) score++;
                return score;
            }
        };
    }
</script>
@endpush

@endsection
