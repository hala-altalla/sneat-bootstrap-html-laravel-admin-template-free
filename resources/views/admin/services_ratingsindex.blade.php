@extends('layouts/contentNavbarLayout')

@section('title', 'Services Ratings')

@section('content')

<div class="card">

  <h5 class="card-header text-center">⭐ {{__('fieldsName.servicesRatings')}} </h5>

  <div class="card-body">

    <!-- 🔍 Filter -->
    <form method="GET" class="mb-4">

      <select name="business_account_id" class="form-control" onchange="this.form.submit()">

        <option value="">{{ __('fieldsName.business_account') }}</option>

        @foreach($businessAccounts as $business)
        <option value="{{ $business->id }}" {{ request('business_account_id') == $business->id ? 'selected' : '' }}>
          {{app()->getLocale() == 'ar' ?  $business->business_name_ar :$business->business_name_en }}
        </option>
        @endforeach

      </select>

    </form>

    <!-- 📊 Table -->
    <table class="table table-bordered text-center">

      <thead>
        <tr>
          <th>{{__('fieldsName.service')}}</th>
          <th>{{ __('fieldsName.businees-account-provider') }}</th>
          <th>{{ __('fieldsName.avgratings') }}</th>
          <th>{{ __('fieldsName.details') }}</th>
        </tr>
      </thead>

      <tbody>

        @foreach($services as $service)

        @php
        $ratings = $service->orders->pluck('rating.rating')->filter();
        $avg = $ratings->avg();
        @endphp

        <tr>

          <td>{{app()->getLocale() == 'ar' ? $service->title_ar : $service->title_en }}</td>

          <td>
            {{ app()->getLocale() == 'ar' ? $service->businessAccount->business_name_ar : $service->businessAccount->business_name_en}}
          </td>

          <td>
            ⭐ {{ number_format($avg ?? 0, 1) }}
          </td>

          <td>
            <a href="{{ route('services.ratings.show', $service->id) }}" class="btn btn-primary btn-sm">
              {{ __('fieldsName.viewchart') }}
            </a>
          </td>

        </tr>

        @endforeach

      </tbody>

    </table>

  </div>
</div>


@endsection
