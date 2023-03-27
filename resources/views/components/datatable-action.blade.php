<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Opsi
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{ $edit_url }}">Ubah</a>
        <a class="dropdown-item" data-url="{{ $delete_url }}" data-redirect={{ $redirect_url }} onclick="softDelete(this)">Hapus</a>
    </div>
</div>
