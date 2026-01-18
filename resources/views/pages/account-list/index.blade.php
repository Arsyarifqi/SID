@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Akun Penduduk</h1>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-dark" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            {{-- Rumus Nomor Urut Eps 10 --}}
                            <td class="text-center">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->status == 'approved')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->status == 'approved')
                                    <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deactivateModal{{ $user->id }}">
                                        <i class="fas fa-user-slash fa-sm"></i> Nonaktifkan
                                    </button>
                                @else
                                    <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#activateModal{{ $user->id }}">
                                        <i class="fas fa-user-check fa-sm"></i> Aktifkan
                                    </button>
                                @endif
                            </td>
                        </tr>
                        
                        {{-- Pastikan nama file modal sesuai --}}
                        @include('pages.account-list.confirmation-approve', ['user' => $user])
                        @include('pages.account-list.confirmation-reject', ['user' => $user])
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Navigasi Pagination Eps 10 --}}
        @if ($users->lastPage() > 1)
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} data
                    </small>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection