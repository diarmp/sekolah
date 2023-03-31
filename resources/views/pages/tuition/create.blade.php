@extends('layout.master-page')


@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table tuition type --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>

                </div>
                <div class="card-body">
                    <form action="{{ route('tuition.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="tuition-type-select">Tipe Biaya</label>
                            <select class="form-control @error('tuition_type_id') is-invalid @enderror" name="tuition_type_id"
                                id="tuition-type-select">
                                <option value="">-</option>
                                @foreach ($tuitionTypes as $tuitionType)
                                    <option value="{{ $tuitionType->id }}">
                                        {{ $tuitionType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tuition_type_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="academic-year-select">Tahun Akademik</label>
                            <select class="form-control @error('academic_year_id') is-invalid @enderror" name="academic_year_id"
                                id="academic-year-select">
                                <option value="">-</option>
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}">
                                        {{ $academicYear->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_year_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="grade-select">Tingkat</label>
                            <select class="form-control @error('grade_id') is-invalid @enderror" name="grade_id"
                                id="grade-select">
                                <option value="">-</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">
                                        {{ $grade->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="period">Periode</label>
                            <input type="month" name="period" id="period" value="{{ old('period') }}" class="form-control @error('period') is-invalid @enderror" required>
                            @error('period')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Nominal</label>
                            <input type="text" name="price" id="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required pattern="[0-9]+">
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
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
