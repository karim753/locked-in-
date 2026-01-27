@extends('layouts.app')

@section('title', $keuzedeel->title)

@section('content')
<div class="gradient-bg py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-white mb-4">{{ $keuzedeel->title }}</h1>
            <p class="text-xl text-purple-100">{{ $keuzedeel->period->name }}</p>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Keuzedeel Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Details</h2>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-500">{{ $keuzedeel->credits }} EC</span>
                        @if($keuzedeel->is_repeatable)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-redo mr-1"></i>Herhaalbaar
                            </span>
                        @endif
                    </div>
                </div>

                @if($keuzedeel->description)
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $keuzedeel->description }}</p>
                    </div>
                @else
                    <p class="text-gray-500 italic">Geen beschrijving beschikbaar.</p>
                @endif

                @if($keuzedeel->schedule_info)
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-semibold text-gray-800 mb-2">
                            <i class="fas fa-calendar-alt mr-2"></i>Rooster informatie
                        </h3>
                        <p class="text-gray-700">{{ $keuzedeel->schedule_info }}</p>
                    </div>
                @endif
            </div>

            <!-- Capacity Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Capaciteit</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ $keuzedeel->inscriptions->count() }}</div>
                        <div class="text-sm text-gray-600">Huidige inschrijvingen</div>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $keuzedeel->min_participants }}</div>
                        <div class="text-sm text-gray-600">Minimum nodig</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $keuzedeel->max_participants }}</div>
                        <div class="text-sm text-gray-600">Maximum capaciteit</div>
                    </div>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-4">
                    @php
                        $percentage = ($keuzedeel->inscriptions->count() / $keuzedeel->max_participants) * 100;
                        $color = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                    @endphp
                    <div class="{{ $color }} h-4 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                </div>
                <div class="text-center mt-2 text-sm text-gray-600">
                    {{ round($percentage) }}% vol
                </div>
            </div>

            <!-- Enrolled Students -->
            @if($keuzedeel->inscriptions->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Ingeschreven studenten ({{ $keuzedeel->inscriptions->count() }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($keuzedeel->inscriptions as $inscription)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $inscription->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $inscription->user->email }}</div>
                                    </div>
                                </div>
                                <div>
                                    @if($inscription->status === 'confirmed')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Bevestigd
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Wachtlijst
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Action Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Acties</h3>
                
                @auth
                    @if(Auth::user()->isStudent())
                        @if($userInscription)
                            @if($userInscription->status === 'confirmed')
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                                        <span class="font-medium text-green-800">U bent ingeschreven</span>
                                    </div>
                                    <p class="text-sm text-green-700 mb-3">Uw inschrijving is bevestigd voor dit keuzedeel.</p>
                                    <form action="{{ route('keuzedelen.cancel', $keuzedeel) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                                            <i class="fas fa-times mr-2"></i>Inschrijving annuleren
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-clock text-yellow-600 mr-2"></i>
                                        <span class="font-medium text-yellow-800">Op de wachtlijst</span>
                                    </div>
                                    <p class="text-sm text-yellow-700">U staat op de wachtlijst. U wordt geïnformeerd als er plek vrijkomt.</p>
                                </div>
                            @endif
                        @elseif($hasCompleted)
                            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                                    <span class="font-medium text-blue-800">Afgerond</span>
                                </div>
                                <p class="text-sm text-blue-700 mt-2">U heeft dit keuzedeel al afgerond.</p>
                            </div>
                        @elseif($keuzedeel->isAvailableForUser(Auth::user()) && $keuzedeel->period->isEnrollmentOpen())
                            <form action="{{ route('keuzedelen.enroll', $keuzedeel) }}" method="POST" class="mb-4">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-md font-medium transition">
                                    <i class="fas fa-plus mr-2"></i>Inschrijven voor dit keuzedeel
                                </button>
                            </form>
                        @else
                            <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-gray-600 mr-2"></i>
                                    <span class="font-medium text-gray-800">Niet beschikbaar</span>
                                </div>
                                <p class="text-sm text-gray-700 mt-2">
                                    @if($keuzedeel->isFull())
                                        Dit keuzedeel is vol.
                                    @elseif(!$keuzedeel->period->isEnrollmentOpen())
                                        De inschrijfperiode is gesloten.
                                    @else
                                        U kunt zich niet inschrijven voor dit keuzedeel.
                                    @endif
                                </p>
                            </div>
                        @endif
                    @endif
                @else
                    <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <p class="text-sm text-gray-700 mb-3">Log in om u in te schrijven voor keuzedelen.</p>
                        <a href="{{ route('login') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center block transition">
                            <i class="fas fa-sign-in-alt mr-2"></i>Inloggen
                        </a>
                    </div>
                @endauth

                <a href="{{ route('keuzedelen.index') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium text-center block transition">
                    <i class="fas fa-arrow-left mr-2"></i>Terug naar overzicht
                </a>
            </div>

            <!-- Period Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Periode informatie</h3>
                <div class="space-y-3">
                    <div>
                        <div class="text-sm text-gray-500">Periode</div>
                        <div class="font-medium text-gray-800">{{ $keuzedeel->period->name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Start datum</div>
                        <div class="font-medium text-gray-800">{{ $keuzedeel->period->start_date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Eind datum</div>
                        <div class="font-medium text-gray-800">{{ $keuzedeel->period->end_date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Inschrijving sluit</div>
                        <div class="font-medium text-gray-800">{{ $keuzedeel->period->enrollment_closes_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Teacher Info -->
            @if($keuzedeel->teacher_name)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Docent</h3>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user-tie text-purple-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">{{ $keuzedeel->teacher_name }}</div>
                            <div class="text-sm text-gray-500">Docent</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
