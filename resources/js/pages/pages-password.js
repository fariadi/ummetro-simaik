/**
 * Account Settings - Security
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
    const formChangePass = document.querySelector('#formAccountSettings');

    // Form validation for Change password
    if (formChangePass) {
      const fv = FormValidation.formValidation(formChangePass, {
        fields: {
          new_password: {
            validators: {
              notEmpty: {
                message: 'Please enter new password'
              },
              stringLength: {
                min: 8,
                message: 'Password must be more than 8 characters'
              }
            }
          },
          confirm_new_password: {
            validators: {
              notEmpty: {
                message: 'Please confirm new password'
              },
              identical: {
                compare: function () {
                  return formChangePass.querySelector('[name="new_password"]').value;
                },
                message: 'The password and its confirm are not the same'
              },
              stringLength: {
                min: 8,
                message: 'Password must be more than 8 characters'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.col-md-8'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          // Submit the form when all fields are valid
          // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function () {
        $.ajax({
            data: $('#formAccountSettings').serialize(),
            url: `${baseUrl}json/peserta/password`,
            type: 'PUT',
            success: function (status) {
              Swal.fire({
                icon: 'success',
                title: `Ok!.`,
                text: `Password berhasil di update.`,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            },
            error: function (err) {
              var response = err.responseJSON;
              Swal.fire({
                title: 'Opps!',
                text: response.messages,
                icon: 'error',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
        });
      });
    }
  })();
});

// Select2 (jquery)
$(function () {
  var select2 = $('.select2');

  // Select2 API Key
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        dropdownParent: $this.parent()
      });
    });
  }
});
