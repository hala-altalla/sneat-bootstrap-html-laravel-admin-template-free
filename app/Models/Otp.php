<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
  protected $fillable = [
    'phone',
    'code',
    'expires_at',
    'payload' ,
    'is_used' ,
    'attempts'


    ] ;
    protected $casts = [
      'payload' => 'array',
  ];
}