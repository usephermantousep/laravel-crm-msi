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
              <h3 class="card-title">Visit</h3>
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
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Outlet</th>
                    <th>Tipe</th>
                    <th>Lokasi CI</th>
                    <th>Lokasi CO</th>
                    <th>Jam CI</th>
                    <th>Jam CO</th>
                    <th>Foto CI</th>
                    <th>Foto CO</th>
                    <th>Durasi</th>
                    <th>Laporan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d M Y',$visit->tanggal_visit/1000 )}}</td>
                        <td>{{ $visit->user->nama_lengkap }}</td>
                        <td>{{ $visit->outlet->nama_outlet }}</td>
                        <td>{{ $visit->tipe_visit }}</td>
                        <td><a target="_blank" href="http://www.google.com/maps/place/{{ $visit->latlong_in }}">Lihat Lokasi</a></td>
                        @if ($visit->latlong_out)
                            <td><a target="_blank" href="http://www.google.com/maps/place/{{ $visit->latlong_out }}">Lihat Lokasi</a></td>
                        @else
                            <td>-</td>  
                        @endif
                            <td>{{ date('H:i',$visit->check_in_time/1000 )}}</td>
                        @if ($visit->check_out_time)
                            <td>{{ date('H:i',$visit->check_out_time/1000 )}}</td>
                        @else
                            <td>-</td>
                        @endif
                        <td><a href="{{ asset('storage/').'/'.$visit->picture_visit_in }}">Lihat Foto</a></td>
                        @if ($visit->picture_visit_out)
                        <td><a href="{{ asset('storage/').'/'.$visit->picture_visit_out }}">Lihat Foto</a></td>
                        @else
                        <td>-</td>
                        @endif
                        <td>{{ $visit->durasi_visit ." Menit" ?? '-' }}</td>
                        <td>{{ $visit->laporan_visit ?? '-' }}</td>
                        <td>
                            <a href="/visit/{{ $visit->id }}" class="badge bg-info"><span><i class="fas fa-eye"></i></span></a>
                            <a href="/visit/{{ $visit->id }}" class="badge bg-warning"><span><i class="fas fa-edit"></i></span></a>
                            <a href="/visit/{{ $visit->id }}" class="badge bg-danger"><span><i class="fas fa-times-circle"></i></span></a>

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