@extends('layout.master')

@section('title', 'Admin | Data Mahasiswa')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Data Mahasiswa</h5>
            </div>
            @if(Auth::user()->isAdmin())
            <div class="col-6">
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" href="" data-toggle="modal"
                        data-target="#modalTambah">
                        <i class="fas fa-user-plus mr-1"></i>
                        Tambah Mahasiswa
                    </button>
                    <button type="button" id="import" class="btn btn-success btn-sm">
                        <i class="fas fa-upload mr-1"></i>
                        Import Data
                    </button>
                    <a href="exportMhs" class="btn btn-secondary btn-sm">
                        <i class="fas fa-download mr-1"></i>
                        Export Data
                    </a>
                </div>
            </div>
            @endif
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Mahasiswa
                </h5>
            </div>
            <div class="card-body">
                <table id="mahasiswa" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Profil</th>
                            <th>Nama</th>
                            <th>Angkatan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Tambah Modal -->
<div class="modal fade" id="modalTambah" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formSave" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus mr-1"></i>
                        Tambah Mahasiswa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim">
                        </div>
                        <div class="form-group col-12">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group col-12">
                            <label>Angkatan</label>
                            <input type="number" class="form-control" id="angkatan" name="angkatan">
                        </div>
                        <div class="form-group col-6">
                            <label>Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" id="male" type="radio" name="gender" value="L">
                                <label class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="female" type="radio" name="gender" value="P">
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status" name="status" value="A">
                                <label for="Status" class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status" name="status" value="S">
                                <label for="Status" class="form-check-label">Aktif PKL-PK</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status" name="status" value="L">
                                <label for="Status" class="form-check-label">Lulus PKL-PK</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status" name="status" value="">
                                <label for="Status" class="form-check-label">Tidak Aktif</label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>IP Semester</label>
                            <input type="number" class="form-control" id="ipSemester" name="ipSemester"
                                placeholder="0.00">
                        </div>
                        <div class="form-group col-6">
                            <label>SKS Semester</label>
                            <input type="number" class="form-control" id="sksSemester" name="sksSemester">
                        </div>
                        <div class="form-group col-6">
                            <label>IPK</label>
                            <input type="number" class="form-control" id="ipk" name="ipk" placeholder="0.00">
                        </div>
                        <div class="form-group col-6">
                            <label>SKS Total</label>
                            <input type="number" class="form-control" id="sksTotal" name="sksTotal">
                        </div>
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
<div class="modal fade" id="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-1"></i>
                        Edit
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-12">
                            <label>NIM</label>
                            <input type="text" class="form-control" id='editnim' name="editnim" readonly>
                        </div>
                        <div class="form-group col-12">
                            <label>Nama</label>
                            <input type="text" class="form-control" id='editname' name="editname" value="">
                        </div>
                        <div class="form-group col-12">
                            <label>Angkatan</label>
                            <input type="number" class="form-control" id='editangkatan' name="editangkatan" value="">
                        </div>
                        <div class="form-group col-6">
                            <label>Jenis Kelamin</label>
                            <div class="form-check">
                                <input class="form-check-input" id="male-gender" type="radio" name="editgender"
                                    value="L">
                                <label class="form-check-label">Laki-laki</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="female-gender" type="radio" name="editgender"
                                    value="P">
                                <label class="form-check-label">Perempuan</label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="statusAktif" name="editstatus"
                                    value="A">
                                <label for="editStatus" class="form-check-label">Aktif</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="statusPK" name="editstatus"
                                    value="S">
                                <label for="editStatus" class="form-check-label">Aktif PKL-PK</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="statusLulus" name="editstatus"
                                    value="L">
                                <label for="editStatus" class="form-check-label">Lulus PKL-PK</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="statusNon" name="editstatus"
                                    value="">
                                <label for="editStatus" class="form-check-label">Tidak Aktif</label>
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label>IP Semester</label>
                            <input type="text" class="form-control" id="editipSemester" name="editipSemester">
                        </div>
                        <div class="form-group col-6">
                            <label>SKS Semester</label>
                            <input type="text" class="form-control" id="editsksSemester" name="editsksSemester">
                        </div>
                        <div class="form-group col-6">
                            <label>IPK</label>
                            <input type="text" class="form-control" id="editipk" name="editipk">
                        </div>
                        <div class="form-group col-6">
                            <label>SKS Total</label>
                            <input type="text" class="form-control" id="editsksTotal" name="editsksTotal">
                        </div>
                        <input type="hidden" id="college_id">
                        <input type="hidden" id="_method" value="PUT" name="_method">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade " id="modalImport" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload mr-1"></i>
                    Upload Data Mahasiswa
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="mahasiswa/import" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group col-12">
                        <label>Upload File Excel</label>
                        <input type="file" name="select_file" id="file" class="form-control">
                    </div>
                    <p><b>*harap perhatikan kembali data sebelum diimport, terkhusus pada data NIM. Karena kesalahan import data akan sangat fatal bagi sistem.<b></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Import Data</button>
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
    $("#mahasiswa").DataTable({
        "processing": true,
        "ajax": {
            url: "{{ route('list-mhs') }}"
        },
        "columns": [{
                data: "nim"
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    return '<img src="../public/image/' + full.user.image_profile +
                        '" data-toggle="tooltip" data-placement="bottom" class="img-circle table-avatar" width="40px">'
                }
            },
            {
                data: "name"
            },
            {
                data: "angkatan"
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    if (full.status == "A") {
                        return '<span class="badge badge-success p-2">Aktif</span>';
                    } else if (full.status == "S") {
                        return '<span class="badge badge-primary p-2">Aktif PKL-PK</span>';
                    } else if (full.status == "L") {
                        return '<span class="badge badge-info p-2">Lulus PKL-PK</span>';
                    } else {
                        return '<span class="badge badge-danger p-2">Tidak Aktif</span>';
                    }
                }
            },
            {
                sortable: false,
                "render": function (data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId + '" class="btn btn-warning update">Edit</button>';
                }
            }
        ]
    });

    $('#mahasiswa tbody').on('click', '.update', function () {
        let id = $(this).attr('id');

        $("small").remove(".text-danger");
        $("input").removeClass("is-invalid");
        $.ajax({
            url: "mahasiswa/" + id,
            dataType: "json",
            success: function (result) {
                $('#edit').modal('show');

                $('#editnim').val(result.data.nim);
                $('#editname').val(result.data.name);
                $('#editangkatan').val(result.data.angkatan);
                $('#college_id').val(result.data.id);
                $('#editipSemester').val(result.data.ip_sem);
                $('#editsksSemester').val(result.data.sks_sem);
                $('#editipk').val(result.data.ipk);
                $('#editsksTotal').val(result.data.sks_total);
                const gender = result.data.gender;
                const status = result.data.status;

                if (gender === "L") {
                    $('#male-gender').prop('checked', true);

                } else if (gender === "P") {
                    $('#female-gender').prop('checked', true);
                }

                if (status === "A") {
                    $('#statusAktif').prop('checked', true);
                } 
                else if (status === "S") {
                    $('#statusPK').prop('checked', true);
                } 
                else if (status === "L") {
                    $('#statusLulus').prop('checked', true);
                } 
                else {
                    $('#statusNon').prop('checked', true);
                }
            }
        })
    });

    function loadDataTable() {
        $.ajax({
            url: "{{ url('admin/getDataTableMhs') }}",
            success: function (data) {
                $('#dataTable').html(data);
            }
        })
    }
    loadDataTable();
    $('#formSave').submit(function (e) {
        e.preventDefault();

        var request = new FormData(this);

        $.ajax({
            url: "{{ url('admin/simpanDataMhs') }}",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formSave')[0].reset();
                    $('#modalTambah').modal('hide');
                    $('#mahasiswa').DataTable().ajax.reload();

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

    $('#formEdit').submit(function (e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#college_id').val();
        $.ajax({
            url: "mahasiswa/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formEdit')[0].reset();
                    $('#edit').modal('hide');
                    $('#mahasiswa').DataTable().ajax.reload();

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
    $("#import").click(function (e) {
        e.preventDefault();
        $("#modalImport").modal();
    });

</script>
@endsection
