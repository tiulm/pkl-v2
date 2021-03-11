@extends('layout.master')

@section('title', 'Rekap Nilai')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Rekap Nilai</h5>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-star mr-1"></i>
                    Rekap Nilai
                </h5>
            </div>
            <div class="card-body table-responsive">
                <form action="rekapNilai/export" target="_blank" method="POST">
                @csrf
                    <div class="row">
                        <div class="col-11">
                            <div class="form-group">
                                <select name="filterTA" id="filterTA" class="form-control">
                                    <option value="0">Pilih Tahun Ajaran...</option>
                                    @foreach($term as $semester)
                                    <option id="getFilterTA" value="{{$semester->id}}">{{$semester->term}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-1">
                            <button type="submit" class="btn btn-default form-control">Cetak</button>
                        </div>
                    </div>
                </form>
                <table id="nilai" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th width="15%">Tahun Ajaran</th>
                            <th width="10%">NIM</th>
                            <th>Mahasiswa</th>
                            <th width="10%">Nilai Kelompok</th>
                            <th width="10%">Nilai Individu</th>
                            <th width="10%">Nilai Akhir</th>
                            <th width="10%">Nilai Huruf</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('ajax')
<script>
    $("#nilai").DataTable({
        "processing": true,
        destroy : true,
        "ajax": {
            url: '../koor/rekapNilai/get',
        },
        "columns": [
            {
                data: "term"
            },
            {
                data: "nim"
            },
            {
                data: "name"
            },
            {
                data: "group_assessment"
            },
            {
                data: "intern_assessment"
            },
            {
                data: "final_assessment"
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let nilai = ''
                    if (full.grade == 'Tidak Lulus') {
                        nilai = '<span class="badge p-2 badge-danger">Tidak Lulus</span>'
                    } else {
                        nilai = full.grade
                    }
                    return nilai
                }
            },
            // {
            //     sortable: false,
            //     "render": function(data, type, full, meta) {
            //         let buttonId = full.id;
            //         return '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-warning edit m-1" title="Edit">Edit</button>'
            //     }
            // }
        ]
    });
    
    $("#filterTA").on('change', function(){
        let id = $('#filterTA').val();
        $("#nilai").DataTable({
            "processing": true,
            destroy : true,
            "ajax": {
                url: '../koor/rekapNilai/getFiltered/' + id,
            },
            "columns": [
                {
                    data: "term"
                },
                {
                    data: "nim"
                },
                {
                    data: "name"
                },
                {
                    data: "group_assessment"
                },
                {
                    data: "intern_assessment"
                },
                {
                    data: "final_assessment"
                },
                {
                    sortable: false,
                    "render": function (data, type, full, meta) {
                        let nilai = ''
                        if (full.grade == 'Tidak Lulus') {
                            nilai = '<span class="badge p-2 badge-danger">Tidak Lulus</span>'
                        } else {
                            nilai = full.grade
                        }
                        return nilai
                    }
                },
                // {
                //     sortable: false,
                //     "render": function(data, type, full, meta) {
                //         let buttonId = full.id;
                //         return '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-warning edit m-1" title="Edit">Edit</button>'
                //     }
                // }
            ]
        });
    });
</script>
@endsection