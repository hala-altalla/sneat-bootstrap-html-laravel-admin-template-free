@extends('layouts/contentNavbarLayout')

@section('title', 'Users')

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
<!-- Add User -->
<div class="card mb-4">
  <form method="post" action="{{ route('add.normalusers') }}">
    @csrf

    <h5 class="card-header text-center fw-bold d-flex align-items-center justify-content-center gap-2"
      style="background-color: azure;">
      <i class="bx bx-user-plus"></i>
      {{ __('messages.adduser') }}
    </h5>

    <div class="card-body">

      <div class="mb-3">
        <label>{{ __('messages.name') }}</label>
        <input type="text" name="name" class="form-control">
      </div>

      <div class="mb-3">
        <label>{{ __('messages.phone') }}</label>
        <input type="text" name="phone" class="form-control">
      </div>

      <div class="mb-3">
        <label>{{ __('messages.password') }}</label>
        <input type="password" name="password" class="form-control">
      </div>

      <button class="btn btn-primary" type="submit">{{ __('messages.Add') }}</button>

    </div>
  </form>
</div>

<!-- Search -->
<div class="card p-3 mb-3">
  <div class="d-flex gap-2">

    <div class="position-relative w-100">
      <i class="bx bx-search position-absolute"
        style="left: 10px; top: 50%; transform: translateY(-50%); color: gray;"></i>

      <input type="text" id="search" class="form-control ps-4"
        placeholder="   {{ __('messages.search_user_placeholder') }}">
    </div>

    <button type="button" class="btn btn-primary" onclick="searchUsers()">
      {{ __('messages.search') }}
    </button>

  </div>
</div>

<!-- Table -->
<div class="card p-3">

  <table class="table align-middle">
    <thead>
      <tr>
        <th>{{ __('messages.user') }}</th>
        <th>{{ __('messages.name') }}</th>
        <th>{{ __('messages.phone') }}</th>
        <th>{{ __('messages.type') }}</th>
        <th>{{ __('messages.action') }}</th>
      </tr>
    </thead>

    <tbody id="users-table">

      @foreach($normalusers as $user)
      <tr>
        <td>
          <div class="user-icon">
            <i class="bx bx-user"></i>
          </div>
        </td>

        <td>{{ $user->user->name }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->user->type }}</td>

        <td>
          <a class="dropdown-item" href="{{ route('edit.pagenormalusers',$user->id) }}">
            <i class="bx bx-edit-alt me-1"></i>
            {{ __('fieldsName.edit') }}
          </a>

          <a class="dropdown-item" href="#">
            <form action="{{ route('delete.normalusers' , $user->id) }}" method="POST" style="display: inline-block;"
              onsubmit="return confirm('{{ __('messages.deleteusermessage') }}');">
              @csrf
              @method('DELETE')
              <button type="submit" class="dropdown-item">
                <i class="bx bx-trash me-1"></i>
                {{ __('fieldsName.delete') }}
              </button>
            </form>

          </a>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
  <div class="mt-3 d-flex justify-content-center">
    {{ $normalusers->links('pagination::bootstrap-5') }}
  </div>
</div>

<style>
.user-icon {
  width: 35px;
  height: 35px;
  background: #e7f1ff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.user-icon i {
  color: #0d6efd;
}

table tbody tr:hover {
  background: #f8f9fa;
}
</style>

<!-- JS -->
<script>
function searchUsers() {


  let editText = "{{ __('messages.edit') }}";
  let deleteText = "{{ __('messages.delete') }}";

  let value = document.getElementById('search').value;

  fetch("{{ url('/users/search') }}?search=" + value)
    .then(response => response.json())
    .then(data => {

      let table = document.getElementById('users-table');
      table.innerHTML = '';

      if (data.length === 0) {
        table.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No users found
                        </td>
                    </tr>
                `;
        return;
      }

      data.forEach(user => {
        table.innerHTML += `
                    <tr>
                        <td>
                          <div class="user-icon">
                            <i class="bx bx-user"></i>
                          </div>
                        </td>
                        <td>${user.name}</td>
                        <td>${user.phone}</td>
                        <td>${user.type}</td>
                        <td>
                          <span>___</span>
                        </td>
                    </tr>
                `;
      });

    })
    .catch(error => console.error(error));
}
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



<style>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
  margin-top: 25px;
  padding: 0;
}

/* كل عنصر */
.pagination .page-item {
  list-style: none;
}

/* الروابط */
.pagination .page-link {
  border: none;
  background: #f3f4f6;
  color: #374151;
  padding: 8px 14px;
  border-radius: 10px;
  font-size: 14px;
  transition: all 0.2s ease;
  box-shadow: none;
}

/* hover */
.pagination .page-link:hover {
  background: #4f46e5;
  color: #fff;
  transform: translateY(-2px);
}

/* active */
.pagination .active .page-link {
  background: #4f46e5;
  color: #fff;
}

/* disabled */
.pagination .disabled .page-link {
  background: #e5e7eb;
  color: #9ca3af;
  cursor: not-allowed;
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
