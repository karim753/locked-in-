@extends('admin.layout')

@section('admin-content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Statistieken</h2>
    <p class="text-gray-600">Analyse van het keuzedelen systeem</p>
</div>

<!-- Overview Stats -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-book text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Totaal Keuzedelen</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['keuzedelen_by_period']->sum('keuzedelen_count') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-users text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Totaal Gebruikers</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['users_by_role']->sum('count') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Actieve Inschrijvingen</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ $stats['inscriptions_by_status']->where('status', 'confirmed')->sum('count') + $stats['inscriptions_by_status']->where('status', 'pending')->sum('count') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-sm"></i>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Gem. Inschrijvingen</dt>
                        <dd class="text-lg font-medium text-gray-900">{{ round($stats['popular_keuzedelen']->avg('inscriptions_count'), 1) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Keuzedelen by Period -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Keuzedelen per Periode</h3>
        </div>
        <div class="p-6">
            @if($stats['keuzedelen_by_period']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['keuzedelen_by_period'] as $period)
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $period->name }}</div>
                                <div class="text-sm text-gray-500">{{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-medium text-gray-900">{{ $period->keuzedelen_count }}</div>
                                <div class="text-sm text-gray-500">keuzedelen</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $maxCount = $stats['keuzedelen_by_period']->max('keuzedelen_count');
                                $percentage = $maxCount > 0 ? ($period->keuzedelen_count / $maxCount) * 100 : 0;
                            @endphp
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">Geen periodes gevonden</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Users by Role -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Gebruikers per Rol</h3>
        </div>
        <div class="p-6">
            @if($stats['users_by_role']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['users_by_role'] as $role)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @switch($role->role)
                                    @case('admin')
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-crown text-red-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Beheerders</div>
                                            <div class="text-sm text-gray-500">Admin toegang</div>
                                        </div>
                                        @break
                                    @case('slber')
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-tie text-blue-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">SLB'ers</div>
                                            <div class="text-sm text-gray-500">Studentenbegeleiders</div>
                                        </div>
                                        @break
                                    @case('student')
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-graduation-cap text-green-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Studenten</div>
                                            <div class="text-sm text-gray-500">Reguliere gebruikers</div>
                                        </div>
                                        @break
                                @endswitch
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-medium text-gray-900">{{ $role->count }}</div>
                                <div class="text-sm text-gray-500">gebruikers</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $maxCount = $stats['users_by_role']->max('count');
                                $percentage = $maxCount > 0 ? ($role->count / $maxCount) * 100 : 0;
                            @endphp
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">Geen gebruikers gevonden</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Inscription Status -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Inschrijvingen per Status</h3>
        </div>
        <div class="p-6">
            @if($stats['inscriptions_by_status']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['inscriptions_by_status'] as $status)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @switch($status->status)
                                    @case('confirmed')
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-check text-green-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Bevestigd</div>
                                            <div class="text-sm text-gray-500">Definitieve inschrijvingen</div>
                                        </div>
                                        @break
                                    @case('pending')
                                        <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-yellow-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Wachtlijst</div>
                                            <div class="text-sm text-gray-500">In afwachting</div>
                                        </div>
                                        @break
                                    @case('cancelled')
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-times text-red-600 text-xs"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">Geannuleerd</div>
                                            <div class="text-sm text-gray-500">Verwijderde inschrijvingen</div>
                                        </div>
                                        @break
                                @endswitch
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-medium text-gray-900">{{ $status->count }}</div>
                                <div class="text-sm text-gray-500">inschrijvingen</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $maxCount = $stats['inscriptions_by_status']->max('count');
                                $percentage = $maxCount > 0 ? ($status->count / $maxCount) * 100 : 0;
                            @endphp
                            <div class="bg-purple-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-list text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">Geen inschrijvingen gevonden</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Popular Keuzedelen -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Populairste Keuzedelen</h3>
        </div>
        <div class="p-6">
            @if($stats['popular_keuzedelen']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['popular_keuzedelen'] as $index => $keuzedeel)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-8 h-8 bg-primary rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-medium">{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $keuzedeel->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $keuzedeel->credits }} EC • {{ $keuzedeel->max_participants }} plekken</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-medium text-gray-900">{{ $keuzedeel->inscriptions_count }}</div>
                                <div class="text-sm text-gray-500">inschrijvingen</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            @php
                                $maxCount = $stats['popular_keuzedelen']->max('inscriptions_count');
                                $percentage = $maxCount > 0 ? ($keuzedeel->inscriptions_count / $maxCount) * 100 : 0;
                            @endphp
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-book text-gray-400 text-3xl mb-2"></i>
                    <p class="text-gray-500">Geen keuzedelen gevonden</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
