@extends('layouts/contentNavbarLayout')

@section('title', 'Subcategories')

@section('page-script')
@vite('resources/assets/js/form-basic-inputs.js')
@endsection

@section('content')

<!-- Category Name Header -->
<h4 class="mb-4">{{ __('fieldsName.subof') }}: <span
    class="text-primary">{{ $subcategory->category->getTranslation('name','en') }}

  </span></h4>

<!-- Form to Add Subcategory -->
<form action="{{ route('update.subcategory',$subcategory->id) }}" method="POST" style="background: #fff;">
  @csrf
  @method('put')
  <div class="card" style="background-color:#fff;">
    <h5 class="card-header"><b>{{ __('fieldsName.editcat') }} {{ $subcategory->getTranslation('name','en')}}</b></h5>
    <div class="card-body">
      <div>
        <label class="form-label">{{ __('fieldsName.subcaten') }}</label>
        <input type="text" class="form-control" name="name[en]"
          value="{{ old('name[en]',$subcategory->getTranslation('name','en')) }}"
          placeholder="{{ __('fieldsName.namesubplaceholder') }}" />
        <br>
        <label class="form-label">{{ __('fieldsName.subcatar') }}</label>
        <input type="text" class="form-control" name="name[ar]"
          value="{{ old('name[ar]',$subcategory->getTranslation('name','ar')) }}"
          placeholder="{{ __('fieldsName.namesubplaceholder') }}" />
        <br>
        <button class="btn btn-primary" type="submit" style="background-color: azure; color:black">
          {{ __('fieldsName.save') }}
        </button>
      </div>
    </div>
  </div>
</form>





@endsection
