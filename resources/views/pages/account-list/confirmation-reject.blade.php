<div class="modal fade" id="deactivateModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('account.approval', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="for" value="deactivate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Nonaktifkan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan menonaktifkan akun <strong>{{ $user->name }}</strong>? User ini tidak akan bisa login sementara waktu.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Ya, Nonaktifkan</button>
                </div>
            </div>
        </form>
    </div>
</div>