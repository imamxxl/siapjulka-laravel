@extends('layout.template')

@section('title')
    Manajemen Mahasiswa | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Manajemen Mahasiswa
@endsection

@section('navigasi-satu')
    Manajemen Mahasiswa
@endsection

@section('navigasi-dua')
    Manajemen Mahasiswa
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
                    <h3 class="box-title center">Data Mahasiswa</h3>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                    <a href="/mahasiswa/nonaktif" class="btn btn-lg btn-default fa fa-eye"> Lihat Mahasiswa Non-Aktif
                    </a>
                </div>

                <!-- Table Mahasiswas -->
                <div class="card-body box-body table-hover">
                    <table id="datatableid" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM / Tahun Masuk</th>
                                <th>Nama</th>
                                <th>IMEI</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($mahasiswa as $data)
                                <tr>
                                    <td class="content-header">{{ $no++ }}</td>
                                    <td>{{ $data->nim }} / {{ $data->tahun }}</td>
                                    <td>{{ $data->nama_mahasiswa }}</td>
                                    @if ($data->imei == null)
                                        <td><i class="text-muted">Belum ada IMEI</i></td>
                                    @else
                                        <td>{{ $data->imei }}</td>
                                    @endif
                                    <!-- Status Mahasiswa -->
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
                                            data-target="#modal-view{{ $data->id }}">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modal-edit{{ $data->id }}">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm bg-purple" data-toggle="modal"
                                            data-target="#modal-reset-imei{{ $data->id }}">
                                            <i class="fa fa-fw fa-minus-square"></i>
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

                    <!-- Modal Add -->
                    <div class="modal fade" id="modal-add">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Tambah Data Mahasiswa</h4>
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
                                    <form action="/mahasiswa/add/insert" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>NIM</label>
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
                                                <input type="text" name="nama_mahasiswa" class="form-control"
                                                    value="{{ old('nama_mahasiswa') }}" placeholder="Contoh: Ahmad Imam">
                                                <div class="text-danger">
                                                    @error('nama_mahasiswa')
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
                                                <input type="file" name="avatar">
                                                <p class="help-block">Masukkan foto dengan format ".jpg/.jpeg/.png"
                                                    (ukuran max: 1MB)</p>
                                                <div class="text-danger">
                                                    @error('avatar')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
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

                    <!-- Modal View -->
                    @foreach ($mahasiswa as $data)
                        <div class="modal fade" id="modal-view{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"> Detail {{ $data->nama_mahasiswa }} </h4>
                                    </div>
                                    {{-- <div class="box box-primary"> --}}
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img"
                                            src="{{ url('avatar/' . $data->avatar) }}" alt="User profile picture">

                                        <h3 class="profile-username text-center">{{ $data->nama_mahasiswa }}</h3>

                                        <p class="text-muted text-center">{{ $data->nim }}</p>

                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b>Tahun Masuk</b>
                                                <p class="pull-right">{{ $data->tahun }}</p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Status</b>
                                                <!-- Status Mahasiswa -->
                                                @if ($data->status == '1')
                                                    <span class="pull-right label-lg label-success"
                                                        data-id="{{ $data->status }}">Aktif</span>
                                                @else
                                                    <span class="pull-right label-lg label-danger"
                                                        data-id="{{ $data->status }}">Nonaktif</span>
                                                @endif
                                            </li>
                                            <li class="list-group-item">
                                                <b>Grup</b>
                                                <p class="pull-right">{{ $data->kode_grup }}</p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Jurusan</b>
                                                <!-- Jurusan -->
                                                @if ($data->kode_jurusan == 'S1-PTIK')
                                                    <p class="pull-right">Pendidikan Teknik Informatika dan
                                                        Komputer (S1) </p>
                                                @elseif ($data->kode_jurusan == 'S1-PTE')
                                                    <p class="pull-right">Pendidikan Teknik Elektronika (S1)</p>
                                                @elseif ($data->kode_jurusan == 'D3-PTE')
                                                    <p class="pull-right">Teknik Elektronika (D3)</p>
                                                @else
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
                    @foreach ($mahasiswa as $data)
                        <div class="modal fade" id="modal-edit{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">Edit {{ $data->nama_mahasiswa }}</h4>
                                    </div>

                                    <div class="modal-body">
                                        <form action="/mahasiswa/update/{{ $data->id }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="box-body">

                                                <div class="form-group hidden">
                                                    <label>ID Mahasiswa</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="id_mahasiswa" class="form-control"
                                                        value="{{ $data->user_id }}" readonly>
                                                    <div class="text-danger">
                                                        @error('id_mahasiswa')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>NIM</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="nim" class="form-control"
                                                        value="{{ $data->nim }}" readonly>
                                                    <div class="text-danger">
                                                        @error('nim')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Tahun Masuk</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="tahun" class="form-control"
                                                        value="{{ $data->tahun }}" readonly>
                                                    <div class="text-danger">
                                                        @error('tahun')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Nama Mahasiswa</label>
                                                    <label class="text-danger">*</label>
                                                    <input type="text" name="nama_mahasiswa" class="form-control"
                                                        value="{{ $data->nama_mahasiswa }}"
                                                        placeholder="Contoh: Ahmad Imam">
                                                    <div class="text-danger">
                                                        @error('nama_mahasiswa')
                                                            {{ $message }}
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Jenis Kelamin</label>
                                                    <label class="text-danger">*</label>
                                                    @if ($data->jk == 'Laki-laki')
                                                        <select name="jk_mahasiswa" class="form-control">
                                                            <option value="Laki-laki" selected>Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                    @elseif($data->jk == "Perempuan")
                                                        <select name="jk_mahasiswa" required class="form-control">
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan" selected>Perempuan
                                                            </option>
                                                        </select>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label>Jurusan</label>
                                                    <select class="form-control" name="kode_jurusan">
                                                        <option value="">- Pilih Jurusan -</option>
                                                        @foreach ($jurusan as $list_jurusan)
                                                            <option value="{{ $list_jurusan->kode_jurusan }}"
                                                                {{ $list_jurusan->kode_jurusan == $data->kode_jurusan ? 'selected' : '' }}>
                                                                {{ $list_jurusan->nama_jurusan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Grup</label>
                                                    <select class="form-control" name="kode_grup">
                                                        <option value="">- Pilih Grup -</option>
                                                        @foreach ($grup as $list_grup)
                                                            <option value="{{ $list_grup->kode_grup }}"
                                                                {{ $list_grup->kode_grup == $data->kode_grup ? 'selected' : '' }}>
                                                                {{ $list_grup->kode_grup }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <img src="{{ url('avatar/' . $data->avatar) }}" width="80">
                                                </div>

                                                <div class="form-group">
                                                    <label>Foto Mahasiswa</label>
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
                                                    <p>Keterangan: <a class="text-danger disabled">(*) Wajib diisi</a>
                                                    </p>
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
                    @foreach ($mahasiswa as $data)
                        <div class="modal fade" id="modal-nonaktif{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Nonaktifkan {{ $data->nama_mahasiswa }} </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-danger">
                                            <p><b>Peringatan : </b></p>
                                        </div>
                                        <p>Anda yakin ingin <b> menghapus/menonaktifkan </b> data
                                            {{ $data->nama_mahasiswa }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/mahasiswa/nonaktif/{{ $data->id }}" class="btn btn-danger">Ya!</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    @endforeach

                    <!-- Modal Reset IMEI -->
                    @foreach ($mahasiswa as $data)
                        <div class="modal fade" id="modal-reset-imei{{ $data->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Reset IMEI {{ $data->nama_mahasiswa }} </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <p><b>Catatan : </b></p>
                                        </div>
                                        <p>Saat reset IMEI dilakukan, maka IMEI akan kosong.</p>
                                        <p>Mahasiswa diminta untuk mengirim IMEI ulang melalui Smartphone masing-masing.</p>
                                        <br>
                                        <p>Anda yakin ingin <b> mereset </b> IMEI
                                            {{ $data->nama_mahasiswa }}?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left"
                                            data-dismiss="modal">Tidak</button>
                                        <a href="/mahasiswa/reset_imei/{{ $data->id }}" class="btn bg-purple">Ya!</a>
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
