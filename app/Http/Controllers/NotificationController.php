<?php
// app/Http/Controllers/NotificationController.php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // ── All notifications page ─────────────────────────────────
    // Route: GET /notifications
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        $unreadCount = Notification::where('user_id', Auth::id())
            ->unread()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    // ── Get unread count (AJAX) ────────────────────────────────
    // Route: GET /notifications/count
    public function count()
    {
        $count = Notification::where('user_id', Auth::id())
            ->unread()->count();

        return response()->json(['count' => $count]);
    }

    // ── Get recent notifications (AJAX for bell dropdown) ──────
    // Route: GET /notifications/recent
    public function recent()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn($n) => [
                'id'       => $n->id,
                'type'     => $n->type,
                'title'    => $n->title,
                'body'     => $n->body,
                'icon'     => $n->icon,
                'url'      => $n->url,
                'is_read'  => $n->is_read,
                'time_ago' => $n->time_ago,
            ]);

        $unreadCount = Notification::where('user_id', Auth::id())
            ->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }

    // ── Mark single as read ────────────────────────────────────
    // Route: PATCH /notifications/{id}/read
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) abort(403);

        $notification->update(['is_read' => true]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($notification->url) {
            return redirect($notification->url);
        }

        return back();
    }

    // ── Mark all as read ───────────────────────────────────────
    // Route: POST /notifications/mark-all-read
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->unread()
            ->update(['is_read' => true]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    // ── Delete single notification ─────────────────────────────
    // Route: DELETE /notifications/{id}
    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) abort(403);

        $notification->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notification deleted.');
    }

    // ── Clear all notifications ────────────────────────────────
    // Route: DELETE /notifications/clear-all
    public function clearAll()
    {
        Notification::where('user_id', Auth::id())->delete();

        return back()->with('success', 'All notifications cleared.');
    }
}