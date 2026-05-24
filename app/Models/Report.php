<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  protected $fillable = [
    'order_id',
    'business_account_id',
    'reason',
    'status'
];

public function order()
{
    return $this->belongsTo(Order::class);
}

public function businessAccount()
{
    return $this->belongsTo(BusinessAccount::class);
}
}