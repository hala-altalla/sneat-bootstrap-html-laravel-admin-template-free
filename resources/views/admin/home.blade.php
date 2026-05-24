@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')
<div class="container-xxl py-4">

  <!-- ===== Stats Cards ===== -->
  <div class="row g-3 mb-4">

    <!-- Users -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-user fs-2 text-primary"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.users') }}</h6>
        <p class="mb-0">{{ $normalusers->count()}}</p>
      </div>
    </div>

    <!-- Admins -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-shield-quarter fs-2 text-danger"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.admins') }}</h6>
        <p class="mb-0">{{ $admins->count() }}</p>
      </div>
    </div>

    <!-- Business Accounts -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-briefcase fs-2 text-success"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.business_account') }}</h6>
        <p class="mb-0">{{ $accounts->count() }}</p>
      </div>
    </div>

    <!-- Categories -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-category fs-2 text-warning"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.categories') }}</h6>
        <p class="mb-0">{{ $categories->count() }}</p>
      </div>
    </div>

    <!-- Services -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-cog fs-2 text-success"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.services') }}</h6>
        <p class="mb-0">{{ $services->count() }}</p>
      </div>
    </div>

    <!-- Orders -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-cart fs-2 text-info"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.orders') }}</h6>
        <p class="mb-0">{{ $orders->count() }}</p>
      </div>
    </div>

    <!-- Ads -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-megaphone fs-2 text-primary"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.ads') }}</h6>
        <p class="mb-0">{{ $sliders->count() }}</p>
      </div>
    </div>

    <!-- Reports -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-error-circle fs-2 text-danger"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.reports') }}</h6>
        <p class="mb-0">{{ $reports->count() }}</p>
      </div>
    </div>

    <!-- Cities -->
    <div class="col-12 col-sm-6 col-lg-2">
      <div class="card shadow-sm rounded-3 p-3 text-center">
        <div class="mb-2">
          <i class="bx bx-map fs-2 text-secondary"></i>
        </div>
        <h6 class="mb-1 fw-bold">{{ __('fieldsName.cities') }}</h6>
        <p class="mb-0">{{ $cities->count() }}</p>
      </div>
    </div>

  </div>
  <!-- ===== Admins Carousel ===== -->
  <div class="card mt-4">

    <h5 class="card-header text-center fw-bold" style="background:azure;">
      👑 {{ __('fieldsName.admins') }}
    </h5>

    <div class="card-body">

      @php
      $adminsFiltered = $admins->filter(function($admin){
      return $admin->user->type == 'admin';
      })->values();
      @endphp

      @if($adminsFiltered->count())

      <div id="adminsCarousel" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">

          @foreach($adminsFiltered as $key => $admin)
          <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

            <div class="d-flex justify-content-center">

              <div class="card shadow-sm p-3" style="width: 350px; border-radius:16px;">

                <!-- Header -->
                <div class="d-flex align-items-center mb-3">

                  <!-- Avatar -->
                  <div style="width:50px; height:50px; border-radius:50%; background:#eee;
                            display:flex; align-items:center; justify-content:center;
                            font-weight:bold; font-size:18px;">
                    {{ strtoupper(substr($admin->user->name,0,1)) }}
                  </div>

                  <div class="ms-3">
                    <h6 class="mb-0 fw-bold">
                      {{ $admin->user->name }}
                    </h6>
                    <small class="text-muted">
                      {{ $admin->user->type }}
                    </small>
                  </div>

                </div>

                <!-- Email -->
                <p class="mb-2">
                  <strong>Email:</strong> {{ $admin->email }}
                </p>

                <!-- Created -->
                <p class="mb-2">
                  <strong>Created:</strong>
                  {{ optional($admin->created_at)->format('Y-m-d') }}
                </p>

                <!-- Buttons -->
                <div class="d-flex justify-content-between mt-3">

                  <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-outline-primary">
                    ✏ {{ __('messages.edit') }}
                  </a>

                  <form action="{{ route('admin.delete', $admin) }}" method="POST"
                    onsubmit="return confirm('{{ __('messages.deleteadminmessage') }}');">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-sm btn-outline-danger">
                      🗑 {{ __('messages.delete') }}
                    </button>
                  </form>

                </div>

              </div>

            </div>

          </div>
          @endforeach

        </div>

        <!-- سهم يسار -->
        <button class="carousel-control-prev" type="button" data-bs-target="#adminsCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
        </button>

        <!-- سهم يمين -->
        <button class="carousel-control-next" type="button" data-bs-target="#adminsCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
        </button>

      </div>

      @else
      <p class="text-center text-muted">No admins found</p>
      @endif

    </div>

  </div>
  <!-- ===== Sliders Section ===== -->
  <div class="card mt-4">

    <h5 class="card-header text-center fw-bold" style="background:azure;">
      🎯 {{ __('fieldsName.sliders') }}
    </h5>

    <div class="card-body">

      @if($sliders->count())

      <div id="slidersCarousel" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">

          @foreach($sliders as $key => $slider)
          <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

            <div class="d-flex justify-content-center">
              <div class="card shadow-sm p-3" style="width: 500px; border-radius:16px;">

                <!-- Image -->
                <img src="{{ $slider->imageUrl() }}" class="img-fluid rounded mb-3"
                  style="height:250px; object-fit:cover;">

                <!-- Title -->
                <h5 class="fw-bold text-center">
                  {{ $slider->getTranslation('title', app()->getLocale()) }}
                </h5>

                <!-- Description -->
                <p class="text-muted text-center">
                  {{ $slider->getTranslation('description', app()->getLocale()) }}
                </p>

                <!-- Info -->
                <div class="d-flex justify-content-between">

                  <span>Order: {{ $slider->order }}</span>

                  @if($slider->is_active)
                  <span class="badge bg-success">Active</span>
                  @else
                  <span class="badge bg-danger">Inactive</span>
                  @endif

                </div>

              </div>
            </div>

          </div>
          @endforeach

        </div>

        <!--  سهم يسار -->
        <button class="carousel-control-prev" type="button" data-bs-target="#slidersCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
        </button>

        <!--  سهم يمين -->
        <button class="carousel-control-next" type="button" data-bs-target="#slidersCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
        </button>

      </div>

      @else
      <p class="text-center text-muted">No sliders available</p>
      @endif

    </div>

  </div>
  <!-- ===== High Ratings Carousel ===== -->
  <div class="card mt-4">

    <h5 class="card-header text-center fw-bold" style="background:azure;">
      ⭐ {{ __('fieldsName.toprating') }}
    </h5>

    <div class="card-body">

      @if($highRatings->count())

      <div id="ratingsCarousel" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">

          @foreach($highRatings as $key => $rating)
          <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

            <div class="d-flex justify-content-center">

              <div class="card shadow-sm p-3" style="width: 350px; border-radius:16px;">

                <!-- Service -->
                <h6 class="fw-bold text-center" style="color: cadetblue;">
                  {{app()->getlocale() == 'ar'  ? $rating->order->service->title_ar :  $rating->order->service->title_en }}
                </h6>
                <!-- Provider -->
                <p class="text-center text-muted small">
                  {{ app()->getLocale() == 'ar'
                    ? $rating->order->service->businessAccount->business_name_ar
                    : $rating->order->service->businessAccount->business_name_en }}
                </p>
                <!-- Stars -->
                <div class="text-center mb-2" style="font-size:22px; color:gold;">
                  @for($i=1; $i<=5; $i++) {!! $i <=$rating->rating ? '★' : '☆' !!}
                    @endfor
                </div>

                <!-- Comment -->
                <p class="text-muted text-center small">
                  {{ Str::limit($rating->comment, 100) }}
                </p>

                <!-- User -->
                <p class="text-center mb-1">
                  👤 {{ $rating->order->businessAccount->normalUser->user->name ?? '-' }}
                </p>



              </div>

            </div>

          </div>
          @endforeach

        </div>

        <!-- LEFT -->
        <button class="carousel-control-prev" type="button" data-bs-target="#ratingsCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
        </button>

        <!-- RIGHT -->
        <button class="carousel-control-next" type="button" data-bs-target="#ratingsCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
        </button>

      </div>

      @else
      <p class="text-center text-muted">{{__('fieldsName.noreport')}}</p>
      @endif

    </div>
  </div>
  <!-- ===== Reports Carousel ===== -->
  @can("manage-Reports")
  <div class="card mt-4">

    <h5 class="card-header text-center fw-bold" style="background:azure;">
      🚨 {{ __('fieldsName.pendingreport') }}
    </h5>

    <div class="card-body">

      @if($reportsLatest->count())

      <div id="reportsCarousel" class="carousel slide" data-bs-ride="carousel">

        <div class="carousel-inner">

          @foreach($reportsLatest as $key => $report)
          <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">

            <div class="d-flex justify-content-center">

              <div class="card shadow-sm p-3" style="width: 380px; border-radius:16px;">

                <!-- 🔥 Status Badge -->
                <div class="text-center mb-2">
                  <span class="badge bg-warning">{{ __('fieldsName.pendingreview') }}</span>
                </div>

                <!-- Order -->
                <h6 class="fw-bold text-center" style="color: cadetblue;">
                  #{{ $report->order_id }} -
                  {{ app()->getLocale() == 'ar' ? $report->order->service->title_ar : $report->order->service->title_en }}
                </h6>
                <!-- Provider -->
                <p class="text-center text-muted small">
                  🏢
                  {{app()->getLocale() == 'ar' ? $report->order->service->businessAccount->business_name_ar :$report->order->service->businessAccount->business_name_en }}
                </p>
                <!-- Reason -->
                <div class="p-2 bg-light rounded text-center mb-2">
                  {{ Str::limit($report->reason, 100) }}
                </div>

                <!-- Reporter -->
                <p class="text-center mb-1">

                  👤 {{ $report->businessAccount->normalUser->user->name ?? '-' }}
                  <br>
                  {{ app()->getLocale() == 'ar' ? $report->businessAccount->business_name_ar :  $report->businessAccount->business_name_en}}
                </p>



              </div>

            </div>

          </div>
          @endforeach

        </div>

        <!-- LEFT -->
        <button class="carousel-control-prev" type="button" data-bs-target="#reportsCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
        </button>

        <!-- RIGHT -->
        <button class="carousel-control-next" type="button" data-bs-target="#reportsCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
        </button>

      </div>

      @else
      <p class="text-center text-muted">{{ __('fieldsName.noreport') }}</p>
      @endif

    </div>
  </div>

  @endcan
  @endsection