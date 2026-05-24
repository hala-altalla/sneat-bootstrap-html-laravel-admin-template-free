<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Admin extends Model
{
  use HasRoles , Notifiable;
  protected $fillable = ['user_id','email','password'];

  public function user()
  {
      return $this->belongsTo(User::class);
  }
}