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
                    <h3 class="box-title center">Data Ruang</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <button type="button" class="btn btn-lg btn-success fa fa-plus" data-toggle="modal"
                        data-target="#modal-add">
                        Tambah Data
                    </button>
                    <a href="/ruang/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Ruang Non-Aktif </a>
                </div>

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
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->kode_ruang }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-nonaktif{{ $data->kode_ruang }}">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal Add -->
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Tambah Data Ruang</h4>
                                </div>

                                <div class="modal-header">
                                    <div class="callout callout-warning">
                                        <p><b>Peringatan!!!</b><br>
                                            Pastikan input data Ruang sudah benar. Data <b>kode Ruang</b>
                                            yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                            dihapus untuk alasan keamanan.
                                        </p>
                                    </div>
                                </div>

                                <div class="modal-body">

                                    <form action="/ruang/add/insert" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Ruang</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_ruang" class="form-control"
                                                    value="{{ old('kode_ruang') }}" placeholder="Contoh: FTK02101">
                                                <div class="text-danger">
                                                    @error('kode_ruang')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Ruang</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_ruang" class="form-control"
                                                    value="{{ old('nama_ruang') }}"
                                                    placeholder="Contoh: Ruang Kuliah Teater (E30)">
                                                <div class="text-danger">
                                                    @error('nama_ruang')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-block" value="submit">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>

                    <!-- Modals Edit -->
                    @foreach ($ruang as $data)
                        <div class="modal fade" id="modal-edit{{ $data->kode_ruang }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Edit {{ $data->nama_ruang }}</h4>
                                    </div>
                                    <form action="/ruang/update/{{ $data->kode_ruang }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Ruang</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_ruang" class="form-control"
                                                    value="{{ $data->kode_ruang }}" readonly
                                                    placeholder="Contoh: S1-PTIK">
                                                <div class="text-danger">
                                                    @error('kode_ruang')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Ruang</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_ruang" class="form-control"
                                                    value="{{ $data->nama_ruang }}"
                                                    placeholder="Contoh: Pendidikan Teknik Informatika dan Komputer">
                                                <div class="text-danger">
                                                    @error('nama_ruang')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary btn-block" value="submit">Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach

                    <!-- Modal Nonaktif -->
                    @foreach ($ruang as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->kode_ruang }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Nonaktifkan {{ $data->nama_ruang }} ? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama_ruang }}?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/ruang/nonaktif/{{ $data->kode_ruang }}" class="btn btn-danger">Ya!</a>
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
            <!-- /.row -->
    </section>

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

@endsection
