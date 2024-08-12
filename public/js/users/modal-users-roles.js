/**
 * Edit User
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

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        

        const formRoles = document.getElementById('form-role-user');
        formRoles.addEventListener("submit", (e) => {
            e.preventDefault();

            var dataJson = formJSON(document.querySelector('#form-role-user'));
            var users_id = dataJson.id;
            $.ajax({
                data: $('#form-role-user').serialize(),
                url:  `${baseUrl}json/users/${users_id}/role` ,
                type: 'PUT',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Goog Job!`,
                        text: `Roles berhasil diubah.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });

                    setTimeout(() => {
                        $('#modal-roles').modal('hide');
                    }, 300);
                    
                    if ( $.fn.DataTable.isDataTable( '.dt-table-users' ) ) {
                        var usersDtTable = new $.fn.dataTable.Api( '.dt-table-users' );
                        usersDtTable.draw();
                    }
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
        })
    })();
});

$(function () {
    $(document).on('click', '.on-roles', function () {
        var user_id = $(this).data('id');
    
        $.get(`${baseUrl}json\/users\/${user_id}`, function (response) {
          const data = response.data;
          FormDataJson.fromJson(document.querySelector('#form-role-user'), data);
          $('#role_user_id').val(user_id);
        });
    });
});
