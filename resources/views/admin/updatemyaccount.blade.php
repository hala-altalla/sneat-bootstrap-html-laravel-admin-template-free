@extends('layouts/contentNavbarLayout')

@section('title', 'update admin')

@section('page-script')
@vite('resources/assets/js/form-basic-inputs.js')
@endsection

@section('content')
<div class="card">
  <form method="post" action="{{ route('updatemyaccount') }}">
    @csrf
    @method('PUT')

    <h5 class="card-header text-center fw-bold fs-5 d-flex align-items-center justify-content-center"
      style="color: #000; background-color:azure; border-bottom: 2px solid #dee2e6; border-radius: 8px 8px 0 0; padding: 1rem; gap: 0.5rem;">
      <i class="bx bx-user-plus fs-4"></i>
      {{ __('fieldsName.editadmin') }}
    </h5>
    <div class="card-body">
      <div class="mb-4">
        <label for="exampleFormControlInput1" class="form-label">{{ __('fieldsName.name') }}</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" placeholder="name"
          value="{{ old('name', $admin->user->name) }}" />
      </div>
      <div class="mb-4">
        <label for="exampleFormControlInput1" class="form-label">{{ __('fieldsName.email') }}</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
          value="{{ old('email', $admin->email) }}" placeholder="name@example.com" />
      </div>

      <div class="mb-4">
        <label for="exampleFormControlReadOnlyInputPlain1" class="form-label"
          name="password">{{ __('fieldsName.password') }}</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" name="password"
          value="{{ old('password', $admin->password) }}" placeholder="password" />
      </div>

      <div>
        <button type="submit" class="btn btn-primary">
          <i class="bx bx-refresh"></i> {{ __('fieldsName.editadmin') }}
        </button>
      </div>
    </div>
  </form>
</div>
<div>

</div>
<br>

@endsection