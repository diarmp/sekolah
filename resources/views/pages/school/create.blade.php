@extends('layout.master-page')

@section('content')
  {{-- start ROW --}}

  <div class="row">

    {{-- start table academy years --}}
    <div class="col-lg-6">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-primary font-weight-bold">{{ $title }}</h1>
        <a href="{{ route('schools.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-default shadow-sm">
            Kembali
          </a>
      </div>
      <div class="card">
        <div class="card-body">
          <form action="{{ route('schools.store') }}" method="post">
            @csrf

            <div class="form-group">
              <label for="school-select">Yayasan</label>
              <select class="form-control @error('school_id') is-invalid @enderror" name="school_id" id="school-select">
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
              <label for="name-input">Nama Sekolah</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                id="name-input" autocomplete="off">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="pic_name-input">Nama PIC</label>
              <input type="text" class="form-control @error('pic_name') is-invalid @enderror" name="pic_name"
                id="pic_name-input" autocomplete="off">
              @error('pic_name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="pic_email-input">Email PIC</label>
              <input type="email" class="form-control @error('pic_email') is-invalid @enderror" name="pic_email"
                id="pic_email-input" autocomplete="off">
              @error('pic_email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-default">Batal</button>
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
    $(document).ready(function() {
      let h6 = $('h6.text-primary')
      let labelNamaSekolah = $('label[for="name-input"]')

      labelNamaSekolah.text("Nama Yayasan");
      h6.text("Yayasan Baru");

      $('#school-select').change(function() {
        labelNamaSekolah.text("Nama Yayasan");
        h6.text("Yayasan Baru");
        if ($(this).val() !== '') {
          h6.text("Sekolah Baru");
          labelNamaSekolah.text("Nama Sekolah");
        }
      })
    });
  </script>
@endpush
