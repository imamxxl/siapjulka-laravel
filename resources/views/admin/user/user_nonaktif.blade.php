@extends('layout.template')

@section('title')
    User | Siapjulka | UNP
@endsection

@section('judul-halaman')
    User
@endsection

@section('navigasi-satu')
    User
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-user')
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
                    <h3 class="box-title center">Data Admin Non-Aktif</h3>
                </div>

                <!-- Table Users -->
                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($user as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->jk }}</td>
                                    <!-- Status User -->
                                    @if ($data->status == '1')
                                        <td>
                                            <span class="label label-success" data-id="{{ $data->status }}">Aktif</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="label label-danger" data-id="{{ $data->status }}">Nonaktif</span>
                                        </td>
                                    @endif
                                    <!-- Level User -->
                                    @if ($data->level == 'admin')
                                        <td>
                                            <span class="badge bg-purple" id="{{ $data->level }}">Admin<span>
                                        </td>
                                    @elseif ($data->level == 'dosen')
                                        <td>
                                            <span class="badge btn-primary" id="{{ $data->level }}">Dosen<span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge btn-warning" id="{{ $data->level }}">Mahasiswa<span>
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
                <a class="btn btn-primary" href="/user"> Kembali </a>
            </div>
        
        </div>
        <!-- /.row -->

        <!-- Modal Aktif -->
        @foreach ($user as $data)
            <div class="modal fade" id="modal-aktif{{ $data->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Aktifkan {{ $data->nama }} </h4>
                        </div>
                        <div class="modal-body">
                            <div class="text-danger">
                                <p><b>Peringatan : </b></p>
                            </div>
                            <p>Anda yakin ingin <b> mengktifkan </b> kembali data
                                {{ $data->nama }}?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                            <a href="/user/aktif/{{ $data->id }}" class="btn btn-success">Ya!</a>
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
