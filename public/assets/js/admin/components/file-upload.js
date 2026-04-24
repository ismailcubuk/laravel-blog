document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-file-upload]').forEach(function (root) {
                const input = root.querySelector('.pro-upload-input');
                const nameTag = root.querySelector('[data-file-name]');
                if (!input || !nameTag) {
                    return;
                }

                input.addEventListener('change', function () {
                    const file = input.files && input.files[0];
                    nameTag.textContent = file ? file.name : 'No file selected';
                });
            });
        });
