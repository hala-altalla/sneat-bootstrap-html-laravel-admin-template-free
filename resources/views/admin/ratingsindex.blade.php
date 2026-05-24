@extends('layouts/contentNavbarLayout')

@section('content')

<div class="card">
  <h5 class="card-header">⭐ {{ __('fieldsName.ratings') }}</h5>

  <div class="card-body">

    <table class="table">
      <thead>
        <tr>
          <th>{{ __('fieldsName.orderid') }}</th>
          <th>{{ __('fieldsName.customer') }}</th>
          <th>{{ __('fieldsName.businees-account-customer') }}</th>
          <th>{{ __('fieldsName.service') }}</th>
          <th>{{ __('fieldsName.businees-account-provider') }} </th>
          <th>{{ __('fieldsName.service-provider') }}</th>
          <th>{{ __('fieldsName.rating') }}</th>
          <th>{{ __('fieldsName.details') }}</th>
        </tr>
      </thead>

      <tbody>
        @foreach($ratings as $rating)
        <tr>
          <td>{{ $rating->order_id }}</td>
          <td>{{ $rating->order->businessAccount->normaluser->user->name }}</td>
          <td>
            {{app()->getLocale() == 'ar' ? $rating->businessAccount->business_name_ar :  $rating->businessAccount->business_name_en }}
          </td>

          <td>{{app()->getLocale() == 'ar' ?  $rating->order->service->title_ar : $rating->order->service->title_en  }}
          </td>
          <td>
            {{ app()->getLocale() == 'ar' ? $rating->order->service->businessAccount->business_name_ar : $rating->order->service->businessAccount->business_name_en }}
          </td>
          <td>{{$rating->order->service->businessAccount->normaluser->user->name ?? '-' }}</td>

          <td>⭐ {{ $rating->rating }}</td>

          <td>
            <a href="{{ route('ratings.show' , $rating->id) }}" class="btn btn-sm btn-primary">
              {{__('fieldsName.view')}}
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>

    </table>

  </div>
</div>


@endsection
