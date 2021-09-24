@extends('layout.template')

@section('title')
    FAQ | Siapjulka | UNP
@endsection

@section('judul-halaman')
    FAQ
@endsection

@section('navigasi-satu')
    FAQ
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-faq-mahasiswa')
@endsection

@section('isi-konten')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">1. Mengapa saya tidak bisa login?</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-sort-desc"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            Pastikan anda tidak lupa terhadap password anda. Jika anda lupa terhadap password anda silahkan
                            hubungi admin dan mintalah password anda untuk di reset kembali.
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">2. Mengapa saya tidak bisa melakukan absensi?</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-sort-desc"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            Langkah awal cobalah untuk memeriksa perangkat anda apakah sudah terhubung ke internet atau
                            belum. Jika sudah terhubung mulailah melakukan proses absensi kembali.
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">3. Saya sudah terhubung ke internet tetapi tetap tidak bisa melakukan
                                absensi?</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-sort-desc"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            Perlu diketahui, saat anda pertama kali menggunakan aplikasi android "SIAPJULKA" di
                            ponsel/smartphone anda, maka 1 imei/<i>device id</i> sudah terdaftar di dalam database. Dengan
                            kata lain, anda tidak dapat login akun di berbagai macam perangkat/ponsel. Jika hal tersebut
                            terjadi. maka mintalah kepada admin untuk mereset data perangkat anda.
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-default collapsed-box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">4. Saya sudah bergabung di dalam sesi matakuliah tertentu namun saat
                                proses absensi data saya tidak ditemukan.</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-sort-desc"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            Sebelum perkuliahan tatap muka pertama kali dilakukan (absensi pertama kali dilakukan) anda
                            harus memastikan terlebih dahulu kepada dosen pengajar bahwa anda terverifikasi di kelas
                            matakuliah tertentu. silahkan minta kepada dosen pengajar untuk memverifikasi data anda di dalam
                            sesi matakuliah.
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.col -->
        </div>
    </section>
@endsection
