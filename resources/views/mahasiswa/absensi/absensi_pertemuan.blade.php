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
    @include('layout.nav.nav-absensi-mahasiswa')
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
                        <h3 class="box-title">Seksi: {{ $kode_seksi }}</h3>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title">Matakuliah: {{ $deteksi_matakuliah }}</h3>
                    </div>
                    <div class="box-header with-border">
                        <h3 class="box-title">Pertemuan Tanggal: {{ date('d-m-Y', strtotime($tanggal_pertemuan)) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-question-circle"></i>
                        <h3 class="box-title">Cara Melakukan Absensi</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <ol>
                            <li>Mintalah QR Code dari dosen pengajar matakuliah terkait.</li>
                            <li>Contoh QR Code yang anda dapatkan kurang lebih seperti gambar di samping.
                                <br>
                                <i class="text-red">Catatan:</i>
                                <ul class="text-red">
                                    <li> <i>QR Code di samping hanya sebagai contoh</i> </li>
                                    <li> <i>Anda TIDAK dapat menjadikan QR Code tersebut untuk melakukan proses absensi</i> </li>
                                    <li> <i>QR Code yang valid adalah QR Code yang hanya diberikan oleh dosen matakuliah terkait</i> </li>
                                </ul>
                            </li>
                            <li>Lakukan <i>scanning</i> QR Code melalui aplikasi "SIAPJULKA" di smartphone Android anda.
                                <br>
                                <i class="text-red">Catatan: QR Code bisa dianggap sebagai password untuk verifikasi
                                    kehadiran anda di dalam sebuah kelas</i>
                            </li>
                            <li>Jika anda sudah melakukan <i>scanning</i> QR Code, maka anda dapat melakukan pengecekan status absensi (sudah / belum diverifikasi).
                                <br>
                                <i class="text-red">Catatan: Anda boleh melakukan konfirmasi kepada dosen matakuliah terkait apabila status kehadiran anda tidak sesuai atau belum diverifikasi</i>
                            </li>
                        </ol>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- ./col -->

            @foreach ($qr_image as $data)
                <div class="col-md-3">
                    <div class="box box-widget">
                        <div class="box-header text-center">
                            <img src="data:image/png;base64,{!! base64_encode($qrcode) !!}">
                        </div>
                        <div class="box-footer">
                            <h4 class="text-center">Scan QR Code Ini</h4>
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
                        <a href="/absensi_mahasiswa/detail/{{ $data->id }}/pertemuan/{{ $data->id_pertemuan }}/print"
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
                                    <th>Status</th>
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

                                        <!-- Status Verifikasi -->
                                        @if ($data->verifikasi == '1')
                                            <td>
                                                <p class="text-green">Sudah Diverifikasi Dosen Pengajar</p>
                                            </td>
                                        @else
                                            <td>
                                                <p class="text-red">Belum Diverifikasi Dosen Pengajar</p>
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

        <div>
            <a class="btn btn-primary" href="{{ $previous }}"> Kembali </a>
        </div>

    </section>

@endsection
