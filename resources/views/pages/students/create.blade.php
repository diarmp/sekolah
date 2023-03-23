@extends('layout.master-page')

@section('title', 'Students')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>

    <!-- DataTales -->
    <div class="card shadow mb-4">
      <div class="card-body">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>


          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <select id="partner_status" name="partner_status" class="select2 form-control" required>
                <option value="">Pilih ...</option>
                <option value="vendor">Pemasok</option>
                <option value="client">Pelanggan</option>
                <option value="both">Keduanya</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
    <!-- End DataTales -->
    
@endsection