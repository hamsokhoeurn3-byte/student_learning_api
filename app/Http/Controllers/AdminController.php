<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('user')->latest()->get();

        return response()->json([
            'message' => 'Admins retrieved successfully.',
            'data' => $admins,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|string|max:50|unique:admins,admin_code',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => 'required|string|min:8|confirmed',
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name' => trim($validated['first_name'] . ' ' . $validated['last_name']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'admin_code' => $validated['admin_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department' => $validated['department'] ?? 'Administration',
            'position' => $validated['position'] ?? 'System Administrator',
            'phone' => $validated['phone'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json([
            'message' => 'Admin created successfully.',
            'user' => $user,
            'data' => $admin->load('user'),
        ], 201);
    }

    public function show(Admin $admin)
    {
        return response()->json([
            'message' => 'Admin retrieved successfully.',
            'data' => $admin->load('user'),
        ], 200);
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'admin_id' => ['required', 'string', 'max:50', Rule::unique('admins', 'admin_code')->ignore($admin->id)],
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($admin->user?->id)],
            'department' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:30',
            'status' => 'nullable|string|max:50',
        ]);

        if ($admin->user) {
            if (isset($validated['email'])) {
                $admin->user->email = $validated['email'];
            }
            $admin->user->name = trim($validated['first_name'] . ' ' . $validated['last_name']);
            $admin->user->save();
        }

        $admin->update([
            'admin_code' => $validated['admin_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'department' => $validated['department'] ?? $admin->department,
            'position' => $validated['position'] ?? $admin->position,
            'phone' => $validated['phone'] ?? $admin->phone,
            'status' => $validated['status'] ?? $admin->status,
        ]);

        return response()->json([
            'message' => 'Admin updated successfully.',
            'data' => $admin->fresh()->load('user'),
        ], 200);
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->json([
            'message' => 'Admin deleted successfully.',
        ], 200);
    }
}
