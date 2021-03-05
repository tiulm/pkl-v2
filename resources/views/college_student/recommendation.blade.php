@extends('layout.master')

@section('title', 'Mahasiswa | Rekomendasi')
@section('content')
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

<section class="content">
    <div class="container-fluid">
        <div class="row py-2">
            <div class="col-6">
                <h5>Rekomendasi</h5>
            </div>
        </div>
        <div class="card card-info">
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
                            <th width="25%">Deskripsi Proyek</th>
                            <th width="20%">Instansi</th>
                            <th width="25%">Dosen</th>
                            <th width="10%">Status</th>
                            <th width="20%">Aksi</th>
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
							<span class="badge badge-warning p-2" style="font-size: 11px">Belum Ada Mahasiswa</span>
                            @elseif ($r->status == 1)
							<span class="badge badge-info p-2" style="font-size: 11px">Ada Mahasiswa</span>
							@endif
                            </td>
                            <td>
                            @if($groupgua == 1)
                                <span class="badge badge-info p-2" style="font-size: 11px">Anda Aktif PKL-PK</span>
                            @else
                                @if ($r->status == 1)
                                    @if($r->internship_student_id == Auth::user()->InternshipStudent->id)
                                    <span class="badge badge-warning p-2" style="font-size: 11px">Segara Hubungi Dosen!</span> /
                                    <button onclick="openModalBatal('{{ $r->id }}')" class="btn btn-sm btn-danger ml-1 mr-1">Batal</button>
                                    @else
                                    <span class="badge badge-info p-2" style="font-size: 11px">Telah Diambil</span>
                                    @endif
                                @else
                                    @if($countGua == 0)
                                    <button onclick="openModalAmbil('{{ $r->id }}')" class="btn btn-sm btn-success ml-1 mr-1">Ambil</button>
                                    @else
                                    <span class="badge badge-info p-2" style="font-size: 11px">Anda Telah Mengambil Topik Lain</span>
                                    @endif
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
</section>


<!-- Ambil Modal-->
<div class="modal fade" id="modalAmbil" aria-hidden="true">
    <form action="{{ url('mahasiswa/rekomendasi/store') }}" id="ambilRek" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-check mr-1"></i>
                        Konfirmasi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="rekId" id="rek_id" value="">
                    <input type="hidden" name="internship_student_id" id="internship_student_id" value="{{ Auth::user()->InternshipStudent->id }}">
                    <p>Yakin ingin mengambil rekomendasi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-right">Yakin</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Batal Modal-->
<div class="modal fade" id="modalBatal" aria-hidden="true">
    <form action="{{ url('mahasiswa/rekomendasi/batal') }}" id="batalRek" method="POST">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">
                        <i class="fas fa-times mr-1"></i>
                        Batal
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="rekIdBatal" id="rek_idBatal" value="">
                    <p>Yakin ingin batal mengambil rekomendasi ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger float-right">Yakin</button>
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

	function openModalAmbil(id) {
		$('#modalAmbil').modal('show');
		$('#rek_id').val(id);
    }

	function openModalBatal(id) {
		$('#modalBatal').modal('show');
		$('#rek_idBatal').val(id);
    }
</script>
@endsection

