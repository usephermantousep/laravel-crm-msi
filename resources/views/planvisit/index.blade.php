@extends('layout.main_tamplate')

@section('content')
    <section class="content-header">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark">
                            <h3 class="card-title">Plan Visit</h3>
                            <button type="button" data-toggle="modal" data-target="#exportdate"
                                class="badge bg-success mx-3 elevation-0">EXPORT</button>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <form action="/planvisit" class="d-inline-flex">
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

     <!-- Modal -->
     <div class="modal fade" id="exportdate" tabindex="-1" role="dialog" aria-labelledby="exportdateLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <form method="GET" action="/planvisit/export">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exportdateLabel">Export</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <div class="form-group">
                         <label for="tanggal1">Dari</label>
                         <input class="form-control" type="date" id="tanggal1" name="tanggal1" placeholder="Tanggal" required>
                     </div>
                     <div class="form-group">
                         <label for="tanggal2">Sampai</label>
                         <input class="form-control" type="date" id="tanggal2" name="tanggal2" placeholder="Tanggal" required>
                     </div>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Export</button>
                 </div>
             </form>

         </div>
     </div>
 </div>
    <!-- /.content -->
    <!-- /.content-wrapper -->
@endsection
