@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table Grade --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                    <a href="{{ route('tuition.create') }}" class="btn btn-primary btn-sm">TAMBAH</a>
                </div>
                <div class="card-body">
                    <x-datatable :tableId="'tuition'" 
                    :tableHeaders="['Tipe Biaya', 'Tahun Akademik', 'Tingkat', 'Periode', 'Nominal', 'Aksi']" 
                    :tableColumns="[
                        ['data' => 'tuition_type', 'name' => 'period'], 
                        ['data' => 'academic_year'], 
                        ['data' => 'grade'], 
                        ['data' => 'period'], 
                        ['data' => 'price'], 
                        ['data' => 'action']
                        ]" 
                    :getDataUrl="route('datatable.tuition')" />
                </div>
            </div>
        </div>
        {{-- END table Grade --}}
    </div>
    {{-- END ROW --}}

@endsection
