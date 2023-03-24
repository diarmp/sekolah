<div class="btn btn-group btn-sm">
  <button data-url="{{ route('schools.destroy', ['school' => $row->id]) }}" onclick="confirm('yes to delete')"
    class="btn btn-danger btn-sm btn-icon-split">
    <span class="icon text-white-50">
      <i class="fas fa-trash"></i>
    </span>
  </button>
</div>
