<?php

namespace App\Http\Controllers;

use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


class NotificationsController extends Controller
{

  public function saveToken(Request $request)
  {
      $user = auth()->user();

      $user->device_token = $request->token;
      $user->save();

      return response()->json(['status' => true]);
  }
  public function sendNotification($token, $type)
{
    if (!$token) return;

    $messaging = app('firebase.messaging');
    if($type == 'report')
    {
      $title = 'New report 🔥';
      $body = 'A new report has been added';
    }
   elseif ($type == 'service') {
        $title = 'New Service 🔥';
        $body = 'A new service has been added';
    }
    else {
        $title = 'New Business Account 🏢';
        $body = 'A new business account has been created';
    }

     $message = CloudMessage::fromArray([
        'token' => $token,
        'notification' => [
            'title' => $title,
            'body' => $body,
        ],
        'data' => [
            'type' => $type
        ]
    ]);
    $messaging->send($message);


}

public function notifications()
{
    $user = auth()->user();

    return response()->json([
        'notifications' => $user->notifications()
            ->latest()
            ->take(100)
            ->get(),

        'unread_count' => $user->unreadNotifications->count()
    ]);
}
 public function markAsRead($id)
{
    $user = auth()->user();

    $notification = $user->notifications()
        ->where('id', $id)
        ->first();

    if ($notification) {
        $notification->markAsRead();

        $notification->update(['read_at' => now()]);
    }

    return response()->json(['status' => true]);
}





public function markAllAsRead()
{
    auth()->user()->unreadNotifications->markAsRead();

    return response()->json(['status' => true]);
}
}