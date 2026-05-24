@extends('layouts/contentNavbarLayout')

@section('title', 'Activity Types')

@section('content')

<div class="container-xxl mt-4">
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
  <!--Add Activity Type -->
  <div class="card mb-4">
    <h5 class="card-header fw-bold text-center">
      <i class="bx bx-plus-circle"></i> {{ __('messages.add_activity_type') }}
    </h5>

    <div class="card-body">
      <form method="POST" action="{{ route('activitytype.store') }}">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('messages.name-EN') }}</label>
            <input type="text" name="name[en]" class="form-control" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">{{ __('messages.name-AR') }}</label>
            <input type="text" name="name[ar]" class="form-control" required>
          </div>
        </div>

        <button class="btn btn-primary">
          <i class="bx bx-save"></i> {{ __('messages.Add') }}
        </button>
      </form>
    </div>
  </div>

  <!--  Search -->
  <div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="{{ __('messages.sherchbyname') }}">
  </div>

  <!--Table -->
  <div class="card">
    <h5 class="card-header fw-bold text-center">
      <i class="bx bx-list-ul"></i> {{ __('messages.activity_types_list') }}
    </h5>

    <div class="table-responsive text-nowrap">
      <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.name') }}</th>
            <th>{{ __('messages.action') }}</th>
          </tr>
        </thead>

        <tbody id="tableBody">
          @foreach($activityTypes as $index => $type)
          <tr>
            <td>{{ $index + 1 }}</td>

            <td class="name">
              {{ $type->getTranslation('name','ar') }}
            </td>

            <td class="nameen">
              {{ $type->getTranslation('name','en') }}
            </td>

            <td>
              <!-- Delete -->

              <form action="{{ route('activitytype.delete', $type->id) }}" method="POST" style="display:inline-block;"
                onsubmit="return confirm({{ json_encode(__('messages.delete_confirmactivity')) }});">
                @csrf
                @method('DELETE')

                <button class="btn btn-sm btn-outline-danger">
                  <i class="bx bx-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>

      </table>

    </div>
  </div>

</div>

<!--  Search Script -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
  let value = this.value.toLowerCase();
  let rows = document.querySelectorAll('#tableBody tr');

  rows.forEach(row => {
    let name = row.querySelector('.name').innerText.toLowerCase();
    let name2 = row.querySelector('.nameen').innerText.toLowerCase();

    if (name.includes(value) || name2.includes(value)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
</script>
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