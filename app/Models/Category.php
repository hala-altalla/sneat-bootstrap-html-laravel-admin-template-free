<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
  use  HasTranslations;
  public $translatable = ['name'];
  protected $fillable = ['name'];

  public function subcategories()
  {
      return $this->hasMany(Subcategory::class);
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