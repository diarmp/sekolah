@extends('layout.master-page')

@section('content')

  {{-- start ROW --}}

  <div class="row">

    {{-- start table schools --}}
    <div class="col-lg-10">
      <div class="card">
        <div class="card-header d-flex">
          <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
          <a href="{{ route('schools.create') }}" class="btn btn-primary btn-sm">Tambah {{ $title}}</a>
        </div>
        <div class="card-body">
          <x-datatable :tableId="'schools'" :tableHeaders="['Nama', 'Tipe', 'Yayasan', 'Aksi']" :tableColumns="[['data' => 'name'], ['data' => 'type'], ['data' => 'induk'], ['data' => 'action']]" :getDataUrl="route('datatable.schools')" />
        </div>
      </div>
    </div>
    {{-- END table schools --}}

  </div>
  {{-- END ROW --}}

@endsection
