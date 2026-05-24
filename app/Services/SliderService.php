<?php

namespace App\Services;

use App\Models\Slider;

class SliderService
{
    public function store($data)
    {
        return Slider::create([
          'title' => [
            'en' => $data['title_en'],
            'ar' => $data['title_ar'],
        ],
        'description' => [
            'en' => $data['description_en'],
            'ar' => $data['description_ar'],
        ],
            'link' => $data['link'] ?? null,
            'order' => $data['order'],
            'is_active' => $data['is_active'],
        ]);
    }

    public function getActiveSliders()
    {

        return Slider::latest()->get();
    }
    public function update($data, $id , $image=null)
{
    $slider = Slider::findOrFail($id);

    $slider->update([
        'title' => [
            'en' => $data['title_en'],
            'ar' => $data['title_ar'],
        ],
        'description' => [
            'en' => $data['description_en'],
            'ar' => $data['description_ar'],
        ],
        'link' => $data['link'] ?? null,
        'order' => $data['order'],
        'is_active' => $data['is_active'],
    ]);
    $slider->save();

    if ($image) {

        $slider->clearMediaCollection('sliders');

        $slider->addMediaFromRequest('image')
               ->toMediaCollection('sliders');
    }

    return $slider;
}

}
