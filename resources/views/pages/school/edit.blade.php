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
          <form action="{{ route('schools.update', $school->getKey()) }}" method="post">
            @csrf
            @method('put')
            

            <div class="form-group">
              <label for="name-input">Nama Sekolah</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                id="name-input" autocomplete="off" value="{{ old('name', $school->name) }}">
              @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="school-select">Tingkatan Sekolah</label>
              <select class="form-control @error('grade') is-invalid @enderror" name="grade" >
                <option value="-">-</option>
                @foreach ($grade as $row)
                  <option value="{{$row}}" @selected(old('grade', $row) == $school->grade)>
                    {{ $row }}
                  </option>
                @endforeach
              </select>
              @error('owner')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="name-input">Alamat</label>
              <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                id="name-input" autocomplete="off" value="{{ old('address', $school->address) }}">
              @error('address')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="name-input">Kota / Kabupaten</label>
              <input type="text" class="form-control @error('city') is-invalid @enderror" name="city"
                id="name-input" autocomplete="off" value="{{ old('city', $school->city) }}">
              @error('city')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="name-input">Provinsi</label>
              <input type="text" class="form-control @error('province') is-invalid @enderror" name="province"
                id="name-input" autocomplete="off" value="{{ old('province', $school->province) }}">
              @error('province')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="name-input">No Telepon</label>
              <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                id="name-input" autocomplete="off" value="{{ old('phone', $school->phone) }}">
              @error('phone')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="name-input">Email</label>
              <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                id="name-input" autocomplete="off" value="{{ old('email', $school->email) }}">
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label for="school-select">Pemilik</label>
              <select class="form-control @error('owner') is-invalid @enderror" name="owner" >
                <option value="-">-</option>
                @foreach ($owner as $row)
                  <option value="{{$row->id}}" @selected(old('owner', $row->id) == $school->owner_id)>
                    {{ $row->name }}
                  </option>
                @endforeach
              </select>
              @error('owner')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            

            <div class="form-group">
              <label for="user_id-select">Nama PIC</label>
              <input type="text" readonly class="form-control-plaintext" id="staticUserId"
                value="{{ $school->staf->name }}">
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
  {{-- <script>
    $(document).ready(function() {
      let h6 = $('h6.text-primary')
      let labelNamaSekolah = $('label[for="name-input"]')
      let opsiSekolah = $('#school-select');

      labelNamaSekolah.text("Nama Sekolah");
      h6.text("Ubah Sekolah");

      if (opsiSekolah.val() == "") {
        h6.text("Ubah Yayasan");
        labelNamaSekolah.text("Nama Yayasan");
      }

      opsiSekolah.change(function() {
        labelNamaSekolah.text("Nama Yayasan");
        h6.text("Ubah Yayasan");
        if ($(this).val() !== '') {
          h6.text("Ubah Sekolah");
          labelNamaSekolah.text("Nama Sekolah");
        }
      })
    });
  </script> --}}
@endpush
