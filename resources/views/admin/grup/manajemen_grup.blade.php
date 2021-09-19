@extends('layout.template')

@section('title')
    Manajemen Grup | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Grup
@endsection

@section('navigasi-satu')
    Manajemen Grup
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-grup')
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
                    <h3 class="box-title center">Data Grup</h3>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                    <button type="button" class="btn btn-lg btn-success fa fa-plus" data-toggle="modal"
                        data-target="#modal-add">
                        Tambah Data
                    </button>
                    <a href="/grup/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Grup Non-Aktif </a>
                </div>

                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Grup</th>
                                <th>Nama Grup</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-striped">
                            <?php $no = 1; ?>
                            @foreach ($grup as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->kode_grup }}</td>

                                    @if ($data->nama_grup == '')
                                        <td>
                                            <p><em>Grup belum diberi nama</em></p>
                                        </td>
                                    @else
                                        <td>{{ $data->nama_grup }}</td>
                                    @endif
                                    <!-- Status Grup -->
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
                                            data-target="#modal-edit{{ $data->kode_grup }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-nonaktif{{ $data->kode_grup }}">
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
                                    <h4 class="modal-title">Tambah Data Grup</h4>
                                </div>

                                <div class="modal-header">
                                    <div class="callout callout-warning">
                                        <p><b>Peringatan!!!</b><br>
                                            Pastikan input data Grup sudah benar. Data <b> Grup</b>
                                            yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                            dihapus untuk alasan keamanan.
                                        </p>
                                    </div>
                                </div>

                                <div class="modal-body">

                                    <form action="/grup/add/insert" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Grup</label>
                                                <label class="text-danger">*</label>
                                                <select id="kode_grup" name="kode_grup" class="form-control"
                                                    onchange="myFunction(event)">
                                                    {{ $last = date('Y') - 7 }}
                                                    {{ $now = date('Y') }}
                                                    @for ($i = $now; $i >= $last; $i--)
                                                        @for ($j = 0; $j < 1; $j++)
                                                            <option value="{{ $i }}-PTIK-12">
                                                                {{ $i }}-PTIK-12</option>
                                                            <option value="{{ $i }}-PTIK-34">
                                                                {{ $i }}-PTIK-34</option>
                                                            <option value="{{ $i }}-PTIK-56">
                                                                {{ $i }}-PTIK-56</option>
                                                        @endfor
                                                        @for ($j = 0; $j < 1; $j++)
                                                            <option value="{{ $i }}-PTE-12">
                                                                {{ $i }}-PTE-12</option>
                                                            <option value="{{ $i }}-PTE-34">
                                                                {{ $i }}-PTE-34</option>
                                                            <option value="{{ $i }}-PTE-56">
                                                                {{ $i }}-PTE-56</option>
                                                        @endfor
                                                        @for ($j = 0; $j < 1; $j++)
                                                            <option value="{{ $i }}-D3TE-12">
                                                                {{ $i }}-D3TE-12</option>
                                                            <option value="{{ $i }}-D3TE-34">
                                                                {{ $i }}-D3TE-34</option>
                                                            <option value="{{ $i }}-D3TE-54">
                                                                {{ $i }}-D3TE-56</option>
                                                        @endfor
                                                    @endfor
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_grup')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Grup</label>
                                                <input id="nama_grup" type="text" name="nama_grup" class="form-control"
                                                    value="{{ old('nama_grup') }}" placeholder="Contoh: 2020 PTIK 12">
                                                <div class="text-danger">
                                                    @error('nama_grup')
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
                    @foreach ($grup as $data)
                        <div class="modal fade" id="modal-edit{{ $data->kode_grup }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Edit {{ $data->kode_grup }}</h4>
                                    </div>
                                    <form action="/grup/update/{{ $data->kode_grup }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Grup</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="kode_grup" class="form-control"
                                                    value="{{ $data->kode_grup }}" readonly
                                                    placeholder="Contoh: S1-PTIK">
                                                <div class="text-danger">
                                                    @error('kode_grup')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Grup</label>
                                                <input type="text" name="nama_grup" class="form-control"
                                                    value="{{ $data->nama_grup }}"
                                                    placeholder="Contoh: Pendidikan Teknik Informatika dan Komputer">
                                                <div class="text-danger">
                                                    @error('nama_grup')
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
                    @foreach ($grup as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->kode_grup }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Nonaktifkan {{ $data->kode_grup }} ? </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama_grup }}?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/grup/nonaktif/{{ $data->kode_grup }}" class="btn btn-danger">Ya!</a>
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
