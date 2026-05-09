(() => {
    document.querySelectorAll('.admin-post-form').forEach((form) => {
        const imageInput = form.querySelector('[data-post-image]');
        const imagePreviewBox = form.querySelector('[data-image-preview-box]');

        imageInput?.addEventListener('change', () => {
            const file = imageInput.files && imageInput.files[0];

            if (!file || !imagePreviewBox) {
                return;
            }

            imagePreviewBox.classList.remove('is-empty');
            imagePreviewBox.innerHTML = '';

            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = file.name;
            imagePreviewBox.appendChild(image);
        });
    });

    document.querySelectorAll('[data-admin-post-editor]').forEach((editor) => {
        const input = editor.querySelector('textarea');
        const count = editor.querySelector('[data-editor-count]');
        const proof = editor.parentElement?.querySelector('.admin-post-editor-proof');
        const fixButton = proof?.querySelector('[data-proof-fix]');

        const updateCount = () => {
            if (count && input) {
                count.textContent = String(input.value.length);
            }
        };

        const wrapSelection = (before, after = before, fallback = '') => {
            if (!input) {
                return;
            }

            const start = input.selectionStart;
            const end = input.selectionEnd;
            const selected = input.value.slice(start, end) || fallback;
            input.setRangeText(`${before}${selected}${after}`, start, end, 'end');
            input.focus();
            updateCount();
        };

        const prefixLines = (prefix) => {
            if (!input) {
                return;
            }

            const start = input.selectionStart;
            const end = input.selectionEnd;
            const selected = input.value.slice(start, end) || 'List item';
            const replacement = selected
                .split('\n')
                .map((line, index) => prefix.replace('{n}', String(index + 1)) + line.replace(/^\s+/, ''))
                .join('\n');

            input.setRangeText(replacement, start, end, 'end');
            input.focus();
            updateCount();
        };

        updateCount();
        input?.addEventListener('input', updateCount);

        editor.addEventListener('click', (event) => {
            const button = event.target.closest('[data-editor-action]');

            if (!button || !input) {
                return;
            }

            const action = button.dataset.editorAction;

            if (action === 'bold') wrapSelection('**', '**', 'bold text');
            if (action === 'italic') wrapSelection('*', '*', 'italic text');
            if (action === 'unordered') prefixLines('- ');
            if (action === 'ordered') prefixLines('{n}. ');
            if (action === 'quote') prefixLines('> ');
            if (action === 'code') wrapSelection('`', '`', 'code');
            if (action === 'clear' && confirm('Clear content?')) {
                input.value = '';
                input.focus();
                updateCount();
            }
            if (action === 'fullscreen') {
                editor.classList.toggle('is-expanded');
                button.querySelector('i')?.classList.toggle('bi-arrows-angle-contract');
                button.querySelector('i')?.classList.toggle('bi-arrows-fullscreen');
            }
            if (action === 'link') {
                const start = input.selectionStart;
                const end = input.selectionEnd;
                const selected = input.value.slice(start, end).trim();
                const selectedLooksLikeUrl = /^(https?:\/\/|\/|#)/.test(selected);
                const url = prompt('Link URL', selectedLooksLikeUrl ? selected : 'https://');

                if (url) {
                    const text = selected && !selectedLooksLikeUrl ? selected : prompt('Link text', 'link text');

                    if (text) {
                        input.setRangeText(`[${text}](${url})`, start, end, 'end');
                        input.focus();
                        updateCount();
                    }
                }
            }
            if (action === 'gif') {
                const url = prompt('GIF URL', 'https://');

                if (url) {
                    input.setRangeText(`[GIF: ${url}]`, input.selectionStart, input.selectionEnd, 'end');
                    input.focus();
                    updateCount();
                }
            }
        });

        fixButton?.addEventListener('click', () => {
            if (!input) {
                return;
            }

            const punctuation = proof.querySelector('[data-proof-option="punctuation"]')?.checked;
            const capital = proof.querySelector('[data-proof-option="capital"]')?.checked;
            let value = input.value;

            if (capital) {
                value = value.replace(/(^|[.!?]\s+|\n+)([a-z])/g, (match, lead, letter) => lead + letter.toUpperCase());
            }

            if (punctuation) {
                value = value
                    .split('\n')
                    .map((line) => {
                        const trimmed = line.trimEnd();
                        return trimmed && !/[.!?:;)]$/.test(trimmed) ? `${trimmed}.` : line;
                    })
                    .join('\n');
            }

            input.value = value;
            input.focus();
            updateCount();
        });
    });
})();
