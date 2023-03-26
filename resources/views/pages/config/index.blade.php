@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-10">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
            <a href="{{ route('master-configs.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Config</a>
        </div>
            <div class="card">
                <!-- <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                    <a href="{{ route('master-configs.create') }}" class="btn btn-primary btn-sm">Tambah Configurasi</a>
                </div> -->
                <div class="card-body">
                    <x-datatable :id="'master-configs'" :headers="['Config Code', 'Name', ' ']" :url="route('datatable.master-configs')" />
                </div>
            </div>
        </div>
        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}

@endsection


@section('js')
    <script src="{{ asset('page/config/index.js') }}"></script>
@endsection
