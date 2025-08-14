<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Show the user profile
     */
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return Inertia::render('User/Profile', [
            'user' => $user->only(['id', 'name', 'email', 'role', 'status', 'created_at', 'email_verified_at'])
        ]);
    }

    /**
     * Show the form for editing the user profile
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return Inertia::render('User/EditProfile', [
            'user' => $user->only(['id', 'name', 'email'])
        ]);
    }

    /**
     * Update the user profile
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user password
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile.show')
            ->with('success', 'Password updated successfully.');
    }
}
