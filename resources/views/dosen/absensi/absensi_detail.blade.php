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

    <!-- Main content -->

    @if ($deteksi_participant == 0)
        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404 </h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Maaf! Kelola Absensi tidak dapat diproses.</h3>
                    <p>
                        Hal ini karena peserta/mahasiswa belum ada. <br><br>
                        Untuk menambahkan peserta, anda bisa meng-klik <a href="{{ $link_tambah_peserta }}">Tambah
                            Peserta</a>.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    @else

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
                    <a href="/absensi_dosen/detail/{{ $data->id_seksi }}/pertemuan/{{ $data->id_pertemuan }}">
                        <div class="info-box {{ $color[$color_hitung] }}">
                            <?php $color_hitung++; ?>
                            <span class="info-box-icon">
                                <h1>{{ $no++ }}</h1>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Pertemuan Ke-{{ $pertemuanke++ }} <span
                                        class="text pull-right">
                                        {{ date('d-m-Y', strtotime($data->tanggal)) }}
                                    </span></span>
                                @if ($data->materi == null)
                                    <span class="info-box-number progress-description text-"> <i> Belum ada catatan materi
                                            perkuliahan </i> </span>
                                @else
                                    <span class="info-box-number progress-description">{{ $data->materi }}</span>
                                @endif
                                <span class="progress-description">
                                    Hadir : {{ $hitung_absensi_hadir[$return_deteksi_pertemuan] }}
                                    &nbsp;
                                    Izin : {{ $hitung_absensi_izin[$return_deteksi_pertemuan] }}
                                    &nbsp;
                                    Alfa : {{ $hitung_absensi_alfa[$return_deteksi_pertemuan] }}
                                    <br>
                                    Total : {{ $hitung_absensi_total[$return_deteksi_pertemuan] }}

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

            @if ($hitung_pertemuan >= 16)
                <div class="col-md-1 col-sm-6 col-xs-12 hidden">
                    <div class="info-box">
                        <div class="info-box-icon">
                            <button class="btn info-box bg-gray" type="button" data-toggle="modal"
                                data-target="#modal-add-pertemuan">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            @else
                <div class="col-md-1 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <div class="info-box-icon">
                            <button class="btn info-box bg-gray" type="button" data-toggle="modal"
                                data-target="#modal-add-pertemuan">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            @endif


        </div>
        <!-- /.row -->

        <!-- Modal Add-->
        <div class="modal fade" id="modal-add-pertemuan">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="text-center modal-title">Buat Pertemuan Perkuliahan Matakuliah @foreach ($nama_matakuliah as $makul) {{ $makul->nama_mk }}
                            @endforeach
                        </h4>
                    </div>

                    <div class="modal-body">
                        <form action="/absensi_dosen/insert_pertemuan_absensi/" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group hidden">
                                    <label>Seksi</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="kode_seksi" class="form-control" value="{{ $kode_seksi }}"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label>QR Code</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="qrcode_text" class="form-control hidden"
                                        value="{{ $qrcode_text }}" readonly>
                                </div>

                                <div class="form-group">
                                    <img src="data:image/png;base64,{!! base64_encode($qrcode) !!}">
                                    <input type="text" name="base64image" value="{!! base64_encode($qrcode) !!}" hidden>
                                    @foreach ($nama_matakuliah as $makul)
                                        <input type="text" name="nama_seksi" value="{{ $makul->kode_seksi }}" hidden>
                                    @endforeach
                                </div>

                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <label class="text-danger">*</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="tanggal_picker" type="text" class="form-control pull-right"
                                            id="datepicker" placeholder="07/26/2021">
                                    </div>
                                    <div class="text-danger">
                                        @error('tanggal_picker')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Materi Kuliah (Optional)</label>
                                    <textarea name="materi" class="form-control" rows="3"
                                        placeholder="Masukkan Materi ..."></textarea>
                                </div>
                                <div class="form-group hidden">
                                    <label>Jumlah Peserta</label>
                                    <label class="text-danger">*</label>
                                    <input type="text" name="jumlah_peserta" class="form-control"
                                        value="{{ $hitung_peserta }}" readonly>
                                </div>
                                @foreach ($detail_peserta as $data)
                                    <input type="hidden" name="detail_peserta[]" value="{{ $data->user_id }}">
                                @endforeach
                                @foreach ($detail_peserta as $data)
                                    <input type="hidden" name="imei_peserta[]" value="{{ $data->imei_participant }}">
                                @endforeach
                                <div class="form-group">
                                    <label>Peserta</label>
                                    <label class="text-danger">*</label>
                                    <table id="datatablepertemuan" class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Mahasiswa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($participant as $data)
                                                <tr class="pilih" data-id="{{ $data->username }}"
                                                    data-nama=" {{ $data->nama }}">
                                                    <td class=" content-header">{{ $no++ }}</td>
                                                    <td>{{ $data->username }}</td>
                                                    <td>{{ $data->nama }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn bg-blue btn-block">Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>

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
                <a class="btn btn-primary" href="/absensi_dosen"> Kembali </a>
                <a href="/absensi_dosen/detail/{{ $data->id }}/print" target="_blank"
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

    @endif

@endsection
