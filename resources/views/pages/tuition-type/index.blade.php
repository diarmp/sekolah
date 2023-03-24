@extends('layout.master-page')



@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table tuituion type --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                    <a href="{{ route('tuition-type.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                </div>
                <div class="card-body">
                    <x-datatable :tableId="'tuition-type-table'" :tableHeaders="['Sekolah', 'Tipe Biaya', 'Rutin', 'Aksi']" :tableColumns="[
                        ['data' => 'school.name', 'name' => 'name'],
                        ['data' => 'name'],
                        ['data' => 'generatable'],
                        ['data' => 'action'],
                    ]" :getDataUrl="route('datatable.tuition-type')" />
                </div>
            </div>
        </div>
        {{-- END table tuituion type --}}
    </div>
    {{-- END ROW --}}
@endsection
