/**
 *  Page bbq create
 */

'use strict';

$(function () {
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
});

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        $('.select2_surat').select2({
            dropdownParent: $('#card-ranting'),
            dropdownCssClass: 'no-index',
            ajax: {
              url: `${baseUrl}dataTableJson/alquran?order[0][column]=1&order[0][dir]=desc`,
              data: function (params) {
                var query = {
                  search: params.term,
                  length:1000
                  
                  /*roles_id: 3*/
                }
                return query;
              },
              processResults: function (data) {
                const rows = data.data.map(item => {
                  const pilih = {};
                  pilih.id = item.id;
                  pilih.text = item.nama_surat + ' (' + item.jumlah_ayat + ' ayat)';
                  return pilih;
                })
                return {
                  results: rows
                };
              }
            }
        });

        const formAdd = document.getElementById('formBbq');
        formAdd.addEventListener("submit", (e) => {
            e.preventDefault();
            $.ajax({
                data: $('#formBbq').serialize(),
                url:  `${baseUrl}json/bbq`,
                type:  'POST',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Good Job!`,
                        text: `Data berhasil simpan.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });
                    setTimeout(() => {
                      window.location.href = `${baseUrl}home`;
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