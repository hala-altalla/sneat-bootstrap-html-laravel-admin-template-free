<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderStoreRequest;
use App\Http\Requests\SliderUpdateRequest;
use Illuminate\Http\Request;
use App\Services\SliderService;
use App\Models\Slider;
class SliderController extends Controller
{
  protected $sliderService;

  public function __construct(SliderService $sliderService)
  {
      $this->sliderService = $sliderService;
  }

  // 🔥 عرض الصفحة + السلايدرز
  public function index()
  {
      $sliders = $this->sliderService->getActiveSliders();

      return view('admin.slidersindex', compact('sliders'));
  }

  // 🔥 صفحة الإضافة
  public function create()
  {
      return view('admin.createsliders');
  }

  // 🔥 تخزين سلايدر + صورة (Media Library)
  public function store(SliderStoreRequest $request)
  {


      // 🔥 إنشاء السلايدر
      $slider = $this->sliderService->store($request->validated());

      // 🔥 إضافة الصورة عبر Media Library
      if ($request->hasFile('image')) {
          $slider->addMediaFromRequest('image')
                 ->toMediaCollection('sliders');
      }

      return redirect()->route('admin.sliders.index')
          ->with('success', 'Slider added successfully');
  }

  // 🔥 حذف (اختياري)
  public function destroy($id)
  {
      $slider = Slider::findOrFail($id);

      $slider->clearMediaCollection('sliders');
      $slider->delete();

      return back()->with('success', 'Slider deleted');
  }
  ///
  public function edit($id)
{
    $slider = Slider::findOrFail($id);

    return view('admin.slidersedit', compact('slider'));
}
public function update(SliderUpdateRequest $request, $id)
{
    $this->sliderService->update($request->validated(), $id, $request->file('image'));

    return redirect()->route('admin.sliders.index')
        ->with('success', 'Slider updated successfully');
}
}