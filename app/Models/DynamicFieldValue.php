<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DynamicFieldValue extends Model
{
  use  HasTranslations;


  protected $fillable = ['service_id','dynamic_field_id','value'];

  public function service()
  {
      return $this->belongsTo(Service::class);
  }

  public function field()
  {
      return $this->belongsTo(DynamicField::class,'dynamic_field_id');
  }

}