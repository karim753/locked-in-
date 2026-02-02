@extends('admin.layout')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Gebruiker Bewerken</h2>
        <p class="text-gray-600">Pas de gegevens van de gebruiker aan.</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Terug naar overzicht
    </a>
</div>

<div class="bg-white shadow rounded-lg">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basisinformatie</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Naam <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required
                               value="{{ old('name', $user->name) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               value="{{ old('email', $user->email) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Role and Program -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Rol en Opleiding</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">
                            Rol <span class="text-red-500">*</span>
                        </label>
                        <select id="role" 
                                name="role" 
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>
                                Student
                            </option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                Beheerder
                            </option>
                            <option value="slber" {{ old('role', $user->role) == 'slber' ? 'selected' : '' }}>
                                SLB'er (Studentenbegeleider)
                            </option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="study_program" class="block text-sm font-medium text-gray-700">
                            Opleiding
                        </label>
                        <input type="text" 
                               id="study_program" 
                               name="study_program" 
                               value="{{ old('study_program', $user->study_program) }}"
                               placeholder="bv. Software Development"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('study_program')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="student_number" class="block text-sm font-medium text-gray-700">
                            Studentnummer
                        </label>
                        <input type="text" 
                               id="student_number" 
                               name="student_number" 
                               value="{{ old('student_number', $user->student_number) }}"
                               placeholder="bv. 1234567"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('student_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Gebruikersstatistieken</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-gray-500">Inschrijvingen</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $user->inscriptions->count() }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-gray-500">Voltooide Keuzedelen</div>
                        <div class="text-2xl font-bold text-gray-900">{{ $user->completedKeuzedelen->count() }}</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="text-sm font-medium text-gray-500">Lid sinds</div>
                        <div class="text-lg font-bold text-gray-900">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            @if($user->inscriptions->count() > 0)
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recente Inschrijvingen</h3>
                    <div class="space-y-3">
                        @foreach($user->inscriptions->take(5) as $inscription)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $inscription->keuzdeel->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $inscription->created_at->format('d M Y H:i') }}</div>
                                </div>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $inscription->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $inscription->status === 'confirmed' ? 'Bevestigd' : 'Wachtlijst' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Warning for role changes -->
            @if($user->role === 'admin' && old('role', $user->role) !== 'admin')
                <div class="p-4 bg-red-50 border border-red-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-800">
                                <strong>Waarschuwing:</strong> U staat op het punt de beheerdersrechten van deze gebruiker te verwijderen. 
                                Deze gebruiker kan dan geen toegang meer krijgen tot het admin panel.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                Annuleren
            </a>
            <button type="submit" 
                    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-save mr-2"></i>Bijwerken
            </button>
        </div>
    </form>
</div>
@endsection
