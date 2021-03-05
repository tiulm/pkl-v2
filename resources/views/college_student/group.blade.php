@extends('layout.master')

@section('title', 'Mahasiswa | Proyek Kelompok')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Proyek Kelompok</h5>
            </div>
            @if(Auth::user()->isVerifiedGroupProject() < 4)
            <div class="col-6">
                <div class="float-right">
                <button onclick="openModalProgres('{{ $group->id }}')" class="btn btn-primary btn-sm progresKel float-right"><i class="fas fa-plus mr-1"></i> Tambah Progress</button>
                </div>
            </div>
            @endif
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-tasks mr-1"></i>
                    Progress
                </h5>
            </div>
            <div class="card-body table-responsive">
                <table id="kelompokPro" class="table table-striped w-100">       
                    <thead>
                        <tr>
                            <th width="10%">No.</th>
                            <th width="20%">Tanggal</th>
                            <th>Progress</th>
                            <th>Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($pk as $p)
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{ Carbon\Carbon::parse($p->date)->isoFormat('DD/MM/YY') }}</td>
                            <td>{{ $p->description }}</td>
                            <td>
                                @if ($p->agreement == 'N')
                                    <span class="badge badge-danger p-2" style="font-size: 10px">Belum Disetujui</span>
                                @else
                                    <span class="badge badge-success p-2" style="font-size: 10px">Disetujui</span>
                                @endif
                            </td>
                            <td>
                                @if ($p->agreement == 'N')
                                <button onclick="openModalHapus('{{$p->id}}')"
                                    title="Hapus Progress" class="btn btn-danger">Hapus</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<!-- Modal Tambah Progress -->
<div class="modal fade" id="modalProgress" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="fas fa-plus mr-1"></i>
                    Tambah Progress Kelompok
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="pk/tambahProgress" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="row mt-2">
                        <input name="groupId" type="hidden" value="" class="form-control" id="groupProgress" required>
                        <div class="form-group col-12">
                            <label for="tgl">Tanggal</label>
                            <input name="tanggalProgress" type="date" value="" class="form-control" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="desc">Deskripsi</label>
                            <textarea rows="3" name="deskripsiProgress" value="" class="form-control" id=""></textarea>
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

<!-- Modal Hapus Progress -->
<div class="modal fade" id="hapus" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    Konfirmasi Hapus Progress
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus Progress?<br><br>
                    <form action="pk/hapusProgress" id="pengamat" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-9">
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
    function openModalHapus([id]) {
        $('#hapus').modal();
        $('#group_hapus').val(id);
    }

    function openModalProgres(id) {
        $('#modalProgress').modal();
        $('#groupProgress').val(id);
    }
</script>
@endsection
