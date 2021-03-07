@extends('layout.master')

@section('title', 'Koordinator | Rekomendasi')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Rekomendasi</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" href="#modalTambah" data-toggle="modal">
                        <i class="fas fa-plus-square mr-1"></i>
                        Tambah Rekomendasi
                    </button>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fab fa-get-pocket mr-1"></i>
                    Daftar Rekomendasi
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="rekomendasi" class="table table-striped projects dataTable w-100">
                    <thead>
                        <tr>
                            <th width="30%">Deskripsi Proyek</th>
                            <th width="20%">Instansi</th>
                            <th width="25%">Dosen</th>
                            <th width="15%">Status</th>
                            <th width="5%">Mahasiswa</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rek as $r)
                        <tr>
                            <td>
                                {{ $r->description }}
                            </td>
                            <td>
                                {{ $r->agency }}
                            </td>
                            <td>
                                {{ $r->Lecturer->name }}
                            </td>
                            <td>
                                @if ($r->status == 0)
                                <span class="badge badge-danger p-2" style="font-size: 10px">Belum Ada Mahasiswa</span>
                                @elseif ($r->status == 1)
                                <span class="badge badge-info p-2" style="font-size: 10px">Ada Mahasiswa</span>
                                @endif
                            </td>
                            <td>
                                @if ($r->status == 1)
                                <button onclick="openModalLihat(['{{ $r->id }}', '{{ $r->InternshipStudent->name }}', '{{ $r->InternshipStudent->nim }}', '{{ $r->InternshipStudent->User->image_profile }}'])"
                                    class="btn btn-block btn-primary btn-sm">Lihat</button>
                                <button onclick="openModalBatal('{{ $r->id }}')"
                                    class="btn btn-block btn-warning btn-sm">Batalkan</button>
                                @endif
                            </td>
                            <td>
                                <button
                                    onclick="openModalEdit(['{{ $r->id }}', '{{ $r->description }}', '{{ $r->agency }}', '{{ $r->Lecturer->id }}'])"
                                    class="btn btn-block btn-secondary btn-sm">Edit</button>
                                <button onclick="openModalDelete('{{ $r->id }}')"
                                    class="btn btn-block btn-danger btn-sm">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<!-- Tambah Modal -->
<div class="modal fade" id="modalTambah" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus mr-1"></i>
                    Tambah Rekomendasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('koor/rekomendasi/store') }}" id="formSave" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Deskripsi Proyek</label>
                        <textarea rows="3" required name="deskripsi" id="deskripsi" class="form-control"
                            value=""></textarea>
                    </div>
                    <div class="form-group">
                        <label>Instansi</label>
                        <input type="text" required class="form-control" id="instansi" name="instansi">
                    </div>
                    <div class="form-group">
                        <label>Dosen Pembimbing</label>
                        <select name="supervisor" id="Supervisor" required class="form-control" style="width: 100%;">
                            <option value="">Pilih Dosen</option>
                            @foreach($lecture as $lecturer)
                            <option class="Lecturer" value="{{$lecturer->id}}"> {{$lecturer->name}}</option>
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

<!-- Lihat Modal -->
<div class="modal fade" id="modalLihat" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle mr-1"></i>
                    Mahasiswa Pengambil Rekomendasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="text-center bodi">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <strong>Jika sudah terjadi perbincangan antara dosen dan mahasiswa, maka rekomendasi dapat dihapus.<br><br>
                Jika mahasiswa tidak kunjung menemui dosen bersangkutan, maka status dapat diubah kembali ke "Belum ada mahasiswa" dengan tombol "<i class="fas fa-stop-circle"></i>"</strong>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="modalEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Rekomendasi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('koor/rekomendasi/update') }}" id="formSave" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="rekId" id="rekId"></input>
                        <label>Deskripsi Proyek</label>
                        <textarea rows="3" required name="deskripsi" id="editDeskripsi" class="form-control"
                            value=""></textarea>
                    </div>
                    <div class="form-group">
                        <label>Instansi</label>
                        <input type="text" required class="form-control" id="editInstansi" name="instansi">
                    </div>
                    <div class="form-group">
                        <label>Dosen Pembimbing</label>
                        <select name="supervisor" id="editSupervisor" class="form-control" style="width: 100%;">
                            @foreach($lecture as $lecturer)
                            <option class="editLecturer" value="{{$lecturer->id}}"> {{$lecturer->name}}</option>
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

<!-- Batal Modal-->
<div class="modal fade" id="modalBatal" aria-hidden="true">
    <form action="{{ url('koor/rekomendasi/batal') }}" id="hapusRek" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-trash mr-1"></i>
                        Batalkan Rekomendasi dengan Mahasiswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="rekIdBatal" id="rek_idBatal" value="">
                    <p>Yakin ingin membatalkan rekomendasi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning float-right">Yakin</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Delete Modal-->
<div class="modal fade" id="modalDelete" aria-hidden="true">
    <form action="{{ url('koor/rekomendasi/hapus') }}" id="hapusRek" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">
                        <i class="fas fa-trash mr-1"></i>
                        Konfirmasi Hapus
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="rekId" id="rek_id" value="">
                    <p>Yakin ingin menghapus rekomendasi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger float-right">Hapus</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('ajax')
<script>
    $("#rekomendasi").DataTable({
        "processing": true,
    });

    function openModalEdit([id, desc, agency, lectureId]) {
        $('#modalEdit').modal('show');
        $('#rekId').val(id);
        $('#editDeskripsi').val(desc);
        $('#editInstansi').val(agency);
        $('#editSupervisor').val(lectureId)
    }

    function openModalDelete(id) {
        $('#modalDelete').modal();
        $('#rek_id').val(id);
    }
    
    function openModalBatal(id) {
        $('#modalBatal').modal();
        $('#rek_idBatal').val(id);
    }

    function openModalLihat([id, mhs, nim, poto]) {
        $('#modalLihat').modal();
        $('.bodi').html('');
        let modal = ''
        
        modal = '<img id="poto" src="../public/image/'+poto+'" width="150px" height="150px"' +
                'class="img-circle mb-2">'+
                '<h2 id="name" class="lead"><b>'+mhs+'</b></h2>'+
                '<h4 id="nim" class="lead">'+nim+'</h4>'

        $('.bodi').append(modal);
    }

</script>
@endsection
