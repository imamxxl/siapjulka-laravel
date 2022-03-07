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
                        <h4>UNIVERSITAS NEGERI PADANG</h4>
                        <h5>LAPORAN ABSENSI PERMATAKULIAH</h5>
                    </td>
                </tr>
                {{-- <tr>
                    <td colspan="2"><br></BR></td>
                </tr>
                <tr>
                    <td>Prog. Studi</td>
                    <td colspan="1">: 
                        {{ $prodi }}
                    </td>
                </tr>
                <tr>
                    <td>Seksi</td>
                    <td colspan="1">: 
                        <b>{{ $kode_seksi }}</b>
                    </td>
                </tr>
                <tr>
                    <td>Matakuliah</td>
                    <td colspan="2">: 
                        {{ $matakuliah }} ({{ $sks }} 
                        SKS)</td>
                </tr>

                <tr>
                    <td>Dosen</td>
                    <td colspan="2">: 
                        {{ $dosen }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Pertemuan</td>
                    <td colspan="2">: 
                        {{ date('d/m/Y', strtotime($tanggal_pertemuan)) }} 
                    </td>
                </tr>
                <tr>
                    <td>Materi</td>
                    @if ($materi_pertemuan == null)
                        <td colspan="2"> : <i class="text-muted">-</i></td>
                    @else
                        <td colspan="2"> : "{{ $materi_pertemuan }}"</td>
                    @endif
                </tr> --}}
            </table>
            <br>
            <table width="650px" border="1">
                <tr>
                    <th width='2%' align='center'>No</th>
                    <th width='4%' align='center'>Seksi</th>
                    <th width='30%' align='center'>Matakuliah</th>
                    <th width='4%' align='center'>SKS</th>
                    <th width='8%' align='center'>Total Mahasiswa Hadir</th>
                    <th width='8%' align='center'>Total Mahasiswa Izin</th>
                    <th width='8%' align='center'>Total Mahasiswa Alpa</th>
                    <th width='8%' align='center'>Total Absensi yang dilakukan</th>
                    {{-- <th width='8%' align='center'>Persentasi Keberhasilan Perkuliahan</th> --}}
                </tr>
                <?php $no = 1; ?>
                @foreach ($absensis as $key => $data)
                    <tr>
                        <td align='center'>{{ $no++ }}</td>
                        <td>{{ $data->kode_seksi }}</td>
                        <td>{{ $data->nama_mk }}</td>
                        <td align="center">{{ $data->sks }}</td>

                        <!-- Jumlah Hadir -->
                        <td align="center">{{ $hitung_absensi_hadir[$key] }}</td>

                        <!-- Jumlah Izin -->
                        <td align="center">{{ $hitung_absensi_izin[$key] }}</td>

                        <!-- Jumlah Alfa -->
                        <td align="center">{{ $hitung_absensi_alfa[$key] }}</td>

                        <!-- Jumlah Total -->
                        <td align="center">{{ $hitung_absensi_total[$key] }}</td>
                    </tr>
                @endforeach
            </table>

            <div class='page-break'></div>
            <p>&nbsp;</p><br />
            <table border="0" width="600px">
                <tr>
                    <td width='29%'>
                        <b>
                            {{-- {{ $hitung_absensi_hadir }} --}}
                        </b>
                    </td>
                    <td width='10%'>&nbsp;</td>
                    <td width='20%'>Padang, {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    {{-- <td></td> --}}
                    <td>
                        <b>
                            {{-- {{ $hitung_absensi_izin }} --}}
                        </b>
                    </td>
                    <td width='5%'>&nbsp;</td>
                    <td>Dekan Jurusan</td>
                </tr>
            </table>

            {{-- <table border="0" width="600px">
                <tr>
                    <td width="10%"><b> (V) Hadir</b></td>
                    <td width='29%'><b>:
                            {{ $hitung_absensi_hadir }}
                        </b>
                    </td>
                    <td width='10%'>&nbsp;</td>
                    <td width='20%'>Padang, {{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td> <b>(I) Izin</b></td>
                    <td>
                        <b>:
                            {{ $hitung_absensi_izin }}
                        </b>
                    </td>
                    <td width='5%'>&nbsp;</td>
                    <td>Dosen Pengajar,</td>
                </tr>
                <tr>
                    <td> <b>(A) Alfa</b></td>
                    <td><b>:
                            {{ $hitung_absensi_alfa }}
                        </b></td>
                    <td width='5%'>&nbsp;</td>
                    <td rowspan="2"></td>
                </tr>
                <tr>
                    <td> <b>Total</b></td>
                    <td><b>:
                            {{ $hitung_semua_peserta }}
                        </b></td>
                    <td width='5%'>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>
                        {{ $dosen }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>
                        {{ $nip_dosen }}
                    </td>
                </tr>
                <tr>
                    <td rowspan="2">
                        <img src="data:image/png;base64,{!! base64_encode($qrcode) !!}">
                    </td>
                    <td width='5%'>&nbsp;</td>
                </tr>
            </table> --}}
        </div>
    </div>
</body>

</htmL>
