@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Permohonan Surat</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Masuk</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Warga</th>
                            <th>Jenis Surat</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $sub)
                        <tr>
                            <td>
                                <strong>{{ $sub->resident->name }}</strong><br>
                                <small>NIK: {{ $sub->resident->nik }}</small>
                            </td>
                            <td>{{ $sub->type }}</td>
                            <td>{{ Str::limit($sub->necessity, 30) }}</td>
                            <td>
                                @php
                                    $badges = ['pending'=>'warning', 'approved'=>'info', 'ready'=>'success', 'rejected'=>'danger'];
                                @endphp
                                <span class="badge badge-{{ $badges[$sub->status] }}">{{ ucfirst($sub->status) }}</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateModal{{ $sub->id }}">
                                    <i class="fas fa-edit"></i> Proses
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="updateModal{{ $sub->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <form action="{{ route('submission.updateStatus', $sub->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Permohonan: {{ $sub->resident->name }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Ubah Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="pending" {{ $sub->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="approved" {{ $sub->status == 'approved' ? 'selected' : '' }}>Disetujui (Proses Cetak)</option>
                                                    <option value="ready" {{ $sub->status == 'ready' ? 'selected' : '' }}>Siap Diambil</option>
                                                    <option value="rejected" {{ $sub->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Catatan Admin (Alasan tolak/lokasi ambil)</label>
                                                <textarea name="admin_note" class="form-control" rows="3">{{ $sub->admin_note }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <a href="{{ route('submission.pdf', $sub->id) }}" target="_blank" class="btn btn-sm btn-secondary">
    <i class="fas fa-print"></i> Cetak
</a>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection