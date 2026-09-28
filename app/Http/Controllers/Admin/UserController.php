<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,farmer,user',
        ]);

        if ($user->role === 'admin') {
            return response()->json(
                ['error' => 'Cannot change admin role.'],
                403
            );
        }

        $user->update([
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'User role updated successfully.'
        ]);
    }

    public function approve(User $user)
    {
        if ($user->role !== 'farmer') {
            abort(403, 'Only Farmer accounts can be approved.');
        }

        $user->update(['is_approved' => true]);

        return back()->with('success', "{$user->name} has been approved and can now list products.");
    }

    public function suspend(User $user)
    {
        if ($user->role !== 'farmer') {
            abort(403, 'Only Farmer accounts can be suspended.');
        }

        $user->update(['is_approved' => false]);

        return back()->with('success', "{$user->name}'s Farmer account has been suspended.");
    }

    public function toggleActive(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot deactivate an admin account.');
        }

        $newStatus = ! $user->is_active;
        $user->update(['is_active' => $newStatus]);

        $statusWord = $newStatus ? 'activated' : 'deactivated';

        return back()->with('success', "{$user->name}'s account has been {$statusWord}.");
    }
}
