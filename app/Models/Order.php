<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [
    'business_account_id',
    'service_id',
    'needed_at',
    'quantity',
    'details',
    'status'
];

public function businessaccount()
{
    return $this->belongsTo(BusinessAccount::class ,  'business_account_id');
}

public function service()
{
    return $this->belongsTo(Service::class);
}

 public function rating()
  {
       return $this->hasOne(Rating::class);
  }
  public function reports()
{
    return $this->hasMany(Report::class);
}
}
