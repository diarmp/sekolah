<div class="btn btn-group btn-sm">
    <a href="{{ route('grade.edit', ['grade' => $row->id]) }}" class="btn btn-info btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-info-circle"></i>
        </span>
        <span class="text">EDIT</span>

    </a>

    <button data-url="{{ route('grade.destroy', ['grade' => $row->id]) }}"
        data-redirect={{ route('grade.index') }} onclick="softDelete(this)" class="btn btn-danger btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
        </span>
        <span class="text">DELETE</span>
    </button>
</div>
