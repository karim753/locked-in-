@extends('admin.layout')

@section('page-title', 'Periodes Beheren')
@section('page-description', 'Beheer inschrijfperiodes voor keuzedelen')

@section('admin-content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Periodes Beheren</h2>
    <a href="{{ route('admin.periods.create') }}" 
       class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Nieuwe Periode
    </a>
</div>

<!-- Periods Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    @foreach($periods as $period)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover" data-period-id="{{ $period->id }}" data-enrollment-status="{{ $period->isEnrollmentOpen() ? 'open' : 'closed' }}">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-green-500 to-teal-600 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-2">{{ $period->name }}</h3>
                        <p class="text-green-100 text-sm">{{ $period->keuzedelen->count() }} keuzedelen</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($period->is_active)
                            @if($period->isEnrollmentOpen())
                                <span class="px-3 py-1 bg-green-400 text-green-900 text-xs font-semibold rounded-full">
                                    Open
                                </span>
                            @else
                                <span class="px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-semibold rounded-full">
                                    Gesloten
                                </span>
                            @endif
                        @else
                            <span class="px-3 py-1 bg-gray-400 text-gray-900 text-xs font-semibold rounded-full">
                                Inactief
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Date Range -->
                <div class="mb-4">
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Periode
                    </div>
                    <div class="text-sm font-medium text-gray-900">
                        {{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }}
                    </div>
                </div>

                <!-- Enrollment Period -->
                <div class="mb-6">
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                        <i class="fas fa-clock mr-2"></i>
                        Inschrijfperiode
                    </div>
                    <div class="text-sm text-gray-900">
                        <div>{{ $period->enrollment_opens_at->format('d M Y H:i') }}</div>
                        <div>t/m {{ $period->enrollment_closes_at->format('d M Y H:i') }}</div>
                    </div>
                </div>

                <!-- Toggle Switch -->
                @if($period->is_active)
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-sm font-medium text-gray-700">Inschrijvingen</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   class="sr-only peer" 
                                   {{ $period->isEnrollmentOpen() ? 'checked' : '' }}
                                   onchange="toggleEnrollmentStatus({{ $period->id }}, this.checked)">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                @else
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-sm font-medium text-gray-700">Inschrijvingen</span>
                        <span class="text-xs text-gray-400">N.v.t.</span>
                    </div>
                @endif

                <!-- Stats -->
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $period->keuzedelen->count() }}</div>
                            <div class="text-xs text-gray-500">Keuzedelen</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">
                                {{ \App\Models\Inscription::whereHas('keuzdeel', function($q) use ($period) {
                                    $q->where('period_id', $period->id);
                                })->whereIn('status', ['pending', 'confirmed'])->count() }}
                            </div>
                            <div class="text-xs text-gray-500">Inschrijvingen</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex space-x-3">
                    <a href="{{ route('admin.periods.edit', $period) }}" 
                       class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
                        <i class="fas fa-edit mr-2"></i>Bewerken
                    </a>
                    <form action="{{ route('admin.periods.destroy', $period) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Weet u zeker dat u deze periode wilt verwijderen? Alle bijbehorende keuzedelen worden ook verwijderd.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
@if($periods->hasPages())
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Toon <span class="font-medium">{{ $periods->firstItem() }}</span> tot 
                <span class="font-medium">{{ $periods->lastItem() }}</span> van 
                <span class="font-medium">{{ $periods->total() }}</span> resultaten
            </div>
            <div>
                {{ $periods->links() }}
            </div>
        </div>
    </div>
@endif

@if($periods->count() === 0)
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
        <i class="fas fa-calendar-times text-gray-400 text-6xl mb-6"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-3">Geen periodes gevonden</h3>
        <p class="text-gray-500 mb-6">Er zijn nog geen periodes aangemaakt.</p>
        <a href="{{ route('admin.periods.create') }}" 
           class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Maak eerste periode aan
        </a>
    </div>
@endif

<script>
// Toggle enrollment status
function toggleEnrollmentStatus(periodId, isOpen) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/admin/periods/${periodId}/toggle-enrollment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            is_open: isOpen
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            const card = document.querySelector(`[data-period-id="${periodId}"]`);
            if (card) {
                const statusBadge = card.querySelector('.bg-green-400, .bg-yellow-400');
                const toggle = card.querySelector('input[type="checkbox"]');
                const statusText = card.querySelector('.text-gray-700').nextElementSibling;
                
                if (isOpen) {
                    statusBadge.className = 'px-3 py-1 bg-green-400 text-green-900 text-xs font-semibold rounded-full';
                    statusBadge.textContent = 'Open';
                    statusText.textContent = 'Open';
                    card.setAttribute('data-enrollment-status', 'open');
                } else {
                    statusBadge.className = 'px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-semibold rounded-full';
                    statusBadge.textContent = 'Gesloten';
                    statusText.textContent = 'Gesloten';
                    card.setAttribute('data-enrollment-status', 'closed');
                }
            }
        } else {
            showNotification(data.message || 'Er is een fout opgetreden', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Er is een fout opgetreden bij het bijwerken van de inschrijfstatus', 'error');
    });
}

// Show notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'
    }`;
    notification.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas ${type === 'success' ? 'fa-check-circle text-green-400' : 'fa-exclamation-circle text-red-400'}"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm ${type === 'success' ? 'text-green-800' : 'text-red-800'}">${message}</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>
@endsection
