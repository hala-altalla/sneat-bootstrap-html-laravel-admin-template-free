@extends('layouts/contentNavbarLayout')

@section('title', 'Categories')

@section('content')
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

<form action="{{ route('update.category' , $category) }}" method="POST" style="background: #fff;">
  @csrf
  @method('put')
  <div class="card" style="background-color:#fff;">
    <h5 class="card-header"><b>{{ __('fieldsName.editcat') }} {{ $category->getTranslation('name', 'en') }}</b></h5>
    <div class="card-body">
      <div>
        <label for="category_en" class="form-label">{{ __('fieldsName.ennamecat') }}</label>
        <input type="text" class="form-control" id="category_en" name="name[en]"
          value="{{ old('name[en]',$category->getTranslation('name','en')) }}" placeholder="name of category" />
        <br>
        <label for="category_ar" class="form-label">{{ __('fieldsName.arnamecat') }}</label>
        <input type="text" class="form-control" id="category_ar" name="name[ar]"
          value="{{ old('name[ar]',$category->getTranslation('name','ar')) }}" placeholder="name of category" />
        <br>
        <button class="btn btn-primary" type="submit"
          style="background-color: azure; color:black">{{ __('fieldsName.savecat') }}</button>
      </div>
    </div>
  </div>
</form>

<!-- ===== Display Subcategories ===== -->
<div class="mt-4">

  <div class="d-flex flex-wrap gap-3">
    @foreach($category->subcategories as $subcategory)
    <div class="p-3" style="background-color: #f8f9fa; border-radius: 16px; flex: 1 1 250px; min-width:250px;">

      <!-- Header with category name -->
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">
          <i class="bx bx-collection me-1"></i>
          {{ $subcategory->getTranslation('name','en') }} / {{ $subcategory->getTranslation('name','ar') }}
        </h5>

        <!-- Actions -->
        <div class="dropdown">
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
            <i class="icon-base bx bx-dots-vertical-rounded"></i>
          </button>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('pageupdatesubcategory',$subcategory) }}"><i
                class="icon-base bx bx-edit-alt me-1"></i> {{__('fieldsName.edit')}}</a>

            <form action="{{ route('delete.subcategory', $subcategory->id) }}" method="POST" class="dropdown-item"
              style="display: inline-block;" onsubmit="return confirm(' {{ __('messages.deletesubcat') }} ');">
              @csrf
              @method('DELETE')
              <button type="submit" style="border:none; background:none; padding:0;">
                <i class="icon-base bx bx-trash me-1"></i> {{__('fieldsName.delete')}}

              </button>
            </form>






          </div>
        </div>
      </div>

      <!-- Subcategories Pills -->


      <!-- Add Subcategory Button -->


    </div>
    @endforeach
  </div>

</div>



</style>

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
</style>

@endsection