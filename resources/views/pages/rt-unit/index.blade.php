@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data RT</h1>
        <a href="{{ route('rt-unit.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah RT
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>Nomor RT</th>
                            <th>Berada di RW</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rt_units as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>RT {{ $item->number }}</td>
                            <td><span class="badge badge-info">RW {{ $item->rwUnit->number }}</span></td>
                            <td>
                                <a href="{{ route('rt-unit.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('rt-unit.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus RT ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Data RT belum ada.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $rt_units->links() }}
            </div>
        </div>
    </div>
</div>
@endsection