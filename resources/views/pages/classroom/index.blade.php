@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table Grade --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                    <a href="{{ route('classroom.create') }}" class="btn btn-primary btn-sm">TAMBAH</a>
                </div>
                <div class="card-body">
                    <x-datatable :tableId="'classroom'" :tableHeaders="['Tahun Akademik', 'Tingkat', 'Kelas', 'Aksi']" 
                    :tableColumns="[
                        ['data' => 'academic_year.academic_year_name'], 
                        ['data' => 'grade.grade_name'],  
                        ['data' => 'name'], 
                        ['data' => 'action']
                    ]" :getDataUrl="route('datatable.classroom')" />
                </div>
            </div>
        </div>
        {{-- END table Grade --}}
    </div>
    {{-- END ROW --}}

@endsection
