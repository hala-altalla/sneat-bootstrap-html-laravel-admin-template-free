@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Slider')

@section('content')

<div class="card">

  <h5 class="card-header text-center fw-bold" style="background:azure;">
    ✏️ Edit Slider
  </h5>

  <form method="POST" action="{{ route('admin.sliders.update', $slider->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card-body">

      <!-- Title EN -->
      <div class="mb-3">
        <label>Title EN</label>
        <input type="text" name="title_en" value="{{ $slider->getTranslation('title', 'en') }}" class="form-control">
      </div>

      <!-- Title AR -->
      <div class="mb-3">
        <label>Title AR</label>
        <input type="text" name="title_ar" value="{{ $slider->getTranslation('title', 'ar') }}" class="form-control">
      </div>

      <!-- Description EN -->
      <div class="mb-3">
        <label>Description EN</label>
        <textarea name="description_en"
          class="form-control">{{ $slider->getTranslation('description', 'en') }}</textarea>
      </div>

      <!-- Description AR -->
      <div class="mb-3">
        <label>Description AR</label>
        <textarea name="description_ar"
          class="form-control">{{ $slider->getTranslation('description', 'ar') }}</textarea>
      </div>

      <!-- Link -->
      <div class="mb-3">
        <label>Link</label>
        <input type="text" name="link" value="{{ $slider->link }}" class="form-control">
      </div>

      <!-- Order -->
      <div class="mb-3">
        <label>Order</label>
        <input type="number" name="order" value="{{ $slider->order }}" class="form-control">
      </div>

      <!-- Active -->
      <div class="mb-3">
        <label>Status</label>
        <select name="is_active" class="form-control">
          <option value="1" {{ $slider->is_active ? 'selected' : '' }}>Active</option>
          <option value="0" {{ !$slider->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

      <!-- Current Image -->
      <div class="mb-3">
        <img src="{{ $slider->imageUrl() }}" style="width:200px; border-radius:10px;">
      </div>

      <!-- New Image -->
      <div class="mb-3">
        <label>Change Image</label>
        <input type="file" name="image" class="form-control">
      </div>

      <!-- Submit -->
      <button class="btn btn-primary w-100">
        Update Slider
      </button>

    </div>

  </form>

</div>

@endsection