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
                    <x-datatable :tableId="'academy-year'" :tableHeaders="['Tahun Akademik', 'Status Tahun Ajaran', 'Mulai Ajaran', 'Akhir Ajaran', 'Aksi']" :tableColumns="[
                        ['data' => 'academic_year_name'],
                        ['data' => 'status_years'],
                        ['data' => 'year_start'],
                        ['data' => 'year_end'],
                        ['data' => 'action'],
                    ]" :getDataUrl="route('datatable.academy-year')" />
                </div>
            </div>
        </div>
        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}
@endsection
