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
                    <h3 class="box-title center">Data Dosen</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <a href="/dosen/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Dosen Non-Aktif </a>
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
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modal-view{{ $data->kode_dosen }}">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->user_id }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                            data-target="#modal-nonaktif{{ $data->id }}">
                                            <i class="fa fa-fw fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal View -->
                    @foreach ($dosen as $data)
                        <div class="modal fade" id="modal-view{{ $data->kode_dosen }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Detail {{ $data->nama_dosen }}</h4>
                                    </div>

                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img"
                                            src="{{ url('avatar/' . $data->avatar) }}" alt="User profile picture">

                                        <h3 class="profile-username text-center">{{ $data->nama_dosen }}</h3>

                                        <p class="text-muted text-center">{{ $data->kode_dosen }}</p>

                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b>NIP</b>
                                                <p class="pull-right">{{ $data->nip_dosen }}</p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Jenis Kelamin</b>
                                                <p class="pull-right">{{ $data->jk }}</p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Status</b>
                                                @if ($data->status == '1')
                                                    <span class="pull-right label-lg label-success"
                                                        data-id="{{ $data->status }}">Aktif</span>
                                                @else
                                                    <span class="pull-right label-lg label-danger"
                                                        data-id="{{ $data->status }}">Nonaktif</span>
                                                @endif
                                            </li>
                                            <li class="list-group-item">
                                                <b>Dibuat</b> <a class="pull-right">{{ $data->created_at }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Diupdate</b> <a class="pull-right">{{ $data->updated_at }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach

                    <!-- Modal Edit -->
                    @foreach ($dosen as $data)
                        <div class="modal fade" id="modal-edit{{ $data->user_id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Edit {{ $data->nama_dosen }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/dosen/update/{{ $data->user_id }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group hidden">
                                                    <label>ID Dosen</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="id_dosen" class="form-control"
                                                        value="{{ $data->user_id }}">
                                                    <div class="text-danger">
                                                        @error('id_dosen')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kode Dosen</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="kode_dosen" class="form-control"
                                                        value="{{ $data->kode_dosen }}" readonly
                                                        placeholder="Contoh: 5335">
                                                    <div class="text-danger">
                                                        @error('kode_dosen')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Dosen</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="nama_dosen" class="form-control"
                                                        value="{{ $data->nama_dosen }}"
                                                        placeholder="Contoh: Delsina Faiza, S.t.,M.t.">
                                                    <div class="text-danger">
                                                        @error('nama_dosen')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>NIP/NIDN/NUPN</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="nip_dosen" class="form-control"
                                                        value="{{ $data->nip_dosen }}"
                                                        placeholder="Contoh: 198304132009122002">
                                                    <div class="text-danger">
                                                        @error('nip_dosen')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <label class="text-danger">*</label>
                                                    @if ($data->jk == 'Laki-laki')
                                                        <select name="jk_dosen" class="form-control">
                                                            <option value="Laki-laki" selected>Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    @elseif($data->jk == "Perempuan")
                                                        <select name="jk_dosen" required class="form-control show-tick">
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan" selected>Perempuan
                                                            </option>
                                                        </select>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <img src="{{ url('avatar/' . $data->avatar) }}" width="80">
                                                </div>

                                                <div class="form-group">
                                                    <label>Foto Dosen</label>
                                                    <input type="file" name="avatar_dosen">
                                                    <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                        (ukuran max: 1MB)</p>
                                                    <div class="text-danger">
                                                        @error('avatar_dosen')
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
                                                <button type="submit" class="btn btn-primary btn-block"
                                                    value="submit">Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal add -->
                        </div>
                    @endforeach

                    <!-- Modal Nonaktif -->
                    @foreach ($dosen as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Nonaktifkan {{ $data->nama_dosen }} ?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama_dosen }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/dosen/nonaktif/{{ $data->id }}" class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.row -->
    </section>
@endsection
