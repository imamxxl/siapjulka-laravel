@extends('layout.template')

@section('title')
    Cari Kelas | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Cari Kelas
@endsection

@section('navigasi-satu')
    Cari Kelas
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-cari-kelas')
@endsection

@section('isi-konten')
    @if (session('pesan-sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Berhasil bergabung ke kelas </h4>
            {{ session('pesan-sukses') }}
        </div>
    @endif
    @if (session('pesan-kelas-terdeteksi'))
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Anda sudah berada di kelas ini </h4>
            {{ session('pesan-kelas-terdeteksi') }}
        </div>
    @endif
    @if (session('pesan-gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Kelas tidak dapat ditemukan </h4>
            {{ session('pesan-gagal') }}
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row">

                <div class="col-md-6">
                    <div class="box">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title">Cari Kelas Dengan Token</h3>
                            </div>
                            <div class="panel-body">
                                <form action="/cari_kelas/detail" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="token" id="token"
                                            value="{{ old('token') }}" placeholder="Contoh: x6suGJ">
                                        <div class="text-danger">
                                            @error('token')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning">Cari Token <span
                                            class="glyphicon glyphicon-search"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-info-circle"></i>
                            <h3 class="box-title">Info</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul>
                                <li>Minta Token kepada dosen matakuliah terkait</li>
                                <li>Inputkan Token</li>
                                <li>Tunggu dan konfirmasikan kepada dosen pengajar agar anda diverifikasi di kelasnya</li>
                                <li>Peringatan: Jika anda TIDAK terverifikasi di kelas tertentu, anda tidak akan dapat
                                    mengambil presensi</li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- ./col -->

                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Hasil Pencarian Kelas</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                            <!-- /.box-tools -->

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="card-body box-body table-hover">
                                <table id="datatableparticipant" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Token</th>
                                            <th>Seksi</th>
                                            <th>Matakuliah</th>
                                            <th>SKS</th>
                                            <th>Jadwal</th>
                                            <th>Dosen</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($seksi as $data)
                                            <tr>
                                                <td>{{ $data->token }}</td>
                                                <td>{{ $data->kode_seksi }}</td>
                                                <td>{{ $data->nama_mk }}</td>
                                                <td>{{ $data->sks }}</td>
                                                <td>{{ $data->kode_ruang }} <br>
                                                    {{ $data->hari . ', ' . $data->jadwal_mulai . '-' . $data->jadwal_selesai }}
                                                </td>
                                                <td>{{ $data->kode_dosen }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                        data-target="#modal-gabung{{ $data->id }}">
                                                        Masuk
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
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

            <!-- Modal Add Participant -->
            @foreach ($seksi as $data)
                <div class="modal fade" id="modal-gabung{{ $data->id }}">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title text-center">Gabung ke kelas {{ $data->nama_mk }}</h4>
                            </div>

                            <div class="modal-body">
                                <p>Anda yakin ingin gabung/masuk ke kelas <b> {{ $data->nama_mk }} - {{ $data->kode_seksi }} </b>
                                <form action="/cari_kelas/detail/tambah_participant" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="box-body">
                                        <div class="form-group hidden">
                                            <label>ID Seksi</label>
                                            <label class="text-danger">*</label>
                                            <input type="text" name="id_seksi" class="form-control"
                                                value="{{ $data->id }}" placeholder="1">
                                            <div class="text-danger">
                                                @error('id_seksi')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                        @foreach ($user as $item)
                                            <div class="form-group hidden">
                                                <label>User ID</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="user_id" class="form-control"
                                                    value="{{ $item->id }}" placeholder="1">
                                                <div class="text-danger">
                                                    @error('user_id')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group hidden">
                                                <label>IMEI</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="imei" class="form-control"
                                                    value="{{ $item->imei }}" placeholder="1">
                                                <div class="text-danger">
                                                    @error('imei')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success" value="submit">Masuk</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endforeach
            <!-- /.modal -->

        </div>
    </section>

@endsection
