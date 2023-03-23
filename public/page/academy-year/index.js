$(function() {

    const table = $("#academy-year")
    const url   = table.data('url')


    table.DataTable({
        processing: true,
        serverSide: true,
        ajax: url,
        columns: [
            {data: 'school.name', name: 'name'},
            {data: 'name'},
            {data: 'action'},

        ]
    });



});


