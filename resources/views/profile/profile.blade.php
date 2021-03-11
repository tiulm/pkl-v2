@extends('layout.master')

@section('title', "$role | Profil")
@section('content')
<section class="content">
    <div class="container-fluid">
        <h5 class="py-2">Profil</h5>
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-circle mr-1"></i>
                            Profil
                        </h3>
                    </div>
                    <form action="{{ url('profilUpdate', ['id' => Auth::user()->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="text-center">
                                <img src="public/image/{{ $user->image_profile }}" width="150px" height="150px" class="img-circle mb-2">
                                @if(Auth::user()->isStudent())
                                <h2 class="lead"><b>{{ Auth::user()->InternshipStudent->name }}</b></h2>
                                <h4 class="lead">{{ Auth::user()->InternshipStudent->nim }}</h4>
                                @endif
                                @if(Auth::user()->isCoordinator() || Auth::user()->isAdmin())
                                <h2 class="lead text-uppercase"><b>{{ Auth::user()->username }}</b></h2>
                                @endif
                            </div>
                            <hr>
                            <div class="form-group">
                                <p>*Foto Berwarna dengan ekstensi jpeg, png, atau jpg (max. 100 KB) dengan ukuran 3:4 (pas foto)</p>
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" name="image_profile" class="custom-file-input" id="image_profile">
                                        <label class="custom-file-label" for="image_profile">Choose file</label>
                                    </div>
                                </div>
                                @error('image_profile')
                                <small class="alert text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @if(Auth::user()->isStudent())
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="text" class="form-control font-weight" id="email" name="email" value="{{ $user->email }}">
                                @error('email')
                                <small class="alert text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Telp</label>
                                <input type="number" class="form-control font-weight" id="telp" name="telp" value="{{ $user->phone_number }}">
                                @error('telp')
                                <small class="alert text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("image_profile").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })
</script>
@endsection