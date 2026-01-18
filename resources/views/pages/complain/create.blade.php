@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Buat Aduan Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('complain.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Judul Aduan</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: Lampu Jalan Mati">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Isi Aduan / Kronologi</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5">{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Foto Bukti (Opsional)</label>
                    <input type="file" name="foto_proof" class="form-control-file @error('foto_proof') is-invalid @enderror">
                    <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                    @error('foto_proof') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                <a href="{{ route('complain.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection