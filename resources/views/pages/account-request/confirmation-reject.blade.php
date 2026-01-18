<div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('account.approval', [$user->id, 'reject']) }}" method="POST">
            @csrf
            
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Konfirmasi Tolak</h5>
                    <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak pendaftaran akun <b>{{ $user->name }}</b>?</p>
                    <p class="text-muted small">*Warga tidak akan bisa login jika pendaftaran ditolak.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak Akun</button>
                </div>
            </div>
        </form>
    </div>
</div>