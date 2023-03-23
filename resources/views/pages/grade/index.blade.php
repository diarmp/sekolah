@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table Grade --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                    <a href="{{ route('grade.create') }}" class="btn btn-primary btn-sm">ADD</a>
                </div>
                <div class="card-body">
                    <x-datatable :tableId="'grade'" :tableHeaders="['School', 'Grade', 'Action']" :tableColumns="[['data' => 'school.name', 'name' => 'name'], ['data' => 'name'], ['data' => 'action']]" :getDataUrl="route('datatable.grade')" />
                </div>
            </div>
        </div>
        {{-- END table Grade --}}
    </div>
    {{-- END ROW --}}

@endsection
