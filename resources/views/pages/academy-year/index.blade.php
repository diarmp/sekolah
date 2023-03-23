@extends('layout.master-page')

@section('title', 'Academy year')


@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
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


@push('js')
    <script src="{{ asset('page/academy-year/index.js') }}"></script>
@endpush
