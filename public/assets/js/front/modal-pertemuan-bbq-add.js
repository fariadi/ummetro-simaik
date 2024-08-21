
/**
 *  Modal ranting aktivitas add
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

$(function () {
    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
});

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        $("#mentor_jadwal").datepicker({ format: "dd/mm/yyyy" });
        $("#mentor_jam").timepicker({ timeFormat: "H:i:s" });
        
        const formPertemuan = document.getElementById('formPertemuan');

        formPertemuan.addEventListener("submit", (e) => {
            e.preventDefault();

            var dataJson = formJSON(document.querySelector('#formPertemuan'));
            var dataID = dataJson.id;
            $.ajax({
                data: $('#formPertemuan').serialize(),
                url:  `${baseUrl}json/mentor/${dataID}/pertemuan`,
                type: 'PUT',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Good Job!`,
                        text: `Data pertemuan berhasil simpan.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });

                    setTimeout(() => {
                        $('#modal-pertemuan-add').modal('hide');
                    }, 300);
                    
                    if ( $.fn.DataTable.isDataTable( '.dt-table-bbq1' ) ) {
                        var dtTable = new $.fn.dataTable.Api( '.dt-table-bbq1' );
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