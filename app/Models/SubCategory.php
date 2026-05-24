<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{
  use HasTranslations;
  public $translatable = ['name'];
  protected $fillable = ['category_id','name'];
  protected $casts = [
    'name'=>'array',
   ];

  public function category()
  {
      return $this->belongsTo(Category::class);
  }

  public function services()
  {
      return $this->hasMany(Service::class);
  }
  public function dynamicfields()
  {
      return $this->hasMany(DynamicField::class);
  }
}