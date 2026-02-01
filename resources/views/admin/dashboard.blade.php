@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Admin Dashboard</h1>
            <p class="text-xl text-white">Techniek College Rotterdam - Keuzedeel Systeem</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Welkom, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600">Beheer het keuzedeel systeem</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Rol</div>
                <div class="text-2xl font-bold text-primary">Administrator</div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-users text-primary text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'student')->count() }}</div>
                    <div class="text-sm text-gray-600">Studenten</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-book text-primary text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Keuzedeel::count() }}</div>
                    <div class="text-sm text-gray-600">Keuzedelen</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user-check text-primary text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Inscription::whereIn('status', ['pending', 'confirmed'])->count() }}</div>
                    <div class="text-sm text-gray-600">Inschrijvingen</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-calendar text-primary text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\Period::where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-600">Actieve Periodes</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Keuzedelen Management -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Keuzedelen Beheer</h3>
            <div class="space-y-4">
                <a href="{{ route('keuzedelen.index') }}" class="block w-full bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-list mr-2"></i>Bekijk Alle Keuzedelen
                </a>
                <a href="#" onclick="confirmDeleteAllKeuzedelen()" class="block w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-trash mr-2"></i>Verwijder Alle Keuzedelen
                </a>
            </div>
        </div>

        <!-- User Management -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Gebruikers Beheer</h3>
            <div class="space-y-4">
                <a href="#" class="block w-full bg-gray-400 text-gray-200 px-4 py-2 rounded-md text-center cursor-not-allowed">
                    <i class="fas fa-user-plus mr-2"></i>Gebruiker Toevoegen (Nog niet beschikbaar)
                </a>
                <a href="#" class="block w-full bg-gray-400 text-gray-200 px-4 py-2 rounded-md text-center cursor-not-allowed">
                    <i class="fas fa-users mr-2"></i>Alle Gebruikers (Nog niet beschikbaar)
                </a>
                <a href="#" class="block w-full bg-gray-400 text-gray-200 px-4 py-2 rounded-md text-center cursor-not-allowed">
                    <i class="fas fa-user-cog mr-2"></i>Rollen & Rechten (Nog niet beschikbaar)
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Recente Activiteit</h3>
        <div class="space-y-3">
            @php
                $recentInscriptions = \App\Models\Inscription::with('user', 'keuzdeel')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            @endphp
            
            @if($recentInscriptions->count() > 0)
                @foreach($recentInscriptions as $inscription)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-primary bg-opacity-10 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-primary text-sm"></i>
                            </div>
                            <div>
                                <div class="font-medium text-gray-800">{{ $inscription->user->name }}</div>
                                <div class="text-sm text-gray-500">
                                    Ingeschreven voor: {{ $inscription->keuzdeel->title }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    Opleiding: {{ $inscription->user->study_program ?? 'Onbekend' }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($inscription->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($inscription->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $inscription->status }}
                            </span>
                            <div class="text-xs text-gray-500 mt-1">
                                {{ $inscription->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 text-center py-4">Nog geen recente activiteit</p>
            @endif
        </div>
    </div>

    <!-- Detailed Enrollment Overview -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Volledige Inschrijvingen</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keuzedeel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Opleiding</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $allInscriptions = \App\Models\Inscription::with('user', 'keuzdeel')
                            ->orderBy('created_at', 'desc')
                            ->get();
                    @endphp
                    
                    @if($allInscriptions->count() > 0)
                        @foreach($allInscriptions as $inscription)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $inscription->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $inscription->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $inscription->keuzdeel->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $inscription->keuzdeel->credits }} credits</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($inscription->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($inscription->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $inscription->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inscription->created_at->format('d-m-Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inscription->user->study_program ?? 'Onbekend' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <span class="text-gray-400">Bekijk</span>
                                    <span class="text-gray-400">Details</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Geen inschrijvingen gevonden
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDeleteAllKeuzedelen() {
    if (confirm('Weet je zeker dat je ALLE keuzedelen wilt verwijderen? Dit kan niet ongedaan worden gemaakt!')) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/delete-all-keuzedelen';
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            form.appendChild(csrfInput);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection
