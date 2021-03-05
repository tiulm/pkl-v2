@extends('layout.master')

@section('title', 'Mahasiswa | Seminar')
@section('content')
<section class="content">
    <div class="container-fluid">
        <h5 class="py-2">Seminar</h5>
        <div class="card card-warning">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Jadwal Seminar
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="seminar" class="table table-striped projects dataTable w-100">
                    <thead>
                        <tr>
                            <th width='15%'>Tanggal</th>
                            <th width='35%'>Judul</th>
                            <th width='15%'>Instansi</th>
                            <th width='20%'>Kelompok</th>
                            <th width='5%'>Kuota Pengamat</th>
                            <th width='10%'>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 0 ?>
                        @foreach ($seminar as $s)
                        <tr>
                            <td>
                                <b>{{ Carbon\Carbon::parse($s->GroupProjectSchedule->date)->isoFormat('D MMMM Y') }}</b><br>
                                <small>
                                    {{ $s->GroupProjectSchedule->place }}<br>
                                    {{ Carbon\Carbon::parse($s->GroupProjectSchedule->time)->isoFormat('HH:mm') }} -
                                    {{ Carbon\Carbon::parse($s->GroupProjectSchedule->time_end)->isoFormat('HH:mm') }}
                                    WITA
                                </small>
                            </td>
                            <td>
                                {{ $s->title }}
                            </td>
                            <td>
                                {{ $s->Agency->agency_name }}
                            </td>
                            <td>
                                @foreach($s->InternshipStudents as $i)
                                <a href="../public/image/{{ $i->User->image_profile }}" target="_blank">
                                    <img src="../public/image/{{ $i->User->image_profile }}" data-toggle="tooltip"
                                        data-placement="bottom" class="table-avatar m-1" title="{{ $i->name }}">
                                </a>
                                @endforeach
                            </td>
                            <td>
                                @if($peserta[$j] == $s->GroupProjectSchedule->quota)
                                    {{ $s->GroupProjectSchedule->quota }} <span class="badge badge-sm badge-success p-2" style="font-size: 10px">Penuh</span>
                                @else
                                    {{ $s->GroupProjectSchedule->quota }}
                                @endif
                            </td>
                            <td>
                                @if($gua[$j] == 0)
                                    @if($peserta[$j] < $s->GroupProjectSchedule->quota)
                                        @if ($pengamat[$j] == 0)
                                            <button onclick="openModalHadir('{{ $s->id }}')"
                                                class="btn btn-sm btn-success hadiri ml-1 mr-1">Hadiri</button>
                                        @else
                                        <button onclick="openModalBatal('{{ $s->id }}')"
                                            class="btn btn-sm btn-danger batal ml-1 mr-1" title="Batal Hadir">Batal</button>
                                        @endif
                                    @else
                                        @if ($pengamat[$j] != 0)
                                            <button onclick="openModalBatal('{{ $s->id }}')"
                                                class="btn btn-sm btn-danger batal ml-1 mr-1">Batal</button>
                                        @endif
                                    @endif
                                @else
                                    <span class="badge badge-info p-2" style="font-size: 12px">Kelompok Anda</span>
                                @endif
                            </td>
                        </tr>
                        <?php $j++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Hadiri modal -->
<div class="modal fade" id="hadiri" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">
                    <i class="fas fa-check mr-1"></i>
                    Konfirmasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghadiri Seminar?<br><br>
                    <form action="berhadir" id="pengamat" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-9">
                                    <input name="internship_student_id" type="hidden"
                                        value="{{ Auth::user()->InternshipStudent->id }}" class="form-control" id="">
                                    <input type="hidden" name="groupProject" id="group_id" value="">
                                </div>
                            </div>
                        </div>
                        <b class="text-danger font-italic">*Pastikan anda bisa menghadiri dan tidak bertabrakan dengan
                            jadwal lain.</b>
                </p>
            </div>
            <div class="modal-footer">
                <button id="tombol_hide" type="submit" class="btn btn-success float-right">Yakin</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Batal modal -->
<div class="modal fade" id="batal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    Konfirmasi Batal Hadir
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin batal menghadiri Seminar?<br><br>
                    <form action="batalHadir" id="pengamat" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-9">
                                    <input name="internship_student_id" type="hidden"
                                        value="{{ Auth::user()->InternshipStudent->id }}" class="form-control" id="">
                                    <input type="hidden" name="groupProject" id="group_batal" value="">
                                </div>
                            </div>
                        </div>
                </p>
            </div>
            <div class="modal-footer">
                <button id="tombol_hide" type="submit" class="btn btn-danger float-right">Yakin</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('ajax')
<script>
    $("#seminar").DataTable({
        "processing": true,
    });

    function openModalHadir(id) {
        $('#hadiri').modal();
        $('#group_id').val(id)
    }

    function openModalBatal(id) {
        $('#batal').modal();
        $('#group_batal').val(id)
    }

</script>
@endsection
