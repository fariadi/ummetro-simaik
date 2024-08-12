/**
 * Page Mahasiswa
 */

'use strict';

$(function () {
  var dt_table1 = $('.dt-table-1');

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_table1.length) {
    var dtTable1 = dt_table1.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'dataTableJson/alquran'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'surat_ke' },
        { data: 'nama_surat' },
        { data: 'action' }
      ],
      order: [[1, 'asc']],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return ++meta.row;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block text-nowrap">' +
              `<button class="btn btn-sm btn-icon on-edit" data-id="${full.id}" data-bs-toggle="modal" data-bs-target="#modal-add"><i class="ti ti-edit"></i></button>` +
              '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="javascript:;" data-id="${full.id}" class="dropdown-item on-delete">Delete</a>` +
              '</div>' +
              '</div>'
            );
          }
        },
        {
          // Client name and Service
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-semibold">' +
              full.surat_ke +
              '</span>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          targets: 2,
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-semibold">' +
              full.nama_surat +
              '</span>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        }
      ],
      dom:
        '<"row me-2"' +
        '<"col-md-2"<"me-3"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
        '>t' +
        '<"row mx-2"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search..'
      },

            buttons: [
              {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Tambah</span>',
                className: 'on-add btn btn-primary mx-3',
                attr: {
                  'data-bs-toggle': 'modal',
                  'data-bs-target': '#modal-add'
                }
              }
            ],
            
    });
  }

  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
    /*
        $('#modal-add-mhs').on('hidden.bs.modal', function () {
          $(this).find('form').trigger('reset');
        })
        */
  }, 300);

  // Delete Record
  $('.dt-table-1').on('click', '.on-delete', function () {
    //dt_mhs_table.row($(this).parents('tr')).remove().draw();
    var dataId = $(this).data('id');
    $.ajax({
      url: `${baseUrl}json/alquran/${dataId}`,
      type: 'DELETE',
      success: function (status) {
        Swal.fire({
          icon: 'success',
          title: `Good Job!`,
          text: `Formulir berhasil dihapus.`,
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        dtTable1.ajax.reload(null, false);
      },
      error: function (err) {
        var response = err.responseJSON;
        Swal.fire({
          title: 'Data Tidak Valid!',
          text: response.messages,
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
});
