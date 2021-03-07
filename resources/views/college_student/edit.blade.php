@extends('layout.master')

@section('title', 'Mahasiswa | Edit Kelompok')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Edit Kelompok PKL-PK</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <a href="{{ route('mahasiswa.home') }}" type="button" class="btn btn-default btn-sm">
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
                @if ($mhs < 4 && $pk->is_verified < 2)
                <div class="card-tools" id="tools">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modalTambah" type="button"
                        class="btn btn-primary btn-sm"><i class="fas fa-user-plus mr-1"></i> Tambah Anggota</a>
                </div>
                @endif
            </div>

            <!-- Modal Tambah Anggota -->
            <div class="modal fade" id="modalTambah" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title"><i class="fas fa-user-plus mr-1"></i>
                                Tambah Anggota
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form action="tambahAnggota" enctype="multipart/form-data" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="row mt-2">
                                    @error('nama')
                                    <div class="form-group col-12">
                                        <div class="alert alert-danger alert-dismissible w-100"><i
                                                class="icon fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    </div>
                                    @enderror
                                    <input name="groupId" type="hidden" value="{{ $pk->id }}" class="form-control"
                                        id="group" required>
                                    <div class="form-group col-12">
                                        <label for="nim">NIM</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <input name="internship_student_id" type="hidden" value=""
                                                    class="form-control" id="">
                                                <input name="nim" type="text" value="" class="form-control" id="inputNim"
                                                    required>
                                                @error('nim')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-primary w-100" id="cek-student"
                                                    onclick="fetchData()">Cek</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control nama" id="nama" readonly value=""
                                            name="nama">
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="ipk">IPK</label>
                                        <input type="number" id="ipk" class="form-control ipk" readonly value="" min="2.5"
                                            name="ipk">
                                        @error('ipk')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-3">
                                        <label for="sks">SKS</label>
                                        <input type="number" id="sks" class="form-control sks" readonly min="90" name="sks">
                                        @error('sks')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="jobDesc">Job Description</label>
                                        <div class="row">
                                            <div class="col-2">
                                                <button type="button" class="btn btn-secondary jobdesk w-100" id="jobdesk"
                                                    data-toggle="modal" data-target="#job_desk"><i
                                                        class="fas fa-eye"></i></button>
                                            </div>
                                            <div class="col-10">
                                                <select name="jobdesc[]" class="select2" multiple="multiple"
                                                    style="width: 100%;" id="jobDesc" required>
                                                    @foreach($job as $jobdesc)
                                                    <option value="{{ $jobdesc->id }}">{{ $jobdesc->jobname }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Kartu Hasil Studi</label>
                                        <input name="khs" type="file" class="form-control-file" id="khs" value="" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Transkrip</label>
                                        <input name="transkrip" type="file" class="form-control-file" id="transkrip"
                                            value="" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Kartu Rencana Studi</label>
                                        <input name="krs" type="file" class="form-control-file" id="krs" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="tombol_hide" type="submit" class="btn btn-primary float-right">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Anggota -->
            <div class="modal fade" id="modalEdit" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title"><i class="fas fa-user-plus mr-1"></i>
                                Edit Anggota
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                                <form action="editAnggota/update" id="editAnggota" enctype="multipart/form-data" method="POST">
                                @csrf
                        <div class="modal-body">
                            <div class="row mt-2">
                                    @error('nama')
                                    <div class="form-group col-12">
                                        <div class="alert alert-danger alert-dismissible w-100"><i
                                                class="icon fas fa-exclamation-circle"></i> {{ $message }}</div>
                                    </div>
                                    @enderror
                                    <input name="groupIdEdit" type="hidden" value="{{ $pk->id }}" class="form-control"
                                        id="group" required>
                                    <div class="form-group col-6">
                                        <label for="nama">Nama</label>
                                        <input name="nama" type="text" value="" class="form-control" id="editNama" readonly>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="nim">NIM</label>
                                        <input type="text" class="form-control nim" id="editNim" readonly value="" name="editNim">
                                    </div>
                                    <div class="form-group col-12">
                                        <label for="jobDesc">Job Description</label>
                                        <div class="row">
                                            <div class="col-2">
                                                <button type="button" class="btn btn-secondary jobdesk w-100" id="jobdesk"
                                                    data-toggle="modal" data-target="#job_desk"><i class="fas fa-eye"></i></button>
                                            </div>
                                            <div class="col-10">
                                                <select name="editJobdesc[]" class="select2 editJob" multiple="multiple" style="width: 100%;"
                                                    id="editJobDesc" required>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                    <hr>
                                        <h6>
                                            Berkas Pendaftaran PKL-PK
                                        </h6>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Kartu Hasil Studi</label>
                                        <input name="editKhs" type="file" class="form-control-file" id="editKhs" value="">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Transkrip</label>
                                        <input name="editTranskrip" type="file" class="form-control-file" id="editTranskrip" value=""
                                        >
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Kartu Rencana Studi</label>
                                        <input name="editKrs" type="file" class="form-control-file" id="editKrs" value="">
                                    </div>
                                    @if ($pk->is_verified == 2)
                                    <div class="form-group col-12">
                                        <hr>
                                        <h6>
                                            Berkas Pendaftaran Seminar PKL-PK
                                        </h6>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Lembar Penilaian PKL</label>
                                        <input name="editNilaiPKL" type="file" class="form-control-file" id="editNilaiPKL" value="">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Sertifikat Kehadiran Seminar</label>
                                        <input name="editSertifikat" type="file" class="form-control-file" id="editSertifikat" value="">
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="lampiran">Sertifikat LKMM</label>
                                        <input name="editLkmm" type="file" class="form-control-file" id="editLkmm" value="">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="tombol_hide" type="submit" class="btn btn-warning float-right">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        
            <!-- Modal List Jobdesc -->
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

            <!-- Lanjut Card Body -->
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
                                @if($pk->is_verified < 3)
                                <button id="{{ $i->id }}" title="Edit Anggota" class="btn btn-warning mr-1 edit"><i
                                        class="fas fa-edit"></i></button>
                                @endif
                                @if($pk->is_verified < 2)
                                <?php $j = 0 ?>
                                @foreach ($i->Jobdescs as $job)
                                @if ($job->jobname == "Project Manager")
                                <?php $j = 1 ?>
                                @endif
                                @endforeach
                                @if ($j != 1)
                                <button onclick="openModalHapus(['{{ $pk->id }}', '{{ $i->id }}', '{{ $i->name }}'])"
                                    title="Hapus Anggota" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal Hapus Anggota -->
<div class="modal fade" id="hapus" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    Konfirmasi Hapus Anggota
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus <strong id="nama_hapus"></strong> dari kelompok?<br><br>
                    <form action="hapusAnggota" id="pengamat" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-9">
                                    <input name="internship_student_id" type="hidden" value="" class="form-control"
                                        id="mhs_hapus">
                                    <input type="hidden" name="groupProject" id="group_hapus" value="">
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


</section>
@endsection

@section('ajax')
<script>
    function openModalHapus([id, mhsId, name]) {
        $('#hapus').modal();
        $('#group_hapus').val(id);
        $('#mhs_hapus').val(mhsId);
        $('#nama_hapus').html(name)
    }

    function fetchData() {
        const nim = $("#inputNim").val();

        $.ajax({
                url: "{{ route('mahasiswa.index') }}",
                data: {
                    nim: nim,
                    status: 'A'
                }
            })
            .done(function (data) {
                $('#nama').val(data.name);
                $('#ipk').val(data.ipk);
                $('#sks').val(data.sks_total);

                $('#nim').removeClass("is-invalid");
                $('#ipk').removeClass("is-invalid");
                $('#sks').removeClass("is-invalid");

                if (data.name === undefined) {
                    $('#nim').addClass("is-invalid");
                    $('#ipk').removeClass("is-invalid");
                    $('#sks').removeClass("is-invalid");
                } else if (data.ipk < 2.5 && data.sks_total < 90) {
                    $('#nim').removeClass("is-invalid");
                    $('#ipk').addClass("is-invalid");
                    $('#sks').addClass("is-invalid");
                } else if (data.ipk < 2.5) {
                    $('#nim').removeClass("is-invalid");
                    $('#ipk').addClass("is-invalid");
                    $('#sks').removeClass("is-invalid");
                } else if (data.sks_total < 90) {
                    $('#nim').removeClass("is-invalid");
                    $('#ipk').removeClass("is-invalid");
                    $('#sks').addClass("is-invalid");
                } else {

                }

            }).fail(function () {
                alert("Error");
            });
    }

    $('#mahasiswa tbody').on('click', '.edit', function () {
        let id = $(this).attr('id')
        $('#modalEdit').modal('show');
        $.ajax({
            url: "../groupEdit/editAnggota/" + id,
            success: function (result) {
                $('#editNim').val(result.data.nim)
                $('#editNama').val(result.data.name)
                $('.editJob').html('')
                
                let jobGua = [];
                
                let jobs = [];
                let jobName = [];
                for(i=0; i<result.job.length; i++) {
                    jobs[i] = result.job[i].id
                    jobName[i] = result.job[i].jobname
                    $('.editJob').append('<option value="'+jobs[i]+'" class="editJobOpt">'+jobName[i]+'</option>')
                }

                for(i=0; i<result.data.jobdescs.length; i++) {
                    jobGua[i] = result.data.jobdescs[i].id
                }

                $('.editJob').val(jobGua)
            }
        })
    });

</script>
@endsection
