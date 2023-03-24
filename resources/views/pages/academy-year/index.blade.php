@extends('layout.master-page')


@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                    <a href="{{ route('academy-year.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                </div>
                <div class="card-body">
                    <x-datatable :tableId="'academy-year'" :tableHeaders="['Sekolah', 'Tahun Akademik', 'Aksi']" :tableColumns="[['data' => 'school.name', 'name' => 'name'], ['data' => 'name'], ['data' => 'action']]" :getDataUrl="route('datatable.academy-year')" />
                </div>
            </div>
        </div>
        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}
@endsection
