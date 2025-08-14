<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the dashboard based on user role - redirects to proper URL
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        switch ($user->role) {
            case 'super_admin':
                return redirect()->route('super-admin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('user.dashboard');
            default:
                return redirect()->route('user.dashboard');
        }
    }

    /**
     * Super Admin Dashboard - Deprecated, use SuperAdmin\DashboardController
     * @deprecated
     */
    public function superAdminDashboard()
    {
        return app(\App\Http\Controllers\SuperAdmin\DashboardController::class)->index();
    }

    /**
     * Admin Dashboard - Deprecated, use Admin\DashboardController
     * @deprecated
     */
    public function adminDashboard()
    {
        return app(\App\Http\Controllers\Admin\DashboardController::class)->index();
    }

    /**
     * User Dashboard - Deprecated, use User\DashboardController
     * @deprecated
     */
    public function userDashboard()
    {
        return app(\App\Http\Controllers\User\DashboardController::class)->index();
    }
}
