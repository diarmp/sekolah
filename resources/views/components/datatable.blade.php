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
