<!-- <div class="btn btn-group btn-sm">
    <a href="{{ route('master-configs.edit', ['master_config' => $row->id]) }}" class="btn btn-info btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-info-circle"></i>
        </span>
        <span class="text">EDIT</span>

    </a>

    <button data-url="{{ route('master-configs.edit', ['master_config' => $row->id]) }}" onclick="confirm('yes to delete')"
        class="btn btn-danger btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-trash"></i>
        </span>
        <span class="text">DELETE</span>
    </button>
</div> -->

<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle shadow-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Opsi
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{ route('master-configs.edit', ['master_config' => $row->id]) }}">Edit</a>
        <a class="dropdown-item" data-url="{{ route('master-configs.edit', ['master_config' => $row->id]) }}" onclick="confirm('yes to delete')">Delete</a>
    </div>
</div>