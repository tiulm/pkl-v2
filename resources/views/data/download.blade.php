@extends('layout.master')

@section('title', 'Unduhan')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Unduhan</h5>
            </div>
            @if(Auth::user()->isCoordinator() || Auth::user()->isAdmin())
            <div class="col-6">
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" href="#modalTambah" data-toggle="modal">
                        <i class="fas fa-file-upload mr-1"></i>
                        Tambah Unduhan
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div class="card card-secondary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-cloud-download-alt mr-1"></i>
                    Unduhan
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="downloads" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th width="50%">Nama Berkas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($download as $d)
                        <tr>
                            <td>{{ $d->file_name }}</td>
                            <td>
                                <a href="../berkas/unduhan/{{ $d->file }}" target="_blank" class="btn btn-primary mr-1">Download</a>
                                @if(Auth::user()->isCoordinator() || Auth::user()->isAdmin())
                                <button id="{{$d->id}}" class="btn btn-danger delete">Hapus</button>
                                @endif
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
            <form action="downloads/store" id="formSave" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus mr-1"></i>
                        Tambah Berkas Unduhan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Berkas</label>
                        <input type="text" class="form-control" id="fileName" name="fileName" required>
                    </div>
                    <div class="form-group">
                        <label>Upload Berkas</label>
                        <input type="file" class="form-control" id="berkas" name="berkas" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('ajax')
<script>
    $("#downloads").DataTable({
        "processing": true,
    });

    $('#downloads tbody').on('click', '.delete', function() {
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
                    url: "downloads/deleteDownloads/" + id,
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
                                window.location.href = "downloads";
                            }
                        )
                    }
                })
            }
        })
    });
</script>
@endsection