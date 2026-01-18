@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Aduan</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('complain.update', $complain->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                
                <div class="form-group">
                    <label>Judul Aduan</label>
                    <input type="text" name="title" class="form-control" value="{{ $complain->title }}">
                </div>

                <div class="form-group">
                    <label>Isi Aduan</label>
                    <textarea name="content" class="form-control" rows="5">{{ $complain->content }}</textarea>
                </div>

                <div class="form-group">
                    <label>Foto Bukti Saat Ini</label><br>
                    @if($complain->foto_proof)
                        <img src="{{ asset('storage/' . $complain->foto_proof) }}" width="200" class="mb-2 d-block">
                    @endif
                    <input type="file" name="foto_proof" class="form-control-file">
                    <small class="text-muted">Pilih file baru jika ingin mengganti foto bukti.</small>
                </div>

                <button type="submit" class="btn btn-primary">Update Aduan</button>
                <a href="{{ route('complain.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection