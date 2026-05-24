@extends('layouts/contentNavbarLayout')

@section('title', 'Add Slider')

@section('content')

<div class="card">

  <!-- Header -->
  <h5 class="card-header text-center fw-bold fs-5 d-flex align-items-center justify-content-center"
    style="color:#000; background-color:azure; border-bottom:2px solid #dee2e6; border-radius:8px 8px 0 0; padding:1rem;">
    🎯 {{__('fieldsName.add_slider')}}
  </h5>

  <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="card-body">

      <!-- Title EN -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.titleen')}}</label>
        <input type="text" name="title_en" class="form-control" placeholder="English title">
      </div>

      <!-- Title AR -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.titlear')}}</label>
        <input type="text" name="title_ar" class="form-control" placeholder="العنوان بالعربي">
      </div>

      <!-- Description EN -->
      <div class="mb-3">{{__('fieldsName.descEn')}}</label>
        <textarea name="description_en" class="form-control"></textarea>
      </div>

      <!-- Description AR -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.descAr')}}</label>
        <textarea name="description_ar" class="form-control"></textarea>
      </div>

      <!-- Link -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.link')}}</label>
        <input type="text" name="link" class="form-control">
      </div>

      <!-- Order -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.order')}}</label>
        <input type="number" name="order" class="form-control">
      </div>

      <!-- Image -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.image')}}</label>
        <input type="file" name="image" class="form-control">
      </div>

      <!-- Active -->
      <div class="mb-3">
        <label class="form-label">{{__('fieldsName.active')}}</label>
        <select name="is_active" class="form-control">
          <option value="1">{{ __('fieldsName.yes') }}</option>
          <option value="0">{{ __('fieldsName.no') }}</option>
        </select>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-primary w-100">
        {{ __('fieldsName.save') }} </button>

    </div>

  </form>

</div>

@endsection
