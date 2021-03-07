<!DOCTYPE html>
<html>

<head>
    <title>Berita Acara PK</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Times New Roman";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        table {
            border-collapse: collapse;
        }

        table td {
            vertical-align: top;
        }

        .score td {
            vertical-align: middle;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 1cm;
            padding-top: 0.2cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            height: 256mm;
        }

        .page-body {
            padding: 0cm 1cm;
        }

        .page-header {
            padding-top: 0cm;
            padding-bottom: 1cm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        .table-info table,
        .table-info th,
        .table-info td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .table-info th,
        .table-info td {
            padding: 5px 15px
        }

        .table-signature th,
        .table-signature td {
            padding: 5px 15px
        }

        .page-title {
            text-align:center;
            font-weight:600;
            font-size:14pt
        }
        .mt-50 {
            margin-top:50px
        }
        .mt-25 {
            margin-top:25px
        }
        .mt-10 {
            margin-top:5px
        }
        ul {
            margin:5px
        }
        .w-100 {
            width:100%
        }

    </style>
</head>

<body id="body">
    <div class="book">
        <div class="page">
            <div class="subpage">
                <div class="page-header">
                    <table style="border-bottom: 5px solid black;">
                        <tr>
                            <td width="15%"><img src="{{ asset('image/ulm.png') }}" alt="" class="w-100"></td>
                            <td align="center">
                                <div style="font-size:16pt">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
                                <div style="font-size:14pt">UNIVERSITAS LAMBUNG MANGKURAT</div>
                                <div style="font-size:14pt">FAKULTAS TEKNIK</div>
                                <div style="font-size:14pt"><b>PROGRAM STUDI TEKNOLOGI INFORMASI</b></div>
                                <div>Alamat  Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</div>
                                <div>Telepon/Fax. : (0511) 4773858-4773868</div>
                                <div>Laman: http://www.ft.ulm.ac.id</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="page-body">
                    <div class="page-title">BERITA ACARA SEMINAR PROYEK KELOMPOK</div>
                    <div class="mt-25">
                        <table width="100%">
                            <tr>
                                <td width="20%">Pada, </td>
                                <td width="5%"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="20%">Hari/Tanggal</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->GroupProjectSchedule->day }}, {{ $groupProject->GroupProjectSchedule->tanggal }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Waktu</td>
                                <td width="5%">:</td>
                                <td>{{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time)->isoFormat('HH.mm') }} -
                                    {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time_end)->isoFormat('HH.mm') }} WITA</td>
                            </tr>
                            <tr>
                                <td width="20%">Tempat</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->GroupProjectSchedule->place }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Judul PK</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->title }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Semester</td>
                                <td width="5%">:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="20%">Tahun Akademik</td>
                                <td width="5%">:</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-25">
                        Dengan susunan Tim Penguji Seminar Proyek Kelompok:
                        <table class="table-info" style="margin-top:5px">
                            <tr>
                                <th>No.</th>
                                <th>NAMA</th>
                                <th>NIP / NIDN / NIPK</th>
                                <th>JABATAN</th>
                                <th>TANDA TANGAN</th>
                            </tr>
                            @foreach ($examiners as $examiner)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $examiner->Lecturer->name }}</td>
                                <td>{{ $examiner->Lecturer->NIP }}</td>
                                <td>{{ $examiner->role }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="mt-10">
                        <div>Setelah diadakan Pengujian dan Rapat Tim Penguji, diambil kesimpulan bahwa Seminar Proyek Kelompok tersebut di atas dinyatakan<sup>#</sup>)</div>
                        <ul style="list-style-type:circle">
                            <li>Diterima tanpa perbaikan;</li>
                            <li>Diterima dengan perbaikan (Catatan Revisi terlampir);</li>
                            <li>Ditolak (seminar proyek kelompok berikutnya paling lambat ......... hari sejak hari ini).</li>
                        </ul>
                        <div>Demikian Berita Acara Seminar Proyek Kelompok ini dibuat dengan sebenar-benarnya.</div>
                    </div>
                    <div class="mt-25">
                        <table class="w-100">
                            <tr>
                                <td width="50%">
                                    Mengetahui <br>
                                    Koordinator Program Studi,
                                </td>
                                <td width="50%">
                                    <br>
                                    Ketua Tim Penguji,
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height:50pt"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Muhammad Alkaff, S.Kom., M.Kom.</td>
                                <td>{{ $examiners[0]->Lecturer->name }}</td>
                            </tr>
                            <tr>
                                <td>NIP. 198606132015041001</td>
                                <td>NIP. {{ $examiners[0]->Lecturer->NIP }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="subpage">
                <div class="page-header">
                    <table style="border-bottom: 5px solid black;">
                        <tr>
                            <td width="15%"><img src="{{ asset('image/ulm.png') }}" alt="" class="w-100"></td>
                            <td align="center">
                                <div style="font-size:16pt">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
                                <div style="font-size:14pt">UNIVERSITAS LAMBUNG MANGKURAT</div>
                                <div style="font-size:14pt">FAKULTAS TEKNIK</div>
                                <div style="font-size:14pt"><b>PROGRAM STUDI TEKNOLOGI INFORMASI</b></div>
                                <div>Alamat  Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</div>
                                <div>Telepon/Fax. : (0511) 4773858-4773868</div>
                                <div>Laman: http://www.ft.ulm.ac.id</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="page-body">
                    <div class="page-title">CATATAN PERBAIKAN</div>
                    <div class="mt-25">
                        <table width="100%">
                            <tr>
                                <td width="20%">Judul</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->title }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Kelompok</td>
                                <td width="5%">:</td>
                                <td>{{ $projectManager->InternshipStudents[0]->name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Catatan Revisi</td>
                                <td width="5%">:</td>
                                <td></td>
                        </table>
                        <table class="w-100" style="border:1px solid #000000;height:10cm;margin-top:5px">
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-25">
                        <table class="w-100">
                            <tr>
                                <th colspan="2">
                                    Tim Pembahas <br> <br>
                                    Ketua Penguji / Penguji I
                                    <br> <br> <br> <br> <br>
                                    {{ $examiners[0]->Lecturer->name }} <br>
                                    NIP. {{ $examiners[0]->Lecturer->NIP }}
                                    <br>
                                    <br>
                                </th>
                            </tr>
                            <tr>
                                <th width="50%">
                                    Penguji II
                                    <br> <br> <br> <br> <br>
                                    {{ $examiners[1]->Lecturer->name }} <br>
                                    NIP. {{ $examiners[1]->Lecturer->NIP }}
                                </th>
                                <th width="50%">
                                    Penguji III
                                    <br> <br> <br> <br> <br>
                                    {{ $examiners[2]->Lecturer->name }} <br>
                                    NIP. {{ $examiners[2]->Lecturer->NIP }}
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-header">
                <table style="border-bottom: 5px solid black;">
                    <tr>
                        <td width="15%"><img src="{{ asset('image/ulm.png') }}" alt="" class="w-100"></td>
                        <td align="center">
                            <div style="font-size:16pt">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
                            <div style="font-size:14pt">UNIVERSITAS LAMBUNG MANGKURAT</div>
                            <div style="font-size:14pt">FAKULTAS TEKNIK</div>
                            <div style="font-size:14pt"><b>PROGRAM STUDI TEKNOLOGI INFORMASI</b></div>
                            <div>Alamat  Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</div>
                            <div>Telepon/Fax. : (0511) 4773858-4773868</div>
                            <div>Laman: http://www.ft.ulm.ac.id</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-body">
                <div class="page-title">
                    FORMAT PENILAIAN <br>
                    SIDANG PROYEK KELOMPOK
                </div>
                <div class="mt-25">
                    <table width="100%" style="margin: 0px 20px">
                        <tr>
                            <td width="20%">Judul</td>
                            <td width="5%">:</td>
                            <td>
                                {{ $groupProject->title }}
                            </td>
                        </tr>
                    </table>
                    <div style="margin: 5px 0px">
                        Menyatakan bahwa mahasiswa yang tersebut di atas telah melaksanakan Proyek Kelompok di Semester <span style="padding:0px 80px"></span> pada:
                    </div>
                    <table width="100%" style="margin: 0px 20px">
                        <tr>
                            <td width="20%">Hari, tgl.</td>
                            <td width="5%">:</td>
                            <td>
                                {{ $groupProject->GroupProjectSchedule->day }}, {{ $groupProject->GroupProjectSchedule->tanggal }}
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Pukul</td>
                            <td width="5%">:</td>
                            <td>
                                {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time)->isoFormat('HH.mm') }} -
                                    {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time_end)->isoFormat('HH.mm') }} WITA
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mt-10">
                    dengan penilaian kriteria hasil dan pelaksanaan Proyek Kelompok sebagai berikut:
                    <table class="table-info score w-100" style="margin-top:5px;">
                        <tr>
                            <th colspan="2">Kriteria Penilaian</th>
                            <th>Range Penilaian</th>
                            <th>Nilai</th>
                        </tr>
                        <tr>
                            <th rowspan="3" colspan="2">Penilaian Kelompok</th>
                            <td>
                                Kualitas Solusi Hasil dan Kerjasama Tim <br>
                                <b>(Range Nilai: 30 – 50)</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Kualitas Penulisan Laporan <br>
                                <b>(Range Nilai: 20 – 30)</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Kualitas Penyampaian Presentasi <br>
                                <b>(Range Nilai: 10 – 20))</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="30%" rowspan="{{ $count }}"> <!--   Harus Dinamis -->
                                <b>Penilaian Individu</b> <br>
                                Komponen Penilaian:
                                <ul>
                                    <li>Kerjasama Tim (40%)</li>
                                    <li>Pelaksanaan Tugas Sesuai Role (30%)</li>
                                    <li>Kualitas Pelaksanaan Tugas (30%)</li>
                                </ul>
                            </td>
                            <th width="30%">Nama</th width="30%">
                            <th width="30%"><i>Role</i></th width="30%">
                            <td width="10%"></td width="30%">
                        </tr>
                        @foreach ($groupProject->InternshipStudents as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>
                                @foreach($member->Jobdescs as $jobdesc)
                                    - {{ $jobdesc->jobname }}<br>
                                @endforeach
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mt-10">
                    <ul>
                        <li>Keterangan: A (80-100), A- (77-79), B+ (75-77), B (70-74), B- (67-69), C+ (64-66), C (60-63), atau Tidak Lulus (kurang dari 60).</li>
                        <li>Nilai akhir bagi masing-masing mahasiswa adalah 50% dari Penilaian Kelompok dan 50% dari Penilaian Individu</li>
                    </ul>
                </div>
                <div class="mt-25">
                    <table class="w-100">
                        <tr>
                            <td width="50%">
                            </td>
                            <td width="50%">
                                Banjarmasin, {{ $groupProject->GroupProjectSchedule->tanggal }} <br>
                                Ketua Tim Penguji / Penguji I,
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="height:50pt"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $examiners[0]->Lecturer->name }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NIP. {{ $examiners[0]->Lecturer->NIP }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-header">
                <table style="border-bottom: 5px solid black;">
                    <tr>
                        <td width="15%"><img src="{{ asset('image/ulm.png') }}" alt="" class="w-100"></td>
                        <td align="center">
                            <div style="font-size:16pt">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
                            <div style="font-size:14pt">UNIVERSITAS LAMBUNG MANGKURAT</div>
                            <div style="font-size:14pt">FAKULTAS TEKNIK</div>
                            <div style="font-size:14pt"><b>PROGRAM STUDI TEKNOLOGI INFORMASI</b></div>
                            <div>Alamat  Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</div>
                            <div>Telepon/Fax. : (0511) 4773858-4773868</div>
                            <div>Laman: http://www.ft.ulm.ac.id</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-body">
                <div class="page-title">
                    FORMAT PENILAIAN <br>
                    SIDANG PROYEK KELOMPOK
                </div>
                <div class="mt-25">
                    <table width="100%" style="margin: 0px 20px">
                        <tr>
                            <td width="20%">Judul</td>
                            <td width="5%">:</td>
                            <td>
                                {{ $groupProject->title }}
                            </td>
                        </tr>
                    </table>
                    <div style="margin: 5px 0px">
                        Menyatakan bahwa mahasiswa yang tersebut diatas telah melaksanakan Proyek Kelompok di Semester <span style="padding:0px 80px"></span> pada:
                    </div>
                    <table width="100%" style="margin: 0px 20px">
                        <tr>
                            <td width="20%">Hari, tgl.</td>
                            <td width="5%">:</td>
                            <td>
                                {{ $groupProject->GroupProjectSchedule->day }}, {{ $groupProject->GroupProjectSchedule->tanggal }}
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Pukul</td>
                            <td width="5%">:</td>
                            <td>
                                {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time)->isoFormat('HH.mm') }} -
                                    {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time_end)->isoFormat('HH.mm') }} WITA
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mt-10">
                    dengan penilaian kriteria hasil dan pelaksanaan Proyek Kelompok sebagai berikut:
                    <table class="table-info score w-100" style="margin-top:5px;">
                        <tr>
                            <th colspan="2">Kriteria Penilaian</th>
                            <th>Range Penilaian</th>
                            <th>Nilai</th>
                        </tr>
                        <tr>
                            <th rowspan="3" colspan="2">Penilaian Kelompok</th>
                            <td>
                                Kualitas Solusi Hasil dan Kerjasama Tim <br>
                                <b>(Range Nilai: 30 – 50)</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Kualitas Penulisan Laporan <br>
                                <b>(Range Nilai: 20 – 30)</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Kualitas Penyampaian Presentasi <br>
                                <b>(Range Nilai: 10 – 20))</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <tr>
                                <td width="30%" rowspan="{{ $count }}"> <!--   Harus Dinamis -->
                                    <b>Penilaian Individu</b> <br>
                                    Komponen Penilaian:
                                    <ul>
                                        <li>Kerjasama Tim (40%)</li>
                                        <li>Pelaksanaan Tugas Sesuai Role (30%)</li>
                                        <li>Kualitas Pelaksanaan Tugas (30%)</li>
                                    </ul>
                                </td>
                                <th width="30%">Nama</th width="30%">
                                <th width="30%"><i>Role</i></th width="30%">
                                <td width="10%"></td width="30%">
                            </tr>
                            @foreach ($groupProject->InternshipStudents as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>
                                    @foreach($member->Jobdescs as $jobdesc)
                                    - {{ $jobdesc->jobname }}<br>
                                    @endforeach
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                    </table>
                </div>
                <div class="mt-10">
                    <ul>
                        <li>Keterangan: A (80-100), A- (77-79), B+ (75-77), B (70-74), B- (67-69), C+ (64-66), C (60-63), atau Tidak Lulus (kurang dari 60).</li>
                        <li>Nilai akhir bagi masing-masing mahasiswa adalah 50% dari Penilaian Kelompok dan 50% dari Penilaian Individu</li>
                    </ul>
                </div>
                <div class="mt-25">
                    <table class="w-100">
                        <tr>
                            <td width="50%">
                            </td>
                            <td width="50%">
                                Banjarmasin, {{ $groupProject->GroupProjectSchedule->tanggal }} <br>
                                Penguji II,
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="height:50pt"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $examiners[1]->Lecturer->name }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NIP. {{ $examiners[1]->Lecturer->NIP }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="page-header">
                <table style="border-bottom: 5px solid black;">
                    <tr>
                        <td width="15%"><img src="{{ asset('image/ulm.png') }}" alt="" class="w-100"></td>
                        <td align="center">
                            <div style="font-size:16pt">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
                            <div style="font-size:14pt">UNIVERSITAS LAMBUNG MANGKURAT</div>
                            <div style="font-size:14pt">FAKULTAS TEKNIK</div>
                            <div style="font-size:14pt"><b>PROGRAM STUDI TEKNOLOGI INFORMASI</b></div>
                            <div>Alamat  Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</div>
                            <div>Telepon/Fax. : (0511) 4773858-4773868</div>
                            <div>Laman: http://www.ft.ulm.ac.id</div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="page-body">
                <div class="page-title">
                    FORMAT PENILAIAN <br>
                    SIDANG PROYEK KELOMPOK
                </div>
                <div class="mt-25">
                    <table width="100%" style="margin: 0px 20px">
                        <tr>
                            <td width="20%">Judul</td>
                            <td width="5%">:</td>
                            <td>
                                {{ $groupProject->title }}
                            </td>
                        </tr>
                    </table>
                    <div style="margin: 5px 0px">
                        Menyatakan bahwa mahasiswa yang tersebut diatas telah melaksanakan Proyek Kelompok di Semester <span style="padding:0px 80px"></span> pada:
                    </div>
                    <table width="100%" style="margin: 0px 20px">
                        <tr>
                            <td width="20%">Hari, tgl.</td>
                            <td width="5%">:</td>
                            <td>
                                {{ $groupProject->GroupProjectSchedule->day }}, {{ $groupProject->GroupProjectSchedule->tanggal }}
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Pukul</td>
                            <td width="5%">:</td>
                            <td>
                                {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time)->isoFormat('HH.mm') }} -
                                    {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time_end)->isoFormat('HH.mm') }} WITA
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mt-10">
                    dengan penilaian kriteria hasil dan pelaksanaan Proyek Kelompok sebagai berikut:
                    <table class="table-info score w-100" style="margin-top:5px;">
                        <tr>
                            <th colspan="2">Kriteria Penilaian</th>
                            <th>Range Penilaian</th>
                            <th>Nilai</th>
                        </tr>
                        <tr>
                            <th rowspan="3" colspan="2">Penilaian Kelompok</th>
                            <td>
                                Kualitas Solusi Hasil dan Kerjasama Tim <br>
                                <b>(Range Nilai: 30 – 50)</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Kualitas Penulisan Laporan <br>
                                <b>(Range Nilai: 20 – 30)</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Kualitas Penyampaian Presentasi <br>
                                <b>(Range Nilai: 10 – 20))</b>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                        <tr>
                            <td width="30%" rowspan="{{ $count }}"> <!--   Harus Dinamis -->
                                <b>Penilaian Individu</b> <br>
                                Komponen Penilaian:
                                <ul>
                                    <li>Kerjasama Tim (40%)</li>
                                    <li>Pelaksanaan Tugas Sesuai Role (30%)</li>
                                    <li>Kualitas Pelaksanaan Tugas (30%)</li>
                                </ul>
                            </td>
                            <th width="30%">Nama</th width="30%">
                            <th width="30%"><i>Role</i></th width="30%">
                            <td width="10%"></td width="30%">
                        </tr>
                        @foreach ($groupProject->InternshipStudents as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>
                                @foreach($member->Jobdescs as $jobdesc)
                                - {{ $jobdesc->jobname }}<br>
                                @endforeach
                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mt-10">
                    <ul>
                        <li>Keterangan: A (80-100), A- (77-79), B+ (75-77), B (70-74), B- (67-69), C+ (64-66), C (60-63), atau Tidak Lulus (kurang dari 60).</li>
                        <li>Nilai akhir bagi masing-masing mahasiswa adalah 50% dari Penilaian Kelompok dan 50% dari Penilaian Individu</li>
                    </ul>
                </div>
                <div class="mt-25">
                    <table class="w-100">
                        <tr>
                            <td width="50%">
                            </td>
                            <td width="50%">
                                Banjarmasin, {{ $groupProject->GroupProjectSchedule->tanggal }} <br>
                                Penguji III,
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="height:50pt"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $examiners[2]->Lecturer->name }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>NIP. {{ $examiners[2]->Lecturer->NIP }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="page">
            <div class="subpage">
                <div class="page-header">
                    <table style="border-bottom: 5px solid black;">
                        <tr>
                            <td width="15%"><img src="{{ asset('image/ulm.png') }}" alt="" class="w-100"></td>
                            <td align="center">
                                <div style="font-size:16pt">KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN</div>
                                <div style="font-size:14pt">UNIVERSITAS LAMBUNG MANGKURAT</div>
                                <div style="font-size:14pt">FAKULTAS TEKNIK</div>
                                <div style="font-size:14pt"><b>PROGRAM STUDI TEKNOLOGI INFORMASI</b></div>
                                <div>Alamat  Jl. Achmad Yani Km. 35,5 Banjarbaru-Kalimantan Selatan 70714</div>
                                <div>Telepon/Fax. : (0511) 4773858-4773868</div>
                                <div>Laman: http://www.ft.ulm.ac.id</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="page-body">
                    <div class="page-title" style="font-size:12pt">
                        DAFTAR HADIR <br>
                        TIM PEMBAHAS SEMINAR <br>
                        PROYEK KELOMPOK <br>
                        PROGRAM STUDI TEKNOLOGI INFORMASI
                    </div>
                    <div class="mt-25">
                        <table width="100%">
                            <tr>
                                <td width="20%">Judul</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->title }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Penyusun</td>
                                <td width="5%">:</td>
                                <td>{{ $projectManager->InternshipStudents[0]->name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Hari/Tanggal</td>
                                <td width="5%">:</td>
                                <td>
                                    {{ $groupProject->GroupProjectSchedule->day }}, {{ $groupProject->GroupProjectSchedule->tanggal }}
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Pukul</td>
                                <td width="5%">:</td>
                                <td>{{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time)->isoFormat('HH.mm') }} -
                                    {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time_end)->isoFormat('HH.mm') }} WITA</td>
                            </tr>
                            <tr>
                                <td width="20%">Tempat</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->GroupProjectSchedule->place }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-25">
                        <table class="table-info score w-100">
                            <tr>
                                <th width="5%">No.</th width="40%">
                                <th width="50%">Nama</th>
                                <th width="20%">NIP / NIDN / NIPK</th>
                                <th width="20%">Jabatan</th width="20%">
                                <th width="5%">Tanda Tangan</th width="5%">
                            </tr>
                            @foreach ($examiners as $examiner)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ $examiner->Lecturer->name }}</td>
                                <td>{{ $examiner->Lecturer->NIP }}</td>
                                <td>{{ $examiner->role }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="mt-25">
                        <table class="w-100">
                            <tr>
                                <td width="50%"></td>
                                <td width="50%" style="font-weight:600">
                                    Banjarmasin, {{ $groupProject->GroupProjectSchedule->tanggal }} <br>
                                    Mengetahui, <br>
                                    Koordinator Program Studi,
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height:50pt"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-weight:600">Muhammad Alkaff, S.Kom., M.Kom.</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-weight:600">NIP. 198606132015041001</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--
    <script>
        window.print();
    </script> -->
</body>

</html>
