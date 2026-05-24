<?php

namespace App\Http\Controllers\api;

use App\Events\NewMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;

class MessagesController extends Controller
{

 // جلب الرسائل
 public function index($conversation)
 {
     return Message::where('conversation_id', $conversation)->get();
 }


public function store(Request $request)
{
    $conversation = Conversation::findOrFail($request->conversation_id);

    if (
        $conversation->user_id != $request->sender_user_id &&
        $conversation->business_account_id != $request->sender_user_id
    ) {
        return response()->json(['error' => 'Not allowed'], 403);
    }

    $message = Message::create([
        'conversation_id' => $request->conversation_id,
        'sender_user_id' => $request->sender_user_id,
        'message' => $request->message
    ]);

    broadcast(new NewMessageEvent($message));

    return response()->json($message);
}
public function myconversation()
{
  $user=Auth()->user();
  $conversations=Conversation::where('user_id' , $user->id)->get();
   return response()->json([
    'your conversations' => $conversations
   ]);
}
}
