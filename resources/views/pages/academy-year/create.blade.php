@extends('layout.master-page')



@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
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
                    <form action="{{ route('academy-year.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="hidden" name="school_id" value="{{ session('school_id') }}">
                            <label for="year-academy-input">Tahun Akademik</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" name="name" id="year-academy-input"
                                placeholder="2019 - 2020">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="year-academy-input">Status Tahun Ajaran</label>
                            <select name="status_years" id="" class="form-control">
                                <option value="">-</option>
                                @foreach ($academyYearStatus as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}
@endsection
