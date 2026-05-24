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
<form action="{{ route('add.category') }}" method="POST" style="background: #fff;">
  @csrf
  <div class="card" style="background-color:#fff;">
    <h5 class="card-header"><b>{{ __('fieldsName.newcategory') }}</b></h5>
    <div class="card-body">
      <div>
        <label for="category_en" class="form-label">{{ __('fieldsName.ennamecat') }}</label>
        <input type="text" class="form-control" id="category_en" name="name[en]"
          placeholder="{{ __('fieldsName.placeholdernamecat') }} " />
        <br>
        <label for="category_ar" class="form-label">{{ __('fieldsName.arnamecat') }}</label>
        <input type="text" class="form-control" id="category_ar" name="name[ar]"
          placeholder="{{ __('fieldsName.placeholdernamecat') }}" />
        <br>
        <button class="btn btn-primary" type="submit"
          style="background-color: azure; color:black">{{ __('fieldsName.addcat') }}</button>
      </div>
    </div>
  </div>
</form>

<!--  Categories Table  -->
<div class="mt-4">

  <div class="card">

    <h5 class="card-header">
      <b>{{ __('fieldsName.categories') }}</b>
    </h5>

    <div class="table-responsive text-nowrap">

      <table class="table table-hover">

        <!-- Header -->
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>{{ __('fieldsName.ennamecat') }}</th>
            <th>{{ __('fieldsName.arnamecat') }}</th>
            <th>{{ __('fieldsName.subcategory') }}</th>
            <th>{{ __('fieldsName.action') }}</th>
          </tr>
        </thead>

        <tbody>

          @foreach($categories as $index => $category)
          <tr>

            <!-- Index -->
            <td>{{ $index + 1 }}</td>

            <!-- English Name -->
            <td>
              <i class="bx bx-collection text-primary me-1"></i>
              {{ $category->getTranslation('name','en') }}
            </td>

            <!-- Arabic Name -->
            <td>
              {{ $category->getTranslation('name','ar') }}
            </td>

            <!-- Subcategories -->
            <td>
              <!-- Add Subcategory -->
              @can('add-Subcategory')
              <a href="{{ route('view.subcategory', $category) }}" class="btn btn-sm btn-outline-primary">
                ➕ {{ __('fieldsName.subcategory') }}
              </a>
              @endcan
            </td>

            <!-- Actions -->
            <td>

              <div class="d-flex gap-2">



                <!-- Dropdown -->
                <div class="dropdown">

                  <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                    ⋮
                  </button>

                  <div class="dropdown-menu">
                    @can('edit-category')
                    <a class="dropdown-item" href="{{ route('pageeditcategory',$category->id) }}">
                      <i class="bx bx-edit-alt me-1"></i>
                      {{ __('fieldsName.edit') }}
                    </a>
                    @endcan
                    @can('delete-category')
                    <form action="{{ route('delete.category', $category->id) }}" method="POST"
                      style="display: inline-block;"
                      onsubmit="return confirm('{{ __('messages.deletecategorymessage') }}');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item">
                        <i class="bx bx-trash me-1"></i>
                        {{ __('fieldsName.delete') }}
                      </button>
                    </form>
                    @endcan


                  </div>

                </div>

              </div>

            </td>

          </tr>
          @endforeach

        </tbody>

      </table>

    </div>

  </div>

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
