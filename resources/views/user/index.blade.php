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
              <h3 class="card-title">User</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <form action="/user" class="d-inline-flex">
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
                    <th>User Name</th>
                    <th>Region</th>
                    <th>Cluster</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->region }}</td>
                        <td>{{ $user->cluster->name }}</td>
                        <td>{{ $user->roles }}</td>
                        <td>
                            <a href="/user/{{ $user->id }}" class="badge bg-info"><span><i class="fas fa-eye"></i></span></a>
                            <a href="/user/{{ $user->id }}" class="badge bg-warning"><span><i class="fas fa-edit"></i></span></a>
                            <a href="/user/{{ $user->id }}" class="badge bg-danger"><span><i class="fas fa-times-circle"></i></span></a>

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