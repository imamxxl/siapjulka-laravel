@extends('layout.template')

@section('title')
    Cari Kelas | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Cari Kelas
@endsection

@section('navigasi-satu')
    Cari Kelas
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-cari-kelas')
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
            <h4><i class="icon fa fa-ban"></i> Kelas gagal ditemukan </h4>
            {{ session('pesan-gagal') }}
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="row">

                <div class="col-md-6">
                    <div class="box">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title">Cari Kelas Dengan Token</h3>
                            </div>
                            <div class="panel-body">
                                <form action="/cari_kelas/detail" method="GET" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="token" id="token"
                                            value="{{ old('token') }}" placeholder="Contoh: x6suGJ">
                                        <div class="text-danger">
                                            @error('token')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-warning">Cari Token <span
                                            class="glyphicon glyphicon-search"></span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <i class="fa fa-info-circle"></i>
                            <h3 class="box-title">Info</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul>
                                <li>Minta Token kepada dosen matakuliah terkait</li>
                                <li>Inputkan Token</li>
                                <li>Tunggu dan konfirmasikan kepada dosen pengajar agar anda diverifikasi di kelasnya</li>
                                <li>Peringatan: Jika anda TIDAK terverifikasi di kelas tertentu, anda tidak akan dapat
                                    mengambil presensi</li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- ./col -->
            </div>
            <!-- /.col -->
        </div>
    </section>

@endsection
