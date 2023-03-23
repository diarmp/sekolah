@extends('layout.master-page')

@section('title', 'Academy year')


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

                    <form action="{{ route('academy-year.update', ['academy_year' => $academyYear->id]) }}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="school-select">School</label>
                            <select class="form-control  @error('school_id') is-invalid @enderror" name="school_id"
                                id="school-select">
                                <option value="">-</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" @if ($academyYear->school_id === $school->id) selected @endif>
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
                            <label for="year-academy-input">Years Academy</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ $academyYear->name }}" id="year-academy-input" placeholder="20XX - 20XX">
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
