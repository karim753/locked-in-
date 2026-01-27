<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // If user is authenticated, redirect based on role
        if (Auth::check()) {
            $user = Auth::user();
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'slber':
                    return redirect()->route('slb.dashboard');
                case 'student':
                default:
                    return redirect()->route('keuzedelen.index');
            }
        }
        
        // Show welcome page for guests
        return view('welcome');
    }
}
