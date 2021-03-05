@extends('layout.master')

@section('title', 'SIMON | FAQ')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Frequently Asked Questions (FAQ)</h5>
            </div>
            @if(Auth::user()->isAdmin())
            <div class="col-6">
                <div class="float-right">
                    <button type="button" class="btn btn-primary btn-sm" href="#modalTambah" data-toggle="modal">
                        <i class="fas fa-plus-circle mr-1"></i>
                        Tambah FAQ
                    </button>
                </div>
            </div>
            @endif
        </div>
        @if(Auth::user()->isAdmin())
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-question-circle mr-1"></i>
                    FAQ
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="faq" class="table table-striped w-100">
                    <thead>
                        <tr>
                            <th width="30%">Pertanyaan</th>
                            <th width="50%">Jawaban</th>
                            <th width="10%">Tipe</th>
                            <th width="5%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($faq as $f)
                        <tr>
                            <td>{{$f->question}}</td>
                            <td>{{$f->answer}}</td>
                            <td><span class="badge badge-info p-2" style="font-size: 11px">{{$f->type}}</span></td>
                            <td>
                                <button id="{{ $f->id }}" class="btn btn-block btn-sm btn-warning edit">Edit</button>
                                <button id="{{ $f->id }}" class="btn btn-block btn-sm btn-danger hapus">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-question-circle mr-1"></i>
                    FAQ
                </h5>
            </div>
            <div class="card-body">
                @foreach ($faq->where('type', 'Publish') as $key => $f)
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="heading{{$key+1}}">
                            <h2 class="mb-0">
                                <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$key+1}}"><h5>{{ $loop->iteration }}. {{ $f->question }}</h5></button>									
                            </h2>
                        </div>
                        <div id="collapse{{$key+1}}" class="collapse" aria-labelledby="heading{{$key+1}}" data-parent="#accordionExample">
                            <div class="card-body">
                                <p>{{ $f->answer }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Tambah Modal -->
<div class="modal fade" id="modalTambah" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="faq/store">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus mr-1"></i>
                        Tambah FAQ
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea rows="2" type="text" class="form-control" id="pertanyaan" name="pertanyaan"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban</label>
                        <textarea type="text" rows="3" class="form-control" id="jawaban" name="jawaban"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                            <select name="tipe" id="tipe" class="form-control" style="width: 100%;">
                            <option value="">Pilih Tipe FAQ</option>
                            <option value="Draft">Draft</option>
                            <option value="Publish">Publish</option>
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

<!-- Edit Modal -->
<div class="modal fade" id="modalEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="faq/update">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus mr-1"></i>
                        Edit FAQ
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <input type="hidden" id="faq_id" name="faq_id">
                        <textarea rows="2" type="text" class="form-control" id="editPertanyaan" name="editPertanyaan"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Jawaban</label>
                        <textarea type="text" rows="3" class="form-control" id="editJawaban" name="editJawaban"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tipe</label>
                            <select name="editTipe" id="editTipe" class="form-control" style="width: 100%;">
                            <option value="">Pilih Tipe FAQ</option>
                            <option value="Draft">Draft</option>
                            <option value="Publish">Publish</option>
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
@endsection

@section('ajax')
<script>
    $("#faq").DataTable({
        "processing": true,
    });

    $('#faq tbody').on('click', '.edit', function() {
        let id = $(this).attr('id');
        $.ajax({
            url: "faq/edit/" + id,
            dataType: "json",
            success: function(result) {
                console.log(result);
                $('#modalEdit').modal('show');

                $('#faq_id').val(result.data.id);
                $('#editPertanyaan').val(result.data.question);
                $('#editJawaban').val(result.data.answer);
                $('#editTipe').val(result.data.type);
            }
        })
    })

    $('#faq tbody').on('click', '.hapus', function() {
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
                    url: "faq/delete/" + id,
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
                                window.location.href = "faq";
                            })
                    }
                })
            }
        })
    });
</script>
@endsection