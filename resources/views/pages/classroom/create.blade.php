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
                    <form action="{{ route('classroom.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="school-select">Sekolah</label>
                            <select class="form-control @error('school_id') is-invalid @enderror" name="school_id"
                                id="school-select">
                                <option value="">-</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('school_id')
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
                            <label for="year-academy-input">Kelas</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="year-academy-input" placeholder="">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
