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
        $('.select2_mentor').select2({
            dropdownParent: $('#modal-mentor-add'),
            ajax: {
              url: `${baseUrl}dataTableJson/users`,
              data: function (params) {
                var query = {
                  search: { value : params.term },
                  roles_id : 3
                }
                return query;
              },
              processResults: function (data) {
                const rows = data.data.map(item => {
                  const sp = {};
                  sp.id = item.id;
                  sp.text = item.name;
                  return sp;
                })
                return {
                  results: rows
                };
              }
            }
        }).on('select2:select', function (e) {
          var data = e.params.data;
          
        });;

        const formMentor = document.getElementById('formMentor');
        formMentor.addEventListener("submit", (e) => {
            e.preventDefault();

            var dataJson = formJSON(document.querySelector('#formMentor'));
            var mentor_id = dataJson.id;
            $.ajax({
                data: $('#formMentor').serialize(),
                url:  (mentor_id) ? `${baseUrl}json/mentor/${mentor_id}` :  `${baseUrl}json/mentor` ,
                type: (mentor_id) ? 'PUT' : 'POST',
                success: function (status) {
                    Swal.fire({
                        icon: 'success',
                        title: `Good Job!`,
                        text: `Mentor berhasil ditetapkan.`,
                        customClass: {
                        confirmButton: 'btn btn-success'
                        }
                    });

                    setTimeout(() => {
                        $('#modal-mentor-add').modal('hide');
                    }, 300);
                    
                    if ( $.fn.DataTable.isDataTable( '.dt-table-users' ) ) {
                        var usersDtTable = new $.fn.dataTable.Api( '.dt-table-users' );
                        usersDtTable.ajax.reload(null,false);
                        //usersDtTable.draw();
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
