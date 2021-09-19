@extends('layout.template')

@section('title')
    Manajemen Grup | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Grup
@endsection

@section('navigasi-satu')
    Manajemen Grup
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-grup')
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
                    <h3 class="box-title center">Data Grup Non-Aktif</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Grup</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($grup as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->kode_grup }}</td>
                                    <td>{{ $data->nama_grup }}</td>
                                    <!-- Status Grup -->
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
                                            data-target="#modal-aktif{{ $data->kode_grup }}">
                                            <i class="fa fa-fw fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modals Aktif -->
                    @foreach ($grup as $data)
                        <div class="modal fade" id="modal-aktif{{ $data->kode_grup }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Aktifkan {{ $data->kode_grup }} </h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Anda yakin ingin <b> mengaktifkan </b> kembali data
                                            {{ $data->nama_grup }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/grup/aktif/{{ $data->kode_grup }}" class="btn btn-success">Ya!</a>
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
                <a class="btn btn-primary" href="/grup"> Kembali </a>
            </div>

        </div>
        <!-- /.row -->

    </section>
@endsection
