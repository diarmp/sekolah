@extends('layout.master-page')

@section('title', 'Academy year')

@section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection


@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">Academy Year</h6>
                    <a href="{{ route('academy-year.create') }}" class="btn btn-primary btn-sm">ADD</a>
                </div>
                <div class="card-body">
                    <x-datatable :id="'academy-year'" :headers="['School', 'Academy Year', 'Action']" :url="route('datatable.academy-year')" />
                </div>
            </div>
        </div>
        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}

@endsection


@section('js')

    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('page/academy-year/index.js') }}"></script>


@endsection
