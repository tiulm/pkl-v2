@extends('layout.master')

@section('title', 'Mahasiswa | Dashboard')
@section('content')
<section class="content">
    <div class="container-fluid">
        @if(session()->has('success'))
        <div class="pt-2">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-info"></i> Selamat Datang!</h5>
                Selamat datang di Sistem Informasi Monitoring PKL dan PK <br>
                Anda login sebagai <b>Mahasiswa</b>
            </div>
        </div>
        @endif
        @if(Auth::user()->isVerifiedGroupProject() === null)
        <!-- Pendaftaran -->
        <form action="{{ route('mahasiswa.daftar') }}" enctype="multipart/form-data" method="POST">
            <h5 class="py-2">Pendaftaran PKL dan PK</h5>
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                Mahasiswa
                            </h3>
                        </div>
                        <div class="card-body">
                            @error('nim[]')
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Failed!</h5>
                                Minimal 3 mahasiswa
                            </div>
                            @enderror
                            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="m-tab" data-toggle="pill" href="#m-1" role="tab"
                                        aria-controls="m-1" aria-selected="true">M-1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="m-tab" data-toggle="pill" href="#m-2" role="tab"
                                        aria-controls="m-2" aria-selected="true">M-2</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="m-tab" data-toggle="pill" href="#m-3" role="tab"
                                        aria-controls="m-3" aria-selected="true">M-3</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link add-mahasiswa">+ Mahasiswa</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="m-tabContent">
                                <!-- Mahasiswa 1 -->
                                <div class="tab-pane fade show active" id="m-1" role="tabpanel"
                                    aria-labelledby="m-1-tab">
                                    @csrf
                                    <div class="row mt-2">
                                        @error('nama-1')
                                        <div class="form-group col-12">
                                            <div class="alert alert-danger alert-dismissible w-100"><i
                                                    class="icon fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        </div>
                                        @enderror
                                        <div class="form-group col-12">
                                            <label for="nim">NIM</label>
                                            <div class="row">
                                                <div class="col-9">
                                                    <input name="internship_student_id" type="hidden"
                                                        value="{{ Auth::user()->InternshipStudent->id }}"
                                                        class="form-control" id="">
                                                    <input name="nim[]" type="text"
                                                        value="{{ Auth::user()->InternshipStudent->nim }}"
                                                        class="form-control @error('nama-1') is-invalid @enderror @error('nim-1') is-invalid @enderror"
                                                        id="nim-1" required>
                                                    @error('nim-1')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-primary w-100"
                                                        id="cek-student-1" onclick="fetchData(1)">Cek</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama-1" readonly
                                                value="{{Request::old('nama-1')}}" name="nama-1">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="ipk">IPK</label>
                                            <input type="number"
                                                class="form-control @error('ipk-1') is-invalid @enderror" id="ipk-1"
                                                readonly value="{{Request::old('ipk-1')}}" min="2.5" name="ipk-1">
                                            @error('ipk-1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="sks">SKS</label>
                                            <input type="number"
                                                class="form-control @error('sks-1') is-invalid @enderror" id="sks-1"
                                                readonly value="{{Request::old('sks-1')}}" min="90" name="sks-1">
                                            @error('sks-1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="jobDesc">Job Description</label>
                                            <div class="row">
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-secondary jobdesk w-100"
                                                        id="jobdesk" data-toggle="modal" data-target="#job_desk"><i
                                                            class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="col-9">
                                                    <select name="jobdesc_1[]"
                                                        class="select2 @error('jobdesc_1') is-invalid @enderror"
                                                        multiple="multiple" style="width: 100%;" id="jobDesc-1"
                                                        required>
                                                        @foreach($job as $jobdesc)
                                                        <option value="{{$jobdesc->id}}">{{$jobdesc->jobname}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('jobdesc_1')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Hasil Studi</label>
                                            <input name="khs_1" type="file" class="form-control-file" id="khs-1"
                                                value="{{Request::old('khs_1')}}" required>
                                            @error('khs_1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Transkrip</label>
                                            <input name="transkrip_1" type="file" class="form-control-file"
                                                id="transkrip-1" value="{{Request::old('transkrip_1')}}" required>
                                            @error('transkrip_1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Rencana Studi</label>
                                            <input name="krs_1" type="file" class="form-control-file" id="krs-1"
                                                value="{{Request::old('krs_1')}}" required>
                                            @error('krs_1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <!-- Mahasiswa 2 -->
                                <div class="tab-pane fade show" id="m-2" role="tabpanel" aria-labelledby="m-2-tab">
                                    <div class="row mt-2">
                                        @error('nama-2')
                                        <div class="form-group col-12">
                                            <div class="alert alert-danger alert-dismissible w-100"><i
                                                    class="icon fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        </div>
                                        @enderror
                                        <div class="form-group col-12">
                                            <label for="nim">NIM</label>
                                            <div class="row">
                                                <div class=col-9>
                                                    <input name="nim[]" type="text"
                                                        class="form-control @error('nama-2') is-invalid @enderror"
                                                        value="{{Request::old('nim.2')}}" id="nim-2" required>
                                                    @error('nim-2')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class=col-3>
                                                    <button type="button" class="btn btn-primary w-100"
                                                        id="cek-student-2" onclick="fetchData(2)">Cek</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama-2" readonly
                                                value="{{Request::old('nama-2')}}" name="nama-2">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="ipk">IPK</label>
                                            <input type="number"
                                                class="form-control @error('ipk-2') is-invalid @enderror" id="ipk-2"
                                                readonly value="{{Request::old('ipk-2')}}" min="2.5" name="ipk-2">
                                            @error('ipk-2')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="sks">SKS</label>
                                            <input type="number"
                                                class="form-control @error('sks-2') is-invalid @enderror" id="sks-2"
                                                readonly value="{{Request::old('sks-2')}}" min="90" name="sks-2">
                                            @error('sks-2')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="jobDesc">Job Description</label>
                                            <div class="row">
                                                <div class=col-3>
                                                    <button type="button" class="btn btn-sm btn-secondary jobdesk w-100"
                                                        id="jobdesk" data-toggle="modal" data-target="#job_desk"><i
                                                            class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="col-9">
                                                    <select name="jobdesc_2[]"
                                                        class="select2 @error('jobdesc_2') is-invalid @enderror"
                                                        multiple="multiple" style="width: 100%;" id="jobDesc-2"
                                                        required>
                                                        @foreach($job as $jobdesc)
                                                        <option value="{{$jobdesc->id}}">{{$jobdesc->jobname}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('jobdesc_2')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Hasil Studi</label>
                                            <input name="khs_2" type="file" class="form-control-file" id="khs-2"
                                                required>
                                            @error('khs_2')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Transkrip</label>
                                            <input name="transkrip_2" type="file" class="form-control-file"
                                                id="transkrip-2" required>
                                            @error('transkrip_2')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Rencana Studi</label>
                                            <input name="krs_2" type="file" class="form-control-file" id="krs-2"
                                                required>
                                            @error('krs_1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <!-- Mahasiswa 3 -->
                                <div class="tab-pane fade show" id="m-3" role="tabpanel" aria-labelledby="m-3-tab">
                                    <div class="row mt-2">
                                        @error('nama-3')
                                        <div class="form-group col-12">
                                            <div class="alert alert-danger alert-dismissible w-100"><i
                                                    class="icon fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        </div>
                                        @enderror
                                        <div class="form-group col-12">
                                            <label for="nim">NIM</label>
                                            <div class="row">
                                                <div class=col-9>
                                                    <input name="nim[]" type="text"
                                                        class="form-control @error('nama-3') is-invalid @enderror"
                                                        value="{{Request::old('nim.3')}}" id="nim-3" required>
                                                    @error('nim-3')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-3">
                                                    <button type="button" class="btn btn-primary w-100"
                                                        id="cek-student-3" onclick="fetchData(3)">Cek</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama-3" readonly
                                                value="{{Request::old('nama-3')}}" name="nama-3">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="ipk">IPK</label>
                                            <input type="number"
                                                class="form-control @error('ipk-3') is-invalid @enderror" id="ipk-3"
                                                readonly value="{{Request::old('ipk-3')}}" min="2.5" name="ipk-3">
                                            @error('ipk-3')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="sks">SKS</label>
                                            <input type="number"
                                                class="form-control @error('sks-3') is-invalid @enderror" id="sks-3"
                                                readonly value="{{Request::old('sks-3')}}" min="90" name="sks-3">
                                            @error('sks-3')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="jobDesc">Job Description</label>
                                            <div class="row">
                                                <div class=col-3>
                                                    <button type="button" class="btn btn-sm btn-secondary jobdesk w-100"
                                                        id="jobdesk" data-toggle="modal" data-target="#job_desk"><i
                                                            class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="col-9">
                                                    <select name="jobdesc_3[]"
                                                        class="select2 @error('jobdesc_3') is-invalid @enderror"
                                                        multiple="multiple" style="width: 100%;" id="jobDesc-3"
                                                        required>
                                                        @foreach($job as $jobdesc)
                                                        <option value="{{$jobdesc->id}}">{{$jobdesc->jobname}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('jobdesc_3')
                                                    <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Hasil Studi</label>
                                            <input name="khs_3" type="file" class="form-control-file" id="khs-3"
                                                required>
                                            @error('khs_3')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Transkrip</label>
                                            <input name="transkrip_3" type="file" class="form-control-file"
                                                id="transkrip-3" required>
                                            @error('transkrip_3')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Rencana Studi</label>
                                            <input name="krs_3" type="file" class="form-control-file" id="krs-3"
                                                required>
                                            @error('krs_1')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-industry mr-1"></i>
                                Instansi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="instansi">Nama Instansi/Perusahaan</label>
                                    <input name="instansi" type="text"
                                        class="form-control @error('instansi') is-invalid @enderror"
                                        value="{{Request::old('instansi')}}" id="instansi" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="bidang">Bidang/Sektor Usaha</label>
                                    <input name="bidang" type="text"
                                        class="form-control @error('bidang') is-invalid @enderror"
                                        value="{{Request::old('bidang')}}" id="bidang" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="alamat">Alamat</label>
                                    <input name="alamat" type="text"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        value="{{Request::old('alamat')}}" id="alamat" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="tlp">No. Telephon/Handphone</label>
                                    <input name="tlp" type="text"
                                        class="form-control @error('tlp') is-invalid @enderror"
                                        value="{{Request::old('tlp')}}" id="tlp" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="start">Tanggal Mulai</label>
                                    <input name="start" type="date"
                                        class="form-control @error('start') is-invalid @enderror"
                                        value="{{Request::old('start')}}" id="start" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="end">Tanggal Berakhir</label>
                                    <input name="end" type="date"
                                        class="form-control @error('end') is-invalid @enderror"
                                        value="{{Request::old('end')}}" id="end" required>
                                </div>
                                <div class="form-group col-12">
                                    <label for="kak">Kerangka Acuan Kerja*</label>
                                    <input type="file" class="form-control-file" name="kak" id="kak">
                                    <p><b>Catatan:</b> *disertai tanda tangan dan stampel dari Pembimbing
                                        Lapangan/Instansi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <input href="#reg" type="button" value="Daftarkan Kelompok" class="btn btn-primary float-right"
                        data-toggle="modal">
                </div>
            </div>
            <!-- Deskripsi Jobdesk -->
            <div class="modal fade" id="job_desk" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-info-circle mr-1"></i>
                                Deskripsi Jobdesc
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table" id="detail_verifikasi">
                                <thead>
                                    <tr>
                                        <th>Jobdesc</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job as $jobs)
                                    <tr>
                                        <td>{{$jobs->jobname}}</td>
                                        <td>{{$jobs->description}}</td>
                                        @if ($jobs->status === "wajib")
                                        <td><span class="badge badge-primary p-2">Wajib</span></td>
                                        @else
                                        <td><span class="badge badge-secondary p-2">Tidak Wajib</span></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pendaftaran-->
            <div class="modal fade" id="reg" aria-hidden="true">
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
                        <div class="modal-body">
                            <p>Yakin ingin mengirimkan pendaftaran?<br><b>Data yang diajukan tidak dapat diubah
                                    lagi</b><br>
                                <b class="text-danger font-italic">*Pastikan seluruh anggota kelompok telah memperbarui
                                    foto profil.</b>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary float-right">Yakin</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        <!-- Project -->
        <h5 class="py-2">Proyek Kelompok</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-friends mr-1"></i>
                            Kelompok
                        </h3>
                        @if(Auth::user()->isVerifiedGroupProject() < 4)
                        <div class="card-tools">
                            <a href="groupEdit/{{ $anggota->id }}" type="button" class="btn btn-primary btn-sm">Edit</a>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->isVerifiedGroupProject() >= 1)
                        <div class="text-center">
                            <i class="fas fa-user-graduate fa-7x mb-2"></i>
                            <h2 class="lead"><b>{{$anggota->GroupProjectSupervisor->Lecturer->name}}</b></h2>
                            <b>NIP. {{$anggota->GroupProjectSupervisor->Lecturer->NIP}}</b>
                            <p class="text-muted text-sm"> Pembimbing</p>
                        </div>
                        @else
                        @endif
                        <ul class="list-group list-group-unbordered mb-2">
                            @foreach($anggota->InternshipStudents as $team)
                            <li class="list-group-item">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm"
                                        src="../public/image/{{ $team->User->image_profile }}" alt="user image">
                                    <span class="username">
                                        <a>{{$team->name}}</a>
                                    </span>
                                    @foreach($team->Jobdescs as $jobdesc)
                                    <a class="description">{{$jobdesc->jobname}}</a>
                                    @endforeach
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Detail Proyek
                        </h3>
                        <div class="card-tools" id="tools">
                            @if(Auth::user()->isVerifiedGroupProject() !== null)
                            <button type="button" class="btn btn-primary btn-sm project-edit" data-toggle="modal">Edit
                                Detail Proyek</button>
                            @endif
                            @if((Auth::user()->isVerifiedGroupProject() >= 4) &&
                            ($anggota->laporan === null))
                            @if ($anggota->revisi !== null)
                            <a href="../berkas/revisi/{{ $anggota->revisi }}" target="blank"
                                class="btn btn-info btn-sm report"><i class="fas fa-download"></i> Catatan Revisi</a>
                            @endif
                            <button type="button" id="laporan" class="btn btn-success btn-sm">
                                <i class="fas fa-upload mr-1"></i>
                                Upload Laporan
                            </button>
                            @elseif((Auth::user()->isVerifiedGroupProject() >= 4) &&
                            ($anggota->laporan !== null))
                            @if ($anggota->revisi !== null)
                            <a href="../berkas/revisi/{{ $anggota->revisi }}" target="blank"
                                class="btn btn-info btn-sm report"><i class="fas fa-download"></i> Catatan Revisi</a>
                            @endif
                            <button type="button" id="laporan" class="btn btn-success btn-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit Laporan
                            </button>
                            @endif
                            @if((Auth::user()->isVerifiedGroupProject() === 1) &&
                            (Auth::user()->isProgressGroupProject() === '100'))
                            <button type="button" class="btn btn-success btn-sm daftarSem" data-toggle="modal">Daftar
                                Seminar</button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Tanggal Mulai</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ Carbon\Carbon::parse($anggota->start_intern)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center text-muted">Tanggal Berakhir</span>
                                        <span class="info-box-number text-center text-muted mb-0">{{ Carbon\Carbon::parse($anggota->end_intern)->isoFormat('D MMMM Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->isVerifiedGroupProject() === 0)
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-warning">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Waiting</span>
                                        <span class="info-box-number text-center mb-0">Konfirmasi Pendaftaran</span>
                                    </div>
                                </div>
                            </div>
                            @elseif(Auth::user()->isVerifiedGroupProject() === 1)
                            <div class="col-12 col-sm-4">
                                @if(Auth::user()->isProgressGroupProject() === '100')
                                <div class="info-box bg-success">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Progress Anda Telah 100%</span>
                                        <span class="info-box-number text-center mb-0">Silahkan Ajukan Seminar</span>
                                    </div>
                                </div>
                                @else
                                <div class="info-box bg-primary">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Progress</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{$anggota->progress}}%"></div>
                                        </div>
                                        <span class="info-box-number text-center mb-0">{{$anggota->progress}}%<span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @elseif(Auth::user()->isVerifiedGroupProject() === 2)
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-warning">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Waiting</span>
                                        <span class="info-box-number text-center mb-0">Konfirmasi Seminar</span>
                                    </div>
                                </div>
                            </div>
                            @elseif(Auth::user()->isVerifiedGroupProject() === 3)
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-success">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Seminar</span>
                                        <span
                                            class="info-box-number text-center mb-0">{{ $anggota->GroupProjectSchedule->day }},
                                            {{ $anggota->GroupProjectSchedule->tanggal }}</span>
                                    </div>
                                </div>
                            </div>
                            @else
                            @if($anggota->laporan === null)
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-warning">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Tahap Akhir</span>
                                        <span class="info-box-number text-center mb-0">Silahkan Upload Draft Laporan
                                            Anda</span>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-12 col-sm-4">
                                <div class="info-box bg-success">
                                    <div class="info-box-content">
                                        <span class="info-box-text text-center">Finish</span>
                                        <span class="info-box-number text-center mb-0">Selesai</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>
                        <h3 class="text-primary"><i class="fas fa-edit"></i> Judul</h3>
                        @if($anggota->title === null)
                        <span class=" badge badge-danger">Harus diisi sebelum mendaftar seminar!</span>
                        @else
                        <h5 class="text-muted font-weight-bold">{{$anggota->title}}</h5>
                        @endif
                        <br><br>
                        <div class="row">
                            <div class="col-5">
                                <h5 class="text-muted">Instansi</h5>
                                <hr>
                                <div class="text-muted">
                                    <p class="text-sm">Nama Instansi
                                        <b class="d-block">{{$anggota->Agency->agency_name}}</b>
                                    </p>
                                    <p class="text-sm">Pembimbing Lapangan
                                        @if($anggota->field_supervisor === null)
                                        <span class=" badge badge-danger">Harus diisi sebelum mendaftar seminar!</span>
                                        @else
                                        <b class="d-block">{{$anggota->field_supervisor}}</b>
                                        @endif
                                    </p>
                                    <p class="text-sm">Bidang
                                        <b class="d-block">{{$anggota->Agency->sector}}</b>
                                    </p>
                                    <p class="text-sm">Alamat
                                        <b class="d-block">{{$anggota->Agency->address}}</b>
                                    </p>
                                    <p class="text-sm">No. Hp/Telpon
                                        <b class="d-block">{{$anggota->Agency->phone_number}}</b>
                                    </p>
                                </div>
                            </div>
                            @if(Auth::user()->isVerifiedGroupProject() >= 3)
                            <div class="col-7">
                                <h5 class="text-muted">Seminar</h5>
                                <hr>
                                <div class="text-muted">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-sm">Tempat
                                                <b class="d-block">{{$anggota->GroupProjectSchedule->place}}</b>
                                            </p>
                                            <p class="text-sm">Tanggal & Waktu
                                                <b class="d-block">{{ $anggota->GroupProjectSchedule->day }}, {{ $anggota->GroupProjectSchedule->tanggal }}</b>
                                                {{ Carbon\Carbon::parse($anggota->GroupProjectSchedule->time)->isoFormat('H:mm') }}
                                                -
                                                {{ Carbon\Carbon::parse($anggota->GroupProjectSchedule->time_end)->isoFormat('H:mm') }}
                                                WITA
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            @foreach($fck as $fck)
                                            <p class="text-sm">{{$fck->role}}
                                                <b class="d-block">{{$fck->Lecturer->name}}</b>
                                                NIP. {{$fck->Lecturer->NIP}}
                                            </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Laporan Modal -->
        <div class="modal fade " id="modalLaporan" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-upload mr-1"></i>
                            Upload Draft Laporan .pdf
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <p>*Laporan diupload dengan file ekstensi <b>pdf</b> dan ukuran <b>max 2mb</b></p>
                        <form method="POST" enctype="multipart/form-data" id="uploadLaporan">
                            @csrf
                            <input type="hidden" id="group_id" value="{{$anggota->id}}">
                            <input type="hidden" id="_method" value="PUT" name="_method">
                            <input type="file" name="laporan" class="form-control">
                            <br>
                            <button type="submit" class="btn btn-primary float-right">Kirim</button>
                        </form>
                        <br>
                        <hr>
                        @if($anggota->laporan !== null)
                        <table class="table" id="lapor">
                            <thead>
                                <tr>
                                    <th>Berkas Laporan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Laporan PKL dan PK</td>
                                    <td><a href="../berkas/laporan/{{$anggota->laporan}}" target="blank"
                                            class="btn btn-sm btn-primary float-right"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Project Edit Modal-->
        <div class="modal fade" id="project-edit" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <i class="fas fa-edit mr-1"></i>
                            Edit Detail Proyek
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formEdit" method="POST">
                            @csrf
                            <div class="form-group col-12">
                                <label for="judul">Judul</label>
                                <textarea rows="3" name="editJudul" id="editJudul" class="form-control" required>{{$anggota->title}}</textarea>
                            </div>
                            <div class="form-group col-12">
                                <hr>
                                <h4>
                                    Instansi
                                </h4>
                            </div>
                            <div class="form-group col-12">
                                <label for="Instansi">Nama Instansi</label>
                                <input type="text" name="editInstansi" id="editInstansi" class="form-control"
                                    value="{{$anggota->Agency->agency_name}}" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="pemLapangan">Pembimbing Lapangan</label>
                                <input type="text" name="editPemLapangan" id="editPemLapangan" class="form-control"
                                    value="{{$anggota->field_supervisor}}" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="Bidang">Bidang Usaha Instansi</label>
                                <input type="text" name="editBidang" id="editInstansi" class="form-control"
                                    value="{{$anggota->Agency->sector}}" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="alamat">Alamat Instansi</label>
                                <input type="text" name="editAlamat" id="editAlamat" class="form-control"
                                    value="{{$anggota->Agency->address}}" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="kontak">Kontak Instansi</label>
                                <input type="text" name="editKontak" id="editKontak" class="form-control"
                                    value="{{$anggota->Agency->phone_number}}" required>
                            </div>
                            <input type="hidden" id="project_id" value="{{$anggota->id}}">
                            <input type="hidden" id="_method" value="PUT" name="_method">
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pengajuan Modal -->
        <div class="modal fade" id="submit" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="daftarSeminar/{{$anggota->id}}/edit" id="daftarSeminar" name="daftarSeminar" method="POST" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-paper-plane mr-1"></i>
                                Pengajuan Seminar
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>*Semua file diupload dengan file ekstensi <b>pdf</b> dan ukuran <b>max 1mb</b></p>
                            <hr>
                            <h6>
                                Kelompok
                            </h6>
                            <input type="hidden" name="is_verified" id="is_verified" value="">
                            <input type="hidden" id="project_id">
                            <input type="hidden" id="_method" value="PUT" name="_method">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="setuju">Lembar Persetujuan Seminar PKL dan PK</label>
                                    <input type="file" class="form-control-file" name="setuju" id="setuju" required>
                                </div>
                            </div>
                            <hr>
                            <h6>
                                Anggota
                            </h6>
                            @foreach($anggota->InternshipStudents as $key => $anggota)
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="nim">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim"
                                        value="{{$anggota->nim}}" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" value="{{$anggota->name}}"
                                        readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="nilaiPKL">Lembar Penilaian PKL</label>
                                    @if ($key === 0) @endif
                                    <input type="file" class="form-control-file" name="nilaiPKL_{{$key+1}}"
                                        id="nilaiPKL_{{$key+1}}" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="sertifikatLkmm">Sertifikat LKMM</label>
                                    @if ($key === 0) @endif
                                    <input type="file" class="form-control-file" name="sertifikatLkmm_{{$key+1}}"
                                        id="sertifikatLkmm_{{$key+1}}" required>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary float-right float-right">Ajukan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if(Auth::user()->image_profile === "default.jpg")
        <div class="modal fade show" id="modalProfil" aria-modal="true" style="display: block;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Pengaturan Profil</h4>
                    </div>
                    <div class="modal-body">
                        <p><b>Harap lengkapi profil terlebih dahulu</b><br>Disarankan mengganti password</p>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url ('../profil') }}" type="button" class="btn btn-primary">Profil Saya</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
        @endif
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
    </div>
</section>
@endsection

@section('ajax')
<script>
    function fetchData(i) {

        const nim = $("#nim-" + i).val();

        $.ajax({
                url: "{{ route('mahasiswa.index') }}",
                data: {
                    nim: nim,
                    status: 'A'
                }
            })
            .done(function (data) {
                $('#nama-' + i).val(data.name);
                $('#ipk-' + i).val(data.ipk);
                $('#sks-' + i).val(data.sks_total);

                $('#nim-' + i).removeClass("is-invalid");
                $('#ipk-' + i).removeClass("is-invalid");
                $('#sks-' + i).removeClass("is-invalid");

                if (data.name === undefined) {
                    $('#nim-' + i).addClass("is-invalid");
                    $('#ipk-' + i).removeClass("is-invalid");
                    $('#sks-' + i).removeClass("is-invalid");
                } else if (data.ipk < 2.5 && data.sks_total < 90) {
                    $('#nim-' + i).removeClass("is-invalid");
                    $('#ipk-' + i).addClass("is-invalid");
                    $('#sks-' + i).addClass("is-invalid");
                } else if (data.ipk < 2.5) {
                    $('#nim-' + i).removeClass("is-invalid");
                    $('#ipk-' + i).addClass("is-invalid");
                    $('#sks-' + i).removeClass("is-invalid");
                } else if (data.sks_total < 90) {
                    $('#nim-' + i).removeClass("is-invalid");
                    $('#ipk-' + i).removeClass("is-invalid");
                    $('#sks-' + i).addClass("is-invalid");
                } else {

                }

            }).fail(function () {
                alert("Error");
            });
    }

    $(".nav-tabs").on("click", "a", function (e) {
            e.preventDefault();
            if (!$(this).hasClass('add-mahasiswa')) {
                $(this).tab('show');
            }
        })
        .on("click", "span", function () {
            var anchor = $(this).siblings('a');
            $(anchor.attr('href')).remove();
            $(this).parent().remove();
            $(".nav-tabs li").children('a').first().click();
            $('.add-mahasiswa').removeClass('disabled');
        });

    $('.add-mahasiswa').click(function (e) {
        e.preventDefault();

        const addMahasiswa = `
                                <!-- Mahasiswa 2 -->
                                <div class="tab-pane fade show" id="m-4" role="tabpanel" aria-labelledby="m-4-tab">
                                    <div class="row mt-2">
                                        @error('nama-4')
                                        <div class="form-group col-12">
                                            <div class="alert alert-danger alert-dismissible w-100"><i class="icon fas fa-exclamation-circle"></i> {{ $message }}</div>
                                        </div>
                                        @enderror
                                        <div class="form-group col-12">
                                            <label for="nim">NIM</label>
                                            <div class="row">
                                                <div class="col-9">
                                            <input name="nim[]" type="text" class="form-control @error('nama-4') is-invalid @enderror" value="{{Request::old('nim.4')}}" id="nim-4">
                                            @error('nim-4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                                </div>
                                                <div class="col-3">
                                            <button type="button" class="btn btn-primary w-100" id="cek-student-4" onclick="fetchData(4)">Cek</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama-4" readonly value="{{Request::old('nama-4')}}" name="nama-4">
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="ipk">IPK</label>
                                            <input type="number" class="form-control @error('ipk-4') is-invalid @enderror" id="ipk-4" readonly value="{{Request::old('ipk-4')}}" min="2.5" name="ipk-4">
                                            @error('ipk-4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-3">
                                            <label for="sks">SKS</label>
                                            <input type="number" class="form-control @error('sks-4') is-invalid @enderror" id="sks-4" readonly value="{{Request::old('sks-4')}}" min="90" name="sks-4">
                                            @error('sks-4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="jobDesc">Job Description</label>
                                            <div class="row">
                                                <div class="col-3">
                                                <button type="button" class="btn btn-sm btn-secondary jobdesk w-100" id="jobdesk" data-toggle="modal" data-target="#job_desk"><i class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="col-9">
                                                <select name="jobdesc_4[]" class="select2 @error('jobdesc_4') is-invalid @enderror" multiple="multiple" style="width: 100%;" id="jobDesc-4">
                                                @foreach($job as $jobdesc)
                                                <option value="{{$jobdesc->id}}">{{$jobdesc->jobname}}</option>
                                                @endforeach
                                            </select>
                                            @error('jobdesc_4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Hasil Studi</label>
                                            <input name="khs_4" type="file" class="form-control-file" id="khs-4">
                                            @error('khs_4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Transkrip</label>
                                            <input name="transkrip_4" type="file" class="form-control-file" id="transkrip-4">
                                            @error('transkrip_4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="lampiran">Kartu Rencana Studi</label>
                                            <input name="krs_4" type="file" class="form-control-file" id="krs-4">
                                            @error('krs_4')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <hr>
                                </div>
        `;

        $(this).closest('li').before(
            '<li class="nav-link"><a class="d-inline-block" href="#m-4">M-4</a><span> x </span></li>');
        $('.add-mahasiswa').addClass('disabled');
        $('.tab-content').append(
            '<div class="tab-pane fade" id="m-4" role="tabpanel" aria-labelledby="m-1-tab">' +
            addMahasiswa + '</div>');
        $('.nav-tabs li:nth-child(4) a').click();

        $('.select2').select2();
    });
    $('#tools').on('click', '.project-edit', function () {
        let id = $(this).attr('id');
        $('#project-edit').modal('show');
    });

    $('#formEdit').submit(function (e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#project_id').val();
        $.ajax({
            url: "project/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formEdit')[0].reset();
                    $('#project-edit').modal('hide');
                    location.reload();
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
    });
    $('#uploadLaporan').submit(function (e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#group_id').val();
        $.ajax({
            url: "project/" + id + "/upload",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#uploadLaporan')[0].reset();
                    $('#modalLaporan').modal('hide');
                    location.reload();
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
    });

    $('#tools').on('click', '.daftarSem', function () {
        let id = $(this).attr('id');
        $('#submit').modal('show');
        $.ajax({
            url: "getVerif/" + id,
            success: function (result) {
                $('#is_verified').val(result.data.is_verified)
                $('#project_id').val(result.data.id)
            }
        })

    });

    $("#laporan").click(function(e) {
        e.preventDefault();
        $("#modalLaporan").modal();
    });

</script>

@endsection
