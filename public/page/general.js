
$.ajaxSetup({
    headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
 });




function softDelete(e) {

    const url      = $(e).data('url')
    const name     = $(e).data('name') ?? ''
    const redirect = $(e).data('redirect')

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
            $.ajax({
                type: 'POST',
                data:{
                    _method:"DELETE"
                },
                url: url,
                success: function (response) {
                    toastMessage("success", response.msg)
                    setTimeout(function(){
                        window.location = redirect;
                    }, 1000)
                },
                error: function (xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")")
                    toastMessage("error", err.header.message)
                }
            })
        }
    })
}



function toastMessage(status, msg) {
    Swal.fire(
        {
            "title": msg,
            "text": "",
            "timer": 5000,
            "width": "32rem",
            "padding": "1.25rem",
            "showConfirmButton": false,
            "showCloseButton": true,
            "timerProgressBar": false,
            "customClass": {
              "container": null,
              "popup": null,
              "header": null,
              "title": null,
              "closeButton": null,
              "icon": null,
              "image": null,
              "content": null,
              "input": null,
              "actions": null,
              "confirmButton": null,
              "cancelButton": null,
              "footer": null
            },
            "toast": true,
            "icon": status,
            "position": "top-end"
          }
    )

}
