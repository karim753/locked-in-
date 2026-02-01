@extends('layouts.app')

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Registreren</h1>
            <p class="text-xl text-white mb-4">Techniek College Rotterdam</p>
            <p class="text-lg text-white">Maak een account aan om keuzedelen te kunnen bekijken en inschrijven</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <i class="fas fa-user-plus text-primary text-4xl mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800">TCR Keuzedeel Systeem</h2>
                <p class="text-gray-600">Techniek College Rotterdam</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Volledige naam</label>
                    <input id="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-mailadres</label>
                    <input id="email" type="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Rol</label>
                    <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('role') border-red-500 @enderror" required>
                        <option value="student">Student</option>
                        <option value="slber">SLBer</option>
                    </select>

                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="study_program" class="block text-sm font-medium text-gray-700 mb-2">Opleiding (optioneel voor studenten)</label>
                    <input id="study_program" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('study_program') border-red-500 @enderror" name="study_program" value="{{ old('study_program') }}" placeholder="bv. Software Development, Elektrotechniek, etc.">

                    @error('study_program')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Wachtwoord</label>
                    <input id="password" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Bevestig wachtwoord</label>
                    <input id="password-confirm" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-medium py-2 px-4 rounded-md transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>Account aanmaken
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-primary hover:text-primary-hover">
                        Al een account? Log hier in
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
