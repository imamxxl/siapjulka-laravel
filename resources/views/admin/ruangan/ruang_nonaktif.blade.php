@extends('layout.template')

@section('title')
    Manajemen Ruang | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Ruang
@endsection

@section('navigasi-satu')
    Manajemen Ruang
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-ruang')
@endsection

@section('isi-konten')
    @if (session('pesan-sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses </h4>
            {{ session('pesan-sukses') }}
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title center">Data Ruang Non-Aktif</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Ruang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($ruang as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->kode_ruang }}</td>
                                    <td>{{ $data->nama_ruang }}</td>
                                    <!-- Status Ruang -->
                                    @if ($data->status == '1')
                                        <td>
                                            <span class="label label-success" data-id="{{ $data->status }}">Aktif</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="label label-danger" data-id="{{ $data->status }}">Nonaktif</span>
                                        </td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#modal-aktif{{ $data->kode_ruang }}">
                                            <i class="fa fa-fw fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modals Aktif -->
                    @foreach ($ruang as $data)
                        <div class="modal fade" id="modal-aktif{{ $data->kode_ruang }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Aktifkan {{ $data->nama_ruang }} </h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin <b> mengaktifkan </b> kembali data
                                            {{ $data->nama_ruang }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/ruang/aktif/{{ $data->kode_ruang }}" class="btn btn-success">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            
            <div>
                <a class="btn btn-primary" href="/ruang"> Kembali </a>
            </div>

        </div>
        <!-- /.row -->

    </section>

@endsection
