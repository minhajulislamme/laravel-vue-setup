<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Super Admin Dashboard
     */
    public function index()
    {
        return Inertia::render('SuperAdmin/Dashboard', [
            'stats' => [
                'total_users' => User::count(),
                'total_admins' => User::where('role', 'admin')->count(),
                'total_regular_users' => User::where('role', 'user')->count(),
                'active_users' => User::where('status', 'active')->count(),
                'inactive_users' => User::where('status', 'inactive')->count(),
                'super_admins' => User::where('role', 'super_admin')->count(),
            ]
        ]);
    }
}
