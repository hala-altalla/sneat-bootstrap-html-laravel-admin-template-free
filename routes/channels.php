<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;
use Laravel\Passport\TokenRepository;
use App\Models\User;
use Illuminate\Http\Request;



Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {


        return true;

});