<?php

namespace App\Models;
use Spatie\Translatable\HasTranslations;

use Illuminate\Database\Eloquent\Model;

class DynamicFieldOption extends Model
{
  use  HasTranslations;

  protected $fillable = ['dynamic_field_id','value'];
  protected $casts = [
    'value'=>'array',
   ];
  public function field()
  {
      return $this->belongsTo(DynamicField::class,'dynamic_field_id');
  }
}