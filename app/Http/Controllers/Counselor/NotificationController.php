<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the counselor.
     */
    public function index(Request $request): JsonResponse
    {
        $counselor = auth()->guard('counselor')->user();

        $notifications = Notification::forCounselor($counselor->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $unreadCount = Notification::forCounselor($counselor->id)
            ->unread()
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Notification $notification): JsonResponse
    {
        $counselor = auth()->guard('counselor')->user();

        // Ensure the notification belongs to this counselor
        if ($notification->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this notification.');
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(): JsonResponse
    {
        $counselor = auth()->guard('counselor')->user();

        Notification::forCounselor($counselor->id)
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification): JsonResponse
    {
        $counselor = auth()->guard('counselor')->user();

        // Ensure the notification belongs to this counselor
        if ($notification->counselor_id !== $counselor->id) {
            abort(403, 'Unauthorized access to this notification.');
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }
}
