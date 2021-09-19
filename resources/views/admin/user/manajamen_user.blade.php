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
    @if (session('pesan-gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal </h4>
            {{ session('pesan-gagal') }}
        </div>
    @endif
    @if (session('password-sukses'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses </h4>
            {{ session('password-sukses') }}
        </div>
    @endif
    @if (session('password-gagal'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Gagal </h4>
            {{ session('password-gagal') }}
        </div>
    @endif
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title center">Data User</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <button type="button" class="btn btn-lg btn-warning fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-mahasiswa">
                        Tambah User Mahasiswa
                    </button>
                    <button type="button" class="btn btn-lg btn-primary fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-dosen">
                        Tambah User Dosen
                    </button>
                    <button type="button" class="btn btn-lg bg-purple color-palette fa fa-plus" data-toggle="modal"
                        data-target="#modal-add-admin">
                        Tambah User Admin
                    </button>
                    <a href="/user/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat User Nonaktif </a>
                </div>


                <div class="card-body box-body table-hover">

                    <!-- Table Users -->
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
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modal-view{{ $data->id }}">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-teal-active color-palette"
                                            data-toggle="modal" data-target="#modal-change-password{{ $data->id }}">
                                            <i class="fa fa-fw fa-key"></i>
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

                    <!-- Modal Add Admin-->
                    <div class="modal fade" id="modal-add-admin">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Data User Admin</h4>
                                </div>

                                <div class="modal-header">
                                    <div class="callout bg-purple">
                                        <p><b>Peringatan!!!</b><br>
                                            Pastikan input data Admin sudah benar. Data <b>Admin</b>
                                            yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                            dihapus untuk alasan keamanan.
                                        </p>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <form action="/user/add/insert_user_admin" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Admin</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="username_admin" class="form-control"
                                                    value="{{ old('username_admin') }}" placeholder="Contoh: 5335">
                                                <div class="text-danger">
                                                    @error('username_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Admin</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_admin" class="form-control"
                                                    value="{{ old('nama_admin') }}"
                                                    placeholder="Contoh: Delsina Faiza, S.t.,M.t.">
                                                <div class="text-danger">
                                                    @error('nama_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>NIP/NIDN/NUPN</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nip_admin" class="form-control"
                                                    value="{{ old('nip_admin') }}"
                                                    placeholder="Contoh: 198304132009122002">
                                                <div class="text-danger">
                                                    @error('nip_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" id="jk_admin" name="jk_admin">
                                                    <option value="">- Pilih Jenis Kelamin -</option>
                                                    <option value="Laki-laki" @if (old('jk_admin') == 'Laki-laki') {{ 'selected' }} @endif>Laki-laki
                                                    </option>
                                                    <option value="Perempuan" @if (old('jk_admin') == 'Perempuan') {{ 'selected' }} @endif>Perempuan
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('jk_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <label class="text-danger">*</label>
                                                <input type="password" name="password_admin" class="form-control"
                                                    value="{{ old('password_admin') }}"
                                                    placeholder="Contoh: Password123">
                                                <div class="text-danger">
                                                    @error('password_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Admin</label>
                                                <div class="text-danger">
                                                    <p>Catatan : "Jika tidak memilih foto, maka foto akan
                                                        didefault-kan."</p>
                                                </div>
                                                <input type="file" name="avatar_admin">
                                                <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                    (ukuran max: 1MB)</p>
                                                <div class="text-danger">
                                                    @error('avatar_admin')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default btn-block"
                                                data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn bg-purple btn-block" value="submit">Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal add -->
                    </div>

                    <!-- Modal Add Dosen-->
                    <div class="modal fade" id="modal-add-dosen">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Data User Dosen</h4>
                                </div>

                                <div class="modal-header">
                                    <div class="callout bg-primary">
                                        <p><b>Peringatan!!!</b><br>
                                            Pastikan input data Dosen sudah benar. Data <b>Dosen</b>
                                            yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                            dihapus untuk alasan keamanan.
                                        </p>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <form action="/user/add/insert_user_dosen" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Kode Dosen</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="username_dosen" class="form-control"
                                                    value="{{ old('username_dosen') }}" placeholder="Contoh: 5335">
                                                <div class="text-danger">
                                                    @error('username_dosen')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Dosen</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_dosen" class="form-control"
                                                    value="{{ old('nama_dosen') }}"
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
                                                    value="{{ old('nip_dosen') }}"
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
                                                <select class="form-control" id="jk_dosen" name="jk_dosen">
                                                    <option value="">- Pilih Jenis Kelamin -</option>
                                                    <option value="Laki-laki" @if (old('jk_dosen') == 'Laki-laki') {{ 'selected' }} @endif>Laki-laki
                                                    </option>
                                                    <option value="Perempuan" @if (old('jk_dosen') == 'Perempuan') {{ 'selected' }} @endif>Perempuan
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('jk_dosen')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <label class="text-danger">*</label>
                                                <input type="password" name="password_dosen" class="form-control"
                                                    value="{{ old('password_dosen') }}"
                                                    placeholder="Contoh: Password123">
                                                <div class="text-danger">
                                                    @error('password_dosen')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Dosen</label>
                                                <div class="text-danger">
                                                    <p>Catatan : "Jika tidak memilih foto, maka foto akan
                                                        didefault-kan."</p>
                                                </div>
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
                        <!-- /.modal add -->
                    </div>

                    <!-- Modal Add Mahasiswa-->
                    <div class="modal fade" id="modal-add-mahasiswa">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="text-center modal-title">Tambah Data User Mahasiswa</h4>
                                </div>

                                <div class="modal-header">
                                    <div class="callout callout-warning">
                                        <p><b>Peringatan!!!</b><br>
                                            Pastikan input data Mahasiswa sudah benar. Data <b>Mahasiswa</b>
                                            yang sudah diinputkan merupakan data permanen yang tidak dapat diubah atau
                                            dihapus untuk alasan keamanan.
                                        </p>
                                    </div>
                                </div>

                                <div class="modal-body">
                                    <form action="/user/add/insert_user_mahasiswa" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>NIM </label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nim" class="form-control"
                                                    value="{{ old('nim') }}" placeholder="Contoh: 16076040">
                                                <div class="text-danger">
                                                    @error('nim')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Mahasiswa</label>
                                                <label class="text-danger">*</label>
                                                <input type="text" name="nama_mahasiswa" class="form-control"
                                                    value="{{ old('nama_mahasiswa') }}" placeholder="Contoh: Ahmad Imam">
                                                <div class="text-danger">
                                                    @error('nama_mahasiswa')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Tahun Masuk</label>
                                                <label class="text-danger">*</label>
                                                <select id="tahun" name="tahun" class="form-control ">
                                                    <option value="">- Pilih Tahun Masuk -</option>
                                                    {{ $last = date('Y') - 7 }}
                                                    {{ $now = date('Y') }}
                                                    @for ($i = $now; $i >= $last; $i--)
                                                        <option value="{{ $i }}" @if (old('tahun') == $i) {{ 'selected ' }} @endif>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                <div class="text-danger">
                                                    @error('tahun')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <label class="text-danger">*</label>
                                                <select class="form-control" id="jk_mahasiswa" name="jk_mahasiswa">
                                                    <option value="">- Pilih Jenis Kelamin -</option>
                                                    <option value="Laki-laki" @if (old('jk_mahasiswa') == 'Laki-laki') {{ 'selected' }} @endif>Laki-laki
                                                    </option>
                                                    <option value="Perempuan" @if (old('jk_mahasiswa') == 'Perempuan') {{ 'selected' }} @endif>Perempuan
                                                    </option>
                                                </select>
                                                <div class="text-danger">
                                                    @error('jk_mahasiswa')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Jurusan</label>
                                                <select class="form-control" name="kode_jurusan">
                                                    <option value="">- Pilih Jurusan -</option>
                                                    @foreach ($jurusan as $data)
                                                        <option value="{{ $data->kode_jurusan }}" @if (old('kode_jurusan') == $data->kode_jurusan) {{ 'selected ' }} @endif>
                                                            {{ $data->nama_jurusan }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_jurusan')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Grup</label>
                                                <select class="form-control" name="kode_grup">
                                                    <option value="">- Pilih Grup -</option>
                                                    @foreach ($grup as $data)
                                                        <option value="{{ $data->kode_grup }}" @if (old('kode_grup') == $data->kode_grup) {{ 'selected ' }} @endif>
                                                            {{ $data->kode_grup }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="text-danger">
                                                    @error('kode_grup')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <label class="text-danger">*</label>
                                                <input type="password" name="password_mahasiswa" class="form-control"
                                                    value="{{ old('password_mahasiswa') }}"
                                                    placeholder="Contoh: Password123">
                                                <div class="text-danger">
                                                    @error('password_mahasiswa')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Foto Mahasiswa</label>
                                                <div class="text-danger">
                                                    <p>Catatan : "Jika tidak memilih foto, maka foto akan
                                                        didefault-kan."</p>
                                                </div>
                                                <input type="file" name="avatar_mahasiswa">
                                                <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                    (ukuran max: 1MB)</p>
                                                <div class="text-danger">
                                                    @error('avatar_mahasiswa')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a> </p>
                                            </div>
                                        </div>
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
                        <!-- /.modal add -->
                    </div>

                    <!-- Modal View -->
                    @foreach ($user as $data)
                        <div class="modal fade" id="modal-view{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Detail {{ $data->nama }} </h4>
                                    </div>
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img"
                                            src="{{ url('avatar/' . $data->avatar) }}" alt="User profile picture">

                                        <h3 class="profile-username text-center">{{ $data->nama }}</h3>

                                        <p class="text-muted text-center">{{ $data->kode_admin }}</p>

                                        <ul class="list-group list-group-unbordered">
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
                                                <b>Level</b>
                                                @if ($data->level == 'admin')
                                                    <span class="pull-right bg-purple label-success"
                                                        data-id="{{ $data->level }}">Admin</span>

                                                @elseif ($data->level == 'dosen')
                                                    <span class="pull-right label-lg btn-primary"
                                                        data-id="{{ $data->level }}">Dosen</span>
                                                @else
                                                    <span class="pull-right label-lg label-warning"
                                                        data-id="{{ $data->level }}">Mahasiswa</span>
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

                    <!-- Modal Change Password -->
                    @foreach ($user as $data)
                        <!-- Modal Add Admin-->
                        <div class="modal fade" id="modal-change-password{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Ubah Password {{ $data->nama }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/user/change_password/{{ $data->id }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        value="{{ $data->username }}" readonly>
                                                    <div class="text-danger">
                                                        @error('username')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" class="form-control"
                                                        value="{{ $data->nama }}" readonly>
                                                    <div class="text-danger">
                                                        @error('nama')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Password Baru</label>
                                                    <input type="password" name="password" class="form-control"
                                                        value="{{ old('password') }}"
                                                        placeholder="Masukkan Password Baru">
                                                    <div class="text-danger">
                                                        @error('password')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default btn-block"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary btn-block"
                                                    value="submit">Simpan
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

                    <!-- Modal Nonaktif-->
                    @foreach ($user as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Nonaktifkan {{ $data->nama }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/user/nonaktif/{{ $data->id }}" class="btn btn-danger">Ya!</a>
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
