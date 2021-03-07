<!DOCTYPE html>
<html>

<head>
    <title>Daftar Hadir Seminar PKL dan PK</title>
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
                    <div class="page-title">DAFTAR HADIR PESERTA<br>SEMINAR PRAKTIK KERJA LAPANGAN DAN PROYEK KELOMPOK</div>
                    <div class="mt-25">
                        <table width="100%">
                            <tr>
                                <td width="20%">Hari / Tanggal</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->GroupProjectSchedule->day }}, {{ $groupProject->GroupProjectSchedule->tanggal }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Jam / Ruang</td>
                                <td width="5%">:</td>
                                <td>{{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time)->isoFormat('HH.mm') }} -
                                    {{ Carbon\Carbon::parse($groupProject->GroupProjectSchedule->time_end)->isoFormat('HH.mm') }} WITA / {{ $groupProject->GroupProjectSchedule->place }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Mahasiswa / NIM</td>
                                <td width="5%">:</td>
                                <td>
                                    @foreach ($groupProject->InternshipStudents as $i)
                                    {{ $i->name }} / {{ $i->nim }}<br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Pembimbing</td>
                                <td width="5%">:</td>
                                <td>{{ $supervisors->Lecturer->name }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Judul</td>
                                <td width="5%">:</td>
                                <td>{{ $groupProject->title }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-25">
                        <table class="table-info" style="margin-top:5px">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="50%">NAMA</th>
                                <th width="25%">NIM</th>
                                <th width="20%">TANDA TANGAN</th>
                            </tr>
                            @for ($i=1; $i < 16; $i++)
                            <tr>
                                <td align="center">{{ $i }}</td>
                                <td></td>
                                <td></td>
                                <td @if ($i%2 == 0) align="center" @endif>{{ $i }}</td>
                            </tr>
                            @endfor
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
