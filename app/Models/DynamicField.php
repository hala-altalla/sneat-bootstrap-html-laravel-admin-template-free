<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class DynamicField extends Model
{
  use  HasTranslations;

  public $translatable = ['name'];
  protected $fillable = [
      'category_id','sub_category_id','name','type','is_required'
  ];
  protected $casts = [
    'name'=>'array',
   ];
  public function category()
  {
      return $this->belongsTo(Category::class);
  }

  public function subcategory()
  {
      return $this->belongsTo(SubCategory::class ,'sub_category_id');
  }

  public function options()
  {
      return $this->hasMany(DynamicFieldOption::class);
  }
  public function values()
{
    return $this->hasMany(DynamicFieldValue::class, 'dynamic_field_id');
}
}