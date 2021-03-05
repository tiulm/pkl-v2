@extends('layout.master')

@section('title', 'Koordinator | PKL')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Praktek Kerja Lapangan</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <a href="{{ route('bimbingan-list') }}" type="button" class="btn btn-default btn-sm">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Anggota Kelompok
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="mahasiswa" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Profil</th>
                            <th>Nama</th>
                            <th>Jobdesc</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pk->InternshipStudents as $i)
                        <tr>
                            <td>{{ $i->nim }}</td>
                            <td>
                                <img src="/public/image/{{ $i->User->image_profile }}" data-toggle="tooltip"
                                    data-placement="bottom" class="img-circle table-avatar" width="40px">
                            </td>
                            <td>{{ $i->name }}</td>
                            <td>
                                @foreach ($i->Jobdescs as $job)
                                {{ $job->jobname }}<br>
                                @endforeach
                            </td>
                            <td>
                                <button id="{{ $i->id }}" title="Progress PKL" class="btn btn-primary mr-1 intern">Bimbingan</button>
                                <button id="{{ $i->id }}" title="Log Activity" class="btn btn-secondary mr-1 logact">Log Activity</i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<div class="modal fade internProgress" id="internProgress" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-spinner mr-1"></i>
                    Progress Praktek Kerja Lapangan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table id="internPro" class="table table-striped w-100">
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

<div class="modal fade logAct" id="logAct" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tasks mr-1"></i>
                    Log Activity Praktek Kerja Lapangan
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table id="logActIntern" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</section>
@endsection

@section('ajax')
<script>
    $('#mahasiswa tbody').on('click', '.intern', function() {
        let id = $(this).attr('id');

        $.ajax({
            url: "progress/" + id,
            dataType: "json",
            success: function(result) {
                $('#internProgress').modal('show')
                $('#internPro tbody').html('')
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

                    $('#internPro tbody').append(modal)
                });
                if (belum > 0) {
                    $('.modalBim').append(semua)
                }
            }
        })
    });
    
    $('#internPro tbody').on('click', '.agree', function() {
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
                    url: "agreePKL/" + id,
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
                                $("#internProgress").modal('hide');
                            })
                    }
                })
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
                    url: "agreePKLAll/" + id,
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
                                $("#internProgress").modal('hide');
                            })
                    }
                })
            }
        })

    });

    $('#mahasiswa tbody').on('click', '.logact', function() {
        let id = $(this).attr('id');

        $.ajax({
            url: "logact/" + id,
            dataType: "json",
            success: function(result) {
                $('#logAct').modal('show')
                $('#logActIntern tbody').html('')
                let modal = ''
                let iteration = 1

                result.data.forEach(function(i) {
                    modal = '<tr><td>' + iteration + '</td>' +
                            '<td>' + i.date + '</td>' +
                            '<td>' + i.description + '</td></tr>'
                    iteration += 1

                    $('#logActIntern tbody').append(modal)
                });
            }
        })
    });
</script>
@endsection
