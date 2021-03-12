<!DOCTYPE html>
<html>

<head>
    <title>Rekap Nilai</title>
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
                                <div>Alamat : Jl. Brigjend. H. Hasan Basry Banjarmasin – Kalimantan Selatan 70123</div>
                                <div>Telepon (0511) 3304405 , 3304503 Faksimile (0511) 3304503</div>
                                <div>Laman : ti.ft.unlam.ac.id, Surel : ti@unlam.ac.id</div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="page-body">
                    <div class="page-title" style="text-transform: uppercase;">REKAPITULASI Nilai PKL-PK<br>@if($semester != 0) {{ $term->term }} @endif</div>
                    <div class="mt-50">
                    </div>
                    <div class="mt-25">
                        <table width="100%" class="table-info">
                            <tr>
                                <th align="center" style="vertical-align: middle;">No</th>
                                <th align="center" style="vertical-align: middle;">Nama Mahasiswa</th>
                                <th align="center" style="vertical-align: middle;">NIM</th>
                                <th align="center" style="vertical-align: middle;">Nilai Kelompok</th>
                                <th align="center" style="vertical-align: middle;">Nilai Individu</th>
                                <th align="center" style="vertical-align: middle;">Nilai Akhir</th>
                                <th align="center" style="vertical-align: middle;">Nilai Huruf</th>
                            </tr>
                            @foreach ($data as $key => $d)
                            <tr>
                                <td align="center" style="vertical-align: middle;">{{ $key+1 }}</td>
                                <td style="vertical-align: middle;">{{ $d->name }}</td>
                                <td style="vertical-align: middle;">{{ $d->nim }}</td>
                                <td align="center" style="vertical-align: middle;">{{ $d->group_assessment }}</td>
                                <td align="center" style="vertical-align: middle;">{{ $d->intern_assessment }}</td>
                                <td align="center" style="vertical-align: middle;">{{ $d->final_assessment }}</td>
                                <td align="center" style="vertical-align: middle;">{{ $d->grade }}</td>
                            </tr>
                            @endforeach
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
