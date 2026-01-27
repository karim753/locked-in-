@extends('layouts.app')

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Inloggen</h1>
            <p class="text-xl text-purple-100">Log in om keuzedelen te bekijken en in te schrijven</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <i class="fas fa-graduation-cap text-purple-600 text-4xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800">Keuzedeel Systeem</h2>
                <p class="text-gray-600">Techniek College Rotterdam</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mailadres</label>
                    <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Wachtwoord</label>
                    <input id="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <div class="flex items-center">
                        <input class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="ml-2 block text-sm text-gray-700" for="remember">
                            Onthoud mij
                        </label>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                        <i class="fas fa-sign-in-alt mr-2"></i>Inloggen
                    </button>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="text-sm text-purple-600 hover:text-purple-800" href="{{ route('password.request') }}">
                            Wachtwoord vergeten?
                        </a>
                    </div>
                @endif
            </form>

            <!-- Test Accounts Info -->
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Test accounts:</h3>
                <div class="text-xs text-gray-600 space-y-1">
                    <div><strong>Student:</strong> student@example.com</div>
                    <div><strong>Admin:</strong> admin@example.com</div>
                    <div><strong>SLBer:</strong> slb@example.com</div>
                    <div class="mt-2 text-gray-500">Wachtwoord: password</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
