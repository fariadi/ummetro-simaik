/**
 *  Page auth register multi-steps
 */

'use strict';

// Select2 (jquery)
$(function () {
  var select2 = $('.select2'),
    bsDatepickerFormat = $('#tgl_lahir');

  // select2
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        placeholder: 'Pilih',
        dropdownParent: $this.parent()
      });
    });
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  if (bsDatepickerFormat.length) {
    bsDatepickerFormat.datepicker({
      todayHighlight: true,
      format: 'dd/mm/yyyy',
      orientation: isRtl ? 'auto right' : 'auto left'
    });
  }
});

// Multi Steps Validation
// --------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const stepsValidation = document.querySelector('#multiStepsValidation');
    if (typeof stepsValidation !== undefined && stepsValidation !== null) {
      // Multi Steps form
      const stepsValidationForm = stepsValidation.querySelector('#formRegister');
      // Form steps
      const stepsValidationFormStep0= stepsValidationForm.querySelector('#accountDetailsValidation');
      const stepsValidationFormStep1 = stepsValidationForm.querySelector('#personalInfoValidation');
      // Multi steps next prev button
      const stepsValidationNext = [].slice.call(stepsValidationForm.querySelectorAll('.btn-next'));
      const stepsValidationPrev = [].slice.call(stepsValidationForm.querySelectorAll('.btn-prev'));

      const multiStepsExDate = document.querySelector('.multi-steps-exp-date'),
        multiStepsMobile = document.querySelector('.multi-steps-mobile');

      // Expiry Date Mask
      if (multiStepsExDate) {
        new Cleave(multiStepsExDate, {
          date: true,
          delimiter: '/',
          datePattern: ['m', 'y']
        });
      }

      // Mobile
      if (multiStepsMobile) {
        new Cleave(multiStepsMobile, {
          phone: true,
          phoneRegionCode: 'US'
        });
      }

      let validationStepper = new Stepper(stepsValidation, {
        linear: true
      });

      var formSection = $('.form-block');

      // Biodata Mahasiswa
      const multiSteps0 = FormValidation.formValidation(stepsValidationFormStep0, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Nama Lengkap'
              },
              stringLength: {
                min: 2,
                max: 255,
                message: 'The name must be more than 2 and less than 255 characters long'
              },
              regexp: {
                regexp: /[a-zA-Z ]+$/,
                message: 'The name can only consist of alphabetical, number and space'
              }
            }
          },
          tmpt_lahir: {
            validators: {
              notEmpty: {
                message: 'Tempat Lahir'
              },
              stringLength: {
                min: 2,
                max: 100,
                message: 'The name must be more than 2 and less than 100 characters long'
              }
            }
          },
          tgl_lahir: {
            validators: {
              notEmpty: {
                message: 'Tanggal Lahir'
              }
            }
          },
          telepon_seluler: {
            validators: {
              notEmpty: {
                message: 'Tempat Lahir'
              },
              stringLength: {
                min: 8,
                max: 14,
                message: 'The name must be more than 2 and less than 14 characters long'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Alamat email'
              },
              emailAddress: {
                message: 'The value is not a valid email address'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            // Use this for enabling/changing valid/invalid class
            // eleInvalidClass: '',
            eleValidClass: '',
            rowSelector: '.col-sm-6'
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function () {
        // Jump to the next step when all fields in the current step are valid
        validationStepper.next();
      });

      // Personal info
      const multiSteps1 = FormValidation.formValidation(stepsValidationFormStep1, {
        fields: {
          password: {
            validators: {
              notEmpty: {
                message: 'Please enter your password'
              },
              stringLength: {
                min: 2,
                message: 'Password must be more than 2 characters'
              }
            }
          },
          password_confirmation: {
            validators: {
              notEmpty: {
                message: 'Please confirm password'
              },
              identical: {
                compare: function () {
                  return stepsValidationForm.querySelector('[name="password"]').value;
                },
                message: 'The password and its confirm are not the same'
              },
              stringLength: {
                min: 6,
                message: 'Password must be more than 6 characters'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            // Use this for enabling/changing valid/invalid class
            // eleInvalidClass: '',
            eleValidClass: '',
            rowSelector: function (field, ele) {
              // field is the field name
              // ele is the field element
              switch (field) {
                case 'no_seri_ijazah':
                  return '.col-sm-4';
                default:
                  return '.mb-3';
              }
            }
          }),
          autoFocus: new FormValidation.plugins.AutoFocus(),
          submitButton: new FormValidation.plugins.SubmitButton()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      }).on('core.form.valid', function () {
  
        formSection.block({
          message: '<div class="spinner-border text-primary" role="status"></div>',
          css: {
            backgroundColor: 'transparent',
            border: '0'
          },
          overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8
          }
        });
        $.ajax({
            data: $('#formRegister').serialize(),
            url: `${baseUrl}auth/register`,
            type: 'POST',
            success: function (status) {
              formSection.unblock();
              Swal.fire({
                icon: 'success',
                title: `Pendaftaran akun berhasil!`,
                text: `Terimakasih!. anda berhasil membuat akun pendaftran di universitas muhammadiyah metro`,
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
              setTimeout(() => {
                location.href = `${baseUrl}page/pegawai`
              }, 1000);
            },
            error: function (err) {
              var response = err.responseJSON;
              Swal.fire({
                title: 'Duplicate Entry!',
                text: response.messages,
                icon: 'error',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
              formSection.unblock();
            }
        });
      });

      stepsValidationNext.forEach(item => {
        item.addEventListener('click', event => {
          // When click the Next button, we will validate the current step
          console.log(validationStepper._currentIndex, 'validationStepper._currentIndex');
          switch (validationStepper._currentIndex) {
            case 0:
                multiSteps0.validate();
              break;
            case 1:
                multiSteps1.validate();
              break;
            default:
              break;
          }
        });
      });

      stepsValidationPrev.forEach(item => {
        item.addEventListener('click', event => {
          switch (validationStepper._currentIndex) {
            case 2:
              validationStepper.previous();
              break;

            case 1:
              validationStepper.previous();
              break;

            case 0:

            default:
              break;
          }
        });
      });
    }
  })();
});
