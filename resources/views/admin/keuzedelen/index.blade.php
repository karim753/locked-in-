@extends('admin.layout')

@section('page-title', 'Keuzedelen Beheren')
@section('page-description', 'Beheer alle keuzedelen in het systeem')

@section('admin-content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-2xl font-bold text-gray-900">Keuzedelen Beheren</h2>
    <a href="{{ route('admin.keuzedelen.create') }}" 
       class="btn-primary">
        <i class="fas fa-plus mr-2"></i>Nieuw Keuzedeel
    </a>
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
                       placeholder="Zoek keuzedelen..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>
        <select id="period-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            <option value="">Alle periodes</option>
            @foreach($periods ?? [] as $period)
                <option value="{{ $period->id }}">{{ $period->name }}</option>
            @endforeach
        </select>
        <select id="status-filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
            <option value="">Alle statussen</option>
            <option value="active">Actief</option>
            <option value="inactive">Inactief</option>
        </select>
    </div>
</div>

<!-- Keuzedelen Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    @foreach($keuzedelen as $keuzedeel)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover" data-keuzedeel-id="{{ $keuzedeel->id }}" data-period="{{ $keuzedeel->period_id }}" data-status="{{ $keuzedeel->is_active ? 'active' : 'inactive' }}">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-white mb-2">{{ $keuzedeel->title }}</h3>
                        <p class="text-blue-100 text-sm">{{ $keuzedeel->credits }} EC</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($keuzedeel->is_active)
                            <span class="px-3 py-1 bg-green-400 text-green-900 text-xs font-semibold rounded-full">
                                Actief
                            </span>
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
                <!-- Period Info -->
                <div class="flex items-center text-sm text-gray-600 mb-4">
                    <i class="fas fa-calendar mr-2"></i>
                    {{ $keuzedeel->period->name }}
                </div>

                <!-- Teacher Info -->
                @if($keuzedeel->teacher_name)
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="fas fa-user-tie mr-2"></i>
                        {{ $keuzedeel->teacher_name }}
                    </div>
                @endif

                <!-- Capacity -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Capaciteit</span>
                        <span class="font-semibold">{{ $keuzedeel->currentEnrollments() }} / {{ $keuzedeel->max_participants }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        @php
                            $percentage = ($keuzedeel->currentEnrollments() / $keuzedeel->max_participants) * 100;
                            $color = $percentage >= 90 ? 'bg-red-500' : ($percentage >= 70 ? 'bg-yellow-500' : 'bg-green-500');
                        @endphp
                        <div class="{{ $color }} h-3 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>

                <!-- Toggle Switch -->
                <div class="flex items-center justify-between mb-6">
                    <span class="text-sm font-medium text-gray-700">Status</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                               class="sr-only peer" 
                               {{ $keuzedeel->is_active ? 'checked' : '' }}
                               onchange="toggleKeuzedeelStatus({{ $keuzedeel->id }}, this.checked)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex space-x-3">
                    <a href="{{ route('keuzedelen.show', $keuzedeel) }}" 
                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
                        <i class="fas fa-eye mr-2"></i>Bekijken
                    </a>
                    <a href="{{ route('admin.keuzedelen.edit', $keuzedeel) }}" 
                       class="flex-1 bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg text-center text-sm font-medium transition-colors">
                        <i class="fas fa-edit mr-2"></i>Bewerken
                    </a>
                    <form action="{{ route('admin.keuzedelen.destroy', $keuzedeel) }}" 
                          method="POST" 
                          class="inline"
                          onsubmit="return confirm('Weet u zeker dat u dit keuzedeel wilt verwijderen?')">
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
@if($keuzedelen->hasPages())
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Toon <span class="font-medium">{{ $keuzedelen->firstItem() }}</span> tot 
                <span class="font-medium">{{ $keuzedelen->lastItem() }}</span> van 
                <span class="font-medium">{{ $keuzedelen->total() }}</span> resultaten
            </div>
            <div>
                {{ $keuzedelen->links() }}
            </div>
        </div>
    </div>
@endif

@if($keuzedelen->count() === 0)
    <div class="bg-white rounded-xl shadow-lg p-12 text-center">
        <i class="fas fa-book text-gray-400 text-6xl mb-6"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-3">Geen keuzedelen gevonden</h3>
        <p class="text-gray-500 mb-6">Er zijn nog geen keuzedelen aangemaakt.</p>
        <a href="{{ route('admin.keuzedelen.create') }}" 
           class="btn-primary">
            <i class="fas fa-plus mr-2"></i>Maak eerste keuzedeel aan
        </a>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const periodFilter = document.getElementById('period-filter');
    const statusFilter = document.getElementById('status-filter');
    const cards = document.querySelectorAll('[data-keuzedeel-id]');

    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase();
        const periodValue = periodFilter.value;
        const statusValue = statusFilter.value;

        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const period = card.getAttribute('data-period');
            const status = card.getAttribute('data-status');

            const matchesSearch = title.includes(searchTerm);
            const matchesPeriod = !periodValue || period === periodValue;
            const matchesStatus = !statusValue || status === statusValue;

            card.style.display = matchesSearch && matchesPeriod && matchesStatus ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterCards);
    periodFilter.addEventListener('change', filterCards);
    statusFilter.addEventListener('change', filterCards);
});

// Toggle keuzedeel status
function toggleKeuzedeelStatus(keuzedeelId, isActive) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/admin/keuzedelen/${keuzedeelId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            is_active: isActive
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification(data.message, 'success');
            
            // Update the status badge
            const row = document.querySelector(`tr[data-keuzedeel-id="${keuzedeelId}"]`);
            if (row) {
                const statusCell = row.cells[4]; // Status column
                const statusBadge = statusCell.querySelector('span');
                
                if (isActive) {
                    statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                    statusBadge.textContent = 'Actief';
                    row.setAttribute('data-status', 'active');
                } else {
                    statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800';
                    statusBadge.textContent = 'Inactief';
                    row.setAttribute('data-status', 'inactive');
                }
            }
        } else {
            showNotification(data.message || 'Er is een fout opgetreden', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Er is een fout opgetreden bij het bijwerken van de status', 'error');
    });
}

// Show notification
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
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
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
