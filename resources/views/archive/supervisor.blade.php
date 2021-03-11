@extends('layout.master')

@section('title', 'Rekap Pembimbing')
@section('content')
<section class="content">
    <div class="container-fluid">
    @csrf
        <div class="row py-2">
            <div class="col-6">
                <h5>Rekap Pembimbing</h5>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="far fa-circle nav-icon mr-1"></i>
                    Rekap Pembimbing
                </h5>
            </div>
            <div class="card-body table-responsive">
                <form action="rekapPembimbing/export" target="_blank" method="POST">
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
                <table style="vertical-align: middle;" id="pembimbing" class="table table-striped dataTable w-100">
                    <thead>
                        <tr>
                            <th width="10%">Tahun Ajaran</th>
                            <th width="35%">Mahasiswa & NIM</th>
                            <th width="20%">Instansi</th>
                            <th width="10%">Tanggal Mulai</th>
                            <th width="25%">Pembimbing</th>
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
    $("#pembimbing").DataTable({
        "processing": true,
        "group": 1,
        "destroy" : true,
        "ajax": {
            url: '../koor/rekapPembimbing/get',
        },
        "columns": [
            {
                data: "term.term"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let mhs = '<table class="table-borderless w-100 table-light">'
                    for (let i = 0; i < full.internship_students.length; i++) {
                        mhs += '<tr><td>'+full.internship_students[i].name+'</td><td width="10%">'+full.internship_students[i].nim+'</td></tr>'
                    }
                    let end = '</table>'
                    return mhs + end
                    // let img = ''
                    // for (let i = 0; i < full.internship_students.length; i++) {
                    //     img += '<text>'+ full.internship_students[i].name +' '+ full.internship_students[i].nim +'</text><br>'
                    // }
                    // return img
                }
            },
            {
                data: "agency.agency_name"
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    return '<text>'+ moment(full.start_intern).format('D MMMM Y')+'</text>'
                }
                // data: "start_intern"
            },
            {
                data: "group_project_supervisor.lecturer.name"
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
        $("#pembimbing").DataTable({
            "processing": true,
            "group": 1,
            destroy : true,
            "ajax": {
                url: '../koor/rekapPembimbing/getFiltered/' + id,
            },
            "columns": [
                {
                    data: "term.term"
                },
                {
                    sortable: false,
                    "render": function(data, type, full, meta) {
                        let mhs = '<table class="table-borderless w-100 table-light">'
                        for (let i = 0; i < full.internship_students.length; i++) {
                            mhs += '<tr><td>'+full.internship_students[i].name+'</td><td width="10%">'+full.internship_students[i].nim+'</td></tr>'
                        }
                        let end = '</table>'
                        return mhs + end
                        // let img = ''
                        // for (let i = 0; i < full.internship_students.length; i++) {
                        //     img += '<text>'+ full.internship_students[i].name +' '+ full.internship_students[i].nim +'</text><br>'
                        // }
                        // return img
                    }
                },
                {
                    data: "agency.agency_name"
                },
                {
                    sortable: false,
                    "render": function (data, type, full, meta) {
                        return '<text>'+ moment(full.start_intern).format('D MMMM Y')+'</text>'
                    }
                    // data: "start_intern"
                },
                {
                    data: "group_project_supervisor.lecturer.name"
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