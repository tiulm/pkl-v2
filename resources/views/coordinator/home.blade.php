@extends('layout.master')

@section('title', 'Koordinator | Dashboard')
@section('content')
<section class="content">
    <div class="container-fluid">
        @if(session()->has('success'))
        <div class="pt-2">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info"></i> Selamat Datang!</h5>
                Selamat datang di Sistem Informasi Monitoring PKL dan PK <br>
                Anda login sebagai <b>Koordinator</b>
            </div>
        </div>
        @endif
        <h5 class="py-2">Dashboard</h5>
        @csrf
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-plus"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Daftar PKL dan PK</span>
                        <span class="info-box-number">
                            {{$daftar}}
                        </span>
                        <a href="{{ url ('koor/mahasiswa') }}" class="badge badge-warning float-right">Detail <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mahasiswa PKL & PK</span>
                        <span class="info-box-number">
                            {{$mahasiswa}}
                        </span>
                        <a href="{{ url ('koor/mahasiswa') }}" class="badge badge-info float-right">Detail <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Kelompok PKL & PK</span>
                        <span class="info-box-number">
                            {{$progress}}
                        </span>
                        <a href="{{ url ('koor/bimbingan') }}" class="badge badge-primary float-right">Detail <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Daftar Seminar</span>
                        <span class="info-box-number">
                            {{$seminar}}
                        </span>
                        <a href="{{ url ('koor/seminar') }}" class="badge badge-warning float-right">Detail <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Agenda Seminar
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <thead>
                            <tr>
                                <th width="55%">Judul</th>
                                <th width="15%">Tempat</th>
                                <th width="15%">Tanggal</th>
                                <th width="15%">Waktu</th>
                            </tr>
                        </thead>
                        @foreach ($agenda as $agend)
                        <tr>
                            <td>{{$agend->title}}</td>
                            <td>{{$agend->GroupProjectSchedule->place}}</td>
                            <td>{{ Carbon\Carbon::parse($agend->GroupProjectSchedule->date)->format('d F Y') }}</td>
                            <td>{{ Carbon\Carbon::parse($agend->GroupProjectSchedule->time)->format('h:i') }} - {{ Carbon\Carbon::parse($agend->GroupProjectSchedule->time_end)->format('h:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a class="btn btn-success float-right" href="{{ url ('koor/seminar') }}">Edit Jadwal</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('ajax')
<script>

</script>
@endsection