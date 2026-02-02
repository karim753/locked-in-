@extends('admin.layout')

@section('page-title', 'Dashboard')
@section('page-description', 'Overzicht van het keuzedelen systeem')

@section('admin-content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Totaal Keuzedelen</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_keuzedelen'] }}</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Actieve Keuzedelen</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_keuzedelen'] }}</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Studenten</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['student_users'] }}</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-orange-600 text-xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Actieve Inschrijvingen</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_inscriptions'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Quick Actions -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Snelle Acties</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.keuzedelen.create') }}" 
                   class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Nieuw Keuzedeel</p>
                        <p class="text-sm text-gray-500">Maak een nieuw keuzedeel aan</p>
                    </div>
                </a>

                <a href="{{ route('admin.periods.create') }}" 
                   class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-plus text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Nieuwe Periode</p>
                        <p class="text-sm text-gray-500">Maak een nieuwe periode aan</p>
                    </div>
                </a>

                <a href="{{ route('admin.statistics') }}" 
                   class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-bar text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Statistieken</p>
                        <p class="text-sm text-gray-500">Bekijk gedetailleerde statistieken</p>
                    </div>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center p-3 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                    <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user-cog text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Gebruikers Beheren</p>
                        <p class="text-sm text-gray-500">Beheer gebruikers en rollen</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Recente Inschrijvingen</h3>
                <span class="badge badge-success">Live</span>
            </div>
            
            @if($recentInscriptions->count() > 0)
                <div class="space-y-4">
                    @foreach($recentInscriptions as $inscription)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $inscription->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $inscription->keuzdeel->title }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $inscription->status === 'confirmed' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $inscription->status === 'confirmed' ? 'Bevestigd' : 'Wachtlijst' }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $inscription->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-clipboard-list text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Geen recente inschrijvingen gevonden</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- System Info -->
<div class="mt-8">
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Systeem Informatie</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-server text-blue-600 text-xl"></i>
                </div>
                <p class="text-sm text-gray-500">Laravel Version</p>
                <p class="font-semibold text-gray-900">12.48.1</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-code text-green-600 text-xl"></i>
                </div>
                <p class="text-sm text-gray-500">PHP Version</p>
                <p class="font-semibold text-gray-900">8.2.12</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-database text-purple-600 text-xl"></i>
                </div>
                <p class="text-sm text-gray-500">Database</p>
                <p class="font-semibold text-gray-900">MySQL</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-globe text-orange-600 text-xl"></i>
                </div>
                <p class="text-sm text-gray-500">Environment</p>
                <p class="font-semibold text-gray-900">{{ config('app.env') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
