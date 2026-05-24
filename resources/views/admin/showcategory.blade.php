@extends('layouts/contentNavbarLayout')

@section('title', 'Categories')

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
<div class="container py-5">

  <!-- 🔍 Search Section -->
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <h3 class="fw-bold m-0">
      📊 {{ __('fieldsName.categories') }}
    </h3>

    <div class="position-relative" style="width: 320px;">
      <i class="bx bx-search position-absolute"
        style="left: 12px; top: 50%; transform: translateY(-50%); color:#aaa;"></i>

      <input type="text" id="searchInput" class="form-control ps-5 rounded-pill shadow-sm border-0"
        placeholder="   {{ __('fieldsName.searchcategory') }}" onkeyup="searchCategory()">
    </div>

  </div>

  <!-- 🎴 Grid -->
  <div class="row g-4" id="categoriesContainer">

    @foreach($categories as $category)
    <div class="col-lg-4 col-md-6 category-card"
      data-name="{{ strtolower($category->getTranslation('name','en')) }} {{ strtolower($category->getTranslation('name','ar')) }}">

      <div class="card wow-card border-0 h-100">

        <!-- Header -->
        <div class="card-header wow-header d-flex justify-content-between align-items-center">
          <span>📁 {{ app()->getLocale() == 'ar'
              ? $category->getTranslation('name','ar')
              : $category->getTranslation('name','en') }}</span>

          <span class="badge rounded-pill bg-gradient">
            {{ $category->subcategories->count() }}
          </span>
        </div>

        <div class="card-body d-flex flex-column">
          <!-- Subcategories -->

          <h5 class="fw-bold mb-3">
            {{ __('fieldsName.subcategories') }} :
          </h5>

          <div class="flex-grow-1">

            <div class="d-flex flex-wrap gap-2">
              @foreach($category->subcategories as $sub)
              <span class="wow-badge">
                {{ app()->getLocale() == 'ar'
                    ? $sub->getTranslation('name','ar')
                    : $sub->getTranslation('name','en') }}
              </span>
              @endforeach
            </div>

          </div>

          <!-- Actions -->
          <div class="mt-4 d-flex justify-content-between align-items-center">

            @can('add-Subcategory')
            <a href="{{ route('view.subcategory', $category) }}"
              class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">
              ➕ {{ __('fieldsName.subcategory') }}

            </a>
            @endcan

            <div class="d-flex gap-2">

              @can('edit-category')
              <a href="{{ route('pageeditcategory',$category->id) }}" class="btn btn-sm wow-icon">
                ✏️
              </a>
              @endcan

              @can('delete-category')
              <form action="{{ route('delete.category', $category->id) }}" method="POST"
                onsubmit="return confirm('{{ __('messages.deletecategorymessage') }}');">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm wow-icon danger">
                  🗑
                </button>
              </form>
              @endcan

              <a href="{{ route('cat.fields', $category) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                ⚡ {{ __('fieldsName.dynamic fields') }}
              </a>

            </div>

          </div>

        </div>
      </div>

    </div>
    @endforeach

  </div>
</div>

<!-- 🔥 JavaScript Search -->
<script>
function searchCategory() {

  let input = document.getElementById('searchInput').value.toLowerCase();
  let cards = document.querySelectorAll('.category-card');

  cards.forEach(card => {
    let name = card.getAttribute('data-name');

    if (name.includes(input)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
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
.wow-card {
  border-radius: 18px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
  transition: all 0.3s ease;
}

.wow-card:hover {
  transform: translateY(-8px) scale(1.01);
  box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
}

/* Header */
.wow-header {
  background: linear-gradient(135deg, #6366f1, #3b82f6);
  color: white;
  font-weight: 600;
}

/* Subcategories */
.wow-badge {
  background: #f1f5f9;
  padding: 6px 12px;
  border-radius: 999px;
  font-size: 12px;
  transition: 0.2s;
}

.wow-badge:hover {
  background: #e2e8f0;
  transform: scale(1.05);
}

/* icons buttons */
.wow-icon {
  background: #f8fafc;
  border-radius: 10px;
  transition: 0.2s;
}

.wow-icon:hover {
  background: #e2e8f0;
  transform: scale(1.1);
}

.wow-icon.danger:hover {
  background: #fee2e2;
}
</style>

@endsection