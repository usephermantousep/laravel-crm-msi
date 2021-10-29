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
                                    <h3 class="card-title">Outlet</h3>
                                    <a href="/outlet/export"><button class="badge bg-primary mx-3 elevation-0">EXPORT
                                            ALL</button></a>
                                    <a href="#"><button class="badge bg-success mx-3 elevation-0" data-toggle="modal"
                                            data-target="#importOutlet">IMPORT</button></a>
                                    <a href="/outlet/export/template"><button
                                            class="badge bg-warning mx-3 elevation-0">TEMPLATE IMPORT</button></a>
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
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
                                        <th>Kode Outlet</th>
                                        <th>Badan Usaha</th>
                                        <th>Divisi</th>
                                        <th>Region</th>
                                        <th>Cluster</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Distric</th>
                                        <th>Nama Pemilik</th>
                                        <th>Nomer Telepon</th>
                                        <th>Radius</th>
                                        <th>Limit</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>TM</th>
                                        <th>DSC</th>
                                        <th>DSF</th>
                                        <th>Foto KTP</th>
                                        <th>Foto Shop Sign</th>
                                        <th>Foto Etalase</th>
                                        <th>Foto Depan</th>
                                        <th>Foto Kiri</th>
                                        <th>Foto Kanan</th>
                                        <th>Foto Belakang</th>
                                        <th>Video</th>
                                        <th>Tanggal Registrasi</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($outlets as $outlet)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $outlet->kode_outlet }}</td>
                                            <td>{{ $outlet->badanusaha->name }}</td>
                                            <td>{{ $outlet->divisi->name }}</td>
                                            <td>{{ $outlet->region->name }}</td>
                                            <td>{{ $outlet->cluster->name }}</td>
                                            <td>{{ $outlet->nama_outlet }}</td>
                                            <td>{{ $outlet->alamat_outlet }}</td>
                                            <td>{{ $outlet->distric }}</td>
                                            <td>{{ $outlet->nama_pemilik_outlet ?? '-' }}</td>
                                            <td>{{ $outlet->nomer_tlp_outlet ?? '-' }}</td>
                                            <td>{{ $outlet->radius }}</td>
                                            <td>Rp {{ number_format($outlet->limit, 0, ',', '.') }}</td>

                                            @if ($outlet->latlong)
                                                <td>
                                                    <a target="_blank"
                                                        href="http://www.google.com/maps/place/{{ $outlet->latlong }}">Lihat
                                                        Lokasi
                                                    </a>
                                                </td>

                                            @else
                                                <td>
                                                    -
                                                </td>
                                            @endif

                                            <td>{{ $outlet->status_outlet }}</td>
                                            <td>{{ $users->where('divisi_id', $outlet->divisi_id)->where('region_id', $outlet->region_id)->where('cluster_id', $outlet->cluster_id)->where('role_id', 3)->first()->tm->nama_lengkap ?? '-' }}
                                            </td>
                                            <td>{{ $users->where('divisi_id', $outlet->divisi_id)->where('region_id', $outlet->region_id)->where('role_id', 2)->first()->nama_lengkap ?? '-' }}
                                            </td>
                                            <td>{{ $users->where('divisi_id', $outlet->divisi_id)->where('region_id', $outlet->region_id)->where('cluster_id', $outlet->cluster_id)->where('role_id', 3)->first()->nama_lengkap ?? '-' }}
                                            </td>
                                            @if ($outlet->poto_ktp)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_ktp }}">Lihat
                                                        Foto</a>
                                                </td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->poto_shop_sign)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_shop_sign }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->poto_etalase)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_etalase }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->poto_depan)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_depan }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->poto_kiri)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_kiri }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->poto_kanan)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_kanan }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->poto_belakang)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->poto_belakang }}">Lihat
                                                        Foto</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            @if ($outlet->video)
                                                <td><a href="{{ asset('storage/') . '/' . $outlet->video }}">Lihat
                                                        Video</a></td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ date('d M Y', $outlet->created_at / 1000) }}</td>
                                            <td>
                                                <a href="/outlet/{{ $outlet->id }}" class="badge bg-warning"><span><i
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
    <!-- /.content-wrapper -->

    <!-- Modal -->
    <form action="/outlet/import" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="importOutlet" tabindex="-1" aria-labelledby="importOutletLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importOutletLabel">Import Outlet</h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 mt-3">
                            <label for="formFile" class="form-label">Pilih File</label>
                            <input class="form-control" type="file" id="formFile" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
