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
              <h3 class="card-title">Noo</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <form action="/noo" class="d-inline-flex">
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
                    <th>Dibuat</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nama Pemilik</th>
                    <th>KTP/NPWP</th>
                    <th>Nomer</th>
                    <th>Nomer Wakil</th>
                    <th>Kota</th>
                    <th>Region</th>
                    <th>Cluster</th>
                    <th>Foto Shop Sign</th>
                    <th>Foto Etalase</th>
                    <th>Foto Depan</th>
                    <th>Foto Kanan</th>
                    <th>Foto Kiri</th>
                    <th>Foto Belakang</th>
                    <th>Video</th>
                    <th>Oppo</th>
                    <th>Vivo</th>
                    <th>Samsung</th>
                    <th>Realme</th>
                    <th>Xiaomi</th>
                    <th>Frontliner</th>
                    <th>Lokasi</th>
                    <th>Limit</th>
                    <th>Status</th>
                    <th>Disetujui Oleh</th>
                    <th>Tanggal Disetujui</th>
                    <th>Ditolak Oleh</th>
                    <th>Tanggal Ditolak</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($noos as $noo)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d M Y',$noo->created_at/1000 )}}</td>
                        <td>{{ $noo->nama_outlet }}</td>
                        <td>{{ $noo->alamat_outlet }}</td>
                        <td>{{ $noo->nama_pemilik_outlet }}</td>
                        <td>{{ $noo->ktp_outlet }}</td>
                        <td>{{ $noo->nomer_tlp_outlet }}</td>
                        <td>{{ $noo->nomer_wakil_outlet }}</td>
                        <td>{{ $noo->kota }}</td>
                        <td>{{ $noo->region }}</td>
                        <td>{{ $noo->cluster->name }}</td>
                        <td><a href="{{ asset('storage/').'/'.$noo->poto_shop_sign}}">Lihat Foto</a></td>
                        <td><a href="{{ asset('storage/').'/'.$noo->poto_etalase}}">Lihat Foto</a></td>
                        <td><a href="{{ asset('storage/').'/'.$noo->poto_depan}}">Lihat Foto</a></td>
                        <td><a href="{{ asset('storage/').'/'.$noo->poto_kanan}}">Lihat Foto</a></td>
                        <td><a href="{{ asset('storage/').'/'.$noo->poto_kiri}}">Lihat Foto</a></td>
                        <td><a href="{{ asset('storage/').'/'.$noo->poto_belakang}}">Lihat Foto</a></td>
                        <td><a href="{{ asset('storage/').'/'.$noo->video}}">Lihat Video</a></td>
                        <td>{{ $noo->oppo }}</td>
                        <td>{{ $noo->vivo }}</td>
                        <td>{{ $noo->samsung }}</td>
                        <td>{{ $noo->realme }}</td>
                        <td>{{ $noo->xiaomi }}</td>
                        <td>{{ $noo->fl }}</td>
                        <td><a target="_blank" href="http://www.google.com/maps/place/{{ $noo->latlong}}">Lihat Lokasi</a></td>
                        <td>{{ $noo->limit ?? '-' }}</td>
                        <td>{{ $noo->status }}</td>
                        <td>{{ $noo->approved_by ?? '-' }}</td>
                        <td>{{ $noo->approved_at ?? '-' }}</td>
                        <td>{{ $noo->rejected_by ?? '-' }}</td>
                        <td>{{ $noo->rejected_at ?? '-' }}</td>
                        <td>{{ $noo->keterangan ?? '-' }}</td>
                        <td>
                            <a href="/noo/{{ $noo->id }}" class="badge bg-info"><span><i class="fas fa-eye"></i></span></a>
                            <a href="/noo/{{ $noo->id }}" class="badge bg-warning"><span><i class="fas fa-edit"></i></span></a>
                            <a href="/noo/{{ $noo->id }}" class="badge bg-danger"><span><i class="fas fa-times-circle"></i></span></a>

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