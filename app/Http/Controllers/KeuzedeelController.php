<?php

namespace App\Http\Controllers;

use App\Models\Keuzedeel;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeuzedeelController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $periods = \App\Models\Period::with(['keuzedelen' => function ($query) {
            $query->withCount(['inscriptions' => function ($q) {
                $q->whereIn('status', ['pending', 'confirmed']);
            }]);
        }])->active()->get();

        $userInscriptions = $user ? $user->inscriptions()->with('keuzdeel.period')->get() : collect();
        $completedKeuzedelen = $user ? $user->completedKeuzedelen()->pluck('keuzdeel_id')->toArray() : [];
        
        // Check availability reasons for each keuzedeel
        $availabilityReasons = [];
        if ($user && $user->isStudent()) {
            foreach ($periods as $period) {
                foreach ($period->keuzedelen as $keuzedeel) {
                    $availabilityReasons[$keuzedeel->id] = $this->getAvailabilityReason($keuzedeel, $user);
                }
            }
        }

        return view('keuzedelen.index', compact('periods', 'userInscriptions', 'completedKeuzedelen', 'availabilityReasons'));
    }

    public function show(Keuzedeel $keuzedeel)
    {
        $keuzedeel->load(['period', 'inscriptions' => function ($query) {
            $query->with('user')->whereIn('status', ['pending', 'confirmed']);
        }]);

        $user = Auth::user();
        $userInscription = $user ? $user->inscriptions()->where('keuzdeel_id', $keuzedeel->id)->first() : null;
        $hasCompleted = $user ? $user->hasCompletedKeuzedeel($keuzedeel->id) : false;

        return view('keuzedelen.show', compact('keuzedeel', 'userInscription', 'hasCompleted'));
    }

    public function enroll(Request $request, Keuzedeel $keuzedeel)
    {
        $user = Auth::user();

        if (!$user || !$user->canEnroll()) {
            return back()->with('error', 'Alleen studenten kunnen zich inschrijven voor keuzedelen.');
        }

        if (!$keuzedeel->isAvailableForUser($user)) {
            // Check if user already has an active enrollment in any period
            $hasActiveEnrollment = $user->inscriptions()
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            if ($hasActiveEnrollment) {
                return back()->with('error', 'U kunt slechts voor één keuzedeel tegelijk ingeschreven staan. Annuleer eerst uw huidige inschrijving.');
            }
            
            return back()->with('error', 'Inschrijving niet mogelijk voor dit keuzedeel.');
        }

        try {
            DB::beginTransaction();

            // Check if already enrolled
            $existingInscription = $user->inscriptions()
                ->where('keuzdeel_id', $keuzedeel->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->first();

            if ($existingInscription) {
                return back()->with('error', 'U bent al ingeschreven voor dit keuzedeel.');
            }

            // Check capacity
            $currentEnrollments = $keuzedeel->currentEnrollments();
            
            if ($currentEnrollments >= $keuzedeel->max_participants) {
                return back()->with('error', 'Dit keuzedeel is vol.');
            }

            // Create inscription
            $status = 'confirmed'; // Always confirmed since min=1
            
            Inscription::create([
                'user_id' => $user->id,
                'keuzdeel_id' => $keuzedeel->id,
                'status' => $status,
                'priority' => 1,
                'inscribed_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Inschrijving succesvol bevestigd!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Er is een fout opgetreden bij het inschrijven. Probeer het opnieuw.');
        }
    }

    public function cancel(Request $request, Keuzedeel $keuzedeel)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'U moet ingelogd zijn om uw inschrijving te annuleren.');
        }

        $inscription = $user->inscriptions()
            ->where('keuzdeel_id', $keuzedeel->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if (!$inscription) {
            return back()->with('error', 'Geen actieve inschrijving gevonden voor dit keuzedeel.');
        }

        $inscription->update(['status' => 'cancelled']);

        return back()->with('success', 'Uw inschrijving is geannuleerd.');
    }

    /**
     * Get the reason why a keuzedeel is not available for a user
     */
    private function getAvailabilityReason($keuzedeel, $user)
    {
        if (!$keuzedeel->is_active) {
            return [
                'available' => false,
                'reason' => 'inactief',
                'message' => 'Dit keuzedeel is inactief',
                'icon' => 'fa-pause-circle'
            ];
        }

        if (!$keuzedeel->period->isEnrollmentOpen()) {
            return [
                'available' => false,
                'reason' => 'inschrijving_gesloten',
                'message' => 'Inschrijving is gesloten',
                'icon' => 'fa-lock'
            ];
        }

        // Check if user already has an active inscription for this keuzedeel
        $hasActiveInscription = $user->inscriptions()
            ->where('keuzdeel_id', $keuzedeel->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasActiveInscription) {
            return [
                'available' => false,
                'reason' => 'al_ingeschreven',
                'message' => 'U bent al ingeschreven',
                'icon' => 'fa-check-circle'
            ];
        }

        // Check if user has already completed this keuzedeel
        if ($user->hasCompletedKeuzedeel($keuzedeel->id)) {
            return [
                'available' => false,
                'reason' => 'afgerond',
                'message' => 'Alles afgerond',
                'icon' => 'fa-graduation-cap'
            ];
        }

        // Check if user has enrollment in period (only one keuzedeel per period)
        if ($user->hasEnrollmentInPeriod($keuzedeel->period_id)) {
            return [
                'available' => false,
                'reason' => 'al_anders_ingeschreven',
                'message' => 'Al ingeschreven voor ander keuzedeel',
                'icon' => 'fa-exchange-alt'
            ];
        }

        // Check if keuzedeel is full
        if ($keuzedeel->isFull()) {
            return [
                'available' => false,
                'reason' => 'vol',
                'message' => 'Dit keuzedeel is vol',
                'icon' => 'fa-times-circle'
            ];
        }

        return [
            'available' => true,
            'reason' => 'beschikbaar',
            'message' => 'Beschikbaar',
            'icon' => 'fa-check-circle'
        ];
    }
}
