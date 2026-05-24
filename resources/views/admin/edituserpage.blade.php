@extends('layouts/contentNavbarLayout')

@section('title', 'Edit User')

@section('content')

<div class="card mb-4">
  <form method="post" action="{{ route('update.normalusers' , $user) }}">
    @csrf
    @method('PUT')

    <h5 class="card-header text-center fw-bold d-flex align-items-center justify-content-center gap-2"
      style="background-color: azure;">
      <i class="bx bx-user"></i>
      {{ __('fieldsName.edituser') }}
    </h5>

    <div class="card-body">

      <div class="mb-3">
        <label>{{ __('messages.name') }}</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->user->name) }}">
      </div>

      <div class="mb-3">
        <label>{{ __('messages.phone') }}</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
      </div>

      <div class="mb-3">
        <label>{{ __('messages.password') }}</label>
        <input type="password" name="password" class="form-control" value="{{ old('password', $user->password) }}">
      </div>

      <button class="btn btn-primary" type="submit">{{ __('messages.edit') }}</button>

    </div>
  </form>
</div>


@endsection