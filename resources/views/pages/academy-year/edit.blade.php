@extends('layout.master-page')



@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table academy years --}}
        <div class="col-lg-6">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
                <a href="{{ route('academy-year.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-default shadow-sm">
                    Kembali
                </a>
            </div>

            @error('school_id')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('academy-year.update', ['academy_year' => $academyYear->id]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="school_id" value="{{ session('school_id') }}">
                        <div class="form-group">
                            <label for="year-academy-input">Tahun Akademik</label>
                            <input type="hidden" class="form-control  @error('academic_year_name') is-invalid @enderror"
                                name="academic_year_name" value="{{ $academyYear->academic_year_name }}"
                                id="year-academy-input" placeholder="20XX - 20XX">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">Start</span>
                                        </div>
                                        <input type="date" class="form-control" name="year_start"
                                            value="{{ $academyYear->year_start }}" id="year_start"
                                            placeholder="awal periode akademik">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">End</span>
                                        </div>
                                        <input type="date" class="form-control " name="year_end"
                                            value="{{ $academyYear->year_end }}"id="year_end"
                                            placeholder="awal periode akademik">
                                    </div>
                                </div>
                            </div>
                            @error('academic_year_name')
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
                                    <option value="{{ $key }}"
                                        {{ $academyYear->status_years === $key ? 'selected' : '' }}>{{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}
@endsection
@push('js')
    <script>
        $("#year_end").change(function() {
            let get_year_start = $('#year_start').val()
            let transformDateStart = new Date(get_year_start)

            let get_year_end = $(this).val()
            let transformDateEND = new Date(get_year_end)
            let academyYear = transformDateStart.getFullYear() + " - " + transformDateEND.getFullYear()

            $("#year-academy-input").val(academyYear);

        });
    </script>
@endpush
