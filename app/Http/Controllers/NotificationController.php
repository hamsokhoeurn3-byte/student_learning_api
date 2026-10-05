<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()?->id ?? $request->query('user_id');

        $query = Notification::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($request->has('is_read')) {
            $query->where('is_read', filter_var($request->is_read, FILTER_VALIDATE_BOOLEAN));
        }

        $notifications = $query->latest()->get();

        return response()->json([
            'message' => 'Notifications retrieved successfully.',
            'data' => $notifications,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:200',
            'message' => 'required|string',
            'type' => 'nullable|string|max:30',
            'reference_type' => 'nullable|string|max:50',
            'reference_id' => 'nullable|integer',
        ]);

        $notification = Notification::create([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'message' => $validated['message'],
            'type' => $validated['type'] ?? 'system',
            'reference_type' => $validated['reference_type'] ?? null,
            'reference_id' => $validated['reference_id'] ?? null,
            'is_read' => false,
        ]);

        return response()->json([
            'message' => 'Notification created successfully.',
            'data' => $notification,
        ], 201);
    }

    public function show(Notification $notification)
    {
        return response()->json([
            'message' => 'Notification retrieved successfully.',
            'data' => $notification,
        ], 200);
    }

    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $notification->update([
            'is_read' => $validated['is_read'],
            'read_at' => $validated['is_read'] ? now() : null,
        ]);

        return response()->json([
            'message' => 'Notification updated successfully.',
            'data' => $notification->fresh(),
        ], 200);
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return response()->json([
            'message' => 'Notification deleted successfully.',
        ], 200);
    }
}
