@extends('layout.master')

@section('title', 'Mahasiswa | Sertifikat')
@section('content')
<section class="content">
    <div class="container-fluid">
        <h5 class="py-2">Riwayat</h5>
        <div class="card card-success">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Seminar Yang Telah Ditonton
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="seminar" class="table table-striped projects dataTable w-100">
                    <thead>
                        <tr>
                            <th width='15%'>Tanggal</th>
                            <th>Judul</th>
                            <th>Instansi</th>
                            <th width='20%'>Kelompok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($student as $s)
                        @foreach ($s->GroupProjectSchedule->Observer as $o)
                        @if ($o->internship_student_id == Auth::user()->InternshipStudent->id)
                        <tr>
                            <td>
                                <b>{{ $s->GroupProjectSchedule->tanggal }}</b><br>
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
                        </tr>
                        @endif
                        @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection
@section('ajax')
<script>
    $("#seminar").DataTable({
        "processing": true,
    });
</script>
@endsection
