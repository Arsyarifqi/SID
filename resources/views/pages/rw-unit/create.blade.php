@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data RW</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('rw-unit.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="number">Nomor RW</label>
                    <input type="text" name="number" id="number" 
                           class="form-control @error('number') is-invalid @enderror" 
                           placeholder="Contoh: 01 atau 002" value="{{ old('number') }}">
                    @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                    <a href="{{ route('rw-unit.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection