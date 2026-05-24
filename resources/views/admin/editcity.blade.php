@extends('layouts/contentNavbarLayout')

@section('title', 'edit Cities')
@section('content')

<div class="container-xxl mt-4">

  <!-- Title -->
  <h3 class="city-title mb-4 text-center">
    <i class="bx bx-buildings me-2"></i>
    {{ __('fieldsName.managecity') }}
  </h3>

  <div class="card mb-4">
    <h5 class="card-header fw-bold text-center"> {{ __('fieldsName.editcity') }}</h5>

    <div class="card-body">
      <form action="{{ route('update.city' , $city->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">City Name (EN)</label>
            <input type="text" name="name[en]" class="form-control" required
              value="{{ old('name.en', $city->name['en']) }}">
          </div>

          <div class="col-md-6">
            <label class="form-label">اسم المدينة (AR)</label>
            <input type="text" name="name[ar]" class="form-control" required
              value="{{ old('name.ar', $city->name['ar']) }}">
          </div>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary px-4">
            {{ __('fieldsName.save') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection
