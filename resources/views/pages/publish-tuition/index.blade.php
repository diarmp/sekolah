@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table Publish Tuition --}}
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('publish-tuition.store') }}" method="post">
                        @csrf
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>
                                        <button type="submit" class="btn btn-primary float-right">Terbitkan</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tuitions as $tuition)
                                    <tr>
                                        <td>
                                            <label for="checkbox{{$tuition->id}}">{{$tuition->period}}</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="periods[]" id="checkbox{{$tuition->id}}" value="{{$tuition->id}}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        {{-- END table Publish Tuition --}}
    </div>
    {{-- END ROW --}}

@endsection
