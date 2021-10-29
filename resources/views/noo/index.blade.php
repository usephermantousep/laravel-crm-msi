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
                                    <h3 class="card-title">Noo</h3>
                                    <a href="/noo/export"><button class="badge bg-success mx-3 elevation-0">EXPORT
                                            ALL</button></a>
                                </div>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <form action="/noo" class="d-inline-flex">
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
                                        <th>Tanggal Dibuat</th>
                                        <th>Dibuat oleh</th>
                                        <th>Kode Outlet</th>
                                        <th>Divisi</th>
                                        <th>Badan Usaha</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Nama Pemilik</th>
                                        <th>KTP/NPWP</th>
                                        <th>Nomer</th>
                                        <th>Nomer Wakil</th>
                                        <th>Distric</th>
                                        <th>Region</th>
                                        <th>Cluster</th>
                                        <th>Foto KTP/NPWP</th>
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
                                        <th>Dikonfirmasi Oleh</th>
                                        <th>Tangggal Dikonfirmasi</th>
                                        <th>Disetujui Oleh</th>
                                        <th>Tanggal Disetujui</th>
                                        <th>Ditolak Oleh</th>
                                        <th>Tanggal Ditolak</th>
                                        <th>Keterangan</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($noos as $noo)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d M Y', $noo->created_at / 1000) }}</td>
                                            <td>{{ $noo->created_by }}</td>
                                            <td>{{ $noo->kode_outlet ?? '-' }}</td>
                                            <td>{{ $noo->divisi->name }}</td>
                                            <td>{{ $noo->badanusaha->name }}</td>
                                            <td>{{ $noo->nama_outlet }}</td>
                                            <td>{{ $noo->alamat_outlet }}</td>
                                            <td>{{ $noo->nama_pemilik_outlet }}</td>
                                            <td>{{ $noo->ktp_outlet }}</td>
                                            <td>{{ $noo->nomer_tlp_outlet }}</td>
                                            <td>{{ $noo->nomer_wakil_outlet ?? '-' }}</td>
                                            <td>{{ $noo->distric }}</td>
                                            <td>{{ $noo->region->name }}</td>
                                            <td>{{ $noo->cluster->name }}</td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_ktp }}">Lihat Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_shop_sign }}">Lihat
                                                    Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_etalase }}">Lihat
                                                    Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_depan }}">Lihat Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_kanan }}">Lihat Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_kiri }}">Lihat Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->poto_belakang }}">Lihat
                                                    Foto</a>
                                            </td>
                                            <td><a href="{{ asset('storage/') . '/' . $noo->video }}">Lihat Video</a>
                                            </td>
                                            <td>{{ $noo->oppo }}</td>
                                            <td>{{ $noo->vivo }}</td>
                                            <td>{{ $noo->samsung }}</td>
                                            <td>{{ $noo->realme }}</td>
                                            <td>{{ $noo->xiaomi }}</td>
                                            <td>{{ $noo->fl }}</td>
                                            <td><a target="_blank"
                                                    href="http://www.google.com/maps/place/{{ $noo->latlong }}">Lihat
                                                    Lokasi</a></td>
                                            <td>Rp {{ number_format($noo->limit, 0, ',', '.') }}</td>
                                            <td>{{ $noo->status }}</td>
                                            <td>{{ $noo->confirmed_by ?? '-' }}</td>
                                            <td>{{ $noo->confirmed_at == null ? '-' : date('d M Y', $noo->confirmed_at / 1000) }}
                                            <td>{{ $noo->approved_by ?? '-' }}</td>
                                            <td>{{ $noo->approved_at == null ? '-' : date('d M Y', $noo->approved_at / 1000) }}
                                            </td>
                                            <td>{{ $noo->rejected_by ?? '-' }}</td>
                                            <td>{{ $noo->rejected_at == null ? '-' : date('d M Y', $noo->rejected_at / 1000) }}
                                            </td>
                                            <td>{{ $noo->keterangan ?? '-' }}</td>
                                            @if ($noo->status != 'APPROVED')
                                                <td>
                                                    <a href="/noo/{{ $noo->id }}" class="badge bg-warning"><span><i
                                                                class="fas fa-edit"></i></span></a>
                                                </td>
                                            @endif

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
