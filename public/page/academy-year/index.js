$(function() {
    const table = $("#academic-years")
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

    // softDelete(); # karena belum dipakai, jadi di-disable dulu (oleh: Reza)

    function softDelete() {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: 'Untuk menghapus data ' + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                cancelButton: 'btn btn-light waves-effect',
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            preConfirm: (e) => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve();
                    }, 50);
                });
            }
        }).then((result) => {
            if (result.value) {
                // $.ajax({
                //     type: 'DELETE',
                //     url: url,
                //     data: {
                //         "id": id,
                //         "_token": token,
                //     },
                //     success: function (response) {

                //         toastMessage("success", response.header.message)
                //         setTimeout(function(){
                //             window.location = `/cms/post-log-management/user`;
                //         }, 1000)
                //     },
                //     error: function (xhr, status, error) {
                //         var err = eval("(" + xhr.responseText + ")");
                //         toastMessage("error", err.header.message)
                //     }
                // })
            }
        })
    }

});


