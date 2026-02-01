@extends('layouts.app')

@section('title', 'SLB Dashboard')

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">SLB Dashboard</h1>
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
                <p class="text-gray-600">Begeleid studenten bij hun keuzedeel keuzes</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-gray-500">Rol</div>
                <div class="text-2xl font-bold text-primary">SLBer</div>
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
                    <i class="fas fa-graduation-cap text-primary text-xl"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ \App\Models\CompletedKeuzedeel::count() }}</div>
                    <div class="text-sm text-gray-600">Afgerond</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Student Management -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Studenten Begeleiding</h3>
            <div class="space-y-4">
                <a href="{{ route('keuzedelen.index') }}" class="block w-full bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-list mr-2"></i>Bekijk Keuzedelen
                </a>
                <a href="#" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-users mr-2"></i>Mijn Studenten
                </a>
                <a href="#" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-comments mr-2"></i>Advies Gesprekken
                </a>
            </div>
        </div>

        <!-- Reports -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Rapportages</h3>
            <div class="space-y-4">
                <a href="#" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-chart-bar mr-2"></i>Inschrijving Overzicht
                </a>
                <a href="#" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-chart-pie mr-2"></i>Keuzedeel Populariteit
                </a>
                <a href="#" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition-colors">
                    <i class="fas fa-download mr-2"></i>Exporteer Data
                </a>
            </div>
        </div>
    </div>

    <!-- Student Enrollments Overview -->
    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Recente Student Inschrijvingen</h3>
        <div class="space-y-3">
            @php
                $recentInscriptions = \App\Models\Inscription::with('user', 'keuzdeel')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();
            @endphp
            
            @if($recentInscriptions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keuzedeel</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actie</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentInscriptions as $inscription)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $inscription->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $inscription->user->study_program ?? 'Geen opleiding' }}</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-primary hover:text-primary-hover mr-2">Bekijk</a>
                                        <a href="#" class="text-gray-600 hover:text-gray-900">Contact</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Nog geen inschrijvingen</p>
            @endif
        </div>
    </div>
</div>
@endsection
