@extends('layouts.app')

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Inloggen</h1>
            <p class="text-xl text-white mb-4">Techniek College Rotterdam</p>
            <p class="text-lg text-white">Log in om keuzedelen te bekijken en in te schrijven</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <i class="fas fa-graduation-cap text-primary text-4xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800">TCR Keuzedeel Systeem</h2>
                <p class="text-gray-600">Techniek College Rotterdam</p>
            </div>

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mailadres</label>
                    <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Wachtwoord</label>
                    <input id="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" name="password" required autocomplete="current-password">
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded" name="remember">
                        <label for="remember" class="ml-2 block text-sm text-gray-900">Onthoud mij</label>
                    </div>
                </div>

                <div class="mb-6">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-medium py-2 px-4 rounded-md transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Inloggen
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Nog geen account? <a href="{{ route('register') }}" class="text-primary hover:text-primary-hover font-medium">Account aanmaken</a>
                    </p>
                </div>
            </form>

            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Test Accounts:</h3>
                <div class="text-xs text-gray-600 space-y-1">
                    <p><strong>Admin:</strong> admin@example.com / password</p>
                    <p><strong>SLBer:</strong> slb@example.com / password</p>
                    <p><strong>Student:</strong> student@example.com / password</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
