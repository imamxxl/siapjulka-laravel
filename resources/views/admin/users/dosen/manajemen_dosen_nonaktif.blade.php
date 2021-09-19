@extends('layout.template')

@section('title')
    Manajemen Dosen | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Dosen
@endsection

@section('navigasi-satu')
    Manajemen User
@endsection

@section('navigasi-dua')
    Manajemen Dosen
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-manajemen')
@endsection

@section('isi-konten')
    @if (session('pesan'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses </h4>
            {{ session('pesan') }}
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title center">Data Dosen Non-Aktif</h3>
                </div>

                <!-- Table Dosens -->
                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>NIP/NIDN/NUPN</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($dosen as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->kode_dosen }}</td>
                                    <td>{{ $data->nama_dosen }}</td>
                                    <td>{{ $data->nip_dosen }}</td>
                                    <!-- Status Dosen -->
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
                                            data-target="#modal-aktif{{ $data->id }}">
                                            <i class="fa fa-fw fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            
            <div>
                <a class="btn btn-primary" href="/dosen"> Kembali </a>
            </div>
            <!-- /.tombol kembali -->

        </div>
        <!-- /.row -->

        <!-- Modal Aktif -->
        @foreach ($dosen as $data)
            <div class="modal fade" id="modal-aktif{{ $data->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Aktifkan {{ $data->nama_dosen }} </h4>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin ingin <b> mengktifkan </b> kembali data
                                {{ $data->nama_dosen }}?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                            <a href="/dosen/aktif/{{ $data->id }}" class="btn btn-success">Ya!</a>
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
