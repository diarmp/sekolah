<div class="btn btn-group btn-sm">
    <a href="{{ $edit_url }}" class="btn btn-info btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-info-circle"></i>
        </span>
        <span class="text">EDIT</span>

    </a>

    <button data-url="{{ $delete_url }}" data-redirect={{ $redirect_url }} onclick="softDelete(this)"
        class="btn btn-danger btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
        </span>
        <span class="text">DELETE</span>
    </button>
</div>
