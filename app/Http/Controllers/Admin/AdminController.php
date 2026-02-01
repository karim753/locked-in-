<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuzedeel;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
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
