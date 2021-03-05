@extends('layout.master')

@section('title', 'Admin | Data Jobdesc')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Data Jobdesc</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" href="#modalTambah" data-toggle="modal">
                        <i class="fas fa-user-plus mr-1"></i>
                        Tambah Jobdesc
                    </button>
                    <button type="button" id="import" class="btn btn-success btn-sm">
                        <i class="fas fa-upload mr-1"></i>
                        Import Data
                    </button>
                    <a href="exportJobdesc" class="btn btn-secondary btn-sm">
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
                    Jobdesc
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="jobdesc" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th width="700px">Deskripsi</th>
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
                        Tambah Jobdesc
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jobdesc</label>
                        <input type="text" class="form-control" id="jobname" name="jobname">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea rows="3" class="form-control" id="desk" name="desk"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="wajib">
                        <label for="Status" class="form-check-label">Wajib</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="modalEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEdit" action="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit mr-1"></i>
                        Edit Jobdesc
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Jobdesc</label>
                        <input type="text" class="form-control" id="jobnameEdit" name="jobnameEdit">
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea rows="3" class="form-control" id="deskEdit" name="deskEdit"></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="statusEdit" name="statusEdit" value="wajib">
                        <label for="Status" class="form-check-label">Wajib</label>
                    </div>
                    <input type="hidden" id="job_id">
                    <input type="hidden" id="_method" value="PUT" name="_method">
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

        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-upload mr-1"></i>
                    Upload Data Jobdesc
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{ route('jobdesc-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary float-right">Import Data</button>
                </form>
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
@endsection

@section('ajax')
<script>
    const ENDPOINT = 'jobdesc';
    $("#jobdesc").DataTable({
        "processing": true,
        "order": [[ 2, "desc" ]],
        "ajax": {
            url: "{{ route('get-job') }}"
        },
        "columns": [
            {
                data: "jobname"
            },
            {
                data: "description"
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    if (full.status == "wajib") {
                        return '<span class="badge badge-primary p-2">Wajib</span>';
                    } else {
                        return '<span class="badge badge-secondary p-2">Tidak Wajib</span>';
                    }
                }
            },
            {
                sortable: false,
                "render": function(data, type, full, meta) {
                    let buttonId = full.id;
                    return '<button id="' + buttonId + '" class="btn btn-warning update m-1" title="Edit">Edit</button>'+
                    '<button id="' + buttonId + '" class="btn btn-danger delete" title="Hapus">Hapus</button>'
                }
            }
        ]
    });
    $('#jobdesc tbody').on('click', '.update', function() {
        let id = $(this).attr('id');

        $("small").remove(".text-danger");
        $("input").removeClass("is-invalid");
        $.ajax({
            url: ENDPOINT +'/' +id,
            dataType: "json",
            success: function(result) {
                $('#modalEdit').modal('show');

                $('#jobnameEdit').val(result.data.jobname);
                $('#deskEdit').val(result.data.description);
                $('#job_id').val(result.data.id);
                const status = result.data.status;

                if (status === "wajib") {
                    $('#statusEdit').prop('checked', true);
                } else {
                    $('#statusEdit').prop('checked', false);
                }
            }
        })
    });
    $('#jobdesc tbody').on('click', '.delete', function() {
        let id = $(this).attr('id');
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: 'Yakin ingin menghapus data?',
            text: "Data ini akan dihapus",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
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
                    url: "jobdesc/" + id,
                    method: "POST",
                    data: {
                        _method: "DELETE",
                        "_token": token,
                    },
                    success: function() {
                        Swal.fire(
                                'Deleted!',
                                'Telah Dihapus',
                                'success'
                            )
                            .then(function() {
                                $('#jobdesc').DataTable().ajax.reload();
                            })
                    }
                })
            }
        })
    });

    function loadDataTable() {
        $.ajax({
            url: "{{ route('get-job') }}",
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
            url: "{{ url('admin/simpanDataJobdesc') }}",
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
                    $('#jobdesc').DataTable().ajax.reload();
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

        const id = $('#job_id').val();
        $.ajax({
            url: "jobdesc/" + id + "/edit",
            method: "POST",
            data: request,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if (data == "success") {
                    $('#modalSuccess').modal();
                    $('#formEdit')[0].reset();
                    $('#modalEdit').modal('hide');
                    $('#jobdesc').DataTable().ajax.reload();

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