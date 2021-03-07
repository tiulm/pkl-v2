@extends('layout.master')

@section('title', 'Koordinator | Kelompok')
@section('content')
<section class="content">
    <div class="container-fluid">
        @csrf
        @if ($daftar !== 0)
        <!-- Registrasi -->
        <h5 class="py-2">Registrasi</h5>
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-plus mr-1"></i>
                    Verifikasi Pendaftaran
                </h3>
            </div>
            <div class="card-body  table-responsive">
                <table id="registration" class="table table-striped projects dataTable w-100">
                    <thead>
                        <tr>
                            <th width='20%'>Kelompok</th>
                            <th width='60%'>Instansi</th>
                            <th width='10%'>Lihat</th>
                            <th width='10%'>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @endif
        <!-- Kelompok -->
        <h5 class="py-2">Kelompok PKL dan PK</h5>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Kelompok
                </h3>
            </div>
            <div class="card-body table-responsive">
                <table id="mahasiswa-pk" class="table table-striped projects w-100">
                    <thead>
                        <tr>
                            <th width='20%'>Kelompok</th>
                            <th width="35%">Instansi</th>
                            <th width="25%">Pembimbing</th>
                            <th width='10%'>Lihat</th>
                            <th width='10%'>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Modal Registration Detail -->
<div class="modal fade table-responsive" id="reg-detail" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-1"></i>
                    Detail
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-2" id="tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="true">Mahasiswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="instansi-tab" data-toggle="pill" href="#instansi" role="tab" aria-controls="instansi" aria-selected="false">Instansi/Perusahaan</a>
                    </li>
                </ul>
                <div class="tab-content" id="tabContent">
                    <div class="tab-pane table-responsive fade show active" id="team" role="tabpanel" aria-labelledby="team-tab">
                        <table class="table" id="detail_verifikasi">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>IPK</th>
                                    <th>SKS</th>
                                    <th>Job Deskripsi</th>
                                    <th>Kelengkapan</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="instansi" role="tabpanel" aria-labelledby="instansi-tab">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="instansi">Nama Instansi/Perusahaan</label>
                                <input name="namaInstansi" type="text" class="form-control" id="agency_name" value="" readonly>
                            </div>
                            <div class="form-group col-12">
                                <label for="bidang">Bidang/Sektor Usaha</label>
                                <input name="bidang" type="text" class="form-control" id="sector" value="" readonly>
                            </div>
                            <div class="form-group col-12">
                                <label for="alamat">Alamat</label>
                                <input name="alamat" type="text" class="form-control" id="address" value="" readonly>
                            </div>
                            <div class="form-group col-12">
                                <label for="tlp">No. Telephon/Handphone</label>
                                <input name="noTelp" type="text" class="form-control" id="phone_number" value="" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label for="start">Tanggal Mulai</label>
                                <input name="tglMulai" type="date" class="form-control" id="start_intern" value="" readonly>
                            </div>
                            <div class="form-group col-6">
                                <label for="end">Tanggal Berakhir</label>
                                <input name="tglAkhir" type="date" class="form-control" id="end_intern" value="" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Terima Modal-->
