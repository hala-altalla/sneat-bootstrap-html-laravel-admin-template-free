<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
  protected $fillable = [
    'order_id',
    'business_account_id',
    'rating',
    'comment'
];


public function order()
{
    return $this->belongsTo(Order::class);
}
public function BusinessAccount()
{
  return $this->belongsTo(BusinessAccount::class);
}
}