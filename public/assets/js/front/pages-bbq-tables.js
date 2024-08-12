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
        url: baseUrl + 'dataTableJson/bbq-pengajuan',
        "data": function(d){
            d.pegawai_id = (pegawaiId) ? pegawaiId : null;;
        }
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
            var tglReg = moment(full.pengajuan_tanggal, 'YYYY-MM-DD HH:mm:ss', 'id').format('DD-MMM-YYYY  HH:mm:ss');

            var $row_output =
                '<div class="d-flex justify-content-start align-items-center">' +
                ' <div class="d-flex flex-column">' +
                '<span class="fw-semibold">' +
                full.mulai_ayat_ke + ' s.d ' + full.sampai_ayat_ke + 
                '</span>' +
                '<small class="text-truncate text-muted">  Tanggal. ' + tglReg + '</small>' +
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
            var tglUji = (full.mentor_jadwal) ? moment(full.mentor_jadwal, 'YYYY-MM-DD HH:mm:ss', 'id').format('DD-MMM-YYYY  HH:mm:ss') : 'Belum dibuat';
            var mentor = full.mentor;
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              '<div class="d-flex flex-column">' +
              ' ' + mentor.name +
              '<small class="text-truncate text-muted">  Pertemuan. ' + tglUji + ' ' + full.mentor_lokasi + '</small>' +
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


  $('.dt-table-bbq1').on('click', '.delete-record', function () {
    var bbqId = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          url: `${baseUrl}json/bbq/${bbqId}`,
          type: 'DELETE',
          success: function () {
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: 'The record has been deleted!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
            bbqTable1.ajax.reload(null, false);
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

        // success sweetalert
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'The record is not deleted!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
  
});
