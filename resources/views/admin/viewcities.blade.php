@extends('layouts/contentNavbarLayout')

@section('title', 'Cities')

@section('content')
<div class="container-xxl mt-4">

  <!--  Title -->
  <h3 class="city-title mb-4 text-center">
    <i class="bx bx-map-alt me-2"></i>
    {{ __('fieldsName.syrianCities') }}

    <img src="https://flagcdn.com/w40/sy.png" alt="Syria Flag" class="flag-icon">
  </h3>
  </h3>

  @php
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
  @endphp

  <!-- Cities -->
  <div class="d-flex flex-wrap gap-3">
    @foreach($cities as $index => $city)
    <a href="{{ route('business.cities' , $city->id) }}" class="city-card p-3 flex-grow-1 text-decoration-none"
      style="min-width: 200px; max-width: 250px; background: {{ $colors[$index % count($colors)] }}; color:inherit;">

      <div class="d-flex flex-column align-items-center justify-content-center text-center">

        <!-- Icon -->
        <div class="city-icon mb-2">
          <i class="bx bx-map"></i>
        </div>

        <!-- Names -->
        <h5 class="mb-1 fw-bold">{{ $city->name['en'] }}</h5>
        <span class="text-muted">{{ $city->name['ar'] }}</span>

      </div>
    </a>
    @endforeach
  </div>

</div>

<style>
/* Title */
.city-title {
  font-weight: 700;
  font-size: 28px;
  color: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  animation: fadeInDown 0.6s ease;
}

.city-title i {
  color: #0d6efd;
  font-size: 30px;
  animation: bounce 1.5s infinite;
}

/* Cards */
.city-card {
  border-radius: 16px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: transform 0.2s, box-shadow 0.2s;
  cursor: pointer;
  padding: 1rem;
  color: #000;
}

.city-card:hover {
  transform: translateY(-6px) scale(1.02);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

/*  Icon */
.city-icon {
  background: rgba(255, 255, 255, 0.6);
  border-radius: 50%;
  padding: 10px;
}

.city-icon i {
  color: #0d6efd;
  font-size: 26px;
}

/* 🎞 Animations */
@keyframes fadeInDown {
  from {
    opacity: 0;
    transform: translateY(-15px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes bounce {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-5px);
  }
}

flag-icon {
  width: 28px;
  height: 20px;
  border-radius: 3px;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
  animation: wave 2s infinite ease-in-out;
}

/* حركة خفيفة للعلم  */
@keyframes wave {

  0%,
  100% {
    transform: rotate(0deg);
  }


  50% {
    transform: rotate(3deg);
  }
}
</style>
@endsection
