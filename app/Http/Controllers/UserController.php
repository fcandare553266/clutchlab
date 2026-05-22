<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
{
    if (Auth::user()->role !== 'admin') { abort(403); }

    // 1. Start a query
    $query = User::query();

    // 2. Filter by Role (if the 'role' parameter is present and not 'all')
    if ($request->filled('role') && $request->role !== 'all') {
        $query->where('role', $request->role);
    }

    // 3. Filter by Search (if the 'search' parameter is present)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // 4. Get the filtered users
    $users = $query->latest()->get();

    return view('admin.users.index', compact('users'));
}

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') { abort(403); }

        $request->validate([
            'role' => 'required|in:admin,trainer,client',
        ]);

        $user->update([
            'role' => $request->role,
            'specialization' => $request->specialization,
            'working_hours' => $request->working_hours,
        ]);

        return back()->with('success', 'User updated successfully!');
    }
}