@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengaduan</h1>
        <a href="{{ route('complain.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $complain->title }}</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">
                            Pelapor: <strong>{{ $complain->resident->name ?? 'Anonim/Data Terhapus' }}</strong> | 
                            Tanggal: {{ $complain->reported_date_label }}
                        </small>
                    </div>
                    
                    <p class="text-gray-800" style="white-space: pre-wrap;">{{ $complain->content }}</p>

                    @if($complain->foto_proof)
                        <div class="mt-4">
                            <h6 class="font-weight-bold">Foto Bukti:</h6>
                            <a href="{{ asset('storage/' . $complain->foto_proof) }}" target="_blank">
                                <img src="{{ asset('storage/' . $complain->foto_proof) }}" 
                                     class="img-fluid rounded border shadow-sm" 
                                     style="max-height: 400px; object-fit: cover;" 
                                     alt="Foto Bukti">
                            </a>
                            <p class="small text-muted mt-2">*Klik gambar untuk memperbesar</p>
                        </div>
                    @endif

                    @if($complain->response)
                        <hr>
                        <div class="p-3 bg-light border-left-success shadow-sm">
                            <h6 class="font-weight-bold text-success">Tanggapan Resmi Admin:</h6>
                            <p class="mb-0 text-gray-700" style="font-style: italic;">"{{ $complain->response }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Status Pengaduan</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <span class="badge p-2 badge-{{ $complain->status == 'new' ? 'info' : ($complain->status == 'processing' ? 'warning' : 'success') }}" style="font-size: 1rem; width: 100%;">
                            {{ $complain->status_label }}
                        </span>
                    </div>

                    @if(auth()->user()->role_id == 1)
                        <hr>
                        <form action="{{ route('complain.update', $complain->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Ubah Status</label>
                                <select name="status" class="form-control border-left-primary">
                                    <option value="new" {{ $complain->status == 'new' ? 'selected' : '' }}>Baru</option>
                                    <option value="processing" {{ $complain->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                    <option value="done" {{ $complain->status == 'done' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Berikan Tanggapan</label>
                                <textarea name="response" class="form-control border-left-primary" rows="5" placeholder="Tuliskan solusi atau progres di sini...">{{ old('response', $complain->response) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block shadow">
                                <i class="fas fa-paper-plane fa-sm"></i> Kirim Tanggapan
                            </button>
                        </form>
                    @else
                        @if(!$complain->response)
                            <div class="alert alert-info small">
                                <i class="fas fa-info-circle"></i> Menunggu tanggapan dari Admin desa.
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection