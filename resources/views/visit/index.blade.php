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
                                    <h3 class="card-title">Visit</h3>
                                    <button type="button" data-toggle="modal" data-target="#exportdate"
                                        class="badge bg-success mx-3 elevation-0">EXPORT</button>
                                </div>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <form action="/outlet" class="d-inline-flex">
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
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Outlet</th>
                                        <th>Divisi</th>
                                        <th>Region</th>
                                        <th>Cluster</th>
                                        <th>Tipe</th>
                                        <th>Lokasi CI</th>
                                        <th>Lokasi CO</th>
                                        <th>Jam CI</th>
                                        <th>Jam CO</th>
                                        <th>Foto CI</th>
                                        <th>Foto CO</th>
                                        <th>Transaksi</th>
                                        <th>Durasi</th>
                                        <th>Laporan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visits as $visit)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d M Y', $visit->tanggal_visit / 1000) }}</td>
                                            <td>{{ $visit->user->nama_lengkap ?? '-' }}</td>
                                            <td>{{ $visit->outlet->nama_outlet ?? '-' }}</td>
                                            <td>{{ $visit->outlet->divisi->name ?? '-' }}</td>
                                            <td>{{ $visit->outlet->region->name ?? '-' }}</td>
                                            <td>{{ $visit->outlet->cluster->name ?? '-' }}</td>
                                            <td>{{ $visit->tipe_visit }}</td>
                                            <td><a target="_blank"
                                                    href="http://www.google.com/maps/place/{{ $visit->latlong_in }}">Lihat
                                                    Lokasi</a></td>
                                            @if ($visit->latlong_out)
                                                <td><a target="_blank"
                                                        href="http://www.google.com/maps/place/{{ $visit->latlong_out }}">Lihat
                                                        Lokasi</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ date('H:i', $visit->check_in_time / 1000) }}</td>
                                            @if ($visit->check_out_time)
                                                <td>{{ date('H:i', $visit->check_out_time / 1000) }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td><a href="{{ asset('storage/') . '/' . $visit->picture_visit_in }}">Lihat
                                                    Foto</a></td>
                                            @if ($visit->picture_visit_out)
                                                <td><a href="{{ asset('storage/') . '/' . $visit->picture_visit_out }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ $visit->transaksi }}</td>
                                            <td>{{ $visit->durasi_visit ? $visit->durasi_visit . ' Menit' : '0 Menit ' }}
                                            </td>
                                            <td>{{ $visit->laporan_visit ?? '-' }}</td>
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
<div class="d-flex justify-content-center">
    {{ $visits->links() }}
</div>
            </div><!-- /.container-fluid -->
        </section>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exportdate" tabindex="-1" role="dialog" aria-labelledby="exportdateLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="GET" action="/visit/export">
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
