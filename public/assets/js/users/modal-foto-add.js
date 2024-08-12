/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Update/reset user image of account page
        let accountUserImage = document.getElementById('uploadedAvatar');
        const fileInput = document.querySelector('.account-file-input'),
        resetFileInput = document.querySelector('.account-image-reset');

        if (accountUserImage) {
        const resetImage = accountUserImage.src;
        fileInput.onchange = () => {
            if (fileInput.files[0]) {
                var formData = new FormData();
                formData.append('image', fileInput.files[0]);
                $.ajax({
                    type: 'POST',
                    url: `${baseUrl}json/user/photo`,    
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: `Goog Job!`,
                            text: `Foto berhasil di unggah.`,
                            customClass: {
                              confirmButton: 'btn btn-success'
                            }
                        });
                    },
                    error: function (err) {
                        Swal.fire({
                            title: 'Error data!',
                            text: 'Foto gagal di unggah.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
                accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
            }
        };
        resetFileInput.onclick = () => {
            fileInput.value = '';
            accountUserImage.src = resetImage;
        };
        }
    })();
});