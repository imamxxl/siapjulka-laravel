@extends('layout.template')

@section('title')
    Seksi | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Seksi
@endsection

@section('navigasi-satu')
    Seksi
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-seksi-dosen')
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
                    <h3 class="box-title center">Data Seksi</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <button type="button" class="btn btn-lg btn-warning fa fa-plus" data-toggle="modal"
                        data-target="#modal-input-seksi">
                        Input Seksi
                    </button>
                    <button type="button" class="btn btn-lg btn-success fa fa-file-excel-o" data-toggle="modal"
                        data-target="#modal-import-excel">
                        Import Data Excel
                    </button>
                    <a href="/seksi_dosen/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Seksi Non-Aktif </a>
                </div>

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
                                    @if ($data->status == '1')
                                        <td>
                                            <span class="label label-success" data-id="{{ $data->status }}">Aktif</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="label label-danger"
                                                data-id="{{ $data->status }}">Nonaktif</span>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-sm btn-success" href="/seksi_dosen/detail/{{ $data->id }}">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->kode_seksi }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning color-palette"
                                            data-toggle="modal" data-target="#modal-token{{ $data->kode_seksi }}">
                                            <i class="fa fa-fw fa-refresh"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-nonaktif{{ $data->kode_seksi }}">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal Input Seksi-->
                    <div class="modal fade" id="modal-input-seksi">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Input Seksi Baru</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="/seksi_dosen/insert_seksi" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Seksi</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_seksi" class="form-control"
                                                    value="{{ old('kode_seksi') }}" placeholder="Contoh: 202120760001">
                                                <div class="text-danger">
                                                    @error('kode_seksi')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_mk">
                                                    <option value="">- Pilih Matakuliah -</option>
                                                    @foreach ($matakuliah_all as $list_mk)
                                                        <option value="{{ $list_mk->kode_mk }}" @if (old('kode_mk') == $list_mk->kode_mk) {{ 'selected ' }} @endif>
                                                            {{ $list_mk->kode_mk }} - {{ $list_mk->nama_mk }} -
                                                            {{ $list_mk->sks }} SKS
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_mk')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_jurusan">
                                                    <option value="">- Pilih Jurusan -</option>
                                                    @foreach ($kode_jurusan as $data)
                                                        <option value="{{ $data->kode_jurusan }}"
                                                            @if (old('kode_jurusan') == $data->kode_jurusan) {{ 'selected ' }} @endif>
                                                            {{ $data->nama_jurusan }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_jurusan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="dosen" readonly>
                                                    @foreach ($dosen as $data)
                                                        <option value="{{ $data->kode_dosen }}">
                                                            {{ $data->kode_dosen }} - {{ $data->nama_dosen }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('dosen')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="hari">
                                                    <option value="">- Pilih Hari -</option>
                                                    <option value="Senin" @if (old('hari') == 'Senin') {{ 'selected' }} @endif> Senin
                                                    </option>
                                                    <option value="Selasa" @if (old('hari') == 'Selasa') {{ 'selected' }} @endif>Selasa
                                                    </option>
                                                    <option value="Rabu" @if (old('hari') == 'Rabu') {{ 'selected' }} @endif>Rabu</option>
                                                    <option value="Kamis" @if (old('hari') == 'Kamis') {{ 'selected' }} @endif>Kamis
                                                    </option>
                                                    <option value="Jumat" @if (old('hari') == 'Jumat') {{ 'selected' }} @endif>Jumat
                                                    </option>
                                                    <option value="Sabtu" @if (old('hari') == 'Sabtu') {{ 'selected' }} @endif>Sabtu
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('hari')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jadwal</label>
                                                <label class="text-danger">*</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_mulai">
                                                            <option value="">- Jam Mulai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_mulai') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_mulai')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_selesai">
                                                            <option value="">- Jam Selesai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_selesai') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_selesai')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ruangan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="ruangan">
                                                    <option value="">- Pilih Ruangan -</option>
                                                    @foreach ($ruangan as $data)
                                                        <option value="{{ $data->kode_ruang }}" @if (old('ruangan') == $data->kode_ruang) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_ruang }} - {{ $data->nama_ruang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('ruangan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Token</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="token" class="form-control"
                                                    value="{{ $token }}" readonly>
                                                <div class="text-danger">
                                                    @error('token')
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
                                            <button type="submit" class="btn btn-warning btn-block" value="submit">Simpan
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
                    @foreach ($seksi as $data)
                        <div class="modal fade" id="modal-edit{{ $data->kode_seksi }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Edit Seksi {{ $data->kode_seksi }}</h4>
                                    </div>
                                    <form action="/seksi_dosen/update/{{ $data->id }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Seksi</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_seksi_edit" class="form-control"
                                                    value="{{ $data->kode_seksi }}" readonly
                                                    placeholder="Contoh: S1-PTIK">
                                                <div class="text-danger">
                                                    @error('kode_seksi_edit')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_mk_edit">
                                                    @foreach ($matakuliah_all as $list_matakuliah)
                                                        <option value="{{ $list_matakuliah->kode_mk }}"
                                                            {{ $list_matakuliah->kode_mk == $data->kode_mk ? 'selected' : '' }}>
                                                            {{ $list_matakuliah->kode_mk }} -
                                                            {{ $list_matakuliah->nama_mk }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_mk_edit')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="dosen_edit">
                                                    @foreach ($dosen as $list_dosen)
                                                        <option value="{{ $list_dosen->kode_dosen }}"
                                                            {{ $list_dosen->kode_dosen == $data->kode_dosen ? 'selected' : '' }}>
                                                            {{ $list_dosen->kode_dosen }} -
                                                            {{ $list_dosen->nama_dosen }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('dosen_edit')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="hari_edit">
                                                    <option value="">- Pilih Hari -</option>
                                                    @foreach ($hari as $list_hari)
                                                        <option value="{{ $list_hari }}"
                                                            {{ $list_hari == $data->hari ? 'selected' : '' }}>
                                                            {{ $list_hari }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('hari_edit')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jadwal</label>
                                                <label class="text-danger">*</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_mulai_edit">
                                                            <option value="">- Jam Mulai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) == $data->jadwal_mulai ? 'selected' : '' }}>
                                                                        {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                    </option>
                                                                @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_mulai_edit')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_selesai_edit">
                                                            <option value="">- Jam Selesai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) == $data->jadwal_selesai ? 'selected' : '' }}>
                                                                        {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                    </option>
                                                                @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_selesai_edit')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ruangan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="ruangan_edit">
                                                    @foreach ($ruangan as $list_ruangan)
                                                        <option value="{{ $list_ruangan->kode_ruang }}"
                                                            {{ $list_ruangan->kode_ruang == $data->kode_ruang ? 'selected' : '' }}>
                                                            {{ $list_ruangan->kode_ruang }} -
                                                            {{ $list_ruangan->nama_ruang }} </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('ruangan_edit')
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

                    <!-- Modal Reset Token -->
                    @foreach ($seksi as $data)
                        <div class="modal fade" id="modal-token{{ $data->kode_seksi }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Reset Token Seksi {{ $data->kode_seksi }}</h4>
                                    </div>
                                    <form action="/seksi_dosen/reset_token/{{ $data->id }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Token Lama</label>
                                                <input type="text" name="token_lama" class="form-control"
                                                    value="{{ $data->token }}" readonly>
                                                <div class="text-danger">
                                                    @error('token_lama')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Token Baru</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="token_baru" class="form-control"
                                                    value="{{ $token_edit }}" readonly>
                                                <div class="text-danger">
                                                    @error('token_baru')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Token baru yang akan
                                                        tersimpan. </a> </p>
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning btn-block" value="submit">Reset
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
                    @foreach ($seksi as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->kode_seksi }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Nonaktifkan Seksi {{ $data->kode_seksi }} </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->kode_seksi }}?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/seksi_dosen/nonaktif/{{ $data->id }}" class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach

                    <!-- Modal Import Excel -->
                    <div class="modal fade" id="modal-import-excel">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Import Data Excel</h4>
                                </div>

                                <div class="modal-body">
                                    <div class="alert alert-success">
                                        <h4><i class="icon fa fa-info"></i> Mohon Maaf </h4>
                                        <p>Fitur "Import Data Excel" masih dalam pengembangan.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>

                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

@endsection
