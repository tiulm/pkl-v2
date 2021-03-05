@extends('layout.master')

@section('title', 'Koordinator | Bimbingan')
@section('content')
<section class="content">
    <div class="container-fluid">
        <h5 class="py-2">Bimbingan PKL dan PK</h5>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-spinner mr-1"></i>
                    Progress Mahasiswa
                </h3>
            </div>
            <div class="card-body table-responsive">
                <table id="progress-detail" class="table table-striped table-light projects dataTable w-100">
                    <thead>
                        <tr>
                            <th width='20%'>Kelompok</th>
                            <th width='30%'>Pembimbing</th>
                            <th width='20%'>Progress</th>
                            <th width='15%'>Lihat Progress</th>
                            <th width='15%'>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="modal fade groupProgress" id="groupProgress" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-spinner mr-1"></i>
                    Progress Proyek Kelompok
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table id="kelompokPro" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th width="25%">Tanggal</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>            
            <div class="modal-footer modalBim">
            </div>
        </div>
    </div>
</div>

<div class="modal fade bimbingan" id="project-progress" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check mr-1"></i>
                    Konfirmasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formUpdate" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Tambahkan Progress</label>
                        <input type="hidden" id="groupProjectId" value="">
                        <input type="hidden" id="_method" value="PUT" name="_method">
                        <input type="number" id="updateProgress" min="0" max="100" name="updateProgress" class="form-control" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSuccess">
    <div class="modal-dialog">
        <div class="modal-content bg-success">
            <div class="modal-header">
                <h4 class="modal-title">Success</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Data berhasil disimpan</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFailed">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Failed</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Data gagal disimpan</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ajax')
<script>
    $("#progress-detail").DataTable({
        "processing": true,
        "order": [[ 2, "asc" ]],
        "ajax": {
            url: "{{ url('../koor/bimbingan/show') }}"
        },
        "columns": [{
                sortable: false,
                "render": function(data, type, full, meta) {
                    let img = ''
                    for (let i = 0; i < full.internship_students.length; i++) {
                        img += '<img src="../public/image/' + full.internship_students[i].user.image_profile + '" data-toggle="tooltip" data-placement="bottom" class="table-avatar m-1" title="' + full.internship_students[i].name + '">'
                    }
                    return img
                }
            },
            {
                data: "group_project_supervisor.lecturer.name"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    if(full.progress == 100){
                        return '<span class="badge badge-success p-2">Siap / Sedang Seminar</span>'
                    }
                    else {
                        return '<div class="progress progress-sm">' +
                            '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-volumenow="' + full.progress + '" aria-volumemin="0" aria-volumemax="100" style="width:' + full.progress + '%">' +
                            '</div>' +
                            '</div>' +
                            '<small>' + full.progress + '% Complete</small>'
                    }
                }
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId + '" class="btn btn-primary btn-sm mx-1 groupProgress" title="Progress PK"><i class="fas fa-users"></i></button>' +
                    '<a href="bimbingan/pkl/' + buttonId + '" class="btn btn-info btn-sm internProgress" title="Progress PKL"><i class="fas fa-user"></i></a>'
                }
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    let button = '';
                    if (full.is_verified == 1) {
                        button = '<button id="' + buttonId + '" class="btn btn-success btn-sm bimbingan" title="Update Progress"><i class="fas fa-spinner"></i> Update Progress</button>'
                    }
                    return button
                }
            }
        ]
    });

    $('#progress-detail tbody').on('click', '.groupProgress', function() {
        let id = $(this).attr('id');

        $.ajax({
            url: "bimbingan/pk/" + id,
            dataType: "json",
            success: function(result) {
                $('#groupProgress').modal('show')
                $('#kelompokPro tbody').html('')
                $('.modalBim').html('')
                let modal = ''
                let semua = '<button id="'+ id +'" title="Setujui Semua" class="btn btn-sm btn-success agreeAll float-right">Setujui Semua</a>'
                let belum = 0
                let iteration = 1

                result.data.forEach(function(i) {
                    if (i.agreement == "N") {
                        modal = '<tr><td>' + iteration + '</td>' +
                        '<td>' + i.date + '</td>' +
                        '<td>' + i.description + '</td>' +
                        '<td><span class="badge badge-sm badge-danger p-2" style="font-size: 10px">Belum Disetujui</span></td>' +
                        '<td><button id="'+ i.id +'" title="Setujui" class="btn btn-sm btn-success agree"><i class="fas fa-check"></i></button></td></tr>'
                        belum += 1
                        iteration += 1
                    } else{
                        modal = '<tr><td>' + iteration + '</td>' +
                        '<td>' + i.date + '</td>' +
                        '<td>' + i.description + '</td>' +
                        '<td><span class="badge badge-sm badge-success p-2" style="font-size: 10px">Disetujui</span></td>' +
                        '<td></td></tr>'
                        iteration += 1
                    }
                    $('#kelompokPro tbody').append(modal)
                });
                if (belum > 0) {
                    $('.modalBim').append(semua)
                }
            }
        })
    });

    
    $('.modalBim').on('click', '.agreeAll', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin menyetujui semua progress?',
            text: "Data tidak dapat diubah",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin!'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Loading',
                    timer: 60000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })
                $.ajax({
                    url: "bimbingan/agreePKAll/" + id,
                    method: "POST",
                    data: {
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Success!',
                                'Progress Disetujui',
                                'success'
                            )
                            .then(function() {
                                $("#groupProgress").modal('hide');
                            })
                    }
                })
            }
        })

    });

    $('#kelompokPro tbody').on('click', '.agree', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin menyetujui progress?',
            text: "Data tidak dapat diubah",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin!'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Loading',
                    timer: 60000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                })
                $.ajax({
                    url: "bimbingan/agreePK/" + id,
                    method: "POST",
                    data: {
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Success!',
                                'Progress Disetujui',
                                'success'
                            )
                            .then(function() {
                                $("#groupProgress").modal('hide');
                            })
                    }
                })
            }
        })

    });

    $('#progress-detail tbody').on('click', '.bimbingan', function() {
        let id = $(this).attr('id');

        $.ajax({
            url: "bimbingan/" + id,
            dataType: "json",
            success: function(result) {
                $('#project-progress').modal('show');
                $('#updateProgress').val(result.data.progress);
                $('#groupProjectId').val(result.data.id);
            }
        })
    });

    $('#formUpdate').submit(function(e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#groupProjectId').val();
        $.ajax({
            url: "bimbingan/" + id + "/update",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formUpdate')[0].reset();
                    $('#project-progress').modal('hide');
                    $('#progress-detail').DataTable().ajax.reload();

                } else {
                    $('#modalFailed').modal();
                }
            },
            error: function(data) {
                $("small").remove(".text-danger");
                $("input").removeClass("is-invalid");
                $.each(data.responseJSON.errors, function(key, value) {
                    $('#' + key + '').addClass('is-invalid');
                    $('#' + key + '').after('<small class="text-danger">' + value + '</small>')
                });
            }
        })
    });
</script>
@endsection