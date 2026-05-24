<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
  protected $fillable = ['conversation_id','sender_user_id' , 'message'];
  public function Conversation() {
    return $this->belongsTo(Conversation::class);
}
}
