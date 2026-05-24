<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
  protected $fillable = ['normal_user_id','service_id'];

  public function normaluser()
  {
      return $this->belongsTo(NormalUser::class);
  }

  public function service()
  {
      return $this->belongsTo(Service::class);
  }
}