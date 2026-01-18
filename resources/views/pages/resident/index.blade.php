@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penduduk Lengkap</h1>
        <a href="{{ route('resident.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    {{-- FILTER & SEARCH SECTION --}}
    <div class="card shadow mb-3">
        <div class="card-body py-3">
            <form action="{{ route('resident.index') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label class="small font-weight-bold">Filter RW</label>
                        <select name="rw_id" class="form-control form-control-sm">
                            <option value="">Semua RW</option>
                            @foreach($rw_units as $rw)
                                <option value="{{ $rw->id }}" {{ request('rw_id') == $rw->id ? 'selected' : '' }}>
                                    RW {{ $rw->number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="small font-weight-bold">Cari Nama / NIK</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   placeholder="Ketik kata kunci..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <a href="{{ route('resident.index') }}" class="btn btn-secondary btn-sm btn-block">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm text-dark" width="100%" cellspacing="0" style="font-size: 13px;">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Wilayah</th> 
                            <th>L/P</th>
                            <th>Lahir</th>
                            <th>Status Nikah</th>
                            <th>Telepon</th>
                            <th>Kondisi</th>
                            <th>Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residence as $item)
                        <tr>
                            <td class="text-center">
                                {{ ($residence->currentPage() - 1) * $residence->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $item->nik }}</td>
                            <td>{{ $item->name }}</td>
                            
                            {{-- Kolom Wilayah RT/RW --}}
                            <td class="text-center">
                                @if($item->rtUnit && $item->rwUnit)
                                    <span class="badge badge-light border text-dark" style="font-size: 11px;">
                                        RT {{ $item->rtUnit->number }} / RW {{ $item->rwUnit->number }}
                                    </span>
                                @else
                                    <span class="text-muted" style="font-size: 10px;"><i>N/A</i></span>
                                @endif
                            </td>

                            <td class="text-center">{{ $item->gender == 'male' ? 'L' : 'P' }}</td>
                            <td>{{ $item->birth_place }}, {{ \Carbon\Carbon::parse($item->birth_date)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($item->marital_status) }}</td>
                            <td>{{ $item->phone }}</td>
                            <td class="text-center">
                                @if($item->status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($item->status == 'moved')
                                    <span class="badge badge-warning">Pindah</span>
                                @else
                                    <span class="badge badge-danger">Meninggal</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($item->user_id)
                                    <button class="btn btn-xs btn-info" data-toggle="modal" data-target="#detailAccount{{ $item->id }}">
                                        <i class="fas fa-user fa-xs"></i> Akun
                                    </button>
                                @else
                                    <span class="text-muted" style="font-size: 10px;">Belum Ada</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="/resident/{{ $item->id }}/edit" class="btn btn-xs btn-warning mr-1">
                                        <i class="fas fa-edit fa-xs"></i>
                                    </a>
                                    <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#confirmDelete{{ $item->id }}">
                                        <i class="fas fa-trash fa-xs"></i>
                                    </button>
                                </div>

                                @include('pages.resident.confirmation-delete')

                                @if($item->user_id)
                                    @include('pages.resident.detail-account', ['item' => $item])
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">Data penduduk tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($residence->hasPages())
            <div class="card-footer">
                {{ $residence->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<style>
    .table-sm th, .table-sm td {
        padding: 0.3rem;
        vertical-align: middle;
    }
    .btn-xs {
        padding: 2px 5px;
        font-size: 10px;
    }
    .pagination {
        margin-bottom: 0;
        font-size: 12px;
    }
</style>
@endsection