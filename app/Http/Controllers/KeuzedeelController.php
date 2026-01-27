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

        return view('keuzedelen.index', compact('periods', 'userInscriptions', 'completedKeuzedelen'));
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
            $currentEnrollments = $keuzdeel->currentEnrollments();
            
            if ($currentEnrollments >= $keuzedeel->max_participants) {
                return back()->with('error', 'Dit keuzedeel is vol.');
            }

            // Create inscription
            $status = $currentEnrollments >= $keuzedeel->min_participants ? 'confirmed' : 'pending';
            
            Inscription::create([
                'user_id' => $user->id,
                'keuzdeel_id' => $keuzedeel->id,
                'status' => $status,
            ]);

            DB::commit();

            $message = $status === 'confirmed' 
                ? 'Inschrijving succesvol bevestigd!' 
                : 'Inschrijving ontvangen. U wordt geplaatst op de wachtlijst totdat het minimum aantal deelnemers is bereikt.';

            return back()->with('success', $message);

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
}
