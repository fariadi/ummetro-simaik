
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

let bbqGet = (params, callback) => {
    return new Promise(function(resolve, reject) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:  `${baseUrl}json/bbq/${params.id}`,
            type: 'GET',
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (response) {
                resolve(response.data);
            },
            error: function (err) {
                var messages = err.responseJSON?.messages || 'Data tidak valid'
                reject(new Error(messages));
            }
        });
    });
}
(async function () {  
    const modalValidasi = async (params)=> {
        try {
            const bbq = await bbqGet(params);
            $('#validasi_bbq_id').val(bbq.id);
            $('#dd-nama').text(bbq.pegawai.nama_lengkap);
            $('#dd-surah').text(bbq.surah.nama_surat);
            $('#dd-ayatke').text(bbq.mulai_ayat_ke + ' s.d ' + bbq.sampai_ayat_ke);
        }
        catch(err) {
            Swal.fire({
              title: 'Error!',
              text: err.message,
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            $.unblockUI();
        }
    }
    
    $('.dt-table-bbq1').on('click', '.on-validasi', function () {
        //dt_mhs_table.row($(this).parents('tr')).remove().draw();
        var bbqId = $(this).data('id');
        modalValidasi({id : bbqId})
    });
})(bbqGet);

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {  
        const formPertemuan = document.getElementById('formValidasi');
        
        formValidasi.addEventListener("submit", (e) => {
            e.preventDefault();

            var dataJson = formJSON(document.querySelector('#formValidasi'));
            var dataID = dataJson.id;
            $.ajax({
                data: $('#formValidasi').serialize(),
                url:  `${baseUrl}json/bbq/${dataID}/validasi`,
                type: 'PUT',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Good Job!`,
                        text: `Ajuan berhasil divalidasi.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });

                    setTimeout(() => {
                        if ( $.fn.DataTable.isDataTable( '.dt-table-bbq1' ) ) {
                            var dtTable = new $.fn.dataTable.Api( '.dt-table-bbq1' );
                            dtTable.reload(null,false);
                        }
                        
                        $('#modal-validasi').modal('hide');
                    }, 300);
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