@extends('admin.layout')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Keuzedeel Bewerken</h2>
        <p class="text-gray-600">Pas de gegevens van het keuzedeel aan.</p>
    </div>
    <a href="{{ route('admin.keuzedelen.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left mr-2"></i>Terug naar overzicht
    </a>
</div>

<div class="bg-white shadow rounded-lg">
    <form action="{{ route('admin.keuzedelen.update', $keuzedeel) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basisinformatie</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Titel <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               required
                               value="{{ old('title', $keuzedeel->title) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Beschrijving
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">{{ old('description', $keuzedeel->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="period_id" class="block text-sm font-medium text-gray-700">
                            Periode <span class="text-red-500">*</span>
                        </label>
                        <select id="period_id" 
                                name="period_id" 
                                required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                            <option value="">Kies een periode</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ old('period_id', $keuzedeel->period_id) == $period->id ? 'selected' : '' }}>
                                    {{ $period->name }} ({{ $period->start_date->format('d M Y') }} - {{ $period->end_date->format('d M Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('period_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="credits" class="block text-sm font-medium text-gray-700">
                            Studiepunten (EC) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="credits" 
                               name="credits" 
                               required
                               min="1" 
                               max="10"
                               value="{{ old('credits', $keuzedeel->credits) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('credits')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Capacity Settings -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Capaciteit</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="min_participants" class="block text-sm font-medium text-gray-700">
                            Minimaal aantal deelnemers <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="min_participants" 
                               name="min_participants" 
                               required
                               min="1"
                               value="{{ old('min_participants', $keuzedeel->min_participants) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('min_participants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700">
                            Maximaal aantal deelnemers <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="max_participants" 
                               name="max_participants" 
                               required
                               min="1"
                               value="{{ old('max_participants', $keuzedeel->max_participants) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                @if($keuzedeel->inscriptions_count > 0)
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800">
                                    Let op: Er zijn momenteel {{ $keuzedeel->inscriptions_count }} inschrijvingen voor dit keuzedeel. 
                                    Het verlagen van het maximum aantal deelnemers kan problemen veroorzaken.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Teacher Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Docentinformatie</h3>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="teacher_name" class="block text-sm font-medium text-gray-700">
                            Naam docent
                        </label>
                        <input type="text" 
                               id="teacher_name" 
                               name="teacher_name" 
                               value="{{ old('teacher_name', $keuzedeel->teacher_name) }}"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">
                        @error('teacher_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="schedule_info" class="block text-sm font-medium text-gray-700">
                        Roosterinformatie
                    </label>
                    <textarea id="schedule_info" 
                              name="schedule_info" 
                              rows="3"
                              placeholder="bv. Maandag 13:00-17:00, Locatie: Gebouw A, Ruimte 101"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary">{{ old('schedule_info', $keuzedeel->schedule_info) }}</textarea>
                    @error('schedule_info')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Study Programs -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Toegestane Opleidingen</h3>
                <p class="text-sm text-gray-600 mb-4">Laat leeg voor alle opleidingen, of selecteer specifieke opleidingen.</p>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($studyPrograms as $program)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   id="program_{{ $loop->index }}" 
                                   name="eligible_programs[]" 
                                   value="{{ $program }}"
                                   {{ in_array($program, old('eligible_programs', $keuzedeel->eligible_programs ?? [])) ? 'checked' : '' }}
                                   class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="program_{{ $loop->index }}" class="ml-2 block text-sm text-gray-700">
                                {{ $program }}
                            </label>
                        </div>
                    @endforeach
                </div>
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
                               {{ old('is_active', $keuzedeel->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Actief (zichtbaar voor studenten)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_repeatable" 
                               name="is_repeatable" 
                               value="1"
                               {{ old('is_repeatable', $keuzedeel->is_repeatable) ? 'checked' : '' }}
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="is_repeatable" class="ml-2 block text-sm text-gray-700">
                            Herhaalbaar (studenten kunnen dit keuzedeel meerdere keren volgen)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
            <a href="{{ route('admin.keuzedelen.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                Annuleren
            </a>
            <button type="submit" 
                    class="bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-save mr-2"></i>Bijwerken
            </button>
        </div>
    </form>
</div>
@endsection
