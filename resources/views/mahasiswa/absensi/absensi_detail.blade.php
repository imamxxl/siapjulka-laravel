@extends('layout.template')

@section('title')
    Kelola Absensi | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Kelola Absensi
@endsection

@section('navigasi-satu')
    Manajemen Absensi
@endsection

@section('navigasi-dua')
    Kelola Absensi
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
    @foreach ($data_seksi as $data)
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Seksi : {{ $data->kode_seksi }}</h3>
                        <h3 class="box-title pull-right">Matakuliah : {{ $data->nama_mk }}</h3>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class=" col-md-12">
            <div>
                <button class="btn btn-primary color-palette" type="button" data-toggle="modal"
                    data-target="#modal-token">Token: {{ $data->token }}</button>
            </div>
            <br>
        </div>
    </div>

    <div class="row">
        <?php $no = 1; ?> <?php $pertemuanke = 1; ?>
        @foreach ($rincian_pertemuan as $data)
            <div class="col-md-6 col-md-6 col-xs-12">
                <a href="/absensi_mahasiswa/detail/{{ $data->id_seksi }}/pertemuan/{{ $data->id_pertemuan }}">
                    <div class="info-box {{ $color[$color_hitung] }}">
                        <?php $color_hitung++; ?>
                        <span class="info-box-icon">
                            <h1>{{ $no++ }}</h1>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pertemuan Ke-{{ $pertemuanke++ }} <span class="text pull-right">
                                    {{ date('d-m-Y', strtotime($data->tanggal)) }}
                                </span></span>
                            @if ($data->materi == null)
                                <span class="info-box-number progress-description text-"> <i> Belum ada catatan materi
                                        perkuliahan </i> </span>
                            @else
                                <span class="info-box-number progress-description">{{ $data->materi }}</span>
                            @endif
                            <span class="progress-description">
                                @if ($get_keterangan[$return_deteksi_pertemuan] == null)
                                    Kehadiran: <b>alfa</b>
                                @else
                                    Kehadiran: <b>{{ $get_keterangan[$return_deteksi_pertemuan] }}</b>
                                @endif
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>

                </a>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php $return_deteksi_pertemuan++; ?>
        @endforeach
    </div>
    <!-- /.row -->

    <!-- Modal Token -->
    <div class="modal modal-primary fade" id="modal-token">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">Token</h4>
                </div>
                <div class="modal-body">
                    @foreach ($data_seksi as $data)
                        <h3 class="text-center" id="text-copy">{{ $data->token }}</h3>
                        <h3 class="text-center"><button type="button" class="btn btn-copy btn-outline"><i
                                    class="fa fa-copy"></i></button></h3>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    @foreach ($data_seksi as $data)
        <div>
            <a class="btn btn-primary" href="/absensi_mahasiswa"> Kembali </a>
            <a href="/absensi_mahasiswa/detail/{{ $data->id }}/print" target="_blank"
                class="btn bg-green pull-right"><i class="fa fa-print"></i>
                Print Absensi 1 Semester</a>
        </div>
    @endforeach

    <script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.btn-copy').on("click", function() {
                var value = $('#text-copy').text();

                var $tempCopy = $("<input>");
                $("body").append($tempCopy);
                $tempCopy.val(value).select();
                document.execCommand("copy");
                $tempCopy.remove();
            })
        })
    </script>


@endsection
