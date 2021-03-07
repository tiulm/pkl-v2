@extends('layout.master')

@section('title', 'Koordinator | Pasca Seminar PKL dan PK')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Pengumpulan Laporan PKL dan PK</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <button id="arsipAll" type="button" class="btn btn-success btn-sm">
                        <i class="fas fa-archive mr-1"></i>
                        Arsipkan Semua
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-book mr-1"></i>
                    Pasca Seminar PKL dan PK
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="report" class="table table-striped projects dataTable w-100">
                    <thead>
                        <tr>
                            <th width='15%'>Tanggal Seminar</th>
                            <th width='30%'>Judul & Kelompok</th>
                            <th width='25%'>Penguji</th>
                            <th width='15%'>Catatan Revisi & Laporan</th>
                            <th width='5%'>Lihat</th>
                            <th width='10%'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Detail Modal -->
    <div class="modal fade" id="detail" aria-hidden="true">
        <div class="modal-dialog modal-lg">
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
                            <a class="nav-link active" id="group-tab" data-toggle="pill" href="#group" role="tab"
                                aria-controls="group" aria-selected="true">Kelompok</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab"
                                aria-controls="team" aria-selected="true">Mahasiswa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="instansi-tab" data-toggle="pill" href="#instansi" role="tab"
                                aria-controls="instansi" aria-selected="false">Instansi/Perusahaan</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="seminar-tab" data-toggle="pill" href="#seminar" role="tab"
                                aria-controls="seminar" aria-selected="false">Seminar</a>
                        </li> -->
                    </ul>
                    <div class="tab-content" id="tabContent">
                        <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                            <table class="table" id="kelompok">
                                <thead>
                                    <tr>
                                        <th>Berkas Proyek Kelompok</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane table-responsive fade" id="team" role="tabpanel" aria-labelledby="team-tab">
                            <table class="table" id="mahasiswa">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Job Description</th>
                                        <th>Berkas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="instansi" role="tabpanel" aria-labelledby="instansi-tab">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="instansi">Nama Instansi/Perusahaan</label>
                                    <input type="text" class="form-control" id="agency" readonly>
                                </div>
                                <div class="form-group col-12">
                                    <label for="bidang">Bidang/Sektor Usaha</label>
                                    <input type="text" class="form-control" id="bidang" readonly>
                                </div>
                                <div class="form-group col-12">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" readonly>
                                </div>
                                <div class="form-group col-12">
                                    <label for="tlp">No. Telephon/Handphone</label>
                                    <input type="text" class="form-control" id="tlp" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="start">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="end">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="end" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade" id="seminar" role="tabpanel" aria-labelledby="seminar-tab">
                            <div class="form-group">
                                <label>Tempat</label>
                                <input type="text" name="tempat" id="tempat" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" name="tanggal" id="tanggal" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Waktu</label>
                                <div class="input-group">
                                    <input name="waktuMulai" id="waktuMulai" type="text" class="form-control" disabled>
                                    <input name="waktuSelesai" id="waktuSelesai" type="text" class="form-control"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ketua Penguji</label>
                                <input id="ketuapem" type="text" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Sekretaris</label>
                                <input id="pem1" type="text" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Penguji I</label>
                                <input id="pem2" type="text" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                                <label>Penguji II</label>
                                <input id="pem3" type="text" class="form-control" disabled>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- News Report Modal -->
    <div class="modal fade" id="news-report" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-file mr-1"></i>
                        Catatan Revisi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="news_report" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" id="group_project_id" value="">
                            <input type="hidden" id="_method" value="PUT" name="_method">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file-arsip" name="berita">
                                    <label class="custom-file-label" for="arsip">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary tambah">Tambah</button>
                </form>
                <hr>
                <table class="table" id="files">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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

    <!-- Pengamat Modal -->
    <div class="modal fade" id="observer" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengamat">
                        <i class="fas fa-users mr-1"></i>
                        Daftar Pengamat
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <table class="table" id="observer">
                        <thead>
                            <tr>
                                <th width="20%">NIM</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer absen">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('ajax')
