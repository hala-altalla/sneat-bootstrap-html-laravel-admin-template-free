@extends('layouts/contentNavbarLayout')

@section('title', 'Rating Trend')

@section('content')
<div class="mt-4 text-center">

  <h5>⭐ {{ __('fieldsName.avgratings') }}
  </h5>

  <div class="mt-4 d-flex justify-content-center">

    <div class="card shadow-sm p-4 text-center" style="width: 320px; border-radius: 18px;">

      <!-- Title -->
      <div class="text-muted mb-2">
        {{ __('fieldsName.avgratings') }}
      </div>

      <!-- Big Number -->
      <div style="font-size: 40px; font-weight: bold; color: #f5b301;">
        {{ number_format($average ?? 0, 1) }}
      </div>

      <!-- Stars -->
      <div style="font-size: 22px; color: gold; margin-bottom: 10px;">
        @for ($i = 1; $i <= 5; $i++) @if ($i <=round($average)) ★ @else ☆ @endif @endfor </div>

          <!-- Progress Bar -->
          <div class="progress" style="height: 10px; border-radius: 10px;">
            <div class="progress-bar" role="progressbar" style="width: {{ ($average / 5) * 100 }}%;
                  background: linear-gradient(90deg, #f5b301, #ffcc00);">
            </div>
          </div>

          <small class="text-muted mt-2 d-block">
            {{ __('fieldsName.basedratings') }}
          </small>

      </div>

    </div>
    <br>
    <br>
    <div class="card">

      <h5 class="card-header text-center">
        📈 {{ __('fieldsName.ratingtrend') }} -
        {{ app()->getLocale() == 'ar' ? $service->title_ar :$service->title_en }}
      </h5>

      <div class="card-body">

        <canvas id="ratingChart"></canvas>

      </div>

    </div>

    @endsection

    @section('page-script')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('ratingChart');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: @json($labels),
        datasets: [{
          label: 'Average Rating',
          data: @json($data),
          borderColor: '#4e73df',
          borderWidth: 2,
          tension: 0.4,
          fill: false
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            min: 0,
            max: 5
          }
        }
      }
    });
    </script>

    @endsection
