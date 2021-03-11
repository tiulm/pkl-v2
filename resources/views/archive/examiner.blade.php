@extends('layout.master')

@section('title', 'Rekap Penguji')
@section('content')
<section class="content">
    <div class="container-fluid">
    @csrf
        <div class="row py-2">
            <div class="col-6">
                <h5>Rekap Penguji</h5>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="far fa-circle nav-icon mr-1"></i>
                    Rekap Penguji
                </h5>
            </div>
            <div class="card-body table-responsive">
                <form action="rekapPenguji/export" target="_blank" method="POST">
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
                <table id="Penguji" class="table table-striped dataTable w-100">
                    <thead>
                        <tr>
                            <th width="12%">Jadwal Seminar</th>
                            <th width="53%">Penguji</th>
                            <th width="35%">Judul</th>
                            <!-- <th>Aksi</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
@section('ajax')
<script>
    $("#Penguji").DataTable({
        "processing": true,
        "group": 1,
        "destroy" : true,
        "ajax": {
            url: '../koor/rekapPenguji/get',
        },
        "columns": [
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    return '<b>' + full.tanggal + '</b><br><small>' + full
                        .place + '<br>' +
                        moment(full.time, 'HH:mm:ss').format('HH:mm') + '-' +
                        moment(full.time_end, 'HH:mm:ss').format('HH:mm') +
                        ' WITA</small><br>'+
                        '<b>' + full.term.term + '</b>'
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let penguji = '<table class="table-borderless table-light">'
                    for (let i = 0; i < full.group_project.group_project_examiner.length; i++) {
                        penguji += '<tr><th width="20%">'+full.group_project.group_project_examiner[i].role+'</th><td>'+full.group_project.group_project_examiner[i].lecturer.name+'</td></tr>'
                    }
                    let end = '</table>'
                    return penguji + end
                }
            },
            {
                data: "group_project.title"
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
        $("#Penguji").DataTable({
            "processing": true,
            "group": 1,
            destroy : true,
            "ajax": {
                url: '../koor/rekapPenguji/getFiltered/' + id,
            },
            "columns": [
                {
                    sortable: false,
                    "render": function (data, type, full, meta) {
                        return '<b>' + full.tanggal + '</b><br><small>' + full
                            .place + '<br>' +
                            moment(full.time, 'HH:mm:ss').format('HH:mm') + '-' +
                            moment(full.time_end, 'HH:mm:ss').format('HH:mm') +
                            ' WITA</small><br>'+
                            '<b>' + full.term.term + '</b>'
                    }
                },
                {
                    sortable: false,
                    "render": function (data, type, full, meta) {
                        let penguji = '<table class="table-borderless table-light">'
                        for (let i = 0; i < full.group_project.group_project_examiner.length; i++) {
                            penguji += '<tr><th width="20%">'+full.group_project.group_project_examiner[i].role+'</th><td>'+full.group_project.group_project_examiner[i].lecturer.name+'</td></tr>'
                        }
                        let end = '</table>'
                        return penguji + end
                    }
                },
                {
                    data: "group_project.title"
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