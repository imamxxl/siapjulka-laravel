@extends('layout.template')

@section('title')
    Dashboard | Siapjulka | UNP
@endsection

@section('judul-halaman')
    Dashboard
@endsection

@section('navigasi-satu')
    Dashboard
@endsection

@section('bagian-nav')
    @include('layout.nav.nav-dashboard-dosen')
@endsection

@section('isi-konten')
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            {{-- <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3>{{ $hitung_user }}</h3>
                        <p>User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="/user" class="small-box-footer">Lihat Selengkapnya <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            {{-- <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $hitung_matakuliah }}</h3>
                        <p>Matakuliah</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-paper"></i>
                    </div>
                    <a href="/matakuliah-dosen" class="small-box-footer">Lihat Selengkapnya <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $hitung_seksi }}</h3>
                        <p>Seksi</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-clipboard"></i>
                    </div>
                    <a href="/seksi_dosen" class="small-box-footer">Lihat Selengkapnya <i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            {{-- <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $hitung_ruangan }}</h3>
                        <p>Ruangan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-grid-view"></i>
                    </div>
                    <a href="/ruang" class="small-box-footer">Lihat Selengkapnya <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div> --}}
        </div>
    </section>
@endsection
