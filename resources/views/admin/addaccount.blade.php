@extends('layouts/contentNavbarLayout')

@section('title', 'Basic Inputs - Forms')

@section('page-script')
@vite('resources/assets/js/form-basic-inputs.js')
@endsection

@section('content')
<div class="card">
  <form method="post" action="{{ route('store.account') }}">
    @csrf
    <h5 class="card-header text-center fw-bold fs-5 d-flex align-items-center justify-content-center"
      style="color: #000; background-color:azure; border-bottom: 2px solid #dee2e6; border-radius: 8px 8px 0 0; padding: 1rem; gap: 0.5rem;">
      <i class="bx bx-user-plus fs-4"></i>
      {{__('messages.addadmin')}}
    </h5>
    <div class="card-body">
      <div class="mb-4">
        <label for="exampleFormControlInput1" class="form-label">{{ __('messages.name') }}</label>
        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" placeholder="name" />
      </div>
      <div class="mb-4">
        <label for="exampleFormControlInput1" class="form-label">{{ __('messages.email') }}</label>
        <input type="email" class="form-control" id="exampleFormControlInput1" name="email"
          placeholder="name@example.com" />
      </div>

      <div class="mb-4">
        <label for="exampleFormControlReadOnlyInputPlain1" class="form-label"
          name="password">{{ __('messages.password') }}</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" name="password"
          placeholder="password" />
      </div>

      <div>
        <button class="btn btn-primary" type="submit"
          style="background-color: azure; color:black">{{ __('messages.Add') }}</button>
      </div>
    </div>
  </form>
</div>
<div>

</div>
<br>
<div class="d-flex flex-wrap gap-4">

  @foreach($admins as $admin)
  @if($admin->user->type=='admin')
  <div class="card border-0 shadow-sm p-3" style="width: 280px; border-radius: 16px; transition: all 0.3s;"
    onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'"
    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">

    <div class="card-body p-2">

      <!-- Header -->
      <div class="d-flex align-items-center mb-3">
        <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #f0f0f0;
                    display: flex; align-items: center; justify-content: center; font-size: 20px;">
          👤
        </div>
        <div class="ms-2">
          <h6 class="mb-0 fw-bold">{{ $admin->user->name }}</h6>
          <small class="text-muted">{{ $admin->user->type }}</small>
        </div>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <small class="text-muted">Email</small>
        <p class="mb-0 fw-semibold">{{ $admin->email }}</p>
      </div>

      <div class="d-flex justify-content-between mt-3">
        @can('edit-admin')
        <a href="{{ route('admin.edit' , $admin->id) }}" class="btn btn-sm btn-outline-primary w-45">✏️
          {{__('messages.edit')}}</a>
        <form action="{{ route('admin.delete', $admin) }}" method="POST" style="display: inline-block;"
          onsubmit="return confirm('{{ __('messages.deleteadminmessage') }}');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center"
            style="padding: .375rem .75rem; border-radius: .25rem;">
            🗑 {{ __('messages.delete') }}
          </button>
        </form>
        @endcan
      </div>

    </div>
  </div>
  @endif
  @endforeach

</div>




@endsection