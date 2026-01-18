@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Pengajuan Surat Online</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('submission.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Jenis Surat</label>
                    <select name="type" class="form-control" required>
                        <option value="">-- Pilih Jenis Surat --</option>
                        <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                        <option value="Surat Keterangan Tidak Mampu (SKTM)">SKTM</option>
                        <option value="Surat Pengantar Nikah">Surat Pengantar Nikah</option>
                        <option value="Surat Keterangan Usaha">Surat Keterangan Usaha</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Keperluan / Alasan Pengajuan</label>
                    <textarea name="necessity" class="form-control" rows="4" placeholder="Contoh: Untuk persyaratan mendaftar beasiswa kuliah..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection