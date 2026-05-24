<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Slider extends Model implements HasMedia
{
  use InteractsWithMedia , HasTranslations;


    public $translatable =['title','description'];
    protected $fillable =['title','description','link','order','is_active'];
    public function imageUrl(): string
    {
        $media = $this->getFirstMedia('sliders');

        if ($media) {
            return asset('storage/' . $media->getPathRelativeToRoot());
        }

        return asset('images/default.png');
    }
}