<div class="btn btn-group btn-sm">
    <a href="{{ route('academy-year.edit', ['academy_year' => $row->id]) }}" class="btn btn-info btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-info-circle"></i>
        </span>
        <span class="text">EDIT</span>

    </a>

    <button data-url="{{ route('academy-year.destroy', ['academy_year' => $row->id]) }}"
        data-redirect={{ route('academy-year.index') }} onclick="softDelete(this)" class="btn btn-danger btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
        </span>
        <span class="text">DELETE</span>
    </button>
</div>
