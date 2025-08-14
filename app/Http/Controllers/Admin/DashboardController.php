<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'total_users' => User::where('role', 'user')->count(),
                'active_users' => User::where('role', 'user')->where('status', 'active')->count(),
                'inactive_users' => User::where('role', 'user')->where('status', 'inactive')->count(),
                'recent_users' => User::where('role', 'user')->latest()->take(5)->get(),
            ]
        ]);
    }
}
