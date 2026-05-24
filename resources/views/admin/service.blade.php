@extends('layouts/contentNavbarLayout')

@section('title', 'Services')

@section('content')

<div class="container-xxl">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold d-flex align-items-center gap-2">
      <i class="bx bx-crown text-primary"></i>
      {{ __('fieldsName.services') }}
    </h3>
  </div>

  <!-- Search -->
  <div class="card p-3 mb-3 shadow-sm" style="border-radius: 12px;">
    <input type="text" id="searchInput" class="form-control" placeholder="{{ __('fieldsName.searchnameserviced') }}">
  </div>

  <!-- Table -->
  <div class="card shadow-sm" style="border-radius: 12px;">
    <div class="table-responsive">
      <table class="table align-middle mb-0" id="servicesTable">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>{{ __('fieldsName.service') }}</th>
            <th>{{ __('fieldsName.category') }}</th>
            <th>{{ __('fieldsName.businees-account-provider') }}</th>
            <th>{{ __('fieldsName.typeservice') }}</th>
            <th>{{ __('fieldsName.status') }}</th>
            <th class="text-center">{{ __('fieldsName.action') }}</th>
          </tr>
        </thead>

        <tbody>
          @foreach($services as $service)
          <tr>
            <td>{{ $loop->iteration }}</td>

            <!-- Service Name -->
            <td>
              {{ app()->getLocale() == 'ar' ? $service->title_ar : $service->title_en }}
            </td>

            <!-- Category -->
            <td>
              {{ $service->category?->getTranslation('name', app()->getLocale()) ?? '-' }}
            </td>

            <!-- Business Account -->
            <td>
              {{ app()->getLocale() == 'ar' ? $service->businessAccount->business_name_ar: $service->businessAccount->business_name_en }}
            </td>

            <!-- Type -->
            <td>
              @if($service->service_type=="sale")
              <span class="badge bg-info text-dark">
                <!-- {{ ucfirst($service->service_type) }} -->
                {{ __('fieldsName.sale') }}
              </span>
              @endif
              @if($service->service_type=="rent")
              <span class="badge bg-info text-dark">
                <!-- {{ ucfirst($service->service_type) }} -->
                {{ __('fieldsName.rent') }}
              </span>
              @endif
            </td>

            <!-- Status -->
            <td>
              @if($service->status == 'pending')
              <span class="badge bg-warning text-dark">{{ __('fieldsName.pending') }}</span>
              @elseif($service->status == 'accepted')
              <span class="badge bg-success">{{ __('fieldsName.accepted') }}</span>
              @else
              <span class="badge bg-danger">{{ __('fieldsName.rejected') }}</span>
              @endif
            </td>

            <!-- Actions -->
            <td class="text-center">
              <div class="d-flex justify-content-center gap-1 flex-wrap">

                <!-- View -->
                <a href="{{ route('service' , $service->id) }}"
                  class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                  <i class="bx bx-show"></i> {{ __('fieldsName.view') }}
                </a>
                @if($service->status == 'pending')
                <!-- Accept -->
                @can('accept-service')
                <form action="{{ route('accept.service', $service->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-success d-flex align-items-center gap-1"
                    onclick="return confirm('{{ __('messages.accept_confirm_service') ?? 'Accept this service?' }}')">
                    <i class="bx bx-check"></i>
                  </button>
                </form>
                @endcan

                <!-- Reject -->
                @can('reject-service')
                <form action="{{ route('reject.service', $service->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1"
                    onclick="return confirm('{{ __('messages.reject_confirm_service') ?? 'Reject this service?' }}')">
                    <i class="bx bx-x"></i>
                  </button>
                </form>
                @endcan

              </div>
              @else

              <!--  <form action="{{ route('delete.service', $service->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')

                <button onclick="deleteService({{ $service->id }})">🗑️</button>


              </form> -->
              @can(['accept-businessAccount','reject-businessAccount'])
              <button onclick="deleteService({{ $service->id }})" class="btn btn-sm btn-outline-danger">
                🗑️
              </button>
              @endcan
            </td>
            @endif
          </tr>
          @endforeach
        </tbody>

      </table>
      <div class="mt-3 d-flex justify-content-center">
        {{ $services->links('pagination::simple-bootstrap-5') }}
      </div>
    </div>
  </div>

</div>

<!-- Search Script -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
  let value = this.value.toLowerCase();
  let rows = document.querySelectorAll('#servicesTable tbody tr');

  rows.forEach(row => {
    let serviceName = row.children[1].innerText.toLowerCase();

    if (serviceName.includes(value)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
</script>
<script>
function deleteService(id) {

  if (!confirm("{{ __('messages.delete_service_confirm') }}")) return;

  fetch(`/check-service/${id}`)
    .then(res => res.json())
    .then(data => {

      if (data.hasPending) {

        if (!confirm("{{ __('messages.pending_orders_warning') }}")) {
          alert("{{ __('messages.delete_cancelled') }}");
          return;
        }
      }

      fetch(`/delete-service/${id}`, {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            _method: "DELETE"
          })
        })
        .then(() => location.reload());

    });
}
</script>
<style>
.pagination {
  justify-content: center;
  gap: 8px;
}

.pagination .page-link {
  border: none;
  border-radius: 50%;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #0d6efd;
  background: #f1f5ff;
  transition: 0.3s;
}

.pagination .page-link:hover {
  background: #0d6efd;
  color: white;
  transform: scale(1.1);
}

.pagination .page-item.active .page-link {
  background: #0d6efd;
  color: white;
  font-weight: bold;
}

.pagination .page-item.disabled .page-link {
  opacity: 0.4;
}
</style>

@endsection