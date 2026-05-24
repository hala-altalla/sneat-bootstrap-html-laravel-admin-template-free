@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Dynamic Field')

@section('content')

<div class="container mt-4">

  <div class="card p-4 shadow-sm" style="border-radius:16px;">

    <h4 class="mb-4 fw-bold">
      <i class="bx bx-edit text-primary"></i>
      {{ __('messages.edit') }} {{ __('fieldsName.dynamic fields') }}
    </h4>

    <form method="POST" action="{{ route('dynamic-fields.update', $field->id) }}">
      @csrf
      @method('PUT')

      <!-- CATEGORY -->
      <div class="mb-3">
        <label>{{ __('fieldsName.category') }}</label>
        <select class="form-select" name="category_id" id="category">
          @foreach($categories as $category)
          <option value="{{ $category->id }}" {{ $field->category_id == $category->id ? 'selected' : '' }}>
            {{ app()->getLocale() == 'ar' ? $category->getTranslation('name','ar') : $category->getTranslation('name','en') }}
          </option>
          @endforeach
        </select>
      </div>

      <!-- SUBCATEGORY -->
      <div class="mb-3">
        <label>{{ __('fieldsName.subcategory') }}</label>


        <select class="form-select" name="subcategory_id" id="subcategory">
          <option value="">
            {{ __('fieldsName.selectsubcategory') }}</option>
        </select>
      </div>

      <!-- NAME -->
      <div class="mb-3">
        <label>{{ __('fieldsName.arname') }}</label>
        <input type="text" name="name[ar]" class="form-control" value="{{ $field->getTranslation('name','ar') }}">
      </div>

      <div class="mb-3">
        <label>{{ __('fieldsName.enname') }}</label>
        <input type="text" name="name[en]" class="form-control" value="{{ $field->getTranslation('name','en') }}">
      </div>

      <!-- TYPE -->
      <div class="mb-3">
        <label>{{ __('fieldsName.fieldtype') }}</label>
        <select name="type" id="type" class="form-select">
          <option value="text" {{ $field->type=='text'?'selected':'' }}>{{ __('fieldsName.text') }}</option>
          <option value="number" {{ $field->type=='number'?'selected':'' }}>{{ __('fieldsName.number') }}</option>
          <option value="select" {{ $field->type=='select'?'selected':'' }}>{{ __('fieldsName.select') }}</option>
        </select>
      </div>
      <div class="mb-3">
        <label>
          <input type="hidden" name="is_required" value="0">

          <input type="checkbox" name="is_required" value="1"
            {{ old('is_required', $field->is_required) ? 'checked' : '' }}>

          {{ __('fieldsName.required') }}
        </label>
      </div>

      <!-- OPTIONS -->
      <div id="options-container" style="{{ $field->type == 'select' ? '' : 'display:none;' }}">

        <div id="options-list">

          @foreach($field->options as $i => $opt)

          @php
          $value = $opt->value;

          if (is_string($value)) {
          $value = json_decode($value, true);
          }

          if (!is_array($value)) {
          $value = ['ar' => $opt->value, 'en' => $opt->value];
          }
          @endphp

          <div class="d-flex gap-2 mb-2 option-row">

            <input type="text" name="options[{{ $i }}][ar]" class="form-control" value="{{ $value['ar'] ?? '' }}"
              placeholder="Arabic">

            <input type="text" name="options[{{ $i }}][en]" class="form-control" value="{{ $value['en'] ?? '' }}"
              placeholder="English">

          </div>

          @endforeach

        </div>

        <button type="button" class="btn btn-sm btn-primary mt-2" onclick="addOption()">
          + {{ __('fieldsName.addoption') }}
        </button>

      </div>

      <button type="submit" class="btn btn-success mt-3 w-100">
        {{ __('fieldsName.edit') }}
      </button>

    </form>

  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

  // ✔ start index correctly
  let index = document.querySelectorAll('#options-list .option-row').length;

  const type = document.getElementById('type');
  const container = document.getElementById('options-container');

  // ✔ toggle options
  type.addEventListener('change', function() {
    container.style.display = this.value === 'select' ? 'block' : 'none';
  });

  // ✔ add option
  window.addOption = function() {

    let html = `
      <div class="d-flex gap-2 mb-2 option-row">

        <input type="text"
               name="options[${index}][ar]"
               class="form-control"
               placeholder="Arabic">

        <input type="text"
               name="options[${index}][en]"
               class="form-control"
               placeholder="English">

        <button type="button"
                class="btn btn-danger btn-sm"
                onclick="this.parentElement.remove()">
          ✖
        </button>

      </div>
    `;

    document.getElementById('options-list').insertAdjacentHTML('beforeend', html);

    index++;
  };

});
</script>




@endsection