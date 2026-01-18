<div class="modal fade" id="detailAccount{{ $item->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Akun Terhubung</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" class="form-control" value="{{ $item->user->name }}" readonly>
                </div>
                <div class="form-group">
                    <label>Email / Username</label>
                    <input type="text" class="form-control" value="{{ $item->user->email }}" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>