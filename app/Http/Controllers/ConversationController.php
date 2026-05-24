<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
  public function store(Request $request)
  {
    $user=Auth()->user();
      $conversation = Conversation::Create([
          'user_id' => $user->id,
          'business_account_id' => $request->business_account_id
      ]);

      return response()->json($conversation);
  }
  public function open($conversationId, $userId)
{
    $conversation = Conversation::findOrFail($conversationId);

    // تحقق إذا المستخدم طرف بالمحادثة
    if ($conversation->user_id != $userId && $conversation->business_account_id != $userId) {
        abort(403, 'Not allowed');
    }

    return view('admin.chat', [
        'conversation' => $conversationId,
        'senderId' => $userId
    ]);
}
}