<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of all users
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        return Inertia::render('SuperAdmin/UserManagement', [
            'users' => $users,
            'filters' => $request->only(['search', 'role', 'status']),
            'stats' => [
                'total_users' => User::count(),
                'active_users' => User::where('status', 'active')->count(),
                'inactive_users' => User::where('status', 'inactive')->count(),
                'super_admins' => User::where('role', 'super_admin')->count(),
                'admins' => User::where('role', 'admin')->count(),
                'regular_users' => User::where('role', 'user')->count(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('SuperAdmin/CreateUser');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:user,admin,super_admin',
            'status' => 'required|in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing a user
     */
    public function edit(User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        return Inertia::render('SuperAdmin/EditUser', [
            'user' => $user,
        ]);
    }

    /**
     * Update a user
     */
    public function update(Request $request, User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin,super_admin',
            'status' => 'required|in:active,inactive',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Update password if provided
        if ($request->password) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove a user
     */
    public function destroy(User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Prevent self-deletion
        if ($user->id === $currentUser->id) {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('super-admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Prevent deactivating own account
        if ($user->id === $currentUser->id) {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'You cannot deactivate your own account.');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'User activated successfully.' : 'User deactivated successfully.';

        return redirect()->route('super-admin.users.index')
            ->with('success', $message);
    }

    /**
     * Bulk action on users
     */
    public function bulkAction(Request $request)
    {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $request->user_ids;

        // Remove current user from bulk actions
        $userIds = array_filter($userIds, fn($id) => $id != $currentUser->id);

        if (empty($userIds)) {
            return redirect()->route('super-admin.users.index')
                ->with('error', 'No valid users selected for action.');
        }

        switch ($request->action) {
            case 'activate':
                User::whereIn('id', $userIds)->update(['status' => 'active']);
                $message = 'Selected users activated successfully.';
                break;
            case 'deactivate':
                User::whereIn('id', $userIds)->update(['status' => 'inactive']);
                $message = 'Selected users deactivated successfully.';
                break;
            case 'delete':
                User::whereIn('id', $userIds)->delete();
                $message = 'Selected users deleted successfully.';
                break;
        }

        return redirect()->route('super-admin.users.index')
            ->with('success', $message);
    }

    /**
     * Export users data as PDF or Excel
     */
    public function export(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $query = User::query();

        // Apply the same filters as the index method
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $format = $request->input('format', 'pdf');
        $timestamp = now()->format('Y-m-d_H-i-s');

        if ($format === 'excel') {
            return $this->exportToExcel($users, $timestamp);
        } else {
            return $this->exportToPDF($users, $timestamp);
        }
    }

    /**
     * Export users to PDF
     */
    private function exportToPDF($users, $timestamp)
    {
        $html = $this->generateUsersHTML($users, 'PDF');

        // For now, we'll return a simple HTML response
        // In production, you might want to use a library like DomPDF or wkhtmltopdf
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', "attachment; filename=users_export_{$timestamp}.html");
    }

    /**
     * Export users to Excel (CSV format)
     */
    private function exportToExcel($users, $timestamp)
    {
        $csv = "Name,Email,Role,Status,Created At\n";

        foreach ($users as $user) {
            $csv .= '"' . str_replace('"', '""', $user->name) . '",';
            $csv .= '"' . str_replace('"', '""', $user->email) . '",';
            $csv .= '"' . str_replace('"', '""', ucfirst($user->role)) . '",';
            $csv .= '"' . str_replace('"', '""', ucfirst($user->status)) . '",';
            $csv .= '"' . $user->created_at->format('Y-m-d H:i:s') . '"' . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=users_export_{$timestamp}.csv");
    }

    /**
     * Generate HTML for users table
     */
    private function generateUsersHTML($users, $format)
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <title>Users Export - ' . $format . '</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f8f9fa; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .header { margin-bottom: 20px; }
        .status-active { color: #22c55e; font-weight: bold; }
        .status-inactive { color: #ef4444; font-weight: bold; }
        .role { text-transform: capitalize; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Users Export Report</h1>
        <p>Generated on: ' . now()->format('F j, Y \a\t g:i A') . '</p>
        <p>Total Users: ' . $users->count() . '</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($users as $user) {
            $statusClass = $user->status === 'active' ? 'status-active' : 'status-inactive';
            $html .= '<tr>
                <td>' . htmlspecialchars($user->name) . '</td>
                <td>' . htmlspecialchars($user->email) . '</td>
                <td class="role">' . htmlspecialchars(ucfirst($user->role)) . '</td>
                <td class="' . $statusClass . '">' . htmlspecialchars(ucfirst($user->status)) . '</td>
                <td>' . $user->created_at->format('M j, Y g:i A') . '</td>
            </tr>';
        }

        $html .= '</tbody>
    </table>
</body>
</html>';

        return $html;
    }
}
