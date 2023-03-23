@extends('layout.master-page')


@section('content')

    {{-- start ROW --}}

    <div class="row">

        {{-- start table grade --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>

                </div>
                <div class="card-body">

                    <form action="{{ route('grade.update', ['grade' => $grade->id]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="school-select">School</label>
                            <select class="form-control  @error('school_id') is-invalid @enderror" name="school_id"
                                id="school-select">
                                <option value="">-</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" @if ($grade->school_id === $school->id) selected @endif>
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
                            <label for="grade-input">Grade</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ $grade->name }}" id="grade-input" placeholder="5, 6, 7, etc">
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
