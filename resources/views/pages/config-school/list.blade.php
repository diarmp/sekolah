@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>

                </div>
                <div class="card-body">
                    <form action="{{ route('config.save') }}" method="post">
                        @csrf
                        @foreach($data as $row)
                                <div class="form-group">
                                    <label for="config-school-input">{{$row->name}}</label>
                                    <input type="text" class="form-control @error('config.'.$row->code.'') is-invalid @enderror" name="config[{{$row->code}}]"
                                       value="{{($row->value==null)?old("config[".$row->code."]"):old("config[".$row->code."]",$row->value)}}" id="config-school-input">
                                    @error('config.'.$row->code.'')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}

@endsection
