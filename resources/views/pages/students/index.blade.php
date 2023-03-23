@extends('layout.master-page')

@section('title', 'Students')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>

    
    <div class="card shadow mb-4">

        {{-- Add Button --}}
        <div class="card-header py-3">
            <a href="{{ route('students.create') }}" class="btn btn-primary">Tambah Data Siswa</a>
        </div>
        {{-- End Add Button --}}

        
        <div class="card-body">

            <!-- Data Tables -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Tanggal lahir</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->nik }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ strtolower($student->gender) == 'l' ? 'Laki' : 'Perempuan' }}</td>
                            <td>{{ $student->address }}</td>
                            <td>{{ $student->dob }}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
            <!-- End DataTales -->
            
        </div>
    </div>
    
@endsection


@section('js')
<script>
  $(document).ready(function() {
    // $('#dataTable').DataTable();

    var table = $('#dataTable').DataTable(
    //     {
    //       processing: true,
    //       serverSide: true,
    //       ajax: "{{ route('students.datatable') }}",
    //       columns: [
    //           {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //           {data: 'name', name: 'name'},
    //           {data: 'adress', name: 'adress'},
    //           {data: 'dob', name: 'dob'},
    //           {data: 'religion', name: 'religion'},
    //           {data: 'phone_number', name: 'phone_number'},
    //           {
    //               data: 'action', 
    //               name: 'action', 
    //               orderable: true, 
    //               searchable: true
    //           },
    //       ]
    //   }
      );
  });
</script>
@endsection