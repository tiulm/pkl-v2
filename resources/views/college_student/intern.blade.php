@extends('layout.master')

@section('title', 'Mahasiswa | Praktek Kerja Lapangan')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Praktek Kerja Lapangan a.n {{ Auth::user()->InternshipStudent->name }}</h5>
            </div>
            <div class="col-6">
                <div class="float-right">
                </div>
            </div>
        </div>
        <div class="row py-2">
            <div class="col-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-tasks mr-1"></i>
                            Progress
                        </h5>
                        @if(Auth::user()->isVerifiedGroupProject() < 4)
                        <button onclick="openModalProgres('{{Auth::user()->InternshipStudent->id}}')" class="btn btn-primary btn-sm progresKel float-right"><i class="fas fa-plus"></i> Tambah</button>
                        @endif
                    </div>
                    <div class="card-body table-responsive">
                        <table id="internPro" class="table table-striped w-100">       
                            <thead>
                                <tr>
                                    <th width="5%">No.</th>
                                    <th width="20%">Tanggal</th>
                                    <th>Progress</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>    
                            @foreach ($pkl as $p)
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
                                            title="Hapus Progress" class="btn btn-sm btn-danger">Hapus</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-list mr-1"></i>
                            Log Activity
                        </h5>
                        @if(Auth::user()->isVerifiedGroupProject() < 4)
                        <button onclick="openModalLog('{{Auth::user()->InternshipStudent->id}}')" class="btn btn-secondary btn-sm progresKel float-right"><i class="fas fa-plus"></i> Tambah</button>
                        @endif
                    </div>
                    <div class="card-body table-responsive">
                        <table id="logAct" class="table table-striped w-100">       
                            <thead>
                                <tr>
                                    <th width="10%">No.</th>
                                    <th width="20%">Tanggal</th>
                                    <th>Log Activity</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>    
                            @foreach ($log as $p)
                                <tr>
                                    <td>{{ $loop->iteration  }}</td>
                                    <td>{{ Carbon\Carbon::parse($p->date)->isoFormat('DD/MM/YY') }}</td>
                                    <td>{{ $p->description }}</td>
                                    <td>
                                    @if(Auth::user()->isVerifiedGroupProject() < 4)
                                        <button onclick="openModalLogHapus('{{$p->id}}')"
                                            title="Hapus Progress" class="btn btn-sm btn-danger">Hapus</button>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- Modal Tambah Progress -->
<div class="modal fade" id="modalProgress" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><i class="fas fa-plus mr-1"></i>
                    Tambah Progress PKL
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="pkl/tambahProgress" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="row mt-2">
                        <input name="internIdProgress" type="hidden" value="" class="form-control" id="internProgress" required>
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

<!-- Modal Tambah Log -->
<div class="modal fade" id="modalLog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title"><i class="fas fa-plus mr-1"></i>
                    Tambah Log Activity
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="pkl/tambahLog" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="row mt-2">
                        <input name="internIdLog" type="hidden" value="" class="form-control" id="internLog" required>
                        <div class="form-group col-12">
                            <label for="tgl">Tanggal</label>
                            <input name="tanggalLog" type="date" value="" class="form-control" id="">
                        </div>
                        <div class="form-group col-12">
                            <label for="desc">Deskripsi</label>
                            <textarea rows="3" name="deskripsiLog" value="" class="form-control" id=""></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="tombol_hide" type="submit" class="btn btn-secondary float-right">Simpan</button>
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
                    <form action="pkl/hapusProgress" id="pengamat" method="POST">
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

<!-- Modal Hapus Log -->
<div class="modal fade" id="hapusLog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">
                    Konfirmasi Hapus Log Activity
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus Log Activity?<br><br>
                    <form action="pkl/hapusLog" id="pengamat" method="POST">
                        @csrf
                        <div class="form-group col-12">
                            <div class="row">
                                <div class="col-9">
                                    <input type="hidden" name="logId" id="log_hapus" value="">
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

    function openModalLogHapus([id]) {
        $('#hapusLog').modal();
        $('#log_hapus').val(id);
    }

    function openModalProgres(id) {
        $('#modalProgress').modal();
        $('#internProgress').val(id);
    }

    function openModalLog(id) {
        $('#modalLog').modal();
        $('#internLog').val(id);
    }
</script>
@endsection
