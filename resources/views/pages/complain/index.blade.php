@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ auth()->user()->role_id == 1 ? 'Aduan Warga' : 'Pengaduan Saya' }}</h1>
        @if(auth()->user()->role_id == 2 && auth()->user()->resident)
        <a href="{{ route('complain.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Aduan
        </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr class="bg-light">
                            <th width="5%">No</th>
                            <th>Laporan</th>
                            @if(auth()->user()->role_id == 1) <th>Pelapor</th> @endif
                            <th>Tanggal</th>
                            <th width="15%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complains as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $item->title }}</strong>
                            </td>
                            @if(auth()->user()->role_id == 1)
                                <td>{{ $item->resident->name ?? 'N/A' }}</td>
                            @endif
                            <td>{{ $item->reported_date_label }}</td>
                            <td>
                                @if(auth()->user()->role_id == 1)
                                    <form action="{{ route('complain.updateStatus', $item->id) }}" method="POST">
                                        @csrf
                                        <select name="status" class="form-control form-control-sm border-left-{{ $item->status == 'new' ? 'info' : ($item->status == 'processing' ? 'warning' : 'success') }}" onchange="this.form.submit()">
                                            <option value="new" {{ $item->status == 'new' ? 'selected' : '' }}>Baru</option>
                                            <option value="processing" {{ $item->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                            <option value="done" {{ $item->status == 'done' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                @else
                                    <span class="badge badge-{{ $item->status == 'new' ? 'info' : ($item->status == 'processing' ? 'warning' : 'success') }}">
                                        {{ $item->status_label }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('complain.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Isi Laporan">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                                @if(auth()->user()->role_id == 2 && $item->status == 'new')
                                    <form action="{{ route('complain.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus aduan ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role_id == 1 ? '6' : '5' }}" class="text-center text-muted">Belum ada data pengaduan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $complains->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection