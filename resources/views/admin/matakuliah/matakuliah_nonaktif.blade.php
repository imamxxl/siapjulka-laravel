@extends('layout.template')

@section('title')
    Manajemen Matakuliah | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Matakuliah
@endsection

@section('navigasi-satu')
    Manajemen Matakuliah
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-matakuliah')
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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title center">Data Matakuliah Non-Aktif</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="card-body box-body table-hover">
                        <table id="datatableid" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Matakuliah</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($matakuliah as $data)
                                    <tr>
                                        <td class="content-header">{{ $no++ }}</td>
                                        <td>{{ $data->kode_mk }}</td>
                                        <td>{{ $data->nama_mk }}</td>
                                        <!-- Matakuliah Jurusan -->
                                        @if ($data->kode_jurusan == 'S1-PTIK')
                                            <td>
                                                S1 - Pendidikan Teknik Informatika dan Komputer
                                            </td>
                                        @elseif ($data->kode_jurusan == 'S1-PTE')
                                            <td>
                                                S1 - Pendidikan Teknik Elektronika
                                            </td>
                                        @else
                                            <td>
                                                D3 - Teknik Elektronika
                                            </td>
                                        @endif
                                        <!-- Status Matakuliah -->
                                        @if ($data->status == '1')
                                            <td>
                                                <span class="label label-success"
                                                    data-id="{{ $data->status }}">Aktif</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="label label-danger"
                                                    data-id="{{ $data->status }}">Nonaktif</span>
                                            </td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#modal-aktif{{ $data->kode_mk }}">
                                                <i class="fa fa-fw fa-check"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Modals Aktif -->
                        @foreach ($matakuliah as $data)
                            <div class="modal fade" id="modal-aktif{{ $data->kode_mk }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title"> Aktifkan {{ $data->nama_mk }} ? </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin <b> mengaktifkan </b> kembali data
                                                {{ $data->nama_mk }}?
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left"
                                                data-dismiss="modal">Tidak</button>
                                            <a href="/matakuliah/aktif/{{ $data->kode_mk }}"
                                                class="btn btn-success">Ya!</a>
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
                    <a class="btn btn-primary" href="/matakuliah"> Kembali </a>
                </div>

            </div>
            <!-- /.row -->
            
    </section>

@endsection
