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
            <div class="col-xs-12">

                <div class="box">

                    <div class="box-body">
                        <button type="button" class="btn btn-lg btn-success fa fa-plus" data-toggle="modal"
                            data-target="#modal-add">
                            Tambah Data
                        </button>
                        <a href="/matakuliah/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Matakuliah Non-Aktif
                        </a>
                    </div>

                    <div class="box-header">
                        <h3 class="box-title center">Data Matakuliah</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="card-body box-body table-hover">
                        <table id="datatableid" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Matakuliah</th>
                                    <th>SKS</th>
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
                                        <td>{{ $data->sks }}</td>
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
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                data-target="#modal-edit{{ $data->kode_mk }}">
                                                <i class="fa fa-fw fa-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                data-target="#modal-nonaktif{{ $data->kode_mk }}">
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
                                        <h4 class="modal-title">Tambah Data Matakuliah</h4>
                                    </div>

                                    <div class="modal-header">
                                        <div class="callout callout-warning">
                                            <p><b>Peringatan!!!</b><br>
                                                Pastikan input data Matakuliah sudah benar. Data <b>Kode Matakuliah</b>
                                                yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                                dihapus untuk alasan keamanan.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/matakuliah/add/insert" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Kode Matakuliah</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="kode_mk" class="form-control"
                                                        value="{{ old('kode_mk') }}" placeholder="Contoh: TIK113">
                                                    <div class="text-danger">
                                                        @error('kode_mk')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Matakuliah</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="nama_mk" class="form-control"
                                                        value="{{ old('nama_mk') }}"
                                                        placeholder="Contoh: Teknik Komputasi">
                                                    <div class="text-danger">
                                                        @error('nama_mk')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="position-option">Jurusan</label>
                                                    <label class="text-danger">*</label>
                                                    @if ($hitung_jurusan == 0)
                                                        <select class="form-control" name="kode_jurusan" disabled>
                                                            <option value="">- Belum Ada Jurusan. Tambahkan Jurusan! -
                                                            </option>
                                                        </select>
                                                    @else
                                                        <select class="form-control" name="kode_jurusan">
                                                            @foreach ($jurusan as $data)
                                                                <option value="{{ $data->kode_jurusan }}" @if (old('kode_jurusan') == $data->kode_jurusan) {{ 'selected ' }} @endif>
                                                                    {{ $data->nama_jurusan }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                    <div class="text-danger">
                                                        @error('kode_jurusan')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>SKS</label>
                                                    <label class="text-danger">*</label>
                                                    <select class="form-control" name="sks">
                                                        <option value="">- SKS -</option>
                                                        @for ($i = 1; $i <= 6; $i++)
                                                            <option value="{{ $i }}" @if (old('sks') == $i) {{ 'selected ' }} @endif>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                    <div class="text-danger">
                                                        @error('sks')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                                </div>
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

                    <!-- Modal Edit -->
                    @foreach ($matakuliah as $data)
                        <div class="modal fade" id="modal-edit{{ $data->kode_mk }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Edit {{ $data->nama_mk }} </h4>
                                    </div>
                                    <form action="/matakuliah/update/{{ $data->kode_mk }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_mk" class="form-control"
                                                    value="{{ $data->kode_mk }}" readonly placeholder="Contoh: TIK113">
                                                <div class="text-danger">
                                                    @error('kode_mk')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_mk" class="form-control"
                                                    value="{{ $data->nama_mk }}" placeholder="Contoh: Teknik Komputasi">
                                                <div class="text-danger">
                                                    @error('nama_mk')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_jurusan">
                                                    @foreach ($jurusan as $list_jurusan)
                                                        <option value="{{ $list_jurusan->kode_jurusan }}"
                                                            {{ $list_jurusan->kode_jurusan == $data->kode_jurusan ? 'selected' : '' }}>
                                                            {{ $list_jurusan->nama_jurusan }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_jurusan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>SKS</label>
                                                <label class="text-danger">*</label>
                                                <select name="sks" class="form-control">
                                                    @for ($i = 1; $i <= 6; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $data->sks == $i ? 'selected' : '' }}>
                                                            {{ $i }} </option>
                                                    @endfor
                                                </select>
                                                <div class="text-danger">
                                                    @error('sks')
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
                    @foreach ($matakuliah as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->kode_mk }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Nonaktifkan {{ $data->nama_mk }} ? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama_mk }}?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/matakuliah/nonaktif/{{ $data->kode_mk }}"
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

@endsection
