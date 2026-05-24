@extends('layouts/contentNavbarLayout')

@section('title', 'Dynamic Fields')

@section('content')
<div class="container-xxl mt-4">

  <h3 class="mb-4 fw-bold d-flex align-items-center gap-2">
    <i class="bx bx-list-check text-primary"></i>
    {{ __('fieldsName.dynamic fields') }}
  </h3>

  <!-- Table -->
  <div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
      <span>{{ __('fieldsName.all_fields') }}</span>
      <input type="text" id="searchInput" class="form-control w-25" placeholder="{{__('fieldsName.searchnamefield')}}.">
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>{{__('fieldsName.namearabic')}}</th>
            <th>{{__('fieldsName.nameenglish')}}</th>
            <th>{{__('fieldsName.category')}}</th>
            <th>{{__('fieldsName.subcategory')}}</th>
            <th>{{__('fieldsName.typefield')}}</th>
            <th>{{ __('fieldsName.required') }}</th>
            <th>{{ __('fieldsName.action') }}</th>
          </tr>
        </thead>
        <tbody id="fieldsTable">
          @foreach($fields as $index => $field)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $field->getTranslation('name','ar') }}</td>
            <td>{{ $field->getTranslation('name','en') }}</td>
            <td>
              {{app()->getLocale() == 'ar' ? $field->category->getTranslation('name','ar') : $field->category->getTranslation('name','en') }}
            </td>
            <td>
              {{  app()->getLocale() == 'ar' ?  $field->subcategory?->getTranslation('name','ar') : $field->subcategory?->getTranslation('name','en')}}
            </td>
            <td>{{ ucfirst($field->type) }}</td>-
            <td>
              @if($field->is_required)
              <span class="badge bg-success">Yes</span>
              @else
              <span class="badge bg-secondary">No</span>
              @endif
            </td>
            <td>
              @can('edit-dynamicField')
              <a href="{{ route('edit.dynamicfields' , $field->id) }}"
                class="btn btn-sm btn-outline-primary">{{ __('fieldsName.edit') }}</a>
              @endcan
              <br>
              <br>
              @can('delete-dynamicField')
              <form action="{{ route('dynamic-fields.destroy', $field->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this field? This will delete all related data!')"
                style="display:inline-block;">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger btn-sm">
                  🗑️
                </button>

              </form>
              @endcan
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- Search Script -->
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
  const query = this.value.toLowerCase();
  const rows = document.querySelectorAll('#fieldsTable tr');

  rows.forEach(row => {
    const nameAr = row.children[1].textContent.toLowerCase();
    const nameEn = row.children[2].textContent.toLowerCase();

    if (nameAr.includes(query) || nameEn.includes(query)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
</script>

<style>
.table-hover tbody tr:hover {
  background-color: #f5f5f5;
}

.card-header input {
  border-radius: 8px;
  padding: 0.375rem 0.75rem;
}
</style>



@endsection
