@extends('admin.layout')

@section('page-title', 'Gebruikers Beheren')
@section('page-description', 'Beheer alle gebruikers en hun rollen')

@section('admin-content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Gebruikers Beheren</h2>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <div class="flex flex-col lg:flex-row gap-4">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       id="search" 
                       placeholder="Zoek gebruikers..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>
        <select id="role-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            <option value="">Alle rollen</option>
            <option value="student">Studenten</option>
            <option value="admin">Beheerders</option>
            <option value="slber">SLB'ers</option>
        </select>
        <select id="status-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            <option value="">Alle statussen</option>
            <option value="active">Actief</option>
            <option value="inactive">Inactief</option>
        </select>
    </div>
</div>

<!-- Users Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    @foreach($users as $user)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover" data-role="{{ $user->role }}" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                <div class="flex justify-between items-start">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">{{ $user->name }}</h3>
                            <p class="text-purple-100 text-sm">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Role Badge -->
                <div class="mb-4">
                    @switch($user->role)
                        @case('admin')
                            <div class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-sm font-semibold rounded-full">
                                <i class="fas fa-crown mr-2"></i>Beheerder
                            </div>
                            @break
                        @case('slber')
                            <div class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm font-semibold rounded-full">
                                <i class="fas fa-user-tie mr-2"></i>SLB'er
                            </div>
                            @break
                        @case('student')
                            <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
                                <i class="fas fa-graduation-cap mr-2"></i>Student
                            </div>
                            @break
                    @endswitch
                </div>

                <!-- Study Program -->
                @if($user->study_program)
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        {{ $user->study_program }}
                    </div>
                @endif

                <!-- Student Number -->
                @if($user->student_number)
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-id-card mr-2"></i>
                        {{ $user->student_number }}
                    </div>
                @endif

                <!-- Stats -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $user->inscriptions->count() }}</div>
                            <div class="text-xs text-gray-500">Inschrijvingen</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $user->completedKeuzedelen->count() }}</div>
                            <div class="text-xs text-gray-500">Voltooid</div>
                        </div>
                    </div>
                </div>

                <!-- Join Date -->
                <div class="flex items-center text-sm text-gray-500 mb-6">
                    <i class="fas fa-calendar mr-2"></i>
                    Lid sinds {{ $user->created_at->format('d M Y') }}
                </div>

                <!-- Actions -->
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
                        <i class="fas fa-edit mr-2"></i>Bewerken
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
@if($users->hasPages())
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Toon <span class="font-medium">{{ $users->firstItem() }}</span> tot 
                <span class="font-medium">{{ $users->lastItem() }}</span> van 
                <span class="font-medium">{{ $users->total() }}</span> resultaten
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endif

@if($users->count() === 0)
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
        <i class="fas fa-users text-gray-400 text-6xl mb-6"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-3">Geen gebruikers gevonden</h3>
        <p class="text-gray-500">Er zijn geen gebruikers gevonden die overeenkomen met uw zoekopdracht.</p>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const roleFilter = document.getElementById('role-filter');
    const statusFilter = document.getElementById('status-filter');
    const cards = document.querySelectorAll('[data-role]');

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const roleValue = roleFilter.value;
        const statusValue = statusFilter.value;

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const email = card.getAttribute('data-email');
            const role = card.getAttribute('data-role');

            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = !roleValue || role === roleValue;
            const matchesStatus = !statusValue || status === statusValue;

            card.style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterCards);
    roleFilter.addEventListener('change', filterCards);
    statusFilter.addEventListener('change', filterCards);
});
</script>
@endsection
