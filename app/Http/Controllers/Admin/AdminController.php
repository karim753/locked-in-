<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuzedeel;
use App\Models\Period;
use App\Models\User;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_keuzedelen' => Keuzedeel::count(),
            'active_keuzedelen' => Keuzedeel::where('is_active', true)->count(),
            'total_users' => User::count(),
            'student_users' => User::where('role', 'student')->count(),
            'total_inscriptions' => Inscription::count(),
            'active_inscriptions' => Inscription::whereIn('status', ['pending', 'confirmed'])->count(),
        ];

        $recentInscriptions = Inscription::with(['user', 'keuzdeel'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentInscriptions'));
    }

    // Keuzedelen Management
    public function keuzedelenIndex()
    {
        $keuzedelen = Keuzedeel::with('period')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.keuzedelen.index', compact('keuzedelen'));
    }

    public function keuzedelenCreate()
    {
        $periods = Period::orderBy('start_date', 'desc')->get();
        $studyPrograms = ['Software Development', 'Business IT', 'Network Engineering', 'Cybersecurity', 'Data Science'];
        return view('admin.keuzedelen.create', compact('periods', 'studyPrograms'));
    }

    public function keuzedelenStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'period_id' => 'required|exists:periods,id',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1|gt:min_participants',
            'credits' => 'required|integer|min:1|max:10',
            'teacher_name' => 'nullable|string|max:255',
            'schedule_info' => 'nullable|string',
            'eligible_programs' => 'nullable|array',
            'eligible_programs.*' => 'string',
            'is_active' => 'boolean',
            'is_repeatable' => 'boolean',
        ]);

        $data = $request->all();
        $data['eligible_programs'] = $request->eligible_programs ?? [];

        Keuzedeel::create($data);

        return redirect()->route('admin.keuzedelen.index')
            ->with('success', 'Keuzedeel succesvol aangemaakt!');
    }

    public function keuzedelenEdit(Keuzedeel $keuzedeel)
    {
        $periods = Period::orderBy('start_date', 'desc')->get();
        $studyPrograms = ['Software Development', 'Business IT', 'Network Engineering', 'Cybersecurity', 'Data Science'];
        return view('admin.keuzedelen.edit', compact('keuzedeel', 'periods', 'studyPrograms'));
    }

    public function keuzedelenUpdate(Request $request, Keuzedeel $keuzedeel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'period_id' => 'required|exists:periods,id',
            'min_participants' => 'required|integer|min:1',
            'max_participants' => 'required|integer|min:1|gt:min_participants',
            'credits' => 'required|integer|min:1|max:10',
            'teacher_name' => 'nullable|string|max:255',
            'schedule_info' => 'nullable|string',
            'eligible_programs' => 'nullable|array',
            'eligible_programs.*' => 'string',
            'is_active' => 'boolean',
            'is_repeatable' => 'boolean',
        ]);

        $data = $request->all();
        $data['eligible_programs'] = $request->eligible_programs ?? [];

        $keuzedeel->update($data);

        return redirect()->route('admin.keuzedelen.index')
            ->with('success', 'Keuzedeel succesvol bijgewerkt!');
    }

    public function keuzedelenDestroy(Keuzedeel $keuzedeel)
    {
        $keuzedeel->delete();
        return redirect()->route('admin.keuzedelen.index')
            ->with('success', 'Keuzedeel succesvol verwijderd!');
    }

    /**
     * Toggle keuzedeel status (activate/deactivate)
     */
    public function toggleKeuzedeelStatus(Request $request, Keuzedeel $keuzedeel)
    {
        $request->validate([
            'is_active' => 'required|boolean'
        ]);

        $keuzedeel->update([
            'is_active' => $request->is_active
        ]);

        $status = $request->is_active ? 'geactiveerd' : 'gedeactiveerd';
        
        return response()->json([
            'success' => true,
            'message' => "Keuzedeel '{$keuzedeel->title}' succesvol {$status}!"
        ]);
    }

    // Periods Management
    public function periodsIndex()
    {
        $periods = Period::orderBy('start_date', 'desc')->paginate(15);
        return view('admin.periods.index', compact('periods'));
    }

    public function periodsCreate()
    {
        return view('admin.periods.create');
    }

    public function periodsStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_opens_at' => 'required|date|before_or_equal:start_date',
            'enrollment_closes_at' => 'required|date|after:enrollment_opens_at|before_or_equal:end_date',
            'is_active' => 'boolean',
        ]);

        Period::create($request->all());

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode succesvol aangemaakt!');
    }

    public function periodsEdit(Period $period)
    {
        return view('admin.periods.edit', compact('period'));
    }

    public function periodsUpdate(Request $request, Period $period)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'enrollment_opens_at' => 'required|date|before_or_equal:start_date',
            'enrollment_closes_at' => 'required|date|after:enrollment_opens_at|before_or_equal:end_date',
            'is_active' => 'boolean',
        ]);

        $period->update($request->all());

        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode succesvol bijgewerkt!');
    }

    public function periodsDestroy(Period $period)
    {
        $period->delete();
        return redirect()->route('admin.periods.index')
            ->with('success', 'Periode succesvol verwijderd!');
    }

    /**
     * Toggle enrollment status for a period
     */
    public function toggleEnrollmentStatus(Request $request, Period $period)
    {
        $request->validate([
            'is_open' => 'required|boolean'
        ]);

        // Update enrollment dates based on the toggle state
        if ($request->is_open) {
            // Open enrollment - set to open now and close in 30 days
            $period->update([
                'enrollment_opens_at' => now(),
                'enrollment_closes_at' => now()->addDays(30),
            ]);
        } else {
            // Close enrollment - set closes_at to now
            $period->update([
                'enrollment_closes_at' => now(),
            ]);
        }

        $status = $request->is_open ? 'geopend' : 'gesloten';
        
        return response()->json([
            'success' => true,
            'message' => "Inschrijvingen voor periode '{$period->name}' succesvol {$status}!"
        ]);
    }

    // Users Management
    public function usersIndex()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:student,admin,slber',
            'study_program' => 'nullable|string|max:255',
            'student_number' => 'nullable|string|max:50',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.users.index')
            ->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    // Statistics
    public function statistics()
    {
        $stats = [
            'keuzedelen_by_period' => Period::withCount('keuzedelen')->get(),
            'inscriptions_by_status' => Inscription::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'users_by_role' => User::selectRaw('role, COUNT(*) as count')
                ->groupBy('role')
                ->get(),
            'popular_keuzedelen' => Keuzedeel::withCount(['inscriptions' => function ($query) {
                $query->whereIn('status', ['pending', 'confirmed']);
            }])
            ->orderBy('inscriptions_count', 'desc')
            ->limit(10)
            ->get(),
        ];

        return view('admin.statistics', compact('stats'));
    }

    public function deleteAllKeuzedelen(Request $request)
    {
        try {
            DB::beginTransaction();

            // Disable foreign key checks temporarily
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Delete all inscriptions first
            Inscription::truncate();

            // Delete all keuzedelen
            $deletedCount = Keuzedeel::count();
            Keuzedeel::truncate();

            // Re-enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            DB::commit();

            return redirect()->route('admin.dashboard')
                ->with('success', "Succesvol {$deletedCount} keuzedelen verwijderd!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.dashboard')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van keuzedelen: ' . $e->getMessage());
        }
    }
}
