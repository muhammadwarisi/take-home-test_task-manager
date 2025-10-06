<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // hitung data task untuk widget
        $totalTasks = \App\Models\Tasks::count();
        $completedTasks = \App\Models\Tasks::where('status', 'Selesai')->count();
        $pendingTasks = \App\Models\Tasks::where('status', 'Belum Selesai')->count();
        return view('pages.dashboard', compact([
            'totalTasks',
            'completedTasks',
            'pendingTasks'
        ]));
    }
}
