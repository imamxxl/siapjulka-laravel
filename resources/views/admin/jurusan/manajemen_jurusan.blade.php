@extends('layout.template')

@section('title')
    Manajemen Jurusan | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Jurusan
@endsection

@section('navigasi-satu')
    Manajemen Jurusan
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-jurusan')
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
                    <h3 class="box-title center">Data Jurusan</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <button type="button" class="btn btn-lg btn-success fa fa-plus" data-toggle="modal"
                        data-target="#modal-add">
                        Tambah Data
                    </button>
                    <a href="/jurusan/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Jurusan Non-Aktif </a>
                </div>

                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($jurusan as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->kode_jurusan }}</td>
                                    <td>{{ $data->nama_jurusan }}</td>
                                    <!-- Status Jurusan -->
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
                                            data-target="#modal-edit{{ $data->kode_jurusan }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-nonaktif{{ $data->kode_jurusan }}">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modals Add -->
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Tambah Data Jurusan</h4>
                                </div>

                                <div class="modal-header">
                                    <div class="callout callout-warning">
                                        <p><b>Peringatan!!!</b><br>
                                            Pastikan input data Jurusan sudah benar. Data <b>Kode Jurusan</b>
                                            yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                            dihapus untuk alasan keamanan.
                                        </p>
                                    </div>
                                </div>

                                <div class="modal-body">

                                    <form action="/jurusan/add/insert" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Jurusan</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_jurusan" class="form-control"
                                                    value="{{ old('kode_jurusan') }}" placeholder="Contoh: S1-PTIK">
                                                <div class="text-danger">
                                                    @error('kode_jurusan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Jurusan</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_jurusan" class="form-control"
                                                    value="{{ old('nama_jurusan') }}"
                                                    placeholder="Contoh: Pendidikan Teknik Informatika dan Komputer">
                                                <div class="text-danger">
                                                    @error('nama_jurusan')
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
                    @foreach ($jurusan as $data)
                        <div class="modal fade" id="modal-edit{{ $data->kode_jurusan }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Edit {{ $data->nama_jurusan }}</h4>
                                    </div>
                                    <form action="/jurusan/update/{{ $data->kode_jurusan }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Jurusan</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_jurusan" class="form-control"
                                                    value="{{ $data->kode_jurusan }}" readonly
                                                    placeholder="Contoh: S1-PTIK">
                                                <div class="text-danger">
                                                    @error('kode_jurusan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Jurusan</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_jurusan" class="form-control"
                                                    value="{{ $data->nama_jurusan }}"
                                                    placeholder="Contoh: Pendidikan Teknik Informatika dan Komputer">
                                                <div class="text-danger">
                                                    @error('nama_jurusan')
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
                    @foreach ($jurusan as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->kode_jurusan }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Nonaktifkan {{ $data->nama_jurusan }} ? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama_jurusan }}?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/jurusan/nonaktif/{{ $data->kode_jurusan }}"
                                            class="btn btn-danger">Ya!</a>
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
        </div>
    </section>

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

@endsection
