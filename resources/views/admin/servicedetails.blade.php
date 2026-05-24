@extends('layouts/contentNavbarLayout')

@section('title', 'Service Details')

@section('content')

<div class="container-xxl mt-4">

  <div class="card p-4 shadow-sm" style="border-radius:16px;">

    <!-- Title -->
    <h3 class="fw-bold mb-3"> {{ __('fieldsName.service') }} :
      {{ app()->getLocale() == 'ar' ? $service->title_ar : $service->title_en }}
    </h3>

    <div class="row g-4">

      <!-- Left: Images -->
      <div class="col-lg-6">

        <!-- Main Image -->
        <div class="border rounded p-2 mb-2 text-center" style="background:#f8f9fa;">
          <img id="main-product-image" src="{{ $service->mainImageUrl() }}" class="img-fluid rounded"
            style="max-height:450px; object-fit:contain;">
        </div>

        <!-- Thumbnails / Additional Images -->
        @php
        $additionalImages = $service->additionalImagesUrls();
        @endphp
        @if(count($additionalImages))
        <div class="d-flex flex-wrap gap-2">
          @foreach($additionalImages as $img)
          <div class="thumb border rounded" style="width:80px; height:80px; cursor:pointer;">
            <img src="{{ $img }}" class="img-fluid rounded" style="width:100%; height:100%; object-fit:cover;"
              onclick="document.getElementById('main-product-image').src='{{ $img }}'">
          </div>
          @endforeach
        </div>
        @endif

      </div>

      <!-- Right: Info & Details -->
      <div class="col-lg-6">

        <!-- Info -->
        <div class="mb-4">
          <div class="row g-2">
            <div class="col-6"><strong>{{__('fieldsName.category')}}:</strong>
              {{ $service->category?->getTranslation('name', app()->getLocale()) ?? '-' }}</div>
            <div class="col-6"><strong>{{__('fieldsName.businees-account-provider')}}:</strong>
              {{app()->getLocale() == 'ar' ?  $service->businessAccount->business_name_ar : $service->businessAccount->business_name_en }}
            </div>
            <div class="col-6"><strong>{{__('fieldsName.typeservice')}}:</strong>

              @if($service->service_type=="sale")
              <span class="badge bg-info text-dark">
                <!-- {{ ucfirst($service->service_type) }} -->
                {{ __('fieldsName.sale') }}
              </span>
              @endif
              @if($service->service_type=="rent")
              <span class="badge bg-info text-dark">
                <!-- {{ ucfirst($service->service_type) }} -->
                {{ __('fieldsName.rent') }}
              </span>
              @endif
            </div>
            <div class="col-6"><strong> {{ __('fieldsName.price') }}:</strong>
              <br>
              {{ $service->price_usd }} {{ __('fieldsName.usd') }}
              <br>
              {{ $service->price_syp }} {{ __('fieldsName.syr') }}
            </div>
            <div class="col-6"><strong> {{ __('fieldsName.quantity') }}:</strong> {{ $service->quantity }}</div>
            <div class="col-6"><strong> {{ __('fieldsName.status') }}:</strong>
              @if($service->status == 'pending')
              <span class="badge bg-warning text-dark">{{ __('fieldsName.pending') }}</span>
              @elseif($service->status == 'accepted')
              <span class="badge bg-success">{{ __('fieldsName.accepted') }}</span>
              @else
              <span class="badge bg-danger">{{ __('fieldsName.rejected') }}</span>
              @endif
            </div>
          </div>

          <!-- Dynamic Fields as Badges -->
          @if($service->dynamicValues->count())
          <div class="mb-4">
            <h5>⚡ {{__('fieldsName.dynamic fields')}}</h5>
            @foreach($service->dynamicValues as $value)
            <span class="badge bg-primary me-2 mb-2">
              {{ $value->field->getTranslation('name', app()->getLocale()) }}:{{ $value->value }}
            </span>
            @endforeach
          </div>
          @endif

          <!-- Description -->
          <div class="mb-4">
            <h5>📝 {{__('fieldsName.description')}}</h5>
            <p>
              {{ app()->getLocale() == 'ar' ? ($service->description['ar'] ?? '-') : ($service->description['en'] ?? '-') }}
            </p>
          </div>

          <!-- Google Map -->
          @if($service->latitude && $service->longitude)
          <div class="mb-4">
            <h5>📍 {{__('fieldsName.location')}}</h5>
            <iframe width="100%" height="250" style="border:0; border-radius:12px;" loading="lazy" allowfullscreen
              src="https://www.google.com/maps?q={{ $service->latitude }},{{ $service->longitude }}&hl=es;z=14&output=embed">
            </iframe>
            <div class="mt-2 text-end">
              <a href="https://www.google.com/maps?q={{ $service->latitude }},{{ $service->longitude }}" target="_blank"
                class="btn btn-outline-primary">
                <i class="bx bx-map"></i> {{__('fieldsName.openmap')}}
              </a>
            </div>
          </div>
          @endif

          <!-- Back Button -->
          <a href="{{ route('view.services') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> {{__('fieldsName.back')}}
          </a>

        </div>
      </div>

    </div>

  </div>


  @endsection
