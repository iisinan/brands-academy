@extends('layouts.app')

@section('title', 'Set New Password - Brands Academy Portal')

@section('content')

<section class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xl">
        
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 text-amber-400 font-bold flex items-center justify-center mx-auto mb-4 font-serif-title text-2xl shadow-md">
                B
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-serif-title">Set New Password</h1>
            <p class="text-xs text-slate-500 mt-2">
                Choose a strong new password for your Brands Academy account.
            </p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $email) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 bg-slate-50">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">New Password (Min. 8 characters)</label>
                <input type="password" name="password" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                Update Password & Sign In
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:underline">
                &larr; Back to Sign In
            </a>
        </div>

    </div>
</section>

@endsection
