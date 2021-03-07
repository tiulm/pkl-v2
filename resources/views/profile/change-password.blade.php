@extends('layout.master')

@section('title', "$role | Profil")
@section('content')
<section class="content">
    <div class="container-fluid">
        <h5 class="py-2">Profil</h5>
        <div class="row">
            <div class="col-12">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('change.password')}}" method="POST">
                    @csrf
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-key mr-1"></i>
                                Password
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label>Password Lama</label>
                                <input name="current-password" type="password" class="form-control font-weight-bold">
                                @error('current-password')
                                <small class="alert text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label>Password Baru</label>
                                <input name="new-password" type="password" class="form-control font-weight-bold">
                                @error('new-password')
                                <small class="alert text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Re-type Password Baru</label>
                                <input name="new-password_confirmation" type="password" class="form-control font-weight-bold">
                                @error('new-password_confirmation')
                                <small class="alert text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success float-right">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection