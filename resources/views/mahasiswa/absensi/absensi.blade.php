@extends('layout.template')

@section('title')
    Absensi | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Absensi
@endsection

@section('navigasi-satu')
    Absensi
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-absensi-dosen')
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


    @if ($cek_seksi == 0)
        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Maaf! Absensi tidak ditemukan.</h3>
                    <p>
                        Silahkan mengisi seksi perkuliahan terlebih dahulu. <br><br>
                        Untuk melakukannya, anda bisa meng-klik <a href="../../seksi_dosen">Seksi</a>. Kemudian buat seksi serta
                        masukkan input detailnya.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    @else
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title center">Data Absensi</h3>
                    </div>
                    <!-- /.box-header -->

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
                                        <td>
                                            <a class="btn bg-purple" href="/absensi_dosen/detail/{{ $data->id }}">
                                                <i class="fa fa-fw fa-pencil-square-o"></i>Kelola Absensi
                                            </a>
                                            <a class="btn btn-warning" href="/absensi_dosen/lihat_peserta/{{ $data->id }}">
                                                <i class="fa fa-fw fa-users">
                                                </i> Lihat Peserta
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.row -->
            </div>
        </section>
    @endif

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

@endsection