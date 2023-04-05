@extends('layout.master-page')

@section('title', $title)

@section('content')

  <div class="row">
    <div class="col-lg-6">
      <div class="card accordion" id="accordionExample">

        <div class="card-header d-flex">
          <h6 class="mr-auto font-weight-bold text-primary">{{ $title }}</h6>
        </div>

        <form action="{{ route('students.update', $student->getKey()) }}" method="POST" class="p-3">
          @method('PUT')
          @csrf

          {{-- Informasi Siswa Accordion --}}
          <div class="card">

            {{-- Accordion Button --}}
            <div class="card-header" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#informationAccordion" aria-expanded="true" aria-controls="informationAccordion">
                  <span class="text-lg text-dark">Informasi Siswa</span>
                </button>
              </h2>
            </div>
            {{-- End Accordion Button --}}
            
            {{-- Accordion Content --}}
            <div id="informationAccordion" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                <div class="card-body">
        
                  {{-- Academic Year --}}
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="academic_year_id">Tahun Masuk Akademik<span class="text-small text-danger">*</span></label>
                        <select id="academic_year_id" name="academic_year_id" class="form-control select2 @error('academic_year_id') is-invalid @enderror" required>
                          <option value="">--- Pilih ---</option>
                          @foreach ($academic_years as $academic_year)
                            <option value="{{ $academic_year->id }}" @selected(old('academic_year_id', $academic_year->id) == $student->academic_year_id)>{{ $academic_year->name }}</option>
                          @endforeach
                        </select>
                        @error('academic_year_id')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  {{-- End Academic Year --}}
    
                  <div class="dropdown-divider"></div>
                
                  {{-- Name & Day Of Birth --}}
                  <div class="row">
        
                    {{-- Name --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="name">Nama<span class="text-small text-danger">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End Name --}}
                    
                    {{-- Date Of Birth --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="dob">Tanggal Lahir<span class="text-small text-danger">*</span> </label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob', $student->dob) }}" class="form-control @error('dob') is-invalid @enderror" required>
                        @error('dob')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End Date Of Birth --}}
        
                  </div>
                  {{-- End Name & Date Of Birth --}}
        
                  {{-- Gender & Religion --}}
                  <div class="row">
        
                    {{-- Gender --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="gender">Jenis Kelamin<span class="text-small text-danger">*</span></label>
                        <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                          <option value="">--- Pilih ---</option>
                          <option value="L" @selected(old('gender', $student->gender) == 'L')>Laki</option>
                          <option value="P" @selected(old('gender', $student->gender) == 'P')>Perempuan</option>
                        </select>
                        @error('gender')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End Gender --}}
                    
                    {{-- Religion --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="religion">Agama<span class="text-small text-danger">*</span></label>
                        <select id="religion" name="religion" class="form-control @error('religion') is-invalid @enderror" required>
                          <option value="">--- Pilih ---</option>
                          <option value="islam" @selected(old('religion', $student->religion) == 'islam')>Islam</option>
                          <option value="protestan" @selected(old('religion', $student->religion) == 'protestan')>Protestan</option>
                          <option value="katolik" @selected(old('religion', $student->religion) == 'katolik')>Katolik</option>
                          <option value="hindu" @selected(old('religion', $student->religion) == 'hindu')>Hindu</option>
                          <option value="buddha" @selected(old('religion', $student->religion) == 'buddha')>Buddha</option>
                          <option value="khonghucu @selected(old('religion', $student->religion) == 'khonghucu')">Khonghucu</option>
                        </select>
                        @error('religion')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End Religion --}}
                    
                  </div>
                  {{-- End Gender & Address --}}

                  {{-- No Kartu Keluarga & Email --}}
                  <div class="row">
          
                    {{-- KK --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="no_kartu_keluarga">Nomor Kartu Keluarga<span class="text-small text-danger">*</span></label>
                        <input type="number" name="no_kartu_keluarga" id="no_kartu_keluarga" value="{{ old('no_kartu_keluarga', $student->no_kartu_keluarga) }}" class="form-control @error('no_kartu_keluarga') is-invalid @enderror" required>
                        @error('no_kartu_keluarga')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End KK --}}
        
                    {{-- Email --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" value="{{ old('email', $student->email) }}" id="email" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End Email --}}
                    
                  </div>
                  {{-- End No Kartu Keluarga & Email --}}
        
                  {{-- NIK & Phone --}}
                  <div class="row">
        
                    {{-- NIK --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="nik">Nik<span class="text-small text-danger">*</span></label>
                        <input type="number" name="nik" id="nik" value="{{ old('nik', $student->nik) }}" class="form-control @error('nik') is-invalid @enderror" required>
                        @error('nik')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End NIK --}}
        
                    {{-- Phone --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="phone">No Telepon</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}" id="phone" class="form-control @error('phone_number') is-invalid @enderror">
                        @error('phone_number')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End Phone --}}
                    
                  </div>
                  {{-- End NIK & Phone --}}
    
                  {{-- NIS & NISN --}}
                  <div class="row">
        
                    {{-- NIS --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="nis">NIS</label>
                        <input type="number" name="nis" id="nis" value="{{ old('nis', $student->nis) }}" class="form-control @error('nis') is-invalid @enderror">
                        @error('nis')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End NIS --}}
        
                    {{-- NISN --}}
                    <div class="col">
                      <div class="form-group">
                        <label for="nisn">NISN</label>
                        <input type="number" name="nisn" value="{{ old('nisn', $student->nisn) }}" id="nisn" class="form-control @error('nisn') is-invalid @enderror">
                        @error('nisn')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                    {{-- End NISN --}}
                    
                  </div>
                  {{-- End NIS & NISN --}}
        
                  {{-- Address --}}
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="address">Address<span class="text-small text-danger">*</span></label>
                        <textarea name="address" id="address" rows="4" class="form-control @error('address') is-invalid @enderror" required>{{ old('address', $student->address) }}</textarea>
                        @error('address')
                          <div class="invalid-feedback">
                              {{ $message }}
                          </div>
                        @enderror
                      </div>
                    </div>
                  </div>
                  {{-- End Address --}}
        
                  <div class="dropdown-divider"></div>
    
                  {{-- Father Information Section --}}

                    {{-- Name --}}
                    <div class="row">
          
                      {{-- Name --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="father_name">Nama Ayah<span class="text-small text-danger">*</span></label>
                          <input type="text" name="father_name" id="father_name" value="{{ old('father_name', $student->father_name) }}" class="form-control @error('father_name') is-invalid @enderror" required>
                          @error('father_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Name --}}
                      
                    </div>
                    {{-- End Name --}}
    
                    {{-- Work & Phone --}}
                    <div class="row">
          
                      {{-- Work --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="father_work">Pekerjaan Ayah</label>
                          <input type="text" name="father_work" id="father_work" value="{{ old('father_work', $student->father_work) }}" class="form-control @error('father_work') is-invalid @enderror">
                          @error('father_work')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Work --}}
                      
                      {{-- Phone --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="father_phone_number">No Telpon Ayah</label>
                          <input type="text" name="father_phone_number" value="{{ old('father_phone_number', $student->father_phone_number) }}" id="father_phone_number" class="form-control @error('father_phone_number') is-invalid @enderror">
                          @error('father_phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Phone --}}
          
                    </div>
                    {{-- End Work & Phone --}}

                    {{-- Address --}}
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="father_address">Alamat Ayah<span class="text-small text-danger">*</span></label>
                          <textarea name="father_address" id="father_address" rows="4" class="form-control @error('father_address') is-invalid @enderror" required>{{ old('father_address', $student->father_address) }}</textarea>
                          @error('father_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    {{-- End Address --}}
    
                  {{-- Father Information Section --}}
    
                  <div class="dropdown-divider"></div>
    
                  {{-- Mother Information Section --}}

                    {{-- Name --}}
                    <div class="row">
          
                      {{-- Name --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="mother_name">Nama Ibu<span class="text-small text-danger">*</span></label>
                          <input type="text" name="mother_name" id="mother_name" value="{{ old('mother_name', $student->mother_name) }}" class="form-control @error('mother_name') is-invalid @enderror" required>
                          @error('mother_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Name --}}
                      
                    </div>
                    {{-- End Name --}}
    
                    {{-- Work & Phone --}}
                    <div class="row">
          
                      {{-- Work --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="mother_work">Pekerjaan Ibu</label>
                          <input type="text" name="mother_work" id="mother_work" value="{{ old('mother_work', $student->mother_work) }}" class="form-control @error('mother_work') is-invalid @enderror">
                          @error('mother_work')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Work --}}
                      
                      {{-- Phone --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="mother_phone_number">No Telpon Ibu</label>
                          <input type="text" name="mother_phone_number" value="{{ old('mother_phone_number', $student->mother_phone_number) }}" id="mother_phone_number" class="form-control @error('mother_phone_number') is-invalid @enderror">
                          @error('mother_phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Phone --}}
          
                    </div>
                    {{-- End Work & Phone --}}
    
                    {{-- Address --}}
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="mother_address">Alamat Ibu<span class="text-small text-danger">*</span></label>
                          <textarea name="mother_address" id="mother_address" rows="4" class="form-control @error('mother_address') is-invalid @enderror" required>{{ old('mother_address', $student->mother_address) }}</textarea>
                          @error('mother_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    {{-- End Address --}}
    
                  {{-- Mother Information Section --}}
    
                  <div class="dropdown-divider"></div>
    
                  {{-- Guardian Information Section --}}

                    {{-- Name --}}
                    <div class="row">
          
                      {{-- Name --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="guardian_name">Nama Wali</label>
                          <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="form-control @error('guardian_name') is-invalid @enderror">
                          @error('guardian_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Name --}}
                      
                    </div>
                    {{-- End Name --}}
    
                    {{-- Work & Phone --}}
                    <div class="row">
          
                      {{-- Work --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="guardian_work">Pekerjaan Wali</label>
                          <input type="text" name="guardian_work" id="guardian_work" value="{{ old('guardian_work', $student->guardian_work) }}" class="form-control @error('guardian_work') is-invalid @enderror">
                          @error('guardian_work')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Work --}}
                      
                      {{-- Phone --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="guardian_phone_number">No Telpon Wali</label>
                          <input type="text" name="guardian_phone_number" value="{{ old('guardian_phone_number', $student->guardian_phone_number) }}" id="guardian_phone_number" class="form-control @error('guardian_phone_number') is-invalid @enderror">
                          @error('guardian_phone_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Phone --}}
          
                    </div>
                    {{-- End Work & Phone --}}
    
                    {{-- Address --}}
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="guardian_address">Alamat Wali<span class="text-small text-danger">*</span></label>
                          <textarea name="guardian_address" id="guardian_address" rows="4" class="form-control @error('guardian_address') is-invalid @enderror" required>{{ old('guardian_address', $student->guardian_address) }}</textarea>
                          @error('guardian_address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    {{-- End Address --}}
    
                  {{-- Guardian Information Section --}}
                    
                </div>
              </div>
            </div>
            {{-- End Accordion Content --}}

          </div>
          {{-- End Informasi Siswa Accordion --}}

          {{-- Tuitions Accordion --}}
          <div class="card">

            {{-- Accordion Button --}}
            <div class="card-header" id="headingTwo">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#tuitionAccordion" aria-expanded="true" aria-controls="tuitionAccordion">
                  <span class="text-lg text-dark">Biaya Sekolah Siswa</span>
                </button>
              </h2>
            </div>
            {{-- End Accordion Button --}}
            
            {{-- Accordion Content --}}
            <div id="tuitionAccordion" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body">
                <div class="card-body">

                  {{-- Selected Student Tuitions --}}
                  @foreach ($student_tuitions as $student_tuition)
                    <div class="form-group">
                      <label for="{{ $student_tuition->tuition_type->name }}">{{ $student_tuition->tuition_type->name }}</label>
                      <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="addon-wrapping">Rp</span>
                        </div>
                        <input type="number" name="selected_tuitions[{{ $student_tuition->id }}]" id="{{ $student_tuition->tuition_type->name }}" value="{{ $student_tuition->price }}" class="form-control">
                      </div>
                    </div>
                  @endforeach
                  {{-- End Selected Student Tuition --}}
    

                  {{-- Student Tuitions --}}
                  @foreach ($tuition_types as $tuition_type)
                    <div class="form-group">
                      <label for="{{ $tuition_type->name }}">{{ $tuition_type->name }}</label>
                      <div class="input-group flex-nowrap">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="addon-wrapping">Rp</span>
                        </div>
                        <input type="number" name="tuitions[{{ $tuition_type->id }}]" id="{{ $tuition_type->name }}" value="{{ $tuition_type->price }}" class="form-control">
                      </div>
                    </div>
                  @endforeach
                  {{-- End Student Tuitions --}}
                  
                </div>
              </div>
            </div>
            {{-- End Accordion Content --}}

          </div>
          {{-- End Tuitions Accordion --}}

          {{-- Submit Button --}}
          <div class="p-4">
            <button type="submit" class="btn btn-primary">Ubah</button>
          </div>
          {{-- End Submit Button --}}

        </form>

      </div>
    </div>
  </div>
    
@endsection