@extends('layout.master-page')

@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-6">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('master-configs.update', ['master_config' => $master_config->id]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="code-config-input">Configuration Code</label>
                            <input type="text" class="form-control  @error('code') is-invalid @enderror" name="code"
                                value="{{ old('code',$master_config->code) }}" id="code-config-input" placeholder="001 / A001" readonly>
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name-config-input">Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name',$master_config->name) }}" id="name-config-input" placeholder="Config 1 / Setup Config 1">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}

@endsection
