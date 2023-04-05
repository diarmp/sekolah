@extends('layout.master-page')


@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table tuition type --}}
        <div class="col-lg-6">
            @error('school_id')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>

                </div>
                <div class="card-body">
                    <form action="{{ route('tuition-type.store') }}" method="post">
                        @csrf

                        <input type="hidden" name="school_id" value="{{ session('school_id') }}">
                        <div class="form-group">
                            <label for="tuition-type-input">Tipe Biaya</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="tuition-type-input">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check my-2">
                            <input type="checkbox" class="form-check-input" name="generatable" value="1"
                                id="generatable-checkbox">
                            <label class="form-check-label" for="generatable-checkbox">Rutin</label>
                        </div>

                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table tuition type --}}
    </div>
    {{-- END ROW --}}
@endsection
