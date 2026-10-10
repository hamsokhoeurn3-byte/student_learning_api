<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Shared notifications inbox for every role (student, teacher, admin).
 * Notifications are keyed by user_id, so the same logic works for anyone.
 */
class NotificationController extends Controller
{
    /**
     * Show the notifications inbox for the authenticated user, rendered with
     * the layout that matches their role.
     */
    public function index(): View
    {
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
            ->latest()
            ->paginate(15);

        $all = Notification::where('user_id', $userId)->get();

        $summary = [
            'total' => $all->count(),
            'unread' => $all->where('is_read', false)->count(),
            'academic' => $all->filter(fn (Notification $n) => in_array($n->type, ['assignment', 'quiz', 'grade'], true))->count(),
            'system' => $all->filter(fn (Notification $n) => in_array($n->type, ['system', 'attendance', 'course'], true))->count(),
        ];

        $view = match (Auth::user()->role) {
            'admin' => 'pages.admin.notifications.index',
            'teacher' => 'pages.teacher.notifications.index',
            default => 'pages.student.notifications.index',
        };

        return view($view, [
            'notifications' => $notifications,
            'summary' => $summary,
            'readAllRoute' => $this->readAllRoute(),
        ]);
    }

    /**
     * Mark every unread notification for the current user as read.
     */
    public function markAllRead(): RedirectResponse
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return redirect()->route($this->indexRoute())
            ->with('status', 'All notifications marked as read.');
    }

    private function indexRoute(): string
    {
        return match (Auth::user()->role) {
            'admin' => 'admin.notifications',
            'teacher' => 'teacher.notifications',
            default => 'student.notifications',
        };
    }

    private function readAllRoute(): string
    {
        return match (Auth::user()->role) {
            'admin' => 'admin.notifications.read-all',
            'teacher' => 'teacher.notifications.read-all',
            default => 'student.notifications.read-all',
        };
    }
}