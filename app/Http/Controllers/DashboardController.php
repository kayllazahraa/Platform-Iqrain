<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('mentor')) {
            // Check if mentor is approved
            if ($user->mentor && $user->mentor->status_approval !== 'approved') {
                return view('auth.pending-approval');
            }
            return redirect()->route('mentor.dashboard');
        } elseif ($user->hasRole('murid')) {
            return redirect()->route('murid.dashboard');
        }

        // Fallback
        return redirect()->route('landing');
    }
}
