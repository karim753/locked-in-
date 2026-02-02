@extends('admin.layout')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Nieuwe Periode Aanmaken</h2>
        <p class="text-gray-600">Vul onderstaande gegevens in om een nieuwe periode aan te maken.</p>
    </div>
    <a href="{{ route('admin.periods.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Terug naar overzicht
    </a>
</div>

<div class="bg-white shadow rounded-lg">
    <form action="{{ route('admin.periods.store') }}" method="POST">
        @csrf
        
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
                               value="{{ old('name') }}"
                               placeholder="bv. Semester 1 2024"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            Startdatum <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="start_date" 
                               name="start_date" 
                               required
                               value="{{ old('start_date') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                            Einddatum <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="end_date" 
                               name="end_date" 
                               required
                               value="{{ old('end_date') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Enrollment Period -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Inschrijfperiode</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="enrollment_opens_at" class="block text-sm font-medium text-gray-700">
                            Inschrijvingen openen <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="enrollment_opens_at" 
                               name="enrollment_opens_at" 
                               required
                               value="{{ old('enrollment_opens_at') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('enrollment_opens_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="enrollment_closes_at" class="block text-sm font-medium text-gray-700">
                            Inschrijvingen sluiten <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="enrollment_closes_at" 
                               name="enrollment_closes_at" 
                               required
                               value="{{ old('enrollment_closes_at') }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('enrollment_closes_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <p class="mt-2 text-sm text-gray-500">
                    Studenten kunnen zich alleen inschrijven tijdens deze periode.
                </p>
            </div>

            <!-- Settings -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Instellingen</h3>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', '1') ? 'checked' : '' }}
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Actief (periode is zichtbaar en beschikbaar)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
            <a href="{{ route('admin.periods.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                Annuleren
            </a>
            <button type="submit" 
                    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-save mr-2"></i>Opslaan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const enrollmentOpens = document.getElementById('enrollment_opens_at');
    const enrollmentCloses = document.getElementById('enrollment_closes_at');

    // Set minimum dates
    startDate.addEventListener('change', function() {
        endDate.min = this.value;
        if (endDate.value && endDate.value < this.value) {
            endDate.value = this.value;
        }
    });

    enrollmentOpens.addEventListener('change', function() {
        enrollmentCloses.min = this.value;
        if (enrollmentCloses.value && enrollmentCloses.value < this.value) {
            enrollmentCloses.value = this.value;
        }
    });
});
</script>
@endsection
