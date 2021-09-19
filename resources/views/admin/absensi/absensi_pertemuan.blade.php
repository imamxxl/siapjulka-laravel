@extends('layout.template')

@section('title')
    Detail Absensi | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Detail Absensi
@endsection

@section('navigasi-satu')
    Manajemen Absensi
@endsection

@section('navigasi-dua')
    Kelola Absensi
@endsection

@section('navigasi-tiga')
    Detail Absensi
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-absensi')
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

        <div class="callout callout-info">
            <h4>Tip!</h4>
            Klik <a href="javascript:window.location.href=window.location.href">Segarkan</a> atau tekan tombol F5 untuk
            menyegarkan data absensi halaman ini.
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Seksi {{ $kode_seksi }}</h3>
                    </div>
                    <div class="box-body">
                        <button type="button" class="btn btn-lg btn-primary fa fa-pencil" data-toggle="modal"
                            data-target="#modal-edit-pertemuan">
                            Edit Pertemuan
                        </button>
                        <button type="button" class="btn btn-lg btn-danger fa fa-trash" data-toggle="modal"
                            data-target="#modal-delete-pertemuan">
                            Hapus Pertemuan Saat Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-purple">
                        <div class="widget-user-image">
                            <img class="img-circle" src="{{ url('avatar_pertemuan/' . 'logo_pertemuan.png') }}"
                                alt="User Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        @foreach ($matakuliah as $item)
                            <h3 class="widget-user-username">
                                {{ $item->nama_mk }}
                            </h3>
                        @endforeach

                        <h5 class="widget-user-desc">Pertemuan tanggal:
                            {{ date('m-d-Y', strtotime($tanggal_pertemuan)) }}
                        </h5>

                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a>Hadir <span class="pull-right badge bg-green">{{ $hitung_absensi_hadir }}</span></a>
                            </li>
                            <li><a>Izin <span class="pull-right badge bg-yellow">{{ $hitung_absensi_izin }}</span></a>
                            </li>
                            <li><a>Alfa <span class="pull-right badge bg-red">{{ $hitung_absensi_alfa }}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
            <!-- /.col -->

            <div class="col-md-5">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Persentasi Kehadiran</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Absensi</th>
                                <th>Progress</th>
                                <th style="width: 40px">Label</th>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Hadir</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-success"
                                            style="width: {{ $persentasi_hadir }}%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-green">{{ $persentasi_hadir }}%</span></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Izin</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-yellow"
                                            style="width: {{ $persentasi_izin }}%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-yellow">{{ $persentasi_izin }}%</span></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Alfa</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger"
                                            style="width: {{ $persentasi_alfa }}%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-red">{{ $persentasi_alfa }}%</span></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Total</td>
                                <td>
                                    <div class="progress progress-xs progress-striped active">
                                        <div class="progress-bar progress-bar-primary"
                                            style="width: {{ $persentasi_total }}%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-light-blue">{{ $persentasi_total }}%</span></td>
                            </tr>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            @foreach ($qr_image as $data)
                <div class="col-md-3">
                    <div class="box box-widget">
                        <div class="box-header text-center">
                            <img src="data:image/png;base64,{!! base64_encode($qrcode) !!}">
                        </div>
                        <div class="box-footer">
                            <button type="button" class="btn btn-sm bg-purple" data-toggle="modal"
                                data-target="#modal-recovery-qrcode">
                                <i class="fa fa-fw fa-refresh"></i>
                            </button>
                            <a href="/download/seksi{{ $data->id_seksi }}/qrcode{{ $data->id_pertemuan }}" target="_blank">
                                <button class=" btn btn-sm btn-success pull-right"><i class="fa fa-download"></i></button>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title center">Daftar Absensi</h3>
                    </div>

                    <div class="box-body">
                        <a href="/absensi/detail/{{ $data->id }}/pertemuan/{{ $data->id_pertemuan }}/print"
                            target="_blank" class="btn bg-green"><i class="fa fa-print"></i>
                            Print Absensi</a>
                    </div>

                    <div class="card-body box-body table-hover">
                        <table id="datatableparticipant" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Mahasiswa</th>
                                    <th>Kehadiran</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($absensis as $data)
                                    <tr>
                                        <td class="content-header">{{ $no++ }}</td>

                                        <td>{{ $data->username }}</td>
                                        <td>{{ $data->nama }}</td>

                                        <!-- Kehadiran -->
                                        @if ($data->keterangan == 'hadir')
                                            <td>
                                                <span class="label label-success">Hadir</span>
                                            </td>
                                        @elseif($data->keterangan == 'izin')
                                            <td>
                                                <span class="label label-warning">Izin</span>
                                            </td>
                                        @else
                                            <td>
                                                <span class="label label-danger">Alfa</span>
                                            </td>
                                        @endif

                                        <!-- Catatan Tiap Mahasiswa -->
                                        @if ($data->catatan == null)
                                            <td> <i class="text-muted">Belum ada catatan pada mahasiswa ini</i></td>
                                        @else
                                            <td>{{ $data->catatan }}</td>
                                        @endif

                                        <!-- Status Verifikasi -->
                                        @if ($data->verifikasi == '1')
                                            <td>
                                                <p class="text-green">Sudah Diverifikasi</p>
                                            </td>
                                        @else
                                            <td>
                                                <p class="text-red">Belum Diverifikasi</p>
                                            </td>
                                        @endif

                                        @if ($data->verifikasi == null)
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                                                    data-target="#modal-verifikasi{{ $data->id_absensi }}">
                                                    <i class="fa fa-fw fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-catatan{{ $data->id_absensi }}">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#modal-reset{{ $data->id_absensi }}">
                                                    <i class="fa fa-fw fa-circle-o-notch"></i>
                                                </button>
                                            </td>
                                        @else
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                    data-target="#modal-catatan{{ $data->id_absensi }}">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                    data-target="#modal-reset{{ $data->id_absensi }}">
                                                    <i class="fa fa-fw fa-circle-o-notch"></i>
                                                </button>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

        <!-- Modal Verifikasi Absensi -->
        @foreach ($absensis as $data)
            <div class="modal fade" id="modal-verifikasi{{ $data->id_absensi }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> Verifikasi {{ $data->nama }} ({{ $data->username }})</h4>
                        </div>
                        <div class="modal-body">
                            <p>Lakukan verifikasi absensi {{ $data->nama }} ({{ $data->username }}) ?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                            <a href="/absensi/verifikasi_absensi/{{ $data->id_absensi }}"
                                class="btn btn-success">Verifikasi</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endforeach

        <!-- Modal Catatan Absensi -->
        @foreach ($absensis as $data)
            <div class="modal fade" id="modal-catatan{{ $data->id_absensi }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> Tambahkan catatan {{ $data->nama }} ({{ $data->username }})
                            </h4>
                        </div>
                        <form action="/absensi/catatan_absensi/{{ $data->id_absensi }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <p>Tambahkan catatan terhadap peserta {{ $data->nama }} ({{ $data->username }})
                                </p>
                                <div class="form-group">
                                    <textarea name="catatan_absensi" class="form-control" rows="4"
                                        value="{{ $data->catatan }}"
                                        placeholder="Contoh: Mahasiswa ini sering terlambat jika masuk ke kelas">{{ $data->catatan }}</textarea>
                                    <div class="text-danger">
                                        @error('catatan_absensi')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <!-- iCheck -->
                                <div class="box box-success">
                                    <label>
                                        <h4 class="box-title">Status Kehadiran</h4>
                                    </label>
                                    <div class="box-body">
                                        <!-- radio -->
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="radio_hadir" class="flat-red" value="hadir"
                                                    {{ $data->keterangan == 'hadir' ? 'checked' : '' }}> Hadir
                                            </label> <br>
                                            <label>
                                                <input type="radio" name="radio_hadir" class="flat-red" value="izin"
                                                    {{ $data->keterangan == 'izin' ? 'checked' : '' }}> Sakit/Izin
                                            </label> <br>
                                            <label>
                                                <input type="radio" name="radio_hadir" class="flat-red" value=""
                                                    {{ $data->keterangan == null ? 'checked' : '' }}> Alfa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-block" value="submit">Simpan
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

        <!-- Modal Reset Absensi -->
        @foreach ($absensis as $data)
            <div class="modal fade" id="modal-reset{{ $data->id_absensi }}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"> Reset {{ $data->nama }} ({{ $data->username }})</h4>
                        </div>
                        <div class="modal-body">
                            <p>Anda yakin ingin melakukan reset absensi {{ $data->nama }} ({{ $data->username }})
                                ?
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                            <a href="/absensi/reset_absensi/{{ $data->id_absensi }}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        @endforeach

        <!-- Modal recovery QR-Code -->
        <div class="modal fade" id="modal-recovery-qrcode">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Perbaharui QR-Code</h4>
                    </div>

                    <div class="modal-body">
                        <form
                            action="/recovery/qrcode/absensi/{{ $data->id_seksi }}/pertemuan/{{ $data->id_pertemuan }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group hidden">
                                    <label>QR Code Baru</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="qrcode_text_baru" class="form-control hidden"
                                        value="{{ $qrcode_text_baru }}">
                                    <input type="text" name="nama_seksi" class="form-control hidden"
                                        value="{{ $data->kode_seksi }}">
                                </div>

                                <div class="form-group">
                                    <p class="text-center">
                                        <img src="data:image/png;base64,{!! base64_encode($qrcode_baru) !!}">
                                        <input type="text" name="base64image" value="{!! base64_encode($qrcode_baru) !!}" hidden>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <p class="text-center"><span class="label label-danger">NEW QR CODE</span></p>
                                </div>

                                <div class="form-group hidden">
                                    <label>Tanggal</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="tanggal" class="form-control" value="{{ $data->tanggal }}"
                                        readonly>
                                    <div class="text-danger">
                                        @error('tanggal')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p class="text-danger"> <b> Catatan : </b> </p>
                                    <p> QR-Code di atas merupakan QR-Code yang baru. Jika anda
                                        menekan tombol "Perbaharui QR-Code" di bawah, secara otomatis QR-Code lama tidak
                                        dapat digunakan lagi. </p>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary btn-block" value="submit">Perbaharui
                                    QR-Code
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>

        <!-- Modal Edit Pertemuan -->
        <div class="modal fade" id="modal-edit-pertemuan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> Edit Pertemuan Seksi {{ $data->kode_seksi }} - {{ $item->nama_mk }}
                        </h4>
                    </div>
                    <form action="/edit/seksi/{{ $data->id_seksi }}/pertemuan/{{ $data->id_pertemuan }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <label class="text-danger">*</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="tanggal_picker" type="text" class="form-control pull-right" id="datepicker"
                                        value="{{ date('m/d/Y', strtotime($tanggal_pertemuan)) }}"
                                        placeholder="07/26/2021">
                                </div>
                                <div class="text-danger">
                                    @error('tanggal_picker')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Materi Kuliah (Optional)</label>
                                <textarea name="materi" class="form-control" rows="4">{{ $data->materi }}</textarea>
                            </div>
                            <div class="form-group hidden">
                                <p class="text-center">
                                    <img src="data:image/png;base64,{!! base64_encode($qrcode) !!}">
                                    <input type="text" name="base64image" value="{!! base64_encode($qrcode) !!}" hidden>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary btn-block" value="submit">Ubah
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Modal Delete Absensi dan Pertemuan -->
        <div class="modal fade" id="modal-delete-pertemuan">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"> Hapus Pertemuan Tanggal
                            {{ date('m-d-Y', strtotime($tanggal_pertemuan)) }} (Matakuliah {{ $item->nama_mk }}) ?
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger"><b>Peringatan!!!</b></p>
                        <P> Jika anda telah menghapus data ini, semua data absensi pada pertemuan ini akan dihapus secara
                            <b> PERMANEN</b>. <br> Perlu diingat!, data yang telah dihapus tidak dapat di kembalikan lagi.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
                        <a href="/delete/seksi/{{ $data->id_seksi }}/pertemuan/{{ $data->id_pertemuan }}"
                            class="btn btn-danger">Hapus</a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div>
            <a class="btn btn-primary" href="{{ $previous }}"> Kembali </a>
        </div>

    </section>

@endsection
