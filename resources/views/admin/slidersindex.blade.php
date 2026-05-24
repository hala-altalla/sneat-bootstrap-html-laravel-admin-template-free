@extends('layouts/contentNavbarLayout')

@section('title', 'Sliders')

@section('content')

<div class="card">

  <!-- Header -->
  <h5 class="card-header text-center fw-bold fs-5 d-flex align-items-center justify-content-center"
    style="color:#000; background-color:azure; border-bottom:2px solid #dee2e6; border-radius:8px 8px 0 0; padding:1rem;">
    🎯 {{ __('fieldsName.sliderManage') }}
  </h5>
  <br>

  <div class="card-body">

    <!-- Add Button -->
    <div class="mb-4 text-end">
      @can('media-sliderManagement')
      <a href=" {{ route('admin.sliders.create') }}" class="btn btn-primary" style="background-color:cadetblue;">
        + {{ __('fieldsName.add-slider') }}
      </a>
      @endcan
    </div>

    <!-- SLIDERS GRID (3 per row) -->
    <div class="row g-4">

      @forelse($sliders as $slider)

      <div class="col-md-4 col-sm-6">
        <div class="card border-0 shadow-sm h-100 p-3 slider-card">

          <!-- Image -->
          <img src="{{ $slider->imageUrl() }}" class="img-fluid rounded mb-3" style="height:200px; object-fit:cover;">

          <!-- Title -->
          <h6 class="fw-bold">
            {{ $slider->getTranslation('title', app()->getLocale()) }}
          </h6>

          <!-- Description -->
          <p class="text-muted small flex-grow-1">
            {{ $slider->getTranslation('description', app()->getLocale()) }}
          </p>

          <!-- Info -->
          <div class="d-flex justify-content-between align-items-center mb-2">

            <small>
              {{ __('fieldsName.orders') }}:
              <strong>{{ $slider->order }}</strong>
            </small>

            @if($slider->is_active)
            <span class="badge bg-success">{{ __('fieldsName.active') }}</span>
            @else
            <span class="badge bg-danger">{{ __('fieldsName.Inactive') }}</span>
            @endif

          </div>

          <!-- Link -->
          @if($slider->link)
          <a href="{{ $slider->link }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 mb-2">
            {{ __('fieldsName.visitlink') }}
          </a>
          @endif

          <!-- Actions -->
          <div class="d-flex gap-2">
            @can('media-sliderManagement')
            <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-outline-warning w-100">
              ✏ {{ __('fieldsName.edit') }}
            </a>

            <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="w-100"
              onsubmit="return confirm('{{ __('messages.deleteslider') }}');">

              @csrf
              @method('DELETE')

              <button class="btn btn-sm btn-outline-danger w-100">
                🗑 {{ __('fieldsName.delete') }}
              </button>

            </form>
            @endcan
          </div>

        </div>
      </div>

      @empty

      <div class="text-center w-100">
        <p class="text-muted">{{ __('fieldsName.noslider') }}</p>
      </div>

      @endforelse

    </div>

  </div>
</div>

@endsection

@section('page-style')
<style>
/* Card hover effect */
.slider-card {
  border-radius: 18px;
  transition: all 0.3s ease;
  background: #fff;
}

.slider-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

/* Buttons alignment nicer */
.slider-card .btn {
  border-radius: 10px;
}

/* Image smoother look */
.slider-card img {
  border-radius: 14px;
}
</style>
@endsection
