@extends('layouts/contentNavbarLayout')

@section('title', 'Basic Inputs - Forms')

@section('page-script')
@vite('resources/assets/js/form-basic-inputs.js')
@endsection

@section('content')

<!-- Search -->
<div class="mb-4">
  <input type="text" id="searchInput" class="form-control" placeholder="{{ __('messages.search_admin_placeholder')}} "
    onkeyup="filterCards()">
</div>

<!-- Cards -->
<div class="d-flex flex-wrap gap-4" id="cardsContainer">

  @foreach($admins as $admin)
  @if($admin->user->type=='admin')
  <div class="card border-0 shadow-sm p-3 account-card" style="width: 280px; border-radius: 16px; transition: all 0.3s;"
    onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)'"
    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">

    <div class="card-body p-2">

      <!-- Header -->
      <div class="d-flex align-items-center mb-3">

        <!-- Avatar -->
        <div style="width: 45px; height: 45px; border-radius: 50%; background-color: #ddd;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 18px; font-weight: bold;">
          {{ strtoupper(substr($admin->user->name,0,1)) }}
        </div>

        <div class="ms-2">
          <h6 class="mb-0 fw-bold name">{{ $admin->user->name }}</h6>
          <small class="text-muted">{{ $admin->user->type }}</small>
        </div>
      </div>

      <!-- Email -->
      <div class="mb-2">
        <small class="text-muted">Email</small>
        <p class="mb-0 fw-semibold email">{{ $admin->email }}</p>
      </div>

      <!-- Created At -->
      <div class="mb-3">
        <small class="text-muted">Created At</small>
        <p class="mb-0">{{optional( $admin->created_at)->format('Y-m-d') }}</p>
      </div>

      <!-- Buttons -->
      @can('edit-admin')
      <div class="d-flex justify-content-between mt-3">

        <a href="{{ route('admin.edit' , $admin->id) }}" class="btn btn-sm btn-outline-primary">✏️
          {{ __('messages.edit') }}</a>
        <form action="{{ route('admin.delete', $admin) }}" method="POST" style="display: inline-block;"
          onsubmit="return confirm('{{ __('messages.deleteadminmessage') }}');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center"
            style="padding: .375rem .75rem; border-radius: .25rem;">
            🗑 {{ __('messages.delete') }}
          </button>
        </form>
      </div>
      @endcan
    </div>
  </div>
  @endif
  @endforeach

</div>

<!--  Search Script -->
<script>
function filterCards() {
  let input = document.getElementById("searchInput").value.toLowerCase();
  let cards = document.querySelectorAll(".account-card");

  cards.forEach(card => {
    let name = card.querySelector(".name").innerText.toLowerCase();
    let email = card.querySelector(".email").innerText.toLowerCase();

    if (name.includes(input) || email.includes(input)) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
}
</script>
@endsection