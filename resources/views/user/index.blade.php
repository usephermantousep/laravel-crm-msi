@extends('layout.main_tamplate')

@section('content')
    <section class="content-header">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <div class="row d-inline-flex">
                                    <h3 class="card-title">User</h3>
                                    <button type="button" data-toggle="modal" data-target="#addUser"
                                        class="badge bg-success mx-3 elevation-0">Add</button>
                                </div>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <form action="/user" class="d-inline-flex">
                                            <input type="text" name="search" class="form-control float-right"
                                                placeholder="Cari">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>User Name</th>
                                        <th>Role</th>
                                        <th>Badan Usaha</th>
                                        <th>Divisi</th>
                                        <th>Region</th>
                                        <th>Cluster</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nama_lengkap }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->role->name }}</td>
                                            <td>{{ $user->badanusaha->name }}</td>
                                            <td>{{ $user->divisi->name }}</td>
                                            <td>{{ $user->region->name }}</td>
                                            <td>{{ $user->cluster->name }}</td>
                                            <td>
                                                <a href="/user/{{ $user->id }}" class="badge bg-warning"><span><i
                                                            class="fas fa-edit"></i></span></a>
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


    <!-- Modal -->
    <form action="/user" method="POST">
        @csrf
        <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserLabel">Add User</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3 ">
                            <label for="username" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="role_id" class="form-label col-lg-12">Role</label>
                                    <select class="custom-select col-lg-12" name="role_id" id="role_id" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="badanusaha_id" class="form-label col-lg-12">Badan Usaha</label>
                                    <select class="custom-select col-lg-12" id="badanusaha_id" name="badanusaha_id"
                                        required>
                                        @foreach ($badanusahas as $badanusaha)
                                            <option value="{{ $badanusaha->id }}">{{ $badanusaha->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="divisi_id" class="form-label col-lg-12">Divisi</label>
                                    <select class="custom-select col-lg-12" id="divisi_id" name="divisi_id" required>
                                        @foreach ($divisis as $divisi)
                                            <option value="{{ $divisi->id }}">{{ $divisi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="region_id" class="form-label col-lg-12">Region</label>
                                    <select class="custom-select col-lg-12" name="region_id" id="region_id" required>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="cluster_id" class="form-label col-lg-12">Cluster</label>
                                    <select class="custom-select col-lg-12" id="cluster_id" name="cluster_id" required>
                                        @foreach ($clusters as $cluster)
                                            <option value="{{ $cluster->id }}">{{ $cluster->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
