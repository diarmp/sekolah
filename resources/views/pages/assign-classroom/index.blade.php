@extends('layout.master-page')

@push('css')
    <style>
        .row-flex {
            display: flex;
            flex-wrap: wrap;
        }
    </style>
@endpush

@section('content')
    <h1 class="h3 mb-4 text-gray-800">{{ $title }}</h1>

    <div class="row">
        {{-- START ASSIGN CLAASS --}}
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body ">
                    <div class="row flow-flex">
                        <div class="col-5 pr-0">
                            <x-datatable :tableId="'academy-year1'" :tableHeaders="['Sekolah', 'Tahun Akademik', 'Aksi']" :tableColumns="[
                                ['data' => 'school.name', 'name' => 'name'],
                                ['data' => 'name'],
                                ['data' => 'action'],
                            ]" :getDataUrl="route('datatable.academy-year')" />
                        </div>
                        <div class="col-1  d-flex flex-column text-center p-0 m-0 justify-content-around">
                            <span class="h4">
                                <=>
                            </span>
                            <span class="h4">
                                <=>
                            </span>
                        </div>
                        <div class="col-6">
                            <x-datatable :tableId="'academy-year'" :tableHeaders="['Sekolah', 'Tahun Akademik', 'Aksi']" :tableColumns="[
                                ['data' => 'school.name', 'name' => 'name'],
                                ['data' => 'name'],
                                ['data' => 'action'],
                            ]" :getDataUrl="route('datatable.academy-year')" />
                        </div>
                    </div>

                </div>
            </div>
            <div class="d-flex justify-content-end p-2 mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
        {{-- END ASSIGN CLASS --}}
    </div>
@endsection
