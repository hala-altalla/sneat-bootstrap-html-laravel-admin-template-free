<?php

namespace App\Services ;

use App\Models\Favorite;

class FavoriteService
{
  public function store(array $data , $user)
  {
    $normalUserId=$user->normalUser->id;
    $exists = Favorite::where('normal_user_id', $normalUserId)
        ->where('service_id', $data['service_id'])
        ->exists();

    if ($exists) {
       return false;
    }
     $favorite= Favorite::create([
      'normal_user_id' => $user->normalUser->id,
      'service_id' => $data['service_id']
     ]);
     return $favorite;
  }
}