@extends('layouts.app')

@section('title', 'Forgot Password - Brands Academy Portal')

@section('content')

<section class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xl">
        
        <div class="text-center mb-8">
            <x-brand-logo class="w-16 h-16 mx-auto mb-4 drop-shadow-md" />
            <h1 class="text-2xl font-extrabold text-slate-900 font-serif-title">Password Recovery</h1>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Enter your registered email address and we will send you a secure link to reset your portal password.
            </p>
        </div>

        <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@example.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                Send Reset Link
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            Remembered your credentials?
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:underline">
                Back to Sign In
            </a>
        </div>

    </div>
</section>

@endsection
