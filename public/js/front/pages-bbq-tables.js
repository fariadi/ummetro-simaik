/**
 * Page Mahasiswa
 */

'use strict';

$(function () {
  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  var dtBbqTable1 = $('.dt-table-bbq1');

  if (dtBbqTable1.length) {
    var bbqTable1 = dtBbqTable1.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'dataTableJson/bbq-pengajuan'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'pegawai_id' },
        { data: 'surat_id' },
        { data: '' },
        { data: 'action' }
      ],
      order: [[1, 'desc']],
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
              '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="javascript:;" data-id="${full.id}" class="dropdown-item delete-record">Delete</a>` +
              '</div>' +
              '</div>'
            );
          }
        },
        {
            targets: 1,
            searchable: false,
            orderable: false,
            render: function (data, type, full, meta) {
              /* var tglLhr = moment(full.tgl_lahir, "YYYY-MM-DD", 'id').format("DD-MMM-YYYY"); */
              var $row_output =
                '<div class="d-flex justify-content-start align-items-center">' +
                ' <div class="d-flex flex-column">' +
                '<span class="fw-semibold">' +
                full.surah.nama_surat +
                '</span>' +
                '<small class="text-truncate text-muted"> Surah ke-. ' +
                full.surah.surat_ke +
                '</small>' +
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
            /* var tglLhr = moment(full.tgl_lahir, "YYYY-MM-DD", 'id').format("DD-MMM-YYYY"); */
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              ' <div class="d-flex flex-column">' +
              '<span class="fw-semibold">' +
              full.mulai_ayat_ke + ' s.d ' + full.sampai_ayat_ke
              '</span>' +
              '<small class="text-truncate text-muted">  ' +
     
              '</small>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          targets: 3,
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            var tglReg = moment(full.tgl_lahir, 'YYYY-MM-DD', 'id').format('DD-MMM-YYYY');
            var $roles = full.tmpt_lahir;
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              ' <div class="d-flex flex-column">' +
              ' ' +
              '<small class="text-truncate text-muted"> Tanggal. ' +
              ' ' +
              '</small>' +
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

});
