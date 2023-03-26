@extends('layout.master-page')



@section('content')
    {{-- start ROW --}}

    <div class="row">

        {{-- start table tuitions type --}}
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex">
                    <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>

                </div>
                <div class="card-body">

                    <form action="{{ route('tuition-type.update', ['tuition_type' => $tuitionType->id]) }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="school-select">Sekolah</label>
                            <select class="form-control  @error('school_id') is-invalid @enderror" name="school_id"
                                id="school-select">
                                <option value="">-</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}" @if ($tuitionType->school_id === $school->id) selected @endif>
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
                            <label for="year-academy-input">Tipe Biaya</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                value="{{ $tuitionType->name }}" id="year-academy-input">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-check my-2">
                            <input type="checkbox" class="form-check-input" name="generatable" value="1"
                                @if ($tuitionType->generatable == '1') checked @endif id="generatable-checkbox">
                            <label class="form-check-label" for="generatable-checkbox">Rutin</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- END table tuitions type --}}
    </div>
    {{-- END ROW --}}
@endsection
