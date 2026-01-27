@extends('layouts.app')

@section('title', 'Keuzedelen - Overzicht')

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">Keuzedelen</h1>
            <p class="text-xl text-purple-100">Kies uw keuzedeel voor de komende periode</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- User Status Card -->
    @auth
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Welkom, {{ Auth::user()->name }}!</h2>
                    <p class="text-gray-600">
                        @if(Auth::user()->isStudent())
                            Student - {{ Auth::user()->study_program ?? 'Geen opleiding opgegeven' }}
                        @elseif(Auth::user()->isAdmin())
                            Beheerder
                        @elseif(Auth::user()->isSlb())
                            SLBer
                        @endif
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500">Huidige inschrijvingen</div>
                    <div class="text-2xl font-bold text-purple-600">{{ $userInscriptions->whereIn('status', ['pending', 'confirmed'])->count() }}</div>
                </div>
            </div>
        </div>
    @endauth

    <!-- Periods and Keuzedelen -->
    @if($periods->count() > 0)
        @foreach($periods as $period)
            <div class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $period->name }}</h2>
                        <p class="text-gray-600">
                            {{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}
                        </p>
                        @if($period->isEnrollmentOpen())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                                <i class="fas fa-clock mr-1"></i> Inschrijving geopend
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-2">
                                <i class="fas fa-lock mr-1"></i> Inschrijving gesloten
                            </span>
                        @endif
                    </div>
                </div>

                @if($period->keuzedelen->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($period->keuzedelen as $keuzedeel)
                            <div class="bg-white rounded-lg shadow-md card-hover overflow-hidden">
                                <!-- Status Badge -->
                                <div class="relative">
                                    @if(!$keuzedeel->is_active)
                                        <div class="absolute top-2 right-2 z-10">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Inactief
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if(in_array($keuzedeel->id, $completedKeuzedelen))
                                        <div class="absolute top-2 left-2 z-10">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-check mr-1"></i> Afgerond
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Content -->
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="text-lg font-semibold text-gray-800 flex-1">{{ $keuzedeel->title }}</h3>
                                        <span class="text-sm text-gray-500 ml-2">{{ $keuzedeel->credits }} EC</span>
                                    </div>

                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                        {{ Str::limit($keuzedeel->description ?? 'Geen beschrijving beschikbaar.', 100) }}
                                    </p>

                                    <!-- Teacher Info -->
                                    @if($keuzedeel->teacher_name)
                                        <div class="flex items-center text-sm text-gray-500 mb-3">
                                            <i class="fas fa-user-tie mr-2"></i>
                                            {{ $keuzedeel->teacher_name }}
                                        </div>
                                    @endif

                                    <!-- Capacity Info -->
                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                                            <span>Capaciteit</span>
                                            <span>{{ $keuzedeel->inscriptions_count }} / {{ $keuzedeel->max_participants }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            @php
                                                $percentage = ($keuzedeel->inscriptions_count / $keuzedeel->max_participants) * 100;
                                                $color = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                                            @endphp
                                            <div class="{{ $color }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('keuzedelen.show', $keuzedeel) }}" 
                                           class="flex-1 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center transition">
                                            <i class="fas fa-info-circle mr-2"></i>Details
                                        </a>

                                        @auth
                                            @if(Auth::user()->isStudent())
                                                @php
                                                    $userInscription = $userInscriptions->where('keuzdeel_id', $keuzedeel->id)->first();
                                                    $canEnroll = $keuzedeel->isAvailableForUser(Auth::user());
                                                @endphp

                                                @if($userInscription && $userInscription->status === 'confirmed')
                                                    <span class="flex-1 bg-green-100 text-green-800 px-4 py-2 rounded-md text-sm font-medium text-center">
                                                        <i class="fas fa-check mr-2"></i>Ingeschreven
                                                    </span>
                                                @elseif($userInscription && $userInscription->status === 'pending')
                                                    <span class="flex-1 bg-yellow-100 text-yellow-800 px-4 py-2 rounded-md text-sm font-medium text-center">
                                                        <i class="fas fa-clock mr-2"></i>Wachtlijst
                                                    </span>
                                                @elseif($canEnroll && $period->isEnrollmentOpen())
                                                    <form action="{{ route('keuzedelen.enroll', $keuzedeel) }}" method="POST" class="flex-1">
                                                        @csrf
                                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                                            <i class="fas fa-plus mr-2"></i>Inschrijven
                                                        </button>
                                                    </form>
                                                @elseif($keuzedeel->isFull())
                                                    <span class="flex-1 bg-red-100 text-red-800 px-4 py-2 rounded-md text-sm font-medium text-center">
                                                        <i class="fas fa-times mr-2"></i>Vol
                                                    </span>
                                                @elseif(!$period->isEnrollmentOpen())
                                                    <span class="flex-1 bg-gray-100 text-gray-800 px-4 py-2 rounded-md text-sm font-medium text-center">
                                                        <i class="fas fa-lock mr-2"></i>Gesloten
                                                    </span>
                                                @else
                                                    <span class="flex-1 bg-gray-100 text-gray-800 px-4 py-2 rounded-md text-sm font-medium text-center">
                                                        <i class="fas fa-ban mr-2"></i>Niet beschikbaar
                                                    </span>
                                                @endif
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Geen keuzedelen beschikbaar voor deze periode.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Geen periodes beschikbaar</h3>
            <p class="text-gray-600">Er zijn momenteel geen actieve periodes met keuzedelen.</p>
        </div>
    @endif
</div>
@endsection