<div class="modal fade" id="reg-accept" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie mr-1"></i>
                    Dosen Pembimbing
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="verifikasi" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="is_verified" id="is_verified" value="">
                        <input type="hidden" name="groupProject" id="groupProject_id" value="">
                        <input type="hidden" id="_method" value="PUT" name="_method">
                        <label>Dosen Pembimbing</label>
                        <select name="supervisor" id="editSupervisor" class="form-control" style="width: 100%;">
                            @foreach($lecture as $lecturer)
                            @if($lecturer->quota >= 4)
                            <option class="editLecturer bg-danger" value="{{$lecturer->id}}"> {{$lecturer->name}} - Banyak Bimbingan: {{$lecturer->quota}}</option>
                            @elseif($lecturer->quota >= 2)
                            <option class="editLecturer bg-warning" value="{{$lecturer->id}}"> {{$lecturer->name}} - Banyak Bimbingan: {{$lecturer->quota}}</option>
                            @else
                            <option class="editLecturer" value="{{$lecturer->id}}"> {{$lecturer->name}} - Banyak Bimbingan: {{$lecturer->quota}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="updateSupervisor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-tie mr-1"></i>
                    Dosen Pembimbing
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formEdit" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="is_verified" id="is_verified" value="">
                        <input type="hidden" name="groupProject" id="group_id" value="">
                        <input type="hidden" id="_method" value="PUT" name="_method">
                        <label>Dosen Pembimbing</label>
                        <select name="supervisor" id="editPembimbing" class="form-control" style="width: 100%;">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Hapus Modal-->
<div class="modal fade" id="reg-reject" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-check mr-1"></i>
                    Konfirmasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin Menghapus kelompok #nama-mahasiswa?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light float-right">Hapus</button>
            </div>
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
    $("#registration").DataTable({
        "processing": true,
        "ajax": {
            url: "{{ url('../koor/getDataTablePK') }}"
        },
        "columns": [{
                sortable: false,
                "render": function(data, type, full, meta) {
                    let img = ''
                    for (let i = 0; i < full.internship_students.length; i++) {
                        img += '<a href=../public/image/' + full.internship_students[i].user.image_profile + ' target="_blank"><img src="../public/image/' + full.internship_students[i].user.image_profile + '" data-toggle="tooltip" data-placement="bottom" class="table-avatar m-1" title="' + full.internship_students[i].name + '"></a>'
                    }
                    return img
                }
            },
            {
                data: "agency.agency_name"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<a href="../berkas/kak/'+full.kak+'" target="_blank" class="btn btn-block btn-sm btn-primary m-1" title="Kerangka Acuan Kerja">Kerangka</a>' +
                    '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-info detail m-1" title="Detail">Detail</button>'
                }
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-success terima m-1" title="Terima">Terima</button>' +
                        '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-danger tolak m-1" title="Tolak">Tolak</button>'
                }
            }
        ]
    });
    
     $('#registration tbody').on('click', '.sayurkol', function() {
        let berkas = $(this).attr('id')
        $('#daginganjing').modal('show')
        PDFObject.embed('../berkas/kak/'+berkas, "#sambalado")
    })


    $('#registration tbody').on('click', '.detail', function() {
        let id = $(this).attr('id')
        $('#reg-detail').modal('show');

        $.ajax({
            url: "../koor/getDataTableVerif/" + id,
            success: function(result) {
                $('#detail_verifikasi tbody').html('')
                $('#agency_name').val(result.data.agency.agency_name)
                $('#sector').val(result.data.agency.sector)
                $('#address').val(result.data.agency.address)
                $('#phone_number').val(result.data.agency.phone_number)
                $('#start_intern').val(result.data.start_intern)
                $('#end_intern').val(result.data.end_intern)

                let modal = ''
                let job = ''

                result.data.internship_students.forEach(function(i) {
                    let call_job = ''
                    i.jobdescs.forEach(function(job) {
                        call_job += job.jobname + '<br>'
                    })
                    modal = '<tr><td>' + i.nim + '</td>' +
                        '<td>' + i.name + '</td>' +
                        '<td>' + i.ipk + '</td>' +
                        '<td>' + i.sks_total + '</td>' +
                        '<td>' + call_job + '</td>' +
                        '<td><a href="../berkas/transkrip/' + i.file.transcript + '" target="blank" class="btn btn-xs btn-secondary m-1 w-100">Transkrip</a><br>' +
                        '<a href="../berkas/khs/' + i.file.khs + '" target="blank" class="btn btn-xs btn-secondary m-1 w-100">Kartu Hasil Studi</a><br>' +
                        '<a href="../berkas/krs/' + i.file.krs + '" target="blank" class="btn btn-xs btn-secondary m-1 w-100">Kartu Rencana Studi</a></td></tr>'

                    $('#detail_verifikasi tbody').append(modal)
                });

            }
        })
    });

    $('#registration tbody').on('click', '.terima', function() {
        let id = $(this).attr('id')
        $('#reg-accept').modal('show');

        $.ajax({
            url: "../koor/getIsVerif/" + id,
            success: function(result) {
                $('#is_verified').val(result.data.is_verified)
                $('#groupProject_id').val(result.data.id)
            }
        })
    });

    $('#verifikasi').submit(function(e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#groupProject_id').val();
        $.ajax({
            url: "getIsVerif/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#verifikasi')[0].reset();
                    $('#reg-accept').modal('hide');
                    $('#registration').DataTable().ajax.reload();
                    $('#mahasiswa-pk').DataTable().ajax.reload();
                    location.reload();

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
    })

    $('#registration tbody').on('click', '.tolak', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: "Data ini akan dihapus",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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
                    url: "tolakProject/" + id,
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Deleted!',
                                'Telah Dihapus',
                                'success'
                            )
                            .then(function() {
                                $('#registration').DataTable().ajax.reload();
                                $('#mahasiswa-pk').DataTable().ajax.reload();
                            })
                    }
                })
            }
        })
    });
    $("#mahasiswa-pk").DataTable({
        "processing": true,
        "ajax": {
            url: "{{ url('../koor/getDataVerified') }}"
        },
        "columns": [{
                sortable: false,
                "render": function(data, type, full, meta) {
                    let img = ''
                    for (let i = 0; i < full.internship_students.length; i++) {
                        img += '<a href=../public/image/' + full.internship_students[i].user.image_profile + ' target="_blank"><img src="../public/image/' + full.internship_students[i].user.image_profile + '" data-toggle="tooltip" data-placement="bottom" class="table-avatar m-1" title="' + full.internship_students[i].name + '"></a>'
                    }
                    return img
                }
            },
            {
                data: "agency.agency_name"
            },
            {
                data: "group_project_supervisor.lecturer.name"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<a href="../berkas/kak/'+full.kak+'" target="_blank" class="btn btn-block btn-sm btn-primary m-1" title="Kerangka Acuan Kerja">Kerangka</a>' +
                    '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-info detail m-1" title="Detail">Detail</button>'
                }
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-warning edit m-1" title="Edit">Edit</button>' +
                        '<button id="' + buttonId + '" class="btn btn-block btn-sm btn-danger hapus m-1" title="Hapus">Hapus</button>'
                }
            }
        ]
    });
    
    $('#mahasiswa-pk tbody').on('click', '.detail', function() {
        let id = $(this).attr('id')
        $('#reg-detail').modal('show');

        $.ajax({
            url: "../koor/getDataTableVerif/" + id,
            success: function(result) {
                $('#detail_verifikasi tbody').html('')
                $('#agency_name').val(result.data.agency.agency_name)
                $('#sector').val(result.data.agency.sector)
                $('#address').val(result.data.agency.address)
                $('#phone_number').val(result.data.agency.phone_number)
                $('#start_intern').val(result.data.start_intern)
                $('#end_intern').val(result.data.end_intern)

                let modal = ''
                let job = ''

                result.data.internship_students.forEach(function(i) {
                    let call_job = ''
                    i.jobdescs.forEach(function(job) {
                        call_job += job.jobname + '<br>'
                    })
                    modal = '<tr><td>' + i.nim + '</td>' +
                        '<td>' + i.name + '</td>' +
                        '<td>' + i.ipk + '</td>' +
                        '<td>' + i.sks_total + '</td>' +
                        '<td>' + call_job + '</td>' +
                        '<td><a href="../berkas/transkrip/' + i.file.transcript + '" target="blank" class="btn btn-sm btn-secondary m-1 w-100">Transkrip</a><br>' +
                        '<a href="../berkas/khs/' + i.file.khs + '" target="blank" class="btn btn-sm btn-secondary m-1 w-100">Kartu Hasil Studi</a><br>' +
                        '<a href="../berkas/krs/' + i.file.krs + '" target="blank" class="btn btn-sm btn-secondary m-1 w-100">Kartu Rencana Studi</a></td></tr>'

                    $('#detail_verifikasi tbody').append(modal)
                });

            }
        })
    });
    
    $('#mahasiswa-pk tbody').on('click', '.edit', function() {
        let id = $(this).attr('id')
        $('#updateSupervisor').modal('show');
        $.ajax({
            url: "../koor/updateSupervisor/" + id,
            success: function(result) {
                $('#editPembimbing').html('')
                $('#group_id').val(result.data.id)

                let dosenId = [];
                let dosenName = [];
                let dosenQuota = [];
                for(i=0; i<result.dosen.length; i++) {
                    dosenId[i] = result.dosen[i].id
                    dosenName[i] = result.dosen[i].name
                    dosenQuota[i] = result.dosen[i].quota
                    if (dosenQuota[i] >= 4) {
                        $('#editPembimbing').append('<option class="editLecturer bg-danger" value="'+dosenId[i]+'"> '+dosenName[i]+' - Banyak Bimbingan: '+dosenQuota[i]+'</option>')
                    }
                    else if (dosenQuota[i] >= 2) {
                        $('#editPembimbing').append('<option class="editLecturer bg-warning" value="'+dosenId[i]+'"> '+dosenName[i]+' - Banyak Bimbingan: '+dosenQuota[i]+'</option>')
                    }
                    else {
                        $('#editPembimbing').append('<option class="editLecturer" value="'+dosenId[i]+'"> '+dosenName[i]+' - Banyak Bimbingan: '+dosenQuota[i]+'</option>')
                    }
                }

                $('#editPembimbing').val(result.data.group_project_supervisor.lecturer_id)
            }
        })
    });

    $('#formEdit').submit(function(e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#group_id').val();
        $.ajax({
            url: "updateSupervisor/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formEdit')[0].reset();
                    $('#updateSupervisor').modal('hide');
                    $('#mahasiswa-pk').DataTable().ajax.reload();
                    location.reload();

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
    })

    $('#mahasiswa-pk tbody').on('click', '.hapus', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: "Data ini akan dihapus",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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
                    url: "hapusProject/" + id,
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Deleted!',
                                'Telah Dihapus',
                                'success'
                            )
                            .then(function() {
                                $('#registration').DataTable().ajax.reload();
                                $('#mahasiswa-pk').DataTable().ajax.reload();
                            })
                    }
                })
            }
        })

    });
</script>
@endsection