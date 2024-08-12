/**
 * Page Mahasiswa
 */

'use strict';

$(function () {
  var dt_pegawai_table = $('.dt-table-users');

  // ajax setup
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (dt_pegawai_table.length) {
    var dt_pegawai = dt_pegawai_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'dataTableJson/pegawai'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        { data: 'nm_sdm' },
        { data: 'tgl_lahir' },
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
              `<button class="btn btn-sm btn-icon on-edit-user" data-id="${full.id}" data-bs-toggle="modal" data-bs-target="#modal-add-user"><i class="ti ti-edit"></i></button>` +
              '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>' +
              '<div class="dropdown-menu dropdown-menu-end m-0">' +
              `<a href="${baseUrl}page/pegawai/${full.id}/create" class="dropdown-item">Registrasi Akun</a>` +
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
            var $service = full.nbm,
              $name = full.nm_sdm,
              $image = true /*full['avatar_image'], */,
              /*$rand_num = Math.floor(Math.random() * 11) + 1,*/
              /*$user_img = $rand_num + '.png';*/
              $user_img = '0.png';

            if ($image === true) {
              // For Avatar image
              var $output =
                '<img src="' + assetsPath + 'img/avatars/' + $user_img + '" alt="Avatar" class="rounded-circle">';
            } else {
              // For Avatar badge
              var stateNum = Math.floor(Math.random() * 6),
                states = ['success', 'danger', 'warning', 'info', 'primary', 'secondary'],
                $state = states[stateNum],
                $name = full['nm_sdm'],
                $initials = $name.match(/\b\w/g) || [];

              $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
              $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
            }
            // Creates full output for row
            var $detailUrl = baseUrl + 'page/pegawai/' + full.id;
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-2">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<a href="' +
              $detailUrl +'" class="text-body text-truncate"><span class="fw-semibold">' +
              $name +
              '</span></a>' +
              '<small class="text-truncate text-muted">' +
              'NBM. ' + $service +
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
              full.no_hp +
              '</span>' +
              '<small class="text-truncate text-muted"> Alamat. ' +
              full.jln +
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
              $roles +
              '<small class="text-truncate text-muted"> Tanggal. ' +
              tglReg +
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
