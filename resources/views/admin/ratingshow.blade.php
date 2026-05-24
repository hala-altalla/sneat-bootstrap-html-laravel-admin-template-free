@extends('layouts/contentNavbarLayout')

@section('title', 'Rating Details')

@section('content')

<div class="card">

  <!-- Header -->
  <h5 class="card-header text-center fw-bold" style="background:azure;">
    ⭐ {{__('fieldsName.ratingdetails')}}
  </h5>

  <div class="card-body">

    <!-- Order -->
    <div class="mb-3">
      <strong>{{__('fieldsName.orderid')}}:</strong>
      #{{ $rating->order_id }}
    </div>
    <!-- User -->
    <div class="mb-3">
      <strong>{{ __('fieldsName.customer') }}:</strong>
      {{ $rating->order->businessAccount->normalUser->user->name ?? '-' }}
    </div>
    <div class="mb-3">
      <strong>{{ __('fieldsName.businees-account-customer') }}:</strong>
      {{  app()->getLocale() == 'ar' ? $rating->order->businessAccount->business_name_ar : $rating->order->businessAccount->business_name_en}}
    </div>

    <!-- Service -->
    <div class="mb-3">
      <strong>{{__('fieldsName.service')}}:</strong>
      {{ app()->getLocale() == 'ar' ? $rating->order->service->title_ar :$rating->order->service->title_en }}
    </div>

    <!-- Rating -->
    <div class="mb-4">
      <strong>{{__('fieldsName.rating')}}:</strong>

      <div class="mt-2" style="font-size: 22px; color: gold;">

        @for ($i = 1; $i <= 5; $i++) @if ($i <=$rating->rating)
          ★
          @else
          ☆
          @endif
          @endfor

      </div>

      <small class="text-muted">
        ({{ $rating->rating }} / 5)
      </small>
    </div>

    <!-- Comment -->
    <div class="mb-3">
      <strong>{{ __('fieldsName.comment') }}:</strong>
      <div class="border rounded p-3 bg-light">
        {{ $rating->comment ?? 'No comment' }}
      </div>
    </div>



    <!-- Business -->
    <div class="mb-3">
      <strong>{{ __('fieldsName.businees-account-provider') }}:</strong>
      {{ app()->getLocale() == 'ar' ? $rating->order->service->businessAccount->business_name_ar : $rating->order->service->businessAccount->business_name_en }}
    </div>

    <!-- Back -->
    <div class="mt-4">
      <a href="{{ route('ratings.index') }}" class="btn btn-secondary">
        ⬅ {{__('fieldsName.back')}}
      </a>
    </div>

  </div>
</div>

@endsection