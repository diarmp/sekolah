@extends('layout.master-page')

@section('content')
  {{-- start ROW --}}

  <div class="row">

    {{-- start table academy years --}}
    <div class="col-lg-10">
      <div class="card">
        <div class="card-header d-flex">
          <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
          <a href="{{ route('schools.create') }}" class="btn btn-primary btn-sm">Add</a>
        </div>
        <div class="card-body">
          <x-datatable :id="'schools'" :headers="['School Name', 'Type', 'Parent', 'Action']" :url="route('datatable.schools')" />
        </div>
      </div>
    </div>
    {{-- END table academy years --}}
  </div>
  {{-- END ROW --}}
@endsection

@push('js')
  <script>
    $(function() {
      const table = $("#schools")
      const url = table.data('url')


      table.DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [{
            data: 'name',
          },
          {
            data: 'type'
          },
          {
            data: 'parent',
            name: 'name'
          },
          {
            data: 'action'
          },

        ]
      });
    });
  </script>
@endpush
