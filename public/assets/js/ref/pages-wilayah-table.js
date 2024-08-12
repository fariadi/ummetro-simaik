/**
 * Page Mahasiswa
 */

'use strict';

$(function () {
  var dt_wil_table = $('.dt-table-wil');

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_wil_table.length) {
    var dt_wilayah = dt_wil_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'dataTableJson/wilayah'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'kode' },
        { data: 'nama' },
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
              `<button class="btn btn-sm btn-icon on-edit-user" data-id="${full.id}" data-bs-toggle="modal" data-bs-target="#modal-add-user"><i class="ti ti-edit"></i></button>` +
              '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="javascript:;" data-id="${full.id}" class="on-login-as dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-login-as">Login As</a>` +
              `<a href="javascript:;" data-id="${full.id}" class="on-roles dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-roles">Roles</a>` +
              `<a href="javascript:;" data-id="${full.id}" class="dropdown-item delete-record">Delete</a>` +
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
              full.kode +
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
              full.nama +
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
      buttons: []
      /*
            buttons: [
              {
                text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Tambah Mahasiswa</span>',
                className: 'modal-add-mhs btn btn-primary mx-3',
                attr: {
                  'data-bs-toggle': 'modal',
                  'data-bs-target': '#modal-add-mhs'
                }
              }
            ],
            */
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

  $(document).on('click', '.on-edit-user', function () {
    var user_id = $(this).data('id');

    // changing the title of offcanvas
    $('#modalTitleLabel').html('Edit Users');

    $.get(`${baseUrl}json\/mahasiswa\/${user_id}`, function (response) {
      const data = response.data;
      FormDataJson.fromJson(document.querySelector('#addMhsModalForm'), data);
      $('#id_agama').trigger('change');
    });
  });

  $(document).on('click', '.on-login-as', function () {
    var user_id = $(this).data('id');

    $.get(`${baseUrl}json\/users\/${user_id}`, function (response) {
      const data = response.data;
      FormDataJson.fromJson(document.querySelector('#loginAsModalForm'), data);
    });
  });

  // Delete Record
  $('.dt-table-wil').on('click', '.delete-record', function () {
    //dt_mhs_table.row($(this).parents('tr')).remove().draw();
    var formulirId = $(this).data('id');
    $.ajax({
      url: `${baseUrl}json/users/${formulirId}`,
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
        dt_wilayah.ajax.reload(null, false);
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
