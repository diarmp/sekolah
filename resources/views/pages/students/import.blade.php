@extends('layout.master-page')

@section('title', $title)

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Impor Data Siswa</h1>

    {{-- start Datatable --}}
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header d-flex">
                <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                <div class="">
                    <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                    {{-- <a href="{{ route('students.import') }}" class="btn btn-success btn-sm">Impor Excel</a> --}}
                </div>
            </div>

            <div class="card-body">
                <x-datatable 
                    :tableId="'students'" 
                    :tableHeaders="['NIK', 'Nama', 'Jenis Kelamin', 'Alamat', 'Tanggal lahir', 'Action']" 
                    :tableColumns="[
                        ['data' => 'nik'], 
                        ['data' => 'name'], 
                        ['data' => 'gender'],
                        ['data' => 'address'],
                        ['data' => 'dob'],
                        ['data' => 'action']
                    ]" 
                    :getDataUrl="route('datatable.students')" 
                />
            </div>
        </div>
    </div>
    {{-- END Datatable --}}
    
@endsection