<table class="table table-bordered" id="{{ $id }}" data-url="{{ $url }}" width="100%" cellspacing="0">
    <thead>
        <tr>

            @foreach ($headers as $head)
                <th>{{ $head }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

@push('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('js')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush
