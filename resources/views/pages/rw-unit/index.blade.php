@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data RW</h1>
        <a href="{{ route('rw-unit.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
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

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nomor RW</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rw_units as $item)
                        <tr>
                            <td>{{ ($rw_units->currentPage() - 1) * $rw_units->perPage() + $loop->iteration }}</td>
                            <td>RW {{ $item->number }}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('rw-unit.edit', $item->id) }}" class="btn btn-sm btn-warning mr-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        @include('pages.rw-unit.confirmation-delete', ['item' => $item])
                        
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted">Data RW belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $rw_units->links() }}
            </div>
        </div>
    </div>
</div>
@endsection