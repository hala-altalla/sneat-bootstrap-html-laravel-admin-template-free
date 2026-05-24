<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ActivityType extends Model
{
  use  HasTranslations;
  public $translatable = ['name'];
  protected $fillable = ['name'];
  protected $casts = [
    'name' => 'array',
];

  public function businessAccounts()
  {
      return $this->hasMany(BusinessAccount::class);
  }
}