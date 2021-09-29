@extends('layout.main_tamplate')

@section('content')
<section class="content-header">
<!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="row d-inline-flex">
              <h3 class="card-title">Outlet</h3>
              <a href="/outlet/export"><button class="badge bg-success mx-3 elevation-0">EXPORT</button></a>
            </div>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <form action="/outlet" class="d-inline-flex">
                        <input type="text" name="search" class="form-control float-right" placeholder="Cari">
                         <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 500px;">
              <table class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                   <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nama Pemilik</th>
                    <th>Nomer</th>
                    <th>Region</th>
                    <th>Cluster</th>
                    <th>Radius</th>
                    <th>Lat Long</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($outlets as $outlet)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $outlet->nama_outlet }}</td>
                        <td>{{ $outlet->alamat_outlet }}</td>
                        <td>{{ $outlet->nama_pemilik_outlet }}</td>
                        <td>{{ $outlet->nomer_tlp_outlet }}</td>
                        <td>{{ $outlet->region }}</td>
                        <td>{{ $outlet->cluster->name }}</td>
                        <td>{{ $outlet->radius }}</td>
                        <td><a target="_blank" href="http://www.google.com/maps/place/{{ $outlet->latlong}}">Lihat Lokasi</a></td>
                        <td>{{ $outlet->status_outlet }}</td>
                        <td>
                            <a href="/outlet/{{ $outlet->id }}" class="badge bg-info"><span><i class="fas fa-eye"></i></span></a>
                            <a href="/outlet/{{ $outlet->id }}" class="badge bg-warning"><span><i class="fas fa-edit"></i></span></a>
                            <a href="/outlet/{{ $outlet->id }}" class="badge bg-danger"><span><i class="fas fa-times-circle"></i></span></a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
</section>
<!-- /.content -->
<!-- /.content-wrapper -->
@endsection