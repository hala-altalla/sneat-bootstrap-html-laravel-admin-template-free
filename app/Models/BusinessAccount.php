<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class BusinessAccount extends Model implements HasMedia
{
  use InteractsWithMedia;

  public $translatable = ['description'];

  protected $fillable = [
      'activity_type_id',
      'city_id',
      'license_number',
      'business_name_ar',
      'business_name_en',
      'description',
      'latitude',
      'longitude',
      'status',
      'normal_user_id',
      'is_active'

  ];
  protected $casts = [
    'description' => 'array',
    'is_active' => 'boolean',
];

  public function normaluser()
  {
      return $this->belongsTo(NormalUser::class,'normal_user_id');
  }

  public function activityType()
  {
      return $this->belongsTo(ActivityType::class);
  }

  public function city()
  {
      return $this->belongsTo(City::class);
  }

  public function services()
  {
      return $this->hasMany(Service::class);
  }

   public function orders()
   {
      return $this->hasMany(Order::class);
  }


  public function conversations()
{
    return $this->hasMany(Conversation::class);
}

public function ratings()
{
  return $this->hasMany(Rating::class);
}


public function reports()
{
    return $this->hasMany(Report::class);
}
public function registerMediaCollections(): void
{
    $this->addMediaCollection('logo')->singleFile(); // صورة وحدة
    $this->addMediaCollection('attachments'); // عدة ملفات
}
public function logoUrl()
{
    return $this->getFirstMediaUrl('logo');
}
}
