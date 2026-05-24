@extends('layouts/contentNavbarLayout')

@section('title', 'Orders')

@section('content')
<div class="container-xxl mt-4">

  <h3 class="mb-4 fw-bold d-flex align-items-center gap-2">
    <i class="bx bx-cart text-primary"></i>
    {{ __('fieldsName.orders') }}
  </h3>

  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>{{__('fieldsName.service')}}</th>
          <th>{{__('fieldsName.customer')}}</th>
          <th>{{__('fieldsName.businees-account-customer')}}</th>

          <th>{{__('fieldsName.quantity')}}</th>
          <th>{{__('fieldsName.status')}}</th>
          <th>{{__('fieldsName.neededat')}}</th>
          <th>{{__('fieldsName.businees-account-provider')}}</th>
        </tr>
      </thead>

      <tbody>
        @foreach($orders as $index => $order)
        <tr>
          <td>{{ $index + 1 }}</td>

          <td>
            {{app()->getLocale() == 'ar' ?  $order->service->title_ar : $order->service->title_en }}
          </td>

          <td>
            {{ $order->businessAccount->normalUser->user->name ?? '-' }}
          </td>
          <td>
            {{app()->getLocale() == 'ar' ? $order->businessAccount->business_name_ar: $order->businessAccount->business_name_en}}
          </td>

          <td>
            {{ $order->quantity }}
          </td>

          <td>
            @if($order->status == 'pending')
            <span class="badge bg-warning text-dark">{{ __('fieldsName.pending') }}</span>
            @elseif($order->status == 'accepted')
            <span class="badge bg-success">{{ __('fieldsName.accepted') }}</span>
            @else
            <span class="badge bg-danger">{{ __('fieldsName.rejected') }}</span>
            @endif
          </td>

          <td>
            {{ $order->needed_at ?? '-' }}
          </td>

          <td>
            {{app()->getLocale() == 'ar' ? $order->service->businessaccount->business_name_ar : $order->service->businessaccount->business_name_en}}
          </td>

        </tr>
        @endforeach
      </tbody>

    </table>
  </div>
</div>

<style>
.table th,
.table td {
  vertical-align: middle;
}

.badge {
  font-size: 0.85rem;
}

.btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}
</style>

@endsection
