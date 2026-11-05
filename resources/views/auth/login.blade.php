@extends('layouts.app')

@section('title', 'Sign In - Brands Academy Portal')

@section('content')

<section class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200 p-8 sm:p-10 shadow-xl">
        
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 text-amber-400 font-bold flex items-center justify-center mx-auto mb-4 font-serif-title text-2xl shadow-md">
                B
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-serif-title">Portal Sign In</h1>
            <p class="text-xs text-slate-500 mt-1">Access Member Services or Administration</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Password</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-amber-600 focus:ring-amber-500">
                    <span>Remember me</span>
                </label>
                <a href="{{ route('password.request') }}" class="font-semibold text-amber-600 hover:underline">
                    Forgot password?
                </a>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl text-sm font-bold bg-amber-500 hover:bg-amber-400 text-slate-950 shadow-md transition-all">
                Sign In to Portal
            </button>
        </form>

        <!-- Quick Demo Sign-In Buttons for Fast Testing -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <span class="block text-[10px] uppercase font-bold text-slate-400 text-center tracking-wider mb-3">
                Quick Test Accounts
            </span>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" onclick="fillCredentials('admin@brandsacademy.org', 'password')" class="px-3 py-2 rounded-lg bg-slate-900 text-amber-400 hover:bg-slate-800 text-xs font-semibold transition-colors">
                    Admin Account
                </button>
                <button type="button" onclick="fillCredentials('amina.k@example.com', 'password')" class="px-3 py-2 rounded-lg bg-amber-50 text-amber-900 border border-amber-200 hover:bg-amber-100 text-xs font-semibold transition-colors">
                    Member Account
                </button>
            </div>
        </div>

        <div class="mt-6 text-center text-xs text-slate-500">
            Don't have a membership account yet?
            <a href="{{ route('membership.register') }}" class="font-bold text-amber-600 hover:underline">
                Join Ongoing Membership (24/7)
            </a>
        </div>

    </div>
</section>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>

@endsection
