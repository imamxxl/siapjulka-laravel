<html>

<head>
    <title>Absensi Perkuliahan</title>
</head>
<link href="{{ asset('template') }}/bower_components/css-unp/style.css" rel="stylesheet" type="text/css"
    media="print">
<link href="{{ asset('template') }}/bower_components/css-unp/style.css" rel="stylesheet" type="text/css" />

<body onload="window.print()">
    <div id="bg" align="center">
        <img src="{{ url('logo/elektronika.jpg') }}">
    </div>
    <div id="page-SP">
        <div id="table-data">
            <p>&nbsp;</p><br>
            <table border="0" width="600px">
                <tr>
                    <td width="15%"><img style="width:60px;height:60px" src="{{ url('logo/elektronika-icon.png') }}"
                            alt='Logo' /></td>
                    <td>
                        <h4>JURUSAN TEKNIK ELEKTRONIKA</h4>
                        <h4>FAKULTAS TEKNIK</h4>
                        <h5>ABSENSI PERKULIAHAN</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br></BR></td>
                </tr>
                <tr>
                    <td>Prog. Studi</td>
                    <td colspan="1">: {{ $prodi }}</td>
                </tr>
                <tr>
                    <td>Seksi</td>
                    <td colspan="1">: <b>{{ $kode_seksi }}</b></td>
                </tr>
                <tr>
                    <td>Matakuliah</td>
                    <td colspan="2">: {{ $matakuliah }} ({{ $sks }} SKS)</td>
                </tr>
                <tr>
                    <td>Dosen</td>
                    <td colspan="2">: {{ $dosen }}</td>
                </tr>
                <tr>
                    <td>Tanggal Pertemuan</td>
                    <td colspan="2">: {{ date('d/m/Y', strtotime($tanggal_pertemuan)) }} </td>
                </tr>
                <tr>
                    <td>Materi</td>
                    @if ($materi_pertemuan == null)
                        <td colspan="2"> : <i class="text-muted">-</i></td>
                    @else
                        <td colspan="2"> : "{{ $materi_pertemuan }}"</td>
                    @endif
                </tr>
            </table>
            <br>
            <table width="600px" border="1">
                <tr>
                    <th width='2%' align='center'>No</th>
                    <th width='4%' align='center'>NIM</th>
                    <th width='30%' align='center'>Mahasiswa</th>
                    <th width='4%' align='center'>JK</th>
                    <th width='4%' align='center'>Keterangan</th>
                    <th width='30%' align='center'>Catatan</th>
                </tr>
                <?php $no = 1; ?>
                @foreach ($absensis as $data)
                    <tr>
                        <td align='center'>{{ $no++ }}</td>
                        <td>{{ $data->username }}</td>
                        <td>{{ $data->nama }}</td>

                        @if ($data->jk == 'Laki-laki')
                            <td align="center">L</td>
                        @else
                            <td align="center">P</td>
                        @endif

                        @if ($data->keterangan == 'hadir')
                            <td align="center">V</td>
                        @elseif ($data->keterangan == 'izin')
                            <td align="center">I</td>
                        @else
                            <td align="center">A</td>
                        @endif

                        <!-- Catatan absensi tiap mahasiswa -->
                        @if ($data->catatan == null)
                            <td align="center"><i class="text-muted">-</i></td>
                        @else
                            <td>{{ $data->catatan }}</td>
                        @endif
                    </tr>
                @endforeach
            </table>

            {{-- <div class='page-break'></div> --}}
            <p>&nbsp;</p><br />

            <table border="0" width="600px">
                <tr>
                    <td width="10%"><b>(V) Hadir</b></td>
                    <td width='29%'><b>: {{ $hitung_absensi_hadir }}</b></td>
                    <td width='10%'>&nbsp;</td>
                    <td width='20%'>Padang, {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td> <b>(I) Izin </b></td>
                    <td><b>: {{ $hitung_absensi_izin }}</b></td>
                    <td width='5%'>&nbsp;</td>
                    <td>Dosen Pengajar,</td>
                </tr>
                <tr>
                    <td> <b>(A) Alfa </b></td>
                    <td><b>: {{ $hitung_absensi_alfa }}
                        </b></td>
                    <td width='5%'>&nbsp;</td>
                    <td rowspan="2"></td>
                </tr>
                <tr>
                    <td> <b>Total</b></td>
                    <td><b>: {{ $hitung_semua_peserta }}
                        </b></td>
                    <td width='5%'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>{{ $dosen }}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>{{ $nip_dosen }}</td>
                </tr>
                <tr>
                    <td rowspan="2">
                        <img src="data:image/png;base64,{!! base64_encode($qrcode) !!}">
                    </td>
                    <td width='5%'>&nbsp;</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</htmL>
