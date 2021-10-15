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
                                <h3 class="card-title">User</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 500px;">
                                        <form action="/planvisit" class="d-inline-flex">
                                            <input class="form-control float-right" type="month" id="tanggal" name="tanggal"
                                                placeholder="Tanggal">
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
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0" style="height: 500px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Outlet</th>
                                        <th>Kode Outlet</th>
                                        <th>Tanggal Visit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($planVisits as $planVisit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $planVisit->user->nama_lengkap }}</td>
                                            <td>{{ $planVisit->outlet->nama_outlet }}</td>
                                            <td>{{ $planVisit->outlet->kode_outlet }}</td>
                                            <td>{{ date('d M Y', $planVisit->tanggal_visit / 1000) }}</td>
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
