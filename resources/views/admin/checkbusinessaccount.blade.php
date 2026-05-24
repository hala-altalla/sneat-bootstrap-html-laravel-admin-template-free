@extends('layouts/contentNavbarLayout')

@section('title', 'Business Accounts Pending')

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
  <h3 class="mb-4 fw-bold d-flex align-items-center gap-2">
    <i class="bx bx-store-alt text-primary"></i>
    {{ __('messages.businessaccounts') }}
  </h3>

  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>{{ __('messages.businessnamear') }}</th>
          <th>{{ __('messages.businessnameen') }}</th>
          <th>{{ __('messages.licensenumber') }}</th>
          <th>{{ __('messages.status') }}</th>
          <th>{{ __('messages.action') }}</th>
          <th>{{ __('fieldsName.Active/INActive') }}</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($accounts as $index => $account)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $account->business_name_ar }}</td>
          <td>{{ $account->business_name_en }}</td>
          <td>{{ $account->license_number }}</td>
          <td>
            @if($account->status == 'pending')
            <span class="badge bg-warning text-dark">{{ __('fieldsName.pending') }}</span>
            @elseif($account->status == 'accepted')
            <span class="badge bg-success">{{ __('fieldsName.accepted') }}</span>
            @else
            <span class="badge bg-danger">{{ __('fieldsName.rejected') }}</span>
            @endif

          </td>

          @if($account->status=='pending' )

          <td>
            <div class="d-flex gap-2">
              <a href="{{ route('business.view', $account->id) }}" class="btn btn-sm btn-outline-primary">
                {{ __('messages.view') }}
              </a>
              <br>

              <!-- Accept -->
              @can('accept-businessAccount')
              <form action="{{ route('accept' , $account->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">{{ __('messages.accept') }}</button>
              </form>
              @endcan
              <!-- Reject -->

              @can('reject-businessAccount')
              <form action="{{ route('reject' , $account->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">{{ __('messages.reject') }}</button>
              </form>
              @endcan
            </div>
          </td>
          @else

          <td>
            <a href="{{ route('business.view', $account->id) }}" class="btn btn-sm btn-outline-primary">
              {{ __('messages.view') }}
            </a>
            <br>
            <!-- Actions Bottom -->
            <br>
            @can(['reject-businessAccount','accept-businessAccount'])
            <form action="{{ route('delete.businessaccount', $account->id) }}" method="POST"
              style="display: inline-block;" onsubmit="return confirm('{{ __('messages.deletebusinessacc') }}');">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center"
                style="padding: .375rem .75rem; border-radius: .25rem;">
                🗑
              </button>
            </form>
            @endcan

          </td>
          @endif
          <td>
            @if($account->status=='accepted')
            <form action="{{ route('toggle.business.account', $account->id) }}" method="POST" class="d-inline">
              @csrf

              <button type="submit" class="status-toggle {{ $account->is_active ? 'active' : '' }}"
                title="Toggle Status">

                <span class="circle"></span>

              </button>
            </form>
            @else
            <span>_</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="mt-3 d-flex justify-content-center">
      {{ $accounts->links('pagination::simple-bootstrap-5') }}
    </div>
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
<style>
.status-toggle {
  width: 52px;
  height: 28px;
  border-radius: 50px;
  border: none;
  background: #e5e7eb;
  position: relative;
  cursor: pointer;
  transition: all 0.3s ease;
  padding: 0;
  outline: none;
}

.status-toggle .circle {
  width: 22px;
  height: 22px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 3px;
  left: 3px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}

/* Active state */
.status-toggle.active {
  background: linear-gradient(135deg, #22c55e, #16a34a);
}

.status-toggle.active .circle {
  left: 27px;
}
</style>
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
