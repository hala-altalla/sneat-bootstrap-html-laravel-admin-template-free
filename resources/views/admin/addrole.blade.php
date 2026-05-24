@extends('layouts/contentNavbarLayout')

@section('title', 'Add Role with Permissions & Users')

@section('content')
<div class="container-xxl">
  <div class="card">
    <!-- عنوان الصفحة -->
    <h5 class="card-header text-center fw-bold fs-5 d-flex align-items-center justify-content-center"
      style="color: #000; background-color:azure; border-bottom: 2px solid #dee2e6; border-radius: 8px 8px 0 0; padding: 1rem; gap: 0.5rem;">
      <i class="bx bx-shield fs-4"></i> {{ __('fieldsName.addrole') }}
    </h5>

    <div class="card-body">
      <form action="{{ route('add.roles') }}" method="POST">
        @csrf

        <!-- 1️⃣ Role Name -->
        <div class="mb-4">
          <label for="role_name" class="form-label fw-semibold">{{ __('fieldsName.rolename') }}</label>
          <input type="text" id="role_name" name="name" class="form-control"
            placeholder="{{ __('fieldsName.addroleplacholder') }}" required>
        </div>

        <!-- 2️⃣ Permissions Grid -->
        <div class="mb-4">
          <label class="form-label fw-semibold">{{ __('fieldsName.selectpermission') }}</label>
          <div class="d-flex flex-wrap gap-2">
            @foreach($permissions as $permission)
            <label class="permission-card">
              <input type="checkbox" name="permissions[]" value="{{ $permission->name  }}">
              <span>{{ $permission->name }}</span>
            </label>
            @endforeach
          </div>
        </div>

        <!-- 3️⃣ Users Selection -->
        @can('assign-RolePermission')
        <div class="mb-4">
          <label class="form-label fw-semibold">{{ __('fieldsName.assignusers') }}</label>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th style="background-color: azure;">{{ __('fieldsName.select') }}</th>
                  <th style="background-color: azure;">{{ __('fieldsName.name') }}</th>
                  <th style="background-color: azure;">{{ __('fieldsName.email') }}</th>
                  <th style="background-color: azure;">{{ __('fieldsName.type') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($admins as $admin)
                @if($admin->user->type !== 'super_admin')
                <tr>
                  <td>
                    <input type="checkbox" name="users[]" value="{{ $admin->id }}">
                  </td>
                  <td>{{ $admin->user->name ?? 'N/A' }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>{{ $admin->user->type }}</td>
                </tr>
                @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        @endcan
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-plus"></i> {{ __('fieldsName.add-role') }}
        </button>

      </form>
    </div>
  </div>
</div>

<style>
.permission-card {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.75rem 1rem;
  border: 1px solid #dee2e6;
  border-radius: 12px;
  cursor: pointer;
  user-select: none;
  background-color: #f8f9fa;
  transition: all 0.2s ease;
  min-width: 120px;
  text-align: center;
  font-weight: 500;
}

.permission-card input[type="checkbox"] {
  display: none;
}

.permission-card span {
  pointer-events: none;
}

.permission-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.permission-card input[type="checkbox"]:checked+span {
  background-color: #0d6efd;
  color: #fff;
  border-radius: 12px;
  padding: 0.5rem 1rem;
}
</style>

@endsection
