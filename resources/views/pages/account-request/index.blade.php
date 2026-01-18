@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Permintaan Akun</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftar Baru (Menunggu Verifikasi)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center">Validasi NIK</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td class="text-center">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                            </td>
                            <td><mark><strong>{{ $user->nik }}</strong></mark></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->resident_data)
                                    <span class="badge badge-success p-2">
                                        <i class="fas fa-check-circle"></i> Warga Terdata
                                    </span>
                                @else
                                    <span class="badge badge-danger p-2">
                                        <i class="fas fa-times-circle"></i> Data Tidak Ditemukan
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- Tombol Setuju: Hanya aktif jika NIK cocok --}}
                                <button class="btn btn-success btn-sm" 
                                        data-toggle="modal" 
                                        data-target="#approveModal{{ $user->id }}"
                                        {{ !$user->resident_data ? 'disabled' : '' }}>
                                    <i class="fas fa-user-check"></i> Setuju
                                </button>
                                
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal{{ $user->id }}">
                                    <i class="fas fa-user-times"></i> Tolak
                                </button>
                            </td>
                        </tr>

                        {{-- Modal tetap di-include --}}
                        @include('pages.account-request.confirmation-approve', ['user' => $user])
                        @include('pages.account-request.confirmation-reject', ['user' => $user])

                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Tidak ada permintaan akun baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($users->hasPages())
            <div class="card-footer">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session("success") }}',
        confirmButtonColor: '#4e73df'
    });
</script>
@endif
@endsection