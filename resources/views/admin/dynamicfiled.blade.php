@extends('layouts/contentNavbarLayout')

@section('title', 'Add Dynamic Field')

@section('content')

<div class="container mt-4">

  <div class="card p-4 shadow-sm" style="border-radius:16px;">

    <h4 class="mb-4 fw-bold">
      <i class="bx bx-list-plus text-primary"></i>
      {{ __('fieldsName.adddynamicfield') }}
    </h4>

    <form method="POST" action="{{ route('dynamic-fields.store') }}">
      @csrf

      <!-- Category -->
      <div class="mb-3">
        <label class="form-label fw-semibold">{{ __('fieldsName.category') }}</label>
        <select class="form-select" id="category" name="category_id">
          <option value="">{{ __('fieldsName.selectcategory') }}</option>

          @foreach($categories as $category)
          <option value="{{ $category->id }}">
            {{ app()->getLocale() == 'ar'
                ? $category->getTranslation('name','ar')
                : $category->getTranslation('name','en') }}
          </option>
          @endforeach

        </select>
      </div>

      <!-- Subcategory -->
      <div class="mb-3">
        <label class="form-label fw-semibold">{{ __('fieldsName.subcategory') }}</label>
        <select class="form-select" name="subcategory_id" id="subcategory">
          <option value="">{{ __('fieldsName.selectsubcategory') }}</option>
        </select>
      </div>

      <!-- Name AR -->
      <div class="mb-3">
        <label>{{ __('fieldsName.arname') }}</label>
        <input type="text" name="name[ar]" class="form-control">
      </div>

      <!-- Name EN -->
      <div class="mb-3">
        <label>{{ __('fieldsName.enname') }}</label>
        <input type="text" name="name[en]" class="form-control">
      </div>

      <!-- Type -->
      <div class="mb-3">
        <label>{{ __('fieldsName.fieldtype') }}</label>
        <select name="type" id="type" class="form-select">
          <option value="text">{{ __('fieldsName.text') }}</option>
          <option value="number">{{ __('fieldsName.number') }}</option>
          <option value="select">{{ __('fieldsName.select') }}</option>
        </select>
      </div>

      <!-- Required -->
      <div class="mb-3">
        <label>
          <input type="checkbox" name="is_required" value="1">
          {{ __('fieldsName.required') }}
        </label>
      </div>

      <!-- OPTIONS -->
      <div id="options-container" style="display:none;">

        <h5 class="mt-3">{{ __('fieldsName.Options') }}</h5>

        <div id="options-list" class="mb-2"></div>

        <button type="button" onclick="addOption()" class="btn btn-sm btn-primary">
          <i class="bx bx-plus"></i> {{ __('fieldsName.addoption') }}
        </button>

      </div>

      <button type="submit" class="btn btn-success mt-3 w-100">
        {{ __('fieldsName.save') }}
      </button>

    </form>

  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

  let index = 0;

  // =====================
  // CATEGORY → SUBCATEGORY
  // =====================
  let categories = @json($categories);

  document.getElementById('category').addEventListener('change', function() {

    let categoryId = this.value;
    let subSelect = document.getElementById('subcategory');

    subSelect.innerHTML = '<option value="">Select Subcategory</option>';

    let selected = categories.find(cat => cat.id == categoryId);

    if (selected && selected.subcategories) {
      selected.subcategories.forEach(sub => {
        subSelect.innerHTML += `
          <option value="${sub.id}">
            ${sub.name.en}
          </option>
        `;
      });
    }
  });

  // =====================
  // TYPE TOGGLE
  // =====================
  const type = document.getElementById('type');
  const container = document.getElementById('options-container');

  type.addEventListener('change', function() {
    container.style.display = this.value === 'select' ? 'block' : 'none';
  });

  // =====================
  // ADD OPTION
  // =====================
  window.addOption = function() {

    let html = `
      <div class="d-flex gap-2 mb-2 align-items-center option-row p-2 border rounded">

        <input type="text"
               name="options[${index}][ar]"
               class="form-control"
               placeholder="Arabic value">

        <input type="text"
               name="options[${index}][en]"
               class="form-control"
               placeholder="English value">

        <span class="text-danger fw-bold"
              style="cursor:pointer; font-size:20px;"
              onclick="this.parentElement.remove()">
          ×
        </span>

      </div>
    `;

    document.getElementById('options-list')
      .insertAdjacentHTML('beforeend', html);

    index++;
  };

});
</script>

@endsection
