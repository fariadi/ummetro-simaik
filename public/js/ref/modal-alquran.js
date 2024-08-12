/**
 * Edit User
 */

'use strict';

function formJSON(form) {
    const array = $(form).serializeArray();
    const json = {};
    $.each(array, function () {
      json[this.name] = this.value || '';
    });
    return json;
}

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        

        const formAdd = document.getElementById('addAlquranForm');
        formAdd.addEventListener("submit", (e) => {
            e.preventDefault();

            var dataJson = formJSON(document.querySelector('#addAlquranForm'));
            var dataID = dataJson.id;
            $.ajax({
                data: $('#addAlquranForm').serialize(),
                url:  (dataID) ? `${baseUrl}json/alquran/${dataID}` : `${baseUrl}json/alquran`,
                type: (dataID) ? 'PUT' : 'POST',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Goog Job!`,
                        text: `Data berhasil simpan.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });

                    setTimeout(() => {
                        $('#modal-add').modal('hide');
                    }, 300);
                    
                    if ( $.fn.DataTable.isDataTable( '.dt-table-1' ) ) {
                        var dtTable = new $.fn.dataTable.Api( '.dt-table-1' );
                        dtTable.draw();
                    }
                },
                error: function (err) {
                    var response = err.responseJSON;
                    Swal.fire({
                        title: 'Data Tidak Valid!',
                        text: response?.messages || 'Data tidak valid',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    });
                }
            });
        })
    })();
});

$(function () {
    $(document).on('click', '.on-add', function () {
        $('#id').val('');
    });
    $(document).on('click', '.on-edit', function () {
        var id = $(this).data('id');
        $.get(`${baseUrl}json\/alquran\/${id}`, function (response) {
          const data = response.data;
          FormDataJson.fromJson(document.querySelector('#addAlquranForm'), data);
          $('#id').val(id);
        });
    });
});
