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

          {{-- Informasi Murid Accordion --}}
          <div class="card">

            {{-- Accordion Button --}}
            <div class="card-header" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#informationAccordion" aria-expanded="true" aria-controls="informationAccordion">
                  <span class="text-lg text-dark">Informasi Murid</span>
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
                        <label for="academic_year_id">Tahun Akademik<span class="text-small text-danger">*</span></label>
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
                    {{-- Name & Date Of Birth --}}
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
                      
                      {{-- Date Of Birth --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="father_dob">Tanggal Lahir Ayah<span class="text-small text-danger">*</span> </label>
                          <input type="date" name="father_dob" id="father_dob" value="{{ old('father_dob', $student->father_dob) }}" class="form-control @error('father_dob') is-invalid @enderror" required>
                          @error('father_dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Date Of Birth --}}
          
                    </div>
                    {{-- End Name & Date Of Birth --}}
    
                    {{-- Work & Education --}}
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
                      
                      {{-- Education --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="father_education">Edukasi Terakhir Ayah</label>
                          <input type="text" name="father_education" id="father_education" value="{{ old('father_education', $student->father_education) }}" class="form-control @error('father_education') is-invalid @enderror">
                          @error('father_education')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Education --}}
          
                    </div>
                    {{-- End Work & Education --}}
    
                    {{-- Income --}}
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="father_income">Pendapatan Ayah</label>
                          <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="addon-wrapping">Rp</span>
                            </div>
                            <input type="number" name="father_income" id="father_income" value="{{ old('father_income', $student->father_income) }}" class="form-control @error('father_income') is-invalid @enderror">
                          </div>
                          @error('father_income')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    {{-- End Income --}}
    
                  {{-- Father Information Section --}}
    
                  <div class="dropdown-divider"></div>
    
                  {{-- Mother Information Section --}}
                    {{-- Name & Date Of Birth --}}
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
                      
                      {{-- Date Of Birth --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="mother_dob">Tanggal Lahir Ibu<span class="text-small text-danger">*</span> </label>
                          <input type="date" name="mother_dob" id="mother_dob" value="{{ old('mother_dob', $student->mother_dob) }}" class="form-control @error('mother_dob') is-invalid @enderror" required>
                          @error('mother_dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Date Of Birth --}}
          
                    </div>
                    {{-- End Name & Date Of Birth --}}
    
                    {{-- Work & Education --}}
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
                      
                      {{-- Education --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="mother_education">Edukasi Terakhir Ibu</label>
                          <input type="text" name="mother_education" id="mother_education" value="{{ old('mother_education', $student->mother_education) }}" class="form-control @error('mother_education') is-invalid @enderror">
                          @error('mother_education')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Education --}}
          
                    </div>
                    {{-- End Work & Education --}}
    
                    {{-- Income --}}
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="mother_income">Pendapatan Ibu</label>
                          <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="addon-wrapping">Rp</span>
                            </div>
                            <input type="number" name="mother_income" id="mother_income" value="{{ old('mother_income', $student->mother_income) }}" class="form-control @error('mother_income') is-invalid @enderror">
                          </div>
                          
                          @error('mother_income')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    {{-- End Income --}}
    
                  {{-- Mother Information Section --}}
    
                  <div class="dropdown-divider"></div>
    
                  {{-- Guardian Information Section --}}
                    {{-- Name & Date Of Birth --}}
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
                      
                      {{-- Date Of Birth --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="guardian_dob">Tanggal Lahir Wali</label>
                          <input type="date" name="guardian_dob" id="guardian_dob" value="{{ old('guardian_dob', $student->guardian_dob) }}" class="form-control @error('guardian_dob') is-invalid @enderror">
                          @error('guardian_dob')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Date Of Birth --}}
          
                    </div>
                    {{-- End Name & Date Of Birth --}}
    
                    {{-- Work & Education --}}
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
                      
                      {{-- Education --}}
                      <div class="col">
                        <div class="form-group">
                          <label for="guardian_education">Edukasi Terakhir Wali</label>
                          <input type="text" name="guardian_education" id="guardian_education" value="{{ old('guardian_education', $student->guardian_education) }}" class="form-control @error('guardian_education') is-invalid @enderror">
                          @error('guardian_education')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                      {{-- End Education --}}
          
                    </div>
                    {{-- End Work & Education --}}
    
                    {{-- Income --}}
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="guardian_income">Pendapatan Wali</label>
                          <div class="input-group flex-nowrap">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="addon-wrapping">Rp</span>
                            </div>
                            <input type="number" name="guardian_income" id="guardian_income" value="{{ old('guardian_income', $student->guardian_income) }}" class="form-control @error('guardian_income') is-invalid @enderror">
                          </div>
                          
                          @error('guardian_income')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                          @enderror
                        </div>
                      </div>
                    </div>
                    {{-- End Income --}}
    
                  {{-- Guardian Information Section --}}
                    
                </div>
              </div>
            </div>
            {{-- End Accordion Content --}}

          </div>
          {{-- End Informasi Murid Accordion --}}

          {{-- Tuitions Accordion --}}
          <div class="card">

            {{-- Accordion Button --}}
            <div class="card-header" id="headingTwo">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#tuitionAccordion" aria-expanded="true" aria-controls="tuitionAccordion">
                  <span class="text-lg text-dark">Biaya Sekolah Murid</span>
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