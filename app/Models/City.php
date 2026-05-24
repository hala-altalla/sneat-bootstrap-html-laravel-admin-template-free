<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  public $translatable = ['name'];
  protected $fillable = ['name'];
   protected $casts = [
    'name'=>'array',
   ];
  public function businessAccounts()
  {
      return $this->hasMany(BusinessAccount::class);
}
}