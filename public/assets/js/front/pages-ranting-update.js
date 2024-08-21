/**
 *  Page auth register multi-steps
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
        var kodeProv = '',
            kodeKab  = '';
        $('.select2_prov').select2({
            dropdownParent: $('#card-ranting'),
            dropdownCssClass: 'no-index',
            ajax: {
              url: `${baseUrl}json/wil/prov`,
              data: function (params) {
                var query = {
                  search: params.term,
                  /*roles_id: 3*/
                }
                return query;
              },
              processResults: function (data) {
                const rows = data.data.map(item => {
                  const pilih = {};
                  pilih.id = item.kode;
                  pilih.text = item.nama;
                  return pilih;
                })
                return {
                  results: rows
                };
              }
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            kodeProv = data.id;
        });

        $('.select2_kab').select2({
            dropdownParent: $('#card-ranting'),
            dropdownCssClass: 'no-index',
            ajax: {
              url: `${baseUrl}json/wil/kab`,
              data: function (params) {
                var query = {
                  search: params.term,
                  prov: kodeProv
                }
                return query;
              },
              processResults: function (data) {
                const rows = data.data.map(item => {
                  const pilih = {};
                  pilih.id = item.kode;
                  pilih.text = item.nama;
                  return pilih;
                })
                return {
                  results: rows
                };
              }
            }
        }).on('select2:select', function (e) {
            var data = e.params.data;
            kodeKab = data.id;
        });

        $('.select2_kec').select2({
            dropdownParent: $('#card-ranting'),
            dropdownCssClass: 'no-index',
            ajax: {
              url: `${baseUrl}json/wil/kec`,
              data: function (params) {
                var query = {
                  search: params.term,
                  kab: kodeKab
                }
                return query;
              },
              processResults: function (data) {
                const rows = data.data.map(item => {
                  const pilih = {};
                  pilih.id = item.kode;
                  pilih.text = item.nama;
                  return pilih;
                })
                return {
                  results: rows
                };
              }
            }
        });

        const formAdd = document.getElementById('formRanting');
        formAdd.addEventListener("submit", (e) => {
            e.preventDefault();
            $.ajax({
                data: $('#formRanting').serialize(),
                url:  `${baseUrl}json/pegawai/${pegawaiId}/ranting`,
                type:  'PUT',
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
                      window.location.href = `${baseUrl}`;
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