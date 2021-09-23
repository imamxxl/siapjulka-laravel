@extends('layout.template')

@section('title')
    Detail peserta | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Detail peserta
@endsection

@section('navigasi-satu')
    Manajemen Absensi
@endsection

@section('navigasi-dua')
    Detail peserta
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-absensi-mahasiswa')
@endsection

@section('isi-konten')
    @if (session('pesan-sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses </h4>
            {{ session('pesan-sukses') }}
        </div>
    @endif
    @if (session('pesan-gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal </h4>
            {{ session('pesan-gagal') }}
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    @foreach ($seksi as $item)
                        <h3 class="box-title center">Daftar Peserta Matakuliah {{ $item->nama_mk }}</h3>
                    @endforeach
                </div>

                <div class="card-body box-body table-hover">
                    <table id="datatableparticipant" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>NIM</th>
                                <th>Peserta</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($participant as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td><img class="profile-user-img" src="{{ url('avatar/' . $data->avatar) }}"></td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->jk }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

            <!-- Modal Tambah Peserta -->
            @foreach ($mahasiswa as $data)
                <div class="modal fade" id="modal-add">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"> Tambah Peserta Mahasiswa </h4>
                            </div>

                            <div class="modal-body">
                                <table id="lihat_mahasiswa" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Mahasiswa</th>
                                            <th>IMEI</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @foreach ($mahasiswa as $data)
                                            <tr class="pilih" data-id="{{ $data->user_id }}"
                                                data-nim="{{ $data->nim }}" data-nama="{{ $data->nama_mahasiswa }}"
                                                data-imei="{{ $data->imei_mahasiswa }}">
                                                <td class=" content-header">{{ $no++ }}</td>
                                                <td>{{ $data->nim }}</td>
                                                <td>{{ $data->nama_mahasiswa }}</td>
                                                @if ($data->imei_mahasiswa == null)
                                                    <td><i class="text-muted">Belum ada IMEI</i></td>
                                                @else
                                                    <td>{{ $data->imei_mahasiswa }}</td>
                                                @endif
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success pilih">
                                                        <i class="fa fa-fw fa-check"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- </form> --}}
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            @endforeach

            <!-- Modal Verifikasi Peserta -->
            @foreach ($participant as $data)
                <div class="modal fade" id="modal-verifikasi{{ $data->id_participant }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"> Verifikasi {{ $data->nama }} ({{ $data->username }})</h4>
                            </div>
                            <div class="modal-body">
                                <p>Lakukan verifikasi terhadap peserta {{ $data->nama }} ({{ $data->username }})?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                                <a href="/seksi/verifikasi_peserta/{{ $data->id_participant }}"
                                    class="btn btn-success">Verifikasi</a>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            @endforeach

            <!-- Modal Hapus Peserta -->
            @foreach ($participant as $data)
                <div class="modal fade" id="modal-hapus{{ $data->id_participant }}">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"> Hapus {{ $data->nama }} ({{ $data->username }})</h4>
                            </div>
                            <div class="modal-body">
                                <div class="text-danger">
                                    <p><b>Peringatan : </b></p>
                                </div>
                                <p>Anda yakin ingin <b> menghapus </b>
                                    {{ $data->nama }} ({{ $data->username }}) dari seksi ini?
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
                                <a href="/seksi/hapus_peserta/{{ $data->id_participant }}" class="btn btn-danger">Ya!</a>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            @endforeach

            <div>
                <a class="btn btn-primary" href="/absensi_mahasiswa"> Kembali </a>
            </div>

        </div>
    </section>

@endsection
