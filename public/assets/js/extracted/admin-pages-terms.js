document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('termsTitleInput');
        const bodyInput = document.getElementById('termsDescriptionInput');
        const previewTitle = document.getElementById('termsPreviewTitle');
        const previewBody = document.getElementById('termsPreviewBody');
        const meta = document.getElementById('termsEditorMeta');

        if (!titleInput || !bodyInput || !previewTitle || !previewBody || !meta) {
            return;
        }

        const syncPreview = function (content) {
            previewTitle.textContent = titleInput.value.trim() || 'Terms of Use';
            previewBody.innerHTML = content || '<p>Terms content will appear here.</p>';
            meta.textContent = `${(content || '').length} chars`;
        };

        titleInput.addEventListener('input', () => syncPreview(bodyInput.value));

        if (!window.ClassicEditor) {
            bodyInput.addEventListener('input', () => syncPreview(bodyInput.value));
            syncPreview(bodyInput.value);
            return;
        }

        window.ClassicEditor.create(bodyInput, {
            toolbar: [
                'heading', '|',
                'bold', 'italic', 'link', '|',
                'bulletedList', 'numberedList', 'blockQuote', '|',
                'undo', 'redo'
            ]
        }).then((editor) => {
            const update = () => {
                const data = editor.getData();
                bodyInput.value = data;
                syncPreview(data);
            };

            editor.model.document.on('change:data', update);
            update();
        }).catch(() => {
            bodyInput.addEventListener('input', () => syncPreview(bodyInput.value));
            syncPreview(bodyInput.value);
        });

        syncPreview(bodyInput.value);
    });
