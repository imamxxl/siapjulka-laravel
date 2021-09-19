@extends('layout.template')

@section('title')
    Seksi Nonaktif | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Seksi
@endsection

@section('navigasi-satu')
    Manajemen Seksi
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-seksi')
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
                    <h3 class="box-title center">Data Seksi Non-Aktif</h3>
                </div>
                <!-- /.box-header -->

                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Seksi</th>
                                <th>Kode MK</th>
                                <th>Matakuliah</th>
                                <th>SKS</th>
                                <th>Jadwal</th>
                                <th>Dosen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($seksi as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->kode_seksi }}</td>
                                    <td>{{ $data->kode_mk }}</td>
                                    <td>{{ $data->nama_mk }}</td>
                                    <td>{{ $data->sks }}</td>
                                    <td>{{ $data->kode_ruang }} <br>
                                        {{ $data->hari . ', ' . $data->jadwal_mulai . '-' . $data->jadwal_selesai }}
                                    </td>
                                    <td>{{ $data->kode_dosen }}</td>
                                    <!-- Status Seksi -->
                                    <td>
                                        <span class="label label-danger">Nonaktif</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#modal-aktif{{ $data->kode_seksi }}">
                                            <i class="fa fa-fw fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.row -->
            <div>
                <a class="btn btn-primary" href="/seksi"> Kembali </a>
            </div>
        </div>

        <!-- Modals Aktif -->
        @foreach ($seksi as $data)
            <div class="modal fade" id="modal-aktif{{ $data->kode_seksi }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> Aktifkan {{ $data->kode_seksi }} </h4>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin ingin <b> mengaktifkan </b> kembali data
                                {{ $data->kode_seksi }}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                            <a href="/seksi/aktif/{{ $data->id }}" class="btn btn-success">Ya!</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endforeach
        
    </section>
@endsection
