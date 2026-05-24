@extends('layouts/contentNavbarLayout')

@section('title', 'Business Accounts')

@section('content')
<div class="container-xxl mt-4">

  <!--  Title -->
  <h3 class="city-title mb-4 text-center">
    <i class="bx bx-store-alt me-2"></i>
    {{ __('fieldsName.businessaccount') }} {{ app()->getLocale() == 'ar' ? $city->name['ar'] : $city->name['en'] }}
  </h3>

  @php
  // نفس الألوان للمدينة نفسها
  $colors = [
  'linear-gradient(135deg, #e3f2fd, #bbdefb)',
  'linear-gradient(135deg, #e8f5e9, #c8e6c9)',
  'linear-gradient(135deg, #fff3e0, #ffe0b2)',
  'linear-gradient(135deg, #fce4ec, #f8bbd0)',
  'linear-gradient(135deg, #ede7f6, #d1c4e9)',
  'linear-gradient(135deg, #e0f2f1, #b2dfdb)',
  'linear-gradient(135deg, #f1f8e9, #dcedc8)',
  'linear-gradient(135deg, #fff8e1, #ffecb3)',
  'linear-gradient(135deg, #e1f5fe, #b3e5fc)',
  'linear-gradient(135deg, #f3e5f5, #e1bee7)',
  ];
  $color = $colors[$city->id % count($colors)];
  @endphp

  <div class="d-flex flex-wrap gap-3">
    @foreach($businessAccounts as $account)
    <div class="business-card p-3 flex-grow-1" style="min-width: 250px; max-width: 300px; background: {{ $color }};">

      <div class="d-flex flex-column align-items-center justify-content-center text-center">

        <!-- Header -->
        <div class="mb-2">
          <i class="bx bx-building-house fs-2 text-primary mb-1"></i>
          <h5 class="fw-bold mb-0">
            {{ app()->getLocale() == 'ar' ? $account->business_name_ar : $account->business_name_en }}
          </h5>
          <small class="text-muted">{{ __('fieldsName.license') }}: {{ $account->license_number }}</small>
        </div>

        <!-- Info -->
        <p class="text-muted mb-1">
          {{ __('fieldsName.activity') }}::
          {{ $account->activityType->name  }}
        </p>
        <p class="text-muted mb-1">
          {{ __('fieldsName.status') }}: <span class="badge bg-warning text-dark">{{ ucfirst($account->status) }}</span>
        </p>

        <!-- View Button -->
        <a href="{{ route('business.view', $account->id) }}" class="btn btn-outline-primary mt-2 w-75">
          <i class="bx bx-show me-1"></i> {{ __('fieldsName.view') }}
        </a>

      </div>
    </div>
    @endforeach
  </div>

</div>

<style>
.business-card {
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
  padding: 1rem;
}

.business-card:hover {
  transform: translateY(-6px) scale(1.02);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.business-card i {
  margin-bottom: 4px;
}

.badge {
  font-size: 0.85rem;
}
</style>
@endsection