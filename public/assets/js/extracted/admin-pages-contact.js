// Live preview JS
        const input = document.getElementById('map_src_input');
        const preview = document.getElementById('map_preview');

        input.addEventListener('input', function () {
            if (this.value.trim() === '') {
                preview.innerHTML = '';
                return;
            }

            preview.innerHTML = `<iframe src="${this.value}" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen></iframe>`;
        });
