<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
class Service extends Model implements HasMedia
{
use InteractsWithMedia;
  public $translatable = ['description'];
  protected $fillable = [
      'business_account_id','category_id','sub_category_id',
      'title_ar','title_en','description','quantity','service_type',
      'price_usd','price_syp','latitude','longitude','status'
  ];
  protected $casts = [
    'description'=>'array',
   ];

  public function businessAccount()
  {
      return $this->belongsTo(BusinessAccount::class);
  }

  public function category()
  {
      return $this->belongsTo(Category::class);
  }

  public function subcategory()
  {
      return $this->belongsTo(Subcategory::class);
  }

  public function dynamicValues()
  {
      return $this->hasMany(DynamicFieldValue::class);
  }

  public function orders()
  {
      return $this->hasMany(Order::class);
  }
  public function conversations()
  {
    return $this->hasmany(Conversation::class);
  }
  public function favorites()
  {
      return $this->hasMany(Favorite::class);
  }
  public function registerMediaCollections(): void
{
    $this->addMediaCollection('main_image')->singleFile(); // صورة رئيسية واحدة
    $this->addMediaCollection('additional_images');        // صور إضافية ممكن تكون متعددة
}
public function mainImageUrl(): string
    {
        $media = $this->getFirstMedia('main_image');

        if ($media) {
            return asset('storage/' . $media->getPathRelativeToRoot());
        }

        return asset('images/default.png');
      }
    public function additionalImagesUrls(): array
{
    return $this->getMedia('additional_images')->map(function ($media) {
        return asset('storage/' . $media->getPathRelativeToRoot());
    })->toArray();
}

}
