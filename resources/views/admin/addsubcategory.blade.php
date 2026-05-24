@extends('layouts/contentNavbarLayout')

@section('title', 'Subcategories')

@section('page-script')
@vite('resources/assets/js/form-basic-inputs.js')
@endsection

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
<!-- Category Name Header -->

<h4 class="mb-4 d-flex align-items-center">
  <i class="fas fa-layer-group text-primary me-2"></i>

  {{ __('fieldsName.subof') }}:
  <span class="text-primary fw-bold" style="color:aqua;">
    {{ app()->getlocale() == 'en' ? $category->getTranslation('name','en') : $category->getTranslation('name','ar') }}

  </span>
</h4>

<!-- Form to Add Subcategory -->
<form action="{{ route('add.subcategory',$category) }}" method="POST" style="background: #fff;">
  @csrf
  <div class="card" style="background-color:#fff;">
    <h5 class="card-header"><b>{{ __('fieldsName.newcat') }}</b></h5>
    <div class="card-body">
      <div>
        <label class="form-label">{{ __('fieldsName.subcaten') }}</label>
        <input type="text" class="form-control" name="name[en]"
          placeholder="  {{ __('fieldsName.namesubplaceholder') }}" />
        <br>
        <label class="form-label">{{ __('fieldsName.subcatar') }}</label>
        <input type="text" class="form-control" name="name[ar]"
          placeholder="  {{ __('fieldsName.namesubplaceholder') }}" />
        <br>
        <button class="btn btn-primary" type="submit" style="background-color: azure; color:black">
          {{ __('fieldsName.addsubcat') }}
        </button>
      </div>
    </div>
  </div>
</form>

<!-- ===== Display Subcategories ===== -->
<div class="mt-4 d-flex flex-wrap gap-3">

  @foreach($category->subcategories as $sub)
  <div class="p-3 flex-shrink-0" style="background-color:#e9f7ff; border-radius:12px; min-width:250px; transition:0.3s;"
    onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 6px 18px rgba(0,0,0,0.1)'"
    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">

    <!-- Subcategory Names -->
    <h6 class="mb-2 fw-bold">
      {{ $sub->getTranslation('name','en') }} / {{ $sub->getTranslation('name','ar') }}
    </h6>

    <!-- Created at -->
    <small class="text-muted d-block mb-3">Created at:
      {{ $sub->created_at ? $sub->created_at->format('Y-m-d') : '—' }}</small>

    <!-- Actions Bottom -->
    <div class="d-flex gap-2 justify-content-end">
      @can('edit-Subcategory')
      <a href="{{ route('pageupdatesubcategory',$sub) }}" class="badge bg-primary text-white">✏️
        {{ __('fieldsName.edit') }}</a>
      @endcan
      @can('delete-Subcategory')
      <form action="{{ route('delete.subcategory', $sub->id) }}" method="POST" style="display: inline-block;"
        onsubmit="return confirm('{{ __('messages.deletesubcat') }}');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center"
          style="padding: .375rem .75rem; border-radius: .25rem;">
          🗑
        </button>
      </form>
      @endcan
    </div>

  </div>
  @endforeach

</div>
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
@endsection