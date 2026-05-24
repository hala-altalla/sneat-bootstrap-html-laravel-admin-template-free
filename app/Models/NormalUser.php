<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NormalUser extends Model
{
  protected $fillable = ['user_id','phone','password'];

  public function user()
  {
      return $this->belongsTo(User::class);
  }
    public function favorites()
     {
         return $this->hasMany(Favorite::class);
     }
     public function businessaccounts()
     {
         return $this->hasMany(BusinessAccount::class);
     }

}