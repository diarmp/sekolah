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
                    <form action="{{ route('grade.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="grade-input">Grade</label>
                            <input type="text" class="form-control @error('grade_name') is-invalid @enderror" name="grade_name"
                                id="grade-input" placeholder="1, 2, 3, dsb">
                            @error('grade_name')
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

        {{-- END table academy years --}}
    </div>
    {{-- END ROW --}}

@endsection
