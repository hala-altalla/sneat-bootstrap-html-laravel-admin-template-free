@extends('layouts/contentNavbarLayout')

@section('title', 'Manage Cities')

@section('content')
@if(session('error'))
<div class="msg-box error">
  {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="msg-box success">
  {{ session('success') }}
</div>
@endif
<div class="container-xxl mt-4">

  <!--  Title -->
  <h3 class="city-title mb-4 text-center">
    <i class="bx bx-buildings me-2"></i>
    {{ __('fieldsName.managecity') }}
  </h3>

  <!--  Add City -->
  <div class="card mb-4">
    <h5 class="card-header fw-bold text-center"> {{ __('fieldsName.addcity') }}</h5>

    <div class="card-body">
      <form action="" method="POST">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">City Name (EN)</label>
            <input type="text" name="name[en]" class="form-control" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">اسم المدينة (AR)</label>
            <input type="text" name="name[ar]" class="form-control" required>
          </div>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary px-4">
            <i class="bx bx-plus"></i>
            {{ __('fieldsName.add_city') }}
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- 📋 Cities Table -->
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">

      <h5 class="fw-bold mb-0">{{ __('fieldsName.citieslist') }}</h5>

      <!--  Search -->
      <div class="search-box d-flex">
        <input type="text" id="searchInput" class="form-control me-2" placeholder=" {{ __('fieldsName.searchcity') }}">
        <button class="btn btn-primary" onclick="searchTable()">
          <i class="bx bx-search"></i>
        </button>
      </div>

    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle text-center mb-0" id="citiesTable">
        <thead style="background: #f1f5f9;">
          <tr>
            <th>#</th>
            <th>{{ __('fieldsName.enname') }}</th>
            <th> {{ __('fieldsName.arname') }}</th>
            <th>{{ __('fieldsName.action') }}</th>
          </tr>
        </thead>

        <tbody>
          @forelse($cities as $index => $city)
          <tr class="table-row">

            <td>{{ $index + 1 }}</td>

            <td>{{ $city->name['en'] }}</td>

            <td>{{ $city->name['ar'] }}</td>

            <td>
              <a href="{{ route('page.editcity', $city->id) }}" class="btn-edit-fancy">
                <i class="bx bx-edit-alt"></i>
                {{ __('fieldsName.edit') }}
              </a>
              <br>
              <br>

              <form action="{{ route('delete.city' , $city->id) }}" method="POST"
                onsubmit="return confirm('{{ __('messages.deletecitymessage') }}');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-sm btn-danger" style="background-color:#4dabf7;">
                  <i class="bx bx-trash"></i> {{ __('fieldsName.delete') }}
                </button>
              </form>
            </td>

          </tr>
          @empty
          <tr>
            <td colspan="4">{{ __('fieldsName.nocities') }}</td>
          </tr>
          @endforelse
        </tbody>

      </table>
    </div>
  </div>

</div>

<style>
.city-title {
  font-weight: 700;
  font-size: 28px;
  color: #333;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

/* 🔍 Search Box */
.search-box input {
  border-radius: 10px;
}

.search-box button {
  border-radius: 10px;
}

/* ✨ Hover */
.table-row:hover {
  background-color: #f8fafc;
  transform: scale(1.01);
  transition: 0.2s;
}
</style>

<!-- 🔥 Search Script -->
<script>
function searchTable() {
  let input = document.getElementById("searchInput").value.toLowerCase();
  let rows = document.querySelectorAll("#citiesTable tbody tr");

  rows.forEach(row => {
    let text = row.innerText.toLowerCase();
    row.style.display = text.includes(input) ? "" : "none";
  });
}
</script>
<style>
.btn-edit-fancy {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 6px 14px;
  font-size: 13px;
  font-weight: 600;
  color: #0d6efd;
  border-radius: 999px;
  background: rgba(13, 110, 253, 0.1);
  border: 1px solid rgba(13, 110, 253, 0.3);
  backdrop-filter: blur(6px);
  transition: all 0.3s ease;
  text-decoration: none;
}

/* 🔥 Hover effect */
.btn-edit-fancy:hover {
  background: linear-gradient(135deg, #0d6efd, #4dabf7);
  color: #fff;
  transform: translateY(-2px) scale(1.05);
  box-shadow: 0 6px 18px rgba(13, 110, 253, 0.4);
}

/* ✨ أيقونة تتحرك */
.btn-edit-fancy i {
  transition: transform 0.3s;
}

.btn-edit-fancy:hover i {
  transform: rotate(-10deg) scale(1.2);
}
</style>
<style>
.msg-box {
  padding: 12px 16px;
  margin-bottom: 15px;
  border-radius: 8px;
  font-weight: 500;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.msg-box.success {
  background-color: #e6fffa;
  color: #065f46;
  border-left: 5px solid #10b981;
}

.msg-box.error {
  background-color: #fee2e2;
  color: #7f1d1d;
  border-left: 5px solid #ef4444;
}

.alert {
  animation: slideDown 0.4s ease;
}

@keyframes slideDown {
  from {
    transform: translateY(-10px);
    opacity: 0;
  }

  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.msg-box {
  transition: all 0.4s ease;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {

  const messages = document.querySelectorAll('.msg-box');

  messages.forEach((msg) => {

    setTimeout(() => {

      msg.style.transition = "all 0.5s ease";
      msg.style.opacity = "0";
      msg.style.transform = "translateY(-10px)";

      setTimeout(() => {
        msg.remove();
      }, 500);

    }, 10000); // 10 ثواني

  });

});
</script>

@endsection