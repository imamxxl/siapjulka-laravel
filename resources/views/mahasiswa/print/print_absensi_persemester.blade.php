<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Absensi {{ $matakuliah }}</title>
</head>

<link href="{{ asset('template') }}/bower_components/css-unp/style.css" rel="stylesheet" type="text/css" />

<body onload="window.print()">
    <br>
    <br>

    <div id="page-SP">

        <table align="center" width="91%" style="border-collapse:collapse" border="1">
            <tr>
                <td><br>
                    <table align="center" width="97%" border="0">
                        <tr>
                            <td width="20%" align="center"><img style="padding:5px;width:60px;height:60px;"
                                    src="{{ url('logo/elektronika-icon.png') }}" alt="LOGO" /></td>
                            <td colspan="3" width="85%" align="left">
                                <h2 style="text-align:left">JURUSAN TEKNIK ELEKTRONIKA</h2>
                                <h1 style="text-align:left">FAKULTAS TEKNIK</h1>
                            </td>
                            <td width="60%" colspan="2" align="center"></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <hr>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5" align="center">
                                <h2>ABSENSI PERKULIAHAN</h2>
                            </td>
                            {{-- <td rowspan="7" align="center"></td> --}}
                        </tr>
                        <tr>
                            <td colspan="5" align="center">
                                <h2>SEMESTER {{ $keterangan_semester }} {{ $get_tahun }} ({{ $nama_semester }})
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="20%" colspan="1"><b>Program Studi</b></td>
                            <td colspan="4"><b>: {{ $prodi }}</b></td>
                        </tr>
                        <tr>
                            <td width="20%" colspan="1"><b>Seksi</b></td>
                            <td colspan="4"><b>: {{ $get_kode_seksi }}</b></td>
                        </tr>
                        <tr>
                            <td width="20%" colspan="1"><b>Matakuliah</b></td>
                            <td colspan="4"><b>: {{ $matakuliah }}</b></td>
                        </tr>
                        <tr>
                            <td width="20%" colspan="1"><b>Dosen</b></td>
                            <td colspan="4"><b>: {{ $dosen }}</b></td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <table width="100%" style="border-collapse:collapse;" border="1" align="center">
                                    <tr>
                                        <th width="3%" rowspan="2">No</th>
                                        <th width="5%" rowspan="2">NIM</th>
                                        <th width="28%" colspan="2">Mahasiswa</th>
                                        <th width="56%" colspan="16" align="center">Pertemuan</th>
                                        <th width="10%" colspan="3" align="center">Jumlah</th>
                                    </tr>
                                    <tr>
                                        <th> Nama </th>
                                        <th width="6%">JK</th>
                                        <th width="4%">1</th>
                                        <th width="4%">2</th>
                                        <th width="4%">3</th>
                                        <th width="4%">4</th>
                                        <th width="4%">5</th>
                                        <th width="4%">6</th>
                                        <th width="4%">7</th>
                                        <th width="4%">8</th>
                                        <th width="4%">9</th>
                                        <th width="4%">10</th>
                                        <th width="4%">11</th>
                                        <th width="4%">12</th>
                                        <th width="4%">13</th>
                                        <th width="4%">14</th>
                                        <th width="4%">15</th>
                                        <th width="4%">16</th>
                                        <th width="4%">Hadir</th>
                                        <th width="4%">Izin</th>
                                        <th width="4%">Alfa</th>
                                    </tr>

                                    <?php $no = 1; ?>
                                    @foreach ($participant as $key => $mahasiswa)
                                        <tr>
                                            <td align="center">{{ $no++ }}</td>
                                            <td>{{ $mahasiswa->username }}</td>
                                            <td>{{ $mahasiswa->nama }}</td>
                                            @if ($mahasiswa->jk == 'Laki-laki')
                                                <td align="center">L</td>
                                            @else
                                                <td align="center">P</td>
                                            @endif

                                            @foreach ($get_ket_absensi[$key] as $absensi)
                                                @if ($absensi == 'hadir')
                                                    <td bgcolor="#3bff5b" align="center">V</td>
                                                @elseif($absensi == 'izin')
                                                    <td bgcolor="#edff2a" align="center">I</td>
                                                @else
                                                    <td bgcolor="#ff534b" align="center">A</td>
                                                @endif
                                            @endforeach

                                            @for ($i = 1; $i <= $jmlh_pertemuan_saat_ini; $i++)
                                                <td align="center">-</td>
                                            @endfor

                                            <!-- Hitung hadir tiap peserta -->
                                            <td align="center">{{ $get_ket_hadir[$key] }}</td>

                                            <!-- Hitung Izin tiap peserta -->
                                            <td align="center">{{ $get_ket_izin[$key] }}</td>

                                            <!-- Hitung Alfa tiap peserta -->
                                            @if ($get_ket_alfa[$key] == 4)
                                                <td bgcolor="red" align="center">4</td>
                                            @else
                                                <td align="center">{{ $get_ket_alfa[$key] }}</td>
                                            @endif
                                            
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" align="right" width="50%">&nbsp</td>
                            <td><br>Padang, {{ date('d-m-Y') }}</td>
                        </tr>

                        <tr>
                            <td colspan="4" align="right">&nbsp</td>
                            <td colspan="1">Dosen</td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>

                        <tr>
                            <td colspan="2" align="center"><b></td>
                            <td colspan="2" align="right">&nbsp</td>
                            <td><b>{{ $dosen }}</b></td>
                        </tr>

                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>

                    </table>
                    </br>
                </td>
            </tr>
        </table>

    </div>
</body>

</html>
