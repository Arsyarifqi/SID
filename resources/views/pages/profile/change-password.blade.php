@extends('layouts.app')

@section('title', 'Ubah Password')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Keamanan Akun</h1>

    <div class="row">
        <div class="col-lg-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Ubah Password</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('password.update', Auth::user()->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="old_password">Password Saat Ini (Lama)</label>
                            <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" required>
                            @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-danger">Update Password</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection