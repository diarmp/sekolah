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

                    <form action="{{ route('classroom.update', ['classroom' => $classroom->id]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="academic-year-select">Tahun Akademik</label>
                            <select class="form-control  @error('academic_year_id') is-invalid @enderror" name="academic_year_id"
                                id="academic-year-select">
                                <option value="">-</option>
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}" @if ($classroom->academic_year_id === $academicYear->id) selected @endif>
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
                            <select class="form-control  @error('grade_id') is-invalid @enderror" name="grade_id"
                                id="grade-select">
                                <option value="">-</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}" @if ($classroom->grade_id === $grade->id) selected @endif>
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
                            <label for="classroom-input">Kelas</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ $classroom->name }}" id="classroom-input" placeholder="">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
