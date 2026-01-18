@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Data RT</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('rt-unit.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Pilih RW</label>
                    <select name="rw_unit_id" class="form-control @error('rw_unit_id') is-invalid @enderror">
                        <option value="">-- Pilih RW --</option>
                        @foreach($rw_units as $rw)
                            <option value="{{ $rw->id }}" {{ old('rw_unit_id') == $rw->id ? 'selected' : '' }}>
                                RW {{ $rw->number }}
                            </option>
                        @endforeach
                    </select>
                    @error('rw_unit_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor RT</label>
                    <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" 
                           placeholder="Contoh: 01" value="{{ old('number') }}">
                    @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan RT</button>
                    <a href="{{ route('rt-unit.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection