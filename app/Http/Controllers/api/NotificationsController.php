<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
     public function index()
    {
      return response()->json([
        'status' => true ,
        'data' => auth()->user()->Notifications
      ]);
    }

    public function unread()
    {
      return response()->json([
        'status' => true ,
        'data' => auth()->user()->unreadNotifications
      ]);
    }
    public function markAsRead($id)
{
    $user = auth('api')->user();

    $notification = $user->notifications
        ->where('id', $id)
        ->first();

    if (!$notification) {
        return response()->json([
            'status' => false,
            'message' => 'Notification not found'
        ], 404);
    }

    $notification->markAsRead();

    return response()->json([
        'status' => true,
        'message' => 'Marked as read'
    ]);
}
}
