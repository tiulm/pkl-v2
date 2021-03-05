@extends('layout.master')

@section('title', 'Admin | Data Dosen')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Data Dosen</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" href="#modalTambah" data-toggle="modal">
                        <i class="fas fa-user-plus mr-1"></i>
                        Tambah Dosen
                    </button>
                    <button type="button" id="import" class="btn btn-success btn-sm">
                        <i class="fas fa-upload mr-1"></i>
                        Import Data
                    </button>
                    <a href="exportDosen" class="btn btn-secondary btn-sm">
                        <i class="fas fa-download mr-1"></i>
                        Export Data
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Dosen
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="dosen" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Bimbingan</th>
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
            <form id="formSave" action="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus mr-1"></i>
                        Tambah Dosen
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" id="NIP" name="NIP">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="status" name="status">
                            <label class="form-check-label" for="status">
                                Aktif
                            </label>
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
            <form id="formEdit" method="post">
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
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" class="form-control" id="editNIP" name="editNIP" value="">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="editname" name="editname" value="">
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="editStatus" name="editStatus">
                            <label class="form-check-label" for="editStatus">
                                Aktif
                            </label>
                        </div>
                    </div>
                    <input type="hidden" id="dosen_id">
                    <input type="hidden" id="_method" value="PUT" name="_method">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Delete Modal-->
<div class="modal fade" id="delete" aria-hidden="true">
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
                <p>Anda yakin ingin menghapus Data #Dosen?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light float-right">Yakin</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade " id="modalImport" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload mr-1"></i>
                    Upload Data Dosen
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="{{ route('lecturer-import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <input type="file" name="file" class="form-control"><br>
                <p><b>*harap perhatikan kembali data sebelum diimport, terkhusus pada data NIP Dosen. Karena kesalahan import data akan sangat fatal bagi sistem.<b></p>
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
                <p>Gagal menyimpan data</p>
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
    $("#dosen").DataTable({
        "processing": true,
        "ajax": {
            url: "{{ url('admin/getDataTableDosen') }}"
        },
        "columns": [{
                data: "NIP"
            },
            {
                data: "name"
            },
            {
                data: "quota"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    if (full.status == "1") {
                        return '<span class="badge badge-success p-2">Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger p-2">Tidak Aktif</span>';
                    }
                }
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId + '" class="btn btn-warning update">Edit</button>';
                }
            }
        ]
    });
    $('#dosen tbody').on('click', '.update', function() {
        let id = $(this).attr('id');

        $("small").remove(".text-danger");
        $("input").removeClass("is-invalid");
        $.ajax({
            url: "dosen/" + id,
            dataType: "json",
            success: function(result) {
                console.log(result);
                $('#edit').modal('show');

                $('#editNIP').val(result.data.NIP);
                $('#editNIDN').val(result.data.NIDN);
                $('#editname').val(result.data.name);
                $('#dosen_id').val(result.data.id);

                status = result.data.status;

                if (status === "1") {
                    $('#editStatus').prop('checked', true);
                } else {
                    $('#editStatus').prop('checked', false);
                }
            }
        })
    });

    function loadDataTable() {
        $.ajax({
            url: "{{ url('admin/getDataTableDosen') }}",
            success: function(data) {
                $('#dataTable').html(data);
            }
        })
    }
    loadDataTable();
    $('#formSave').submit(function(e) {
        e.preventDefault();

        var request = new FormData(this);
        $.ajax({
            url: "{{ url('admin/simpanDataDosen') }}",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formSave')[0].reset();
                    $('#modalTambah').modal('hide');
                    $('#dosen').DataTable().ajax.reload();
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

    $('#formEdit').submit(function(e) {
        e.preventDefault();

        var request = new FormData(this);

        const id = $('#dosen_id').val();
        $.ajax({
            url: "dosen/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formEdit')[0].reset();
                    $('#edit').modal('hide');
                    $('#dosen').DataTable().ajax.reload();
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

    $("#import").click(function(e) {
        e.preventDefault();
        $("#modalImport").modal();
    });
</script>
@endsection