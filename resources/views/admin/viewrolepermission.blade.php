@extends('layouts/contentNavbarLayout')

@section('title', 'Roles & Permissions')

@section('content')

<div class="container-xxl py-4">

  <!-- Header -->
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

    <div>
      <h2 class="fw-bold mb-1 d-flex align-items-center gap-2">
        <i class="bx bx-shield-quarter text-primary fs-2"></i>
        {{__('fieldsName.role_permission')}}
      </h2>
      <p class="text-muted mb-0">{{ __('fieldsName.managerole') }}</p>
    </div>

    <div class="stat-card">
      <div class="text-muted small">{{{ __('fieldsName.totalroles') }}}</div>
      <div class="fw-bold fs-5">{{ $roles->total() }}</div>
    </div>

  </div>

  <!-- 🔍 SEARCH -->
  <div class="mb-4 d-flex justify-content-end">
    <div class="search-box-small">
      <i class="bx bx-search"></i>
      <input type="text" id="searchRole" placeholder="{{ __('fieldsName.searchrole') }}">
    </div>
  </div>

  <!-- Roles -->
  <div class="row g-4" id="rolesContainer">

    @foreach($roles as $role)

    <div class="col-12 col-md-6 col-xl-4 role-item" data-name="{{ strtolower($role->name) }}">

      <div class="card role-card border-0 shadow-sm h-100">

        <div class="card-body">

          <!-- Header -->
          <div class="d-flex align-items-center gap-3 mb-3">

            <div class="role-avatar">
              {{ strtoupper(substr($role->name,0,1)) }}
            </div>

            <div>
              <h5 class="mb-0 fw-bold">{{ $role->name }}</h5>
              <small class="text-muted">
                {{ $role->permissions->count() }} permissions
              </small>
            </div>

          </div>

          <!-- Permissions -->
          <div class="permissions-box mb-3">
            @foreach($role->permissions->take(5) as $perm)
            <span class="perm-badge">{{ $perm->name }}</span>
            @endforeach

            @if($role->permissions->count() > 5)
            <span class="perm-more">+{{ $role->permissions->count() - 5 }}</span>
            @endif
          </div>

          <!-- Actions -->
          @if(strtolower($role->name) !== 'super-admin')

          <div class="d-flex gap-2 mt-3 align-items-stretch">

            @can('edit-role')
            <a href="{{ route('show.updateroles', $role) }}"
              class="btn btn-primary btn-sm flex-fill role-action-btn d-flex align-items-center justify-content-center">
              ✏️
            </a>
            @endcan

            @can('delete-role')
            <form action="{{ route('delete.roles', $role) }}" method="POST" class="flex-fill d-flex m-0 p-0">

              @csrf
              @method('DELETE')

              <button type="submit"
                class="btn btn-danger btn-sm w-100 role-action-btn d-flex align-items-center justify-content-center">
                🗑
              </button>

            </form>
            @endcan

            <a href="{{ route('show.userroles', $role) }}"
              class="btn btn-outline-primary btn-sm flex-fill role-action-btn d-flex align-items-center justify-content-center">
              👥
            </a>

          </div>

          @else
          <div class="alert alert-dark py-1 text-center mt-3 mb-0">
            {{ __('fieldsName.protectrole') }} 🔒
          </div>
          @endif

        </div>
      </div>

    </div>

    @endforeach

  </div>

  <!-- Pagination -->
  <div class="pagination-wrapper mt-4">
    {{ $roles->onEachSide(1)->links('pagination::bootstrap-5') }}
  </div>

</div>

@endsection


<!-- ================= STYLE ================= -->
<style>
/* Card */
.role-card {
  border-radius: 18px;
  transition: .25s ease;
}

.role-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
}

/* Avatar */
.role-avatar {
  width: 50px;
  height: 50px;
  border-radius: 14px;
  background: linear-gradient(135deg, #6366f1, #06b6d4);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

/* Permissions */
.permissions-box {
  display: flex;
  flex-wrap: wrap;
  gap: 6px;
}

.perm-badge {
  background: #f1f5f9;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 12px;
}

.perm-more {
  font-size: 12px;
  color: #64748b;
}

/* Stat */
.stat-card {
  background: #fff;
  border-radius: 14px;
  padding: 10px 14px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

/* SEARCH */
.search-box-small {
  position: relative;
  width: 100%;
  max-width: 520px;
  /* 🔥 رجعناه كبير */
}

.search-box-small input {
  width: 100%;
  height: 52px;
  /* 🔥 صار كبير */
  border-radius: 14px;
  border: 1px solid #e5e7eb;
  padding: 0 45px;
  font-size: 16px;
  background: #fff;
  transition: .2s;
}

.search-box-small input:focus {
  border-color: #6366f1;
  box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
  outline: none;
}

.search-box-small i {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 16px;
  color: #9ca3af;
}

/* BUTTON FIX (IMPORTANT) */
.role-action-btn {
  height: 40px !important;
  min-height: 40px !important;
  line-height: 1 !important;
  padding: 0 !important;
  border-radius: 10px !important;
}

/* Pagination */
.pagination-wrapper {
  display: flex;
  justify-content: center;
}

.pagination {
  gap: 6px;
}

.pagination .page-item .page-link {
  border-radius: 10px !important;
  border: none;
  padding: 8px 14px;
  background: #f1f5f9;
  color: #6366f1;
}

.pagination .page-item.active .page-link {
  background: #6366f1;
  color: #fff;
}

.pagination .page-item .page-link:hover {
  background: #6366f1;
  color: #fff;
}
</style>


<!-- ================= SCRIPT ================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {

  const searchInput = document.getElementById('searchRole');
  const items = document.querySelectorAll('.role-item');

  searchInput.addEventListener('input', function() {

    const value = this.value.toLowerCase().trim();

    items.forEach(item => {

      const name = item.getAttribute('data-name');

      item.style.display = name.includes(value) ? "" : "none";

    });

  });


});
</script>
