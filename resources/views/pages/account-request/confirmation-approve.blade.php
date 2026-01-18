<div class="modal fade" id="approveModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('account.approval', [$user->id, 'approve']) }}" method="POST">
            @csrf
            
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle"></i> Konfirmasi Persetujuan</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui akun berikut?</p>
                    
                    <div class="alert alert-light border">
                        <table class="table table-sm mb-0">
                            <tr>
                                <td width="30%"><strong>Nama</strong></td>
                                <td>: {{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIK Akun</strong></td>
                                <td>: <span class="badge badge-primary">{{ $user->nik }}</span></td>
                            </tr>
                        </table>
                    </div>

                    @if($user->resident_data)
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-link"></i> <strong>Sistem Mendeteksi:</strong><br>
                            NIK ini cocok dengan data penduduk atas nama <b>{{ $user->resident_data->name }}</b>. 
                            Akun akan otomatis terhubung secara permanen.
                        </div>
                    @else
                        <div class="alert alert-danger mt-3">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Peringatan:</strong><br>
                            NIK pendaftar tidak ditemukan dalam database penduduk desa.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    {{-- Tombol hanya aktif jika data penduduk ditemukan --}}
                    <button type="submit" class="btn btn-success" {{ !$user->resident_data ? 'disabled' : '' }}>
                        Ya, Setujui & Hubungkan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>