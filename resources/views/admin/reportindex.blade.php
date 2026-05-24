@extends('layouts/contentNavbarLayout')

@section('title', 'Reports')

@section('content')

<div class="card">

  <h5 class="card-header text-center fw-bold">
    🚨 {{ __('fieldsName.reportmanagment') }}
  </h5>

  <div class="card-body">

    <table class="table table-bordered align-middle text-center">

      <thead>
        <tr>
          <th>ID</th>
          <th>{{__('fieldsName.orderid')}}</th>
          <th>{{__('fieldsName.customer')}}</th>

          <th>{{__('fieldsName.businees-account-customer')}}</th>
          <th>{{__('fieldsName.businees-account-provider')}}</th>
          <th>{{__('fieldsName.service')}}</th>
          <th> {{ __('fieldsName.reason') }}</th>
          <th>{{__('fieldsName.status')}}</th>
          <th>{{__('fieldsName.action')}}</th>
        </tr>
      </thead>

      <tbody>

        @forelse($reports as $report)

        <tr id="row-{{ $report->id }}" @if(request('highlight')==$report->id)
          style="background-color:#fff3cd;"
          @endif>

          <td>#{{ $report->id }}</td>

          <td>
            #{{ $report->order_id }}

          </td>
          <td>
            {{ $report->businessAccount->normalUser->user->name ?? '-' }}
          </td>
          <td>
            {{ app()->getlocale() == 'ar' ? $report->businessAccount->business_name_ar :  $report->businessAccount->business_name_en }}
          </td>
          <td>
            {{app()->getlocale() == 'ar' ? $report->order->service->businessAccount->business_name_ar : $report->order->service->businessAccount->business_name_en }}
          </td>
          <td>
            {{ app()->getlocale() == 'ar' ? $report->order->service->title_ar : $report->order->service->title_en }}
          </td>

          <td>
            {{ $report->reason }}
          </td>

          <td>
            @if($report->status == 'pending')
            <span class="badge bg-warning">{{__('fieldsName.pending')}}</span>
            @elseif($report->status == 'accepted')
            <span class="badge bg-success">{{__('fieldsName.accepted')}}</span>
            @else
            <span class="badge bg-danger">{{__('fieldsName.rejected')}}</span>
            @endif
          </td>

          <td>
            @if($report->status=="pending")
            <!-- Accept -->
            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" style="display:inline-block;">
              @csrf
              <input type="hidden" name="status" value="accepted">
              <button class="btn btn-sm btn-success">
                ✔ {{__('fieldsName.accept')}}
              </button>
            </form>
            <br>
            <br>
            <!-- Reject -->
            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" style="display:inline-block;">
              @csrf
              <input type="hidden" name="status" value="rejected">
              <button class="btn btn-sm btn-danger">
                ✖ {{__('fieldsName.reject')}}
              </button>
            </form>
            @endif
            @if($report->status=="accepted" || $report->status=="rejected" )
            <span>_</span>
            @endif

          </td>

        </tr>

        @empty

        <tr>
          <td colspan="6" class="text-muted">No reports found</td>
        </tr>

        @endforelse

      </tbody>

    </table>

  </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", function() {

  const urlParams = new URLSearchParams(window.location.search);
  const highlightId = urlParams.get('highlight');

  if (!highlightId) return;

  let attempts = 0;

  const interval = setInterval(() => {

    attempts++;

    const row = document.querySelector(`#row-${highlightId}`);

    console.log("Trying... attempt:", attempts, "row:", row);

    if (row) {

      row.classList.add("highlight-row");

      row.scrollIntoView({
        behavior: "smooth",
        block: "center"
      });

      clearInterval(interval); // 🔥 وقف البحث

    }

    if (attempts > 20) {
      clearInterval(interval);
      console.log("❌ Row not found after many attempts");
    }

  }, 200);

});
</script>
<style>
.highlight-row {
  .highlight-row {
    background-color: #fff3cd !important;
    animation: blink 1s 2;
  }

  @keyframes blink {
    0% {
      background-color: #fff3cd;
    }

    50% {
      background-color: #ffe08a;
    }


    100% {
      background-color: #fff3cd;
    }
  }
}
</style>
<script>
console.log("ROWS IN TABLE:", document.querySelectorAll("table tbody tr").length);
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {

  const id = "{{ request('highlight') }}";

  if (id) {
    const row = document.getElementById("row-" + id);

    if (row) {
      row.scrollIntoView({
        behavior: "smooth",
        block: "center"
      });
    }
  }

});
</script>
@endsection