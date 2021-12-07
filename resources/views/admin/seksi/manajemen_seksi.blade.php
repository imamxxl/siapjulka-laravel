@extends('layout.template')

@section('title')
    Manajemen Seksi | Siapjulka | UNP
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
                        data-target="#modal-add-ptik">
                        Seksi PTIK
                    </button>
                    <button type="button" class="btn btn-lg btn-primary fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-pte">
                        Seksi PTE
                    </button>
                    <button type="button" class="btn btn-lg bg-maroon fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-d3te">
                        Seksi D3-TE
                    </button>
                    <button type="button" class="btn btn-lg btn-success fa fa-file-excel-o" data-toggle="modal"
                        data-target="#modal-import-excel">
                        Import Data Excel
                    </button>
                    <a href="/seksi/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Seksi Non-Aktif </a>
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
                                        <a class="btn btn-sm btn-success" href="/seksi/detail/{{ $data->id }}">
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

                    <!-- Modal Add PTIK-->
                    <div class="modal fade" id="modal-add-ptik">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Data Seksi Matakuliah (S1-PTIK)</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="/seksi/add/insert_ptik" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <label class="text-danger">*</label>
                                                @if ($hitung_jurusan_all == 0)
                                                    <select class="form-control" name="kode_jurusan_ptik" disabled>
                                                        <option value="">- Belum Ada Jurusan. Tambahkan Jurusan! -
                                                        </option>
                                                    </select>
                                                @else
                                                    <select class="form-control" name="kode_jurusan_ptik" disabled>
                                                        @foreach ($jurusan_ptik as $data)
                                                            <option value="{{ $data->kode_jurusan }}"
                                                                @if (old('kode_jurusan_ptik') == $data->kode_jurusan) {{ 'selected ' }} @endif>
                                                                {{ $data->nama_jurusan }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Kode Seksi</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_seksi_ptik" class="form-control"
                                                    value="{{ $kode_seksi_ptik_final }}" readonly>
                                                <div class="text-danger">
                                                    @error('kode_seksi_ptik')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_mk_ptik">
                                                    <option value="">- Pilih Matakuliah -</option>
                                                    @foreach ($matakuliah_ptik as $list_mk)
                                                        <option value="{{ $list_mk->kode_mk }}">
                                                            {{ $list_mk->kode_mk }} - {{ $list_mk->nama_mk }} -
                                                            {{ $list_mk->sks }} SKS
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_mk_ptik')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="dosen_ptik">
                                                    <option value="">- Pilih Dosen -</option>
                                                    @foreach ($dosen as $data)
                                                        <option value="{{ $data->kode_dosen }}" @if (old('dosen_ptik') == $data->kode_dosen) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_dosen }} - {{ $data->nama_dosen }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('dosen_ptik')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="hari_ptik">
                                                    <option value="">- Pilih Hari -</option>
                                                    <option value="Senin" @if (old('hari_ptik') == 'Senin') {{ 'selected' }} @endif> Senin
                                                    </option>
                                                    <option value="Selasa" @if (old('hari_ptik') == 'Selasa') {{ 'selected' }} @endif>Selasa
                                                    </option>
                                                    <option value="Rabu" @if (old('hari_ptik') == 'Rabu') {{ 'selected' }} @endif>Rabu</option>
                                                    <option value="Kamis" @if (old('hari_ptik') == 'Kamis') {{ 'selected' }} @endif>Kamis
                                                    </option>
                                                    <option value="Jumat" @if (old('hari_ptik') == 'Jumat') {{ 'selected' }} @endif>Jumat
                                                    </option>
                                                    <option value="Sabtu" @if (old('hari_ptik') == 'Sabtu') {{ 'selected' }} @endif>Sabtu
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('hari_ptik')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jadwal</label>
                                                <label class="text-danger">*</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_mulai_ptik">
                                                            <option value="">- Jam Mulai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_mulai_ptik') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_mulai_ptik')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_selesai_ptik">
                                                            <option value="">- Jam Selesai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_selesai_ptik') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_selesai_ptik')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ruangan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="ruangan_ptik">
                                                    <option value="">- Pilih Ruangan -</option>
                                                    @foreach ($ruangan as $data)
                                                        <option value="{{ $data->kode_ruang }}" @if (old('ruangan_ptik') == $data->kode_ruang) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_ruang }} - {{ $data->nama_ruang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('ruangan_ptik')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Token</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="token_ptik" class="form-control"
                                                    value="{{ $token }}" readonly>
                                                <div class="text-danger">
                                                    @error('token_ptik')
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

                    <!-- Modal Add PTE-->
                    <div class="modal fade" id="modal-add-pte">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Data Seksi Matakuliah (S1-PTE)</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="/seksi/add/insert_pte" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <label class="text-danger">*</label>
                                                @if ($hitung_jurusan_all == 0)
                                                    <select class="form-control" name="kode_jurusan_pte" disabled>
                                                        <option value="">- Belum Ada Jurusan. Tambahkan Jurusan! -
                                                        </option>
                                                    </select>
                                                @else
                                                    <select class="form-control" name="kode_jurusan_pte" disabled>
                                                        @foreach ($jurusan_pte as $data)
                                                            <option value="{{ $data->kode_jurusan }}"
                                                                @if (old('kode_jurusan_pte') == $data->kode_jurusan) {{ 'selected ' }} @endif>
                                                                {{ $data->nama_jurusan }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Kode Seksi</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_seksi_pte" class="form-control"
                                                    value="{{ $kode_seksi_pte_final }}" readonly>
                                                <div class="text-danger">
                                                    @error('kode_seksi_pte')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_mk_pte">
                                                    <option value="">- Pilih Matakuliah -</option>
                                                    @foreach ($matakuliah_pte as $list_mk)
                                                        <option value="{{ $list_mk->kode_mk }}">
                                                            {{ $list_mk->kode_mk }} - {{ $list_mk->nama_mk }} -
                                                            {{ $list_mk->sks }} SKS
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_mk_pte')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="dosen_pte">
                                                    <option value="">- Pilih Dosen -</option>
                                                    @foreach ($dosen as $data)
                                                        <option value="{{ $data->kode_dosen }}"
                                                            @if (old('dosen_pte') == $data->kode_dosen) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_dosen }} - {{ $data->nama_dosen }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('dosen_pte')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="hari_pte">
                                                    <option value="">- Pilih Hari -</option>
                                                    <option value="Senin" @if (old('hari_pte') == 'Senin') {{ 'selected' }} @endif> Senin
                                                    </option>
                                                    <option value="Selasa" @if (old('hari_pte') == 'Selasa') {{ 'selected' }} @endif>Selasa
                                                    </option>
                                                    <option value="Rabu" @if (old('hari_pte') == 'Rabu') {{ 'selected' }} @endif>Rabu</option>
                                                    <option value="Kamis" @if (old('hari_pte') == 'Kamis') {{ 'selected' }} @endif>Kamis
                                                    </option>
                                                    <option value="Jumat" @if (old('hari_pte') == 'Jumat') {{ 'selected' }} @endif>Jumat
                                                    </option>
                                                    <option value="Sabtu" @if (old('hari_pte') == 'Sabtu') {{ 'selected' }} @endif>Sabtu
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('hari_pte')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jadwal</label>
                                                <label class="text-danger">*</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_mulai_pte">
                                                            <option value="">- Jam Mulai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_mulai_pte') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_mulai_pte')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_selesai_pte">
                                                            <option value="">- Jam Selesai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_selesai_pte') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_selesai_pte')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ruangan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="ruangan_pte">
                                                    <option value="">- Pilih Ruangan -</option>
                                                    @foreach ($ruangan as $data)
                                                        <option value="{{ $data->kode_ruang }}"
                                                            @if (old('ruangan_pte') == $data->kode_ruang) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_ruang }} - {{ $data->nama_ruang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('ruangan_pte')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Token</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="token_pte" class="form-control"
                                                    value="{{ $token }}" readonly>
                                                <div class="text-danger">
                                                    @error('token_pte')
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

                    <!-- Modal Add D3TE-->
                    <div class="modal fade" id="modal-add-d3te">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Data Seksi Matakuliah (D3-PTE)</h4>
                                </div>

                                <div class="modal-body">
                                    <form action="/seksi/add/insert_d3te" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <label class="text-danger">*</label>
                                                @if ($hitung_jurusan_all == 0)
                                                    <select class="form-control" name="kode_jurusan_d3te" disabled>
                                                        <option value="">- Belum Ada Jurusan. Tambahkan Jurusan! -
                                                        </option>
                                                    </select>
                                                @else
                                                    <select class="form-control" name="kode_jurusan_d3te" disabled>
                                                        @foreach ($jurusan_d3te as $data)
                                                            <option value="{{ $data->kode_jurusan }}"
                                                                @if (old('kode_jurusan_d3te') == $data->kode_jurusan) {{ 'selected ' }} @endif>
                                                                {{ $data->nama_jurusan }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Kode Seksi</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_seksi_d3te" class="form-control"
                                                    value="{{ $kode_seksi_d3te_final }}" readonly>
                                                <div class="text-danger">
                                                    @error('kode_seksi_d3te')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Matakuliah</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="kode_mk_d3te">
                                                    <option value="">- Pilih Matakuliah -</option>
                                                    @foreach ($matakuliah_pte as $list_mk)
                                                        <option value="{{ $list_mk->kode_mk }}">
                                                            {{ $list_mk->kode_mk }} - {{ $list_mk->nama_mk }} -
                                                            {{ $list_mk->sks }} SKS
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_mk_d3te')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Dosen</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="dosen_d3te">
                                                    <option value="">- Pilih Dosen -</option>
                                                    @foreach ($dosen as $data)
                                                        <option value="{{ $data->kode_dosen }}"
                                                            @if (old('dosen_d3te') == $data->kode_dosen) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_dosen }} - {{ $data->nama_dosen }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('dosen_d3te')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="hari_d3te">
                                                    <option value="">- Pilih Hari -</option>
                                                    <option value="Senin" @if (old('hari_d3te') == 'Senin') {{ 'selected' }} @endif> Senin
                                                    </option>
                                                    <option value="Selasa" @if (old('hari_d3te') == 'Selasa') {{ 'selected' }} @endif>Selasa
                                                    </option>
                                                    <option value="Rabu" @if (old('hari_d3te') == 'Rabu') {{ 'selected' }} @endif>Rabu
                                                    </option>
                                                    <option value="Kamis" @if (old('hari_d3te') == 'Kamis') {{ 'selected' }} @endif>Kamis
                                                    </option>
                                                    <option value="Jumat" @if (old('hari_d3te') == 'Jumat') {{ 'selected' }} @endif>Jumat
                                                    </option>
                                                    <option value="Sabtu" @if (old('hari_d3te') == 'Sabtu') {{ 'selected' }} @endif>Sabtu
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('hari_d3te')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jadwal</label>
                                                <label class="text-danger">*</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_mulai_d3te">
                                                            <option value="">- Jam Mulai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_mulai_d3te') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_mulai_d3te')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="jadwal_selesai_d3te">
                                                            <option value="">- Jam Selesai -</option>
                                                            @for ($jam = 7; $jam < 18; $jam++)
                                                                @for ($menit = 0; $menit < 60; $menit += 10)
                                                                    <option
                                                                        value="{{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}"
                                                                        @if (old('jadwal_selesai_d3te') == str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT))
                                                                        {{ 'selected ' }}
                                                                @endif
                                                                >
                                                                {{ str_pad($jam, 2, '0', STR_PAD_LEFT) . ':' . str_pad($menit, 2, '0', STR_PAD_LEFT) }}
                                                                </option>
                                                            @endfor
                                                            @endfor
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jadwal_selesai_d3te')
                                                                {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Ruangan</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" name="ruangan_d3te">
                                                    <option value="">- Pilih Ruangan -</option>
                                                    @foreach ($ruangan as $data)
                                                        <option value="{{ $data->kode_ruang }}"
                                                            @if (old('ruangan_d3te') == $data->kode_ruang) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_ruang }} - {{ $data->nama_ruang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('ruangan_d3te')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Token</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="token_d3te" class="form-control"
                                                    value="{{ $token }}" readonly>
                                                <div class="text-danger">
                                                    @error('token_d3te')
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
                                            <button type="submit" class="btn bg-maroon btn-block" value="submit">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>

                    <!-- Modal Import Excel -->
                    <div class="modal modal-success" id="modal-import-excel">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/import_excel" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="text-center modal-title">Import Data Excel</h4>
                                    </div>

                                    <div class="modal-body">
                                        <div>
                                            <p><b>Perhatian : </b></p>
                                        </div>
                                        <p> - Download panduan import data excel terlebih dahulu. </p>

                                        <p> - Tidak boleh ada kolom yang kosong saat menginputkan data seksi melalui excel.
                                        </p>
                                        <p> - Data akan gagal diinput jika terdapat kode seksi yang sama. </p>

                                        <p> - Silahkan download template excel untuk contoh inputan data. </p>

                                        <p> - Kosongkan terlebih dahulu data pada template. (karna data tersebut hanya sebagai contoh) </p>

                                        <div>
                                            <p><b>Pilih File Excel : </b></p>
                                        </div>

                                        <input type="file" name="file" class="form-control">

                                        <P><br></P>

                                        @if (count($errors) > 0)
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="alert alert-warning alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-hidden="true">×</button>
                                                        <h4><i class="icon fa fa-ban"></i> Gagal</h4>
                                                        @foreach ($errors->all() as $error)
                                                            {{ $error }} <br>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (Session::has('success'))
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div class="alert alert-success alert-dismissible">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-hidden="true">×</button>
                                                        <h5>{!! Session::get('berhasil') !!}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">
                                            Batal</button>

                                        <a href="/seksi/download_panduan" class="btn btn-outline fa fa-download"> Unduh
                                            Panduan</a>

                                        <a href="/seksi/download_excel" class="btn btn-outline fa fa-download"> Unduh
                                            Template</a>
                                        <button class="btn btn-outline"> Import</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

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
                                    <form action="/seksi/update/{{ $data->id }}" method="POST"
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
                                    <form action="/seksi/reset_token/{{ $data->id }}" method="POST"
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
                                        <a href="/seksi/nonaktif/{{ $data->id }}" class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

@endsection
