@extends('layouts/contentNavbarLayout')

@section('title', 'Business Account Details')

@section('content')
<div class="container-xxl mt-4">

  <!-- Title -->
  <h3 class="mb-4 fw-bold d-flex align-items-center gap-2 title-anim">
    <i class="bx bx-store-alt text-primary"></i>
    {{ __('fieldsName.businessaccountdetails') }}
  </h3>

  <!-- Card -->
  <div class="business-card p-4 mx-auto" style="max-width: 650px;">
    <!-- Logo -->
    <img src="{{ asset(str_replace('http://localhost/', '', $account->getFirstMediaUrl('logo'))) }}"
      style="width:120px;height:120px;border-radius:50%;object-fit:cover;">
    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-3">
      <div class="icon-circle">
        <i class="bx bx-building-house"> {{ __('fieldsName.businessaccount') }}</i>
      </div>
      <h4 class="mb-0">
        {{ app()->getLocale() == 'ar' ? $account->business_name_ar : $account->business_name_en }}
      </h4>
    </div>

    <!-- Info -->
    <div class="info-section">

      <p>
        <i class="bx bx-category"></i>
        <strong>{{ __('fieldsName.activity') }}:</strong>
        {{ $account->activityType->name }}
      </p>

      <p>
        <i class="bx bx-id-card"></i>
        <strong>{{ __('fieldsName.license') }}:</strong> {{ $account->license_number }}
      </p>

      <p>
        <i class="bx bx-map"></i>
        <strong>{{ __('fieldsName.city') }} :</strong>
        {{  app()->getLocale() == 'ar' ? $account->city->name['ar'] : $account->city->name['en']  }}
      </p>

      <p>
        <i class="bx bx-user"></i>
        <strong>{{ __('fieldsName.owner') }}:</strong>
        {{ $account->normaluser->user->name ?? 'N/A' }}
      </p>

      <p>
        <i class="bx bx-detail"></i>
        <strong>{{ __('fieldsName.description') }}:</strong>
        {{ app()->getLocale() == 'ar' ? $account->description['ar'] ?? '' : $account->description['en'] ?? '' }}
      </p>

      <p>
        <i class="bx bx-time-five"></i>
        <strong>{{ __('fieldsName.status') }}:</strong>
        <span class="badge bg-warning text-dark">
          {{ ucfirst($account->status) }}
        </span>
      </p>

    </div>

    <!-- Map -->
    <div class="map-section mt-4">
      <h6 class="mb-2 d-flex align-items-center gap-1">
        <i class="bx bx-map-pin"></i> {{ __('fieldsName.location') }}
      </h6>

      <div class="map-container">
        <iframe width="100%" height="260" loading="lazy" allowfullscreen
          src="https://maps.google.com/maps?q={{ $account->latitude }},{{ $account->longitude }}&z=15&output=embed">
        </iframe>
      </div>

      <!-- Open in Google Maps -->
      <a href="https://www.google.com/maps?q={{ $account->latitude }},{{ $account->longitude }}" target="_blank"
        class="btn btn-primary mt-3 w-100">
        <i class="bx bx-map"></i> {{__('fieldsName.openmap')}}
      </a>
    </div>
    <!-- Attachments -->
    @if($account->getMedia('attachments')->count())
    <div class="mt-4">
      <h6 class="mb-3 d-flex align-items-center gap-1">
        <i class="bx bx-paperclip"></i> Files
      </h6>

      <div class="attachments-list">
        @foreach($account->getMedia('attachments') as $file)
        <a href="{{ $file->getUrl() }}" target="_blank" class="file-item">
          <i class="bx bx-file"></i>
          {{ $file->file_name }}
        </a>
        @endforeach
      </div>
    </div>
    @endif
    <!-- Back -->
    <div class="mt-4">
      <a href="{{ route('check') }}" class="btn btn-outline-secondary w-100">
        <i class="bx bx-arrow-back"></i> {{__('fieldsName.back')}}
      </a>
    </div>

  </div>
</div>

<style>
/* Title Animation */
.title-anim {
  animation: fadeSlide 0.6s ease;
}

@keyframes fadeSlide {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Card */
.business-card {
  background: linear-gradient(145deg, #f8f9fa, #ffffff);
  border-radius: 20px;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
  transition: 0.3s ease;
}

.business-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 22px 50px rgba(0, 0, 0, 0.12);
}

/* Icon circle */
.icon-circle {
  width: 45px;
  height: 45px;
  background: #e7f1ff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-circle i {
  color: #0d6efd;
  font-size: 20px;
}

/* Info */
.info-section p {
  font-size: 14px;
  margin-bottom: 0.7rem;
  display: flex;
  align-items: center;
}

.info-section i {
  margin-right: 6px;
  color: #6c757d;
}

/* Map */
.map-container {
  overflow: hidden;
  border-radius: 14px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
}

.map-container iframe {
  border: 0;
  transition: transform 0.3s ease;
}

.map-container:hover iframe {
  transform: scale(1.02);
}

/* Buttons */
.btn {
  border-radius: 12px;
}
</style>
<style>
.business-logo {
  width: 120px;
  height: 120px;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #0d6efd;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

.no-logo {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: #f1f3f5;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #aaa;
  margin: auto;
}
</style>
<style>
.attachments-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.file-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px;
  border-radius: 10px;
  background: #f8f9fa;
  text-decoration: none;
  color: #333;
  transition: 0.2s;
}

.file-item:hover {
  background: #e9ecef;
  transform: translateX(5px);
}

.file-item i {
  color: #0d6efd;
}
</style>


@endsection
