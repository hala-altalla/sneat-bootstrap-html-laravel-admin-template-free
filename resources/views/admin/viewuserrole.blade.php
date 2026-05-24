@extends('layouts/contentNavbarLayout')

@section('content')
<div class="mt-4">
  <span>users for {{ $role->name }}</span>
  <div class="d-flex flex-wrap gap-3">
    @foreach($users as $user)
    <div class="p-3"
      style="background-color: #f8f9fa; border-radius: 16px; flex: 1 1 250px; min-width: 250px; max-width: 300px;">

      <!-- Header with user name -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
          <i class="bx bx-user me-1"></i>
          {{ $user->name }}
        </h5>

        <!-- Actions -->
        <div class="dropdown">
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="icon-base bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('admin.edit' , $user->admin->id) }}"><i
                class="icon-base bx bx-edit-alt me-1"></i> Edit</a>
            <form action="{{ route('admin.delete', $user->admin->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('{{ __('messages.deleteadminmessage') }}');">>
              @csrf
              @method('DELETE')
              <button type="submit" class="dropdown-item"><i class="icon-base bx bx-trash me-1"></i> Delete</button>
            </form>
          </div>
        </div>
      </div>

      <!-- Optional: User Info -->
      <p class="mb-1"><strong>Email:</strong> {{ $user->admin->email }}</p>
      <p class="mb-0"><strong>Type:</strong> {{ $user->type }}</p>

    </div>
    @endforeach
  </div>

</div>

<style>
/* Optional: hover effect for cards */
.mt-4 .p-3:hover {
  transform: translateY(-3px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  transition: all 0.2s ease;
}
</style>


@endsection