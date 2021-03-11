<!DOCTYPE html>
<html>

<head>
    <title>Bimbingan PK</title>
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
                <div class="page-body" style="margin-top:100px">
                    <div class="page-title"><u>LEMBAR BIMBINGAN PROYEK KELOMPOK</u></div>
                    <div class="mt-50">
                        <table width="100%" style="border-collapse: separate; border-spacing: 0 10px;">
                            <tr>
                                <td width="20%">Judul</td>
                                <td width="5%">:</td>
                                <td align="justify">{{ $pk->title }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Mahasiswa / NIM</td>
                                <td width="5%">:</td>
                                <td>
                                    @foreach ($pk->InternshipStudents as $i)
                                    {{ $i->name }} / {{ $i->nim }}<br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Pembimbing</td>
                                <td width="5%">:</td>
                                <td>{{ $pk->GroupProjectSupervisor->Lecturer->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-25">
                        <table class="table-info" style="margin-top:5px">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="10%">Tanggal</th>
                                <th width="60%">Uraian</th>
                                <th width="25%">TTD Dosen Pembimbing</th>
                            </tr>
                            <?php $i = 0; ?>
                            @while($i<$p->count() && $i<8)
                            <tr height="70px">
                                <td align="center">{{ $i+1 }}</td>
                                <td>{{ Carbon\Carbon::parse($p[$i]->date)->isoFormat('DD/MM/YY') }}</td>
                                <td align="justify">{{ $p[$i]->description }}</td>
                                <td></td>
                            </tr>
                            <?php $i++; ?>
                            @endwhile
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @if($p->count() > 8)
        <div class="page">
            <div class="subpage">
                <div class="page-body" style="margin-top:100px">
                    <div class="page-title"><u>LEMBAR BIMBINGAN PROYEK KELOMPOK</u></div>
                    <div class="mt-50">
                        <table width="100%" style="border-collapse: separate; border-spacing: 0 10px;">
                            <tr>
                                <td width="20%">Judul</td>
                                <td width="5%">:</td>
                                <td align="justify">{{ $pk->title }}</td>
                            </tr>
                            <tr>
                                <td width="20%">Mahasiswa / NIM</td>
                                <td width="5%">:</td>
                                <td>
                                    @foreach ($pk->InternshipStudents as $i)
                                    {{ $i->name }} / {{ $i->nim }}<br>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Pembimbing</td>
                                <td width="5%">:</td>
                                <td>{{ $pk->GroupProjectSupervisor->Lecturer->name }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-25">
                        <table class="table-info" style="margin-top:5px">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="10%">Tanggal</th>
                                <th width="60%">Uraian</th>
                                <th width="25%">TTD Dosen Pembimbing</th>
                            </tr>
                            <?php $i = 8; ?>
                            @while($i<$p->count() && $i<16)
                            <tr height="70px">
                                <td align="center">{{ $i+1 }}</td>
                                <td>{{ Carbon\Carbon::parse($p[$i]->date)->isoFormat('DD/MM/YY') }}</td>
                                <td align="justify">{{ $p[$i]->description }}</td>
                                <td></td>
                            </tr>
                            <?php $i++; ?>
                            @endwhile
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>



    <!--
    <script>
        window.print();
    </script> -->
</body>

</html>