<script>
    $("#report").DataTable({
        "processing": true,
        "order": [[ 0, "desc" ]],
        "ajax": {
            url: "{{ url('../koor/arsip-pk/show') }}"
        },
        "columns": [{
                sortable: false,
                "render": function (data, type, full, meta) {
                    return '<b>' + full.group_project_schedule.tanggal + '</b><br><small>' + full
                        .group_project_schedule.place + '<br>' +
                        moment(full.group_project_schedule.time, 'HH:mm:ss').format('HH:mm') + '-' +
                        moment(full.group_project_schedule.time_end, 'HH:mm:ss').format('HH:mm') +
                        ' WITA</small>'
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let img = ''
                    for (let i = 0; i < full.internship_students.length; i++) {
                        img += '<a href=../public/image/' + full.internship_students[i].user
                            .image_profile + ' target="_blank"><img src="../public/image/' + full
                            .internship_students[i].user.image_profile +
                            '" data-toggle="tooltip" data-placement="bottom" class="table-avatar m-1" title="' +
                            full.internship_students[i].name + '"></a>'
                    }
                    return full.title + '<br><br>' +img
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let penguji = '<table class="table-borderless table-light">'
                    for (let i = 0; i < full.group_project_examiner.length; i++) {
                        penguji += '<tr><th width="20%">'+full.group_project_examiner[i].role+'</th><td>'+full.group_project_examiner[i].lecturer.name+'</td></tr>'
                    }
                    let end = '</table>'
                    return penguji + end
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    if ((full.revisi === null) && (full.laporan === null)) {
                        return '<span class="badge badge-danger p-2 m-1">Catatan Revisi Belum Tersedia</span><span class="badge badge-danger p-2 ml-1">Laporan Belum Dikumpul</span>'
                    } else if ((full.revisi !== null) && (full.laporan === null)) {
                        return '<span class="badge badge-success p-2 m-1">Catatan Revisi Tersedia</span><span class="badge badge-danger p-2 m-1">Laporan Belum Dikumpul</span>'
                    } else if ((full.revisi === null) && (full.laporan !== null)) {
                        return '<span class="badge badge-danger p-2 m-1">Catatan Revisi Belum Tersedia</span><span class="badge badge-success p-2 m-1">Laporan Sudah Dikumpul</span>'
                    } else if ((full.revisi !== null) && (full.laporan !== null)) {
                        return '<span class="badge badge-success p-2 m-1">Catatan Revisi Tersedia</span><span class="badge badge-success p-2 m-1">Laporan Sudah Dikumpul</span>'
                    }
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId +
                        '" class="btn btn-block btn-primary btn-sm detail" title="Detail">Detail</button>' +
                        '<button id="' + buttonId +
                        '" class="btn btn-block btn-dark btn-sm observer" title="Menghadiri">Pengamat</button>'
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId +
                        '" class="btn btn-block btn-secondary btn-sm news-report" title="Catatan Revisi">Revisi</button>' +
                        '<button id="' + buttonId +
                        '" class="btn btn-block btn-success btn-sm delete" title="Arsipkan">Arsipkan</button>'
                }
            },
        ]
    });

    $('#report tbody').on('click', '.detail', function () {
        let id = $(this).attr('id')
        $('#detail').modal('show');

        $.ajax({
            url: "../koor/detailArsip/" + id,
            success: function (result) {
                $('#mahasiswa tbody').html('')
                $('#kelompok tbody').html('')
                $('#agency').val(result.data.agency.agency_name)
                $('#bidang').val(result.data.agency.sector)
                $('#alamat').val(result.data.agency.address)
                $('#tlp').val(result.data.agency.phone_number)
                $('#start').val(result.data.start_intern)
                $('#end').val(result.data.end_intern)
                // $('#tempat').val(result.schedule.group_project_schedule.place)
                // $('#tanggal').val(moment(result.schedule.group_project_schedule.date).format(
                //     'D MMMM YYYY'))
                // $('#waktuMulai').val(moment(result.schedule.group_project_schedule.time, 'HH:mm:ss')
                //     .format('HH:mm A'))
                // $('#waktuSelesai').val(moment(result.schedule.group_project_schedule.time_end,
                //     'HH:mm:ss').format('HH:mm A'))
                // $('#pem3').val(result.supervisor.lecturer.name)
                // result.fck.forEach(function (mmk) {
                //     let role = mmk.role;
                //     if (role === "Ketua Penguji") {
                //         $('#ketuapem').val(mmk.lecturer.name);
                //     } else if (role === "Sekretaris") {
                //         $('#pem1').val(mmk.lecturer.name);
                //     } else if (role === "Penguji 1") {
                //         $('#pem2').val(mmk.lecturer.name);
                //     } else if (role === "Penguji 2") {
                //         $('#pem3').val(mmk.lecturer.name);
                //     }
                // });

                let modal = ''
                let job = ''

                file = '<tr><td>Kerangka Acuan Kerja</td>' +
                    '<td class="text-right py-0 align-middle">' +
                    '<a href="../berkas/kak/' + result.data.kak +
                    '" target="blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></td></tr>' +
                    '<tr><td>Lembar Persetujuan Seminar PKL dan PK</td>' +
                    '<td class="text-right py-0 align-middle">' +
                    '<a href="../berkas/persetujuan/' + result.data.persetujuan +
                    '" target="blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></td></tr>'
                $('#kelompok tbody').append(file);

                result.data.internship_students.forEach(function (i) {
                    let call_job = ''
                    i.jobdescs.forEach(function (job) {
                        call_job += job.jobname + '<br>'
                    })
                    modal = '<tr><td>' + i.nim + '</td>' +
                        '<td>' + i.name + '</td>' +

                        '<td>' + call_job + '</td>' +
                        '<td><a href="../berkas/nilaiPKL/' + i.file.penilaian_pkl +
                        '" class="btn btn-xs btn-secondary m-1 w-100" target="blank">Lembar Penilaian PKL</a><br>' +
                        '</td></tr>'

                    $('#mahasiswa tbody').append(modal)
                });
            }
        })
    });

    $('#report tbody').on('click', '.observer', function () {
        let id = $(this).attr('id')
        $('#observer').modal('show');

        $.ajax({
            url: "../koor/observer/" + id,
            success: function (result) {
                $('#observer tbody').html('')
                $('.absen').html('')
                let modal = ''
                let absen = '<a href="../koor/absen/' + id +
                    '" target="_blank" class="btn btn-sm btn-primary float-right"><i class="fas fa-print"></i> Daftar Hadir</a>'

                result.data.forEach(function (i) {
                    let mhsId = i.id
                    modal = '<tr><td>' + i.nim + '</td>' +
                        '<td>' + i.name + '</td>' +
                        '</tr>'

                    $('#observer tbody').append(modal)
                });
                $('.absen').append(absen)
            }
        })
    });

    $('#report tbody').on('click', '.news-report', function () {
        let id = $(this).attr('id')
        $('#news-report').modal('show');
        $.ajax({
            url: "newsReport/" + id,
            success: function (result) {
                $('#files tbody').html('')
                $('#group_project_id').val(result.data.id)
                file = '<tr><td> Catatan Revisi (' + result.data.revisi +')' +
                    '<td class="text-right py-0 align-middle">' +
                    '<a href="../berkas/revisi/' + result.data.revisi +
                    '" target="blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></td></tr>' +
                    '<tr><td> Laporan (' + result.data.laporan +')' +
                    '<td class="text-right py-0 align-middle">' +
                    '<a href="../berkas/laporan/' + result.data.laporan +
                    '" target="blank" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a></td></tr>'
                $('#files tbody').append(file);
            }
        })
    });
    $('#news_report').submit(function (e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#group_project_id').val();
        $.ajax({
            url: "newsReport/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#news_report')[0].reset();
                    $('#news-report').modal('hide');
                    $('#report').DataTable().ajax.reload();

                } else {
                    $('#modalFailed').modal();
                }
            },
            error: function (data) {
                $("small").remove(".text-danger");
                $("input").removeClass("is-invalid");
                $.each(data.responseJSON.errors, function (key, value) {
                    $('#' + key + '').addClass('is-invalid');
                    $('#' + key + '').after('<small class="text-danger">' + value +
                        '</small>')
                });
            }
        })
    })

    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
        var fileName = document.getElementById("file-arsip").data[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName
    })

    
    $('#arsipAll').on('click', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin mengarsipkan semua data?',
            text: "Semua data akan diarsipkan",
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
                    url: "arsipAll",
                    method: "POST",
                    data: {
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Berhasil!',
                                'Data PKL-PK Telah Diarsipkan',
                                'success'
                            )
                            .then(function() {
                                $('#report').DataTable().ajax.reload();
                            }
                        )
                    }
                })
            }
        })
    });

    $('#report tbody').on('click', '.delete', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin mengarsipkan data?',
            text: "Data ini akan diarsipkan",
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
                    url: "newsReport/" + id + "/delete",
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Berhasil!',
                                'Data PKL-PK Telah Diarsipkan',
                                'success'
                            )
                            .then(function() {
                                $('#report').DataTable().ajax.reload();
                            }
                        )
                    }
                })
            }
        })
    });

</script>
@endsection
