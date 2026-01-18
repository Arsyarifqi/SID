<div class="modal fade" id="activateModal{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('account.approval', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="for" value="activate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Aktifkan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin akan mengaktifkan kembali akun <strong>{{ $user->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-success" type="submit">Ya, Aktifkan</button>
                </div>
            </div>
        </form>
    </div>
</div>