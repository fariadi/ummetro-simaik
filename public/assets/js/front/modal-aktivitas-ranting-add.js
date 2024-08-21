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

  $(document).on('click', '.on-add-aktivitas-ranting', function () {
    var pegawaiId = $(this).data('pegawai');
    $('#pegawai_id').val(pegawaiId);
  });
});

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {

        
        $("#aktivitas_tanggal").datepicker({ format: "dd/mm/yyyy" });
        const formAktivitasAdd = document.getElementById('aktivitasRantingForm');
        formAktivitasAdd.addEventListener("submit", (e) => {
            e.preventDefault();

            var dataJson = formJSON(document.querySelector('#aktivitasRantingForm'));
            var dataID = dataJson.id;
            $.ajax({
                data: $('#aktivitasRantingForm').serialize(),
                url:  (dataID) ? `${baseUrl}json/aktifitas-ranting/${dataID}` : `${baseUrl}json/aktifitas-ranting`,
                type: (dataID) ? 'PUT' : 'POST',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Good Job!`,
                        text: `Data aktifitas berhasil simpan.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });

                    setTimeout(() => {
                        $('#modal-aktvts-ranting-add').modal('hide');
                    }, 300);
                    /*
                    if ( $.fn.DataTable.isDataTable( '.dt-table-1' ) ) {
                        var dtTable = new $.fn.dataTable.Api( '.dt-table-1' );
                        dtTable.draw();
                    }
                    */
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