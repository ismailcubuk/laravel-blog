(() => {
        const imageInput = document.getElementById('image');
        const preview = document.querySelector('[data-image-preview]');
        const previewImage = preview ? preview.querySelector('img') : null;
        const uploadTrigger = document.querySelector('[data-image-upload-trigger]');
        const editor = document.querySelector('[data-post-editor]');
        const contentInput = document.getElementById('content');
        const count = document.querySelector('[data-editor-count]');
        const fixButton = document.querySelector('[data-proof-fix]');

        const updateCount = () => {
            if (count && contentInput) {
                count.textContent = String(contentInput.value.length);
            }
        };

        const wrapSelection = (before, after = before, fallback = '') => {
            if (!contentInput) {
                return;
            }

            const start = contentInput.selectionStart;
            const end = contentInput.selectionEnd;
            const selected = contentInput.value.slice(start, end) || fallback;
            const replacement = `${before}${selected}${after}`;
            contentInput.setRangeText(replacement, start, end, 'end');
            contentInput.focus();
            updateCount();
        };

        const prefixLines = (prefix) => {
            if (!contentInput) {
                return;
            }

            const start = contentInput.selectionStart;
            const end = contentInput.selectionEnd;
            const selected = contentInput.value.slice(start, end) || 'Liste maddesi';
            const replacement = selected
                .split('\n')
                .map((line, index) => prefix.replace('{n}', String(index + 1)) + line.replace(/^\s+/, ''))
                .join('\n');

            contentInput.setRangeText(replacement, start, end, 'end');
            contentInput.focus();
            updateCount();
        };

        if (contentInput) {
            contentInput.addEventListener('input', updateCount);
            updateCount();
        }

        if (editor) {
            editor.addEventListener('click', (event) => {
                const button = event.target.closest('[data-editor-action]');

                if (!button) {
                    return;
                }

                const action = button.dataset.editorAction;

                if (action === 'bold') wrapSelection('**', '**', 'kalin metin');
                if (action === 'italic') wrapSelection('*', '*', 'italik metin');
                if (action === 'unordered') prefixLines('- ');
                if (action === 'ordered') prefixLines('{n}. ');
                if (action === 'quote') prefixLines('> ');
                if (action === 'link' && contentInput) {
                    const start = contentInput.selectionStart;
                    const end = contentInput.selectionEnd;
                    const selected = contentInput.value.slice(start, end).trim();
                    const selectedLooksLikeUrl = /^(https?:\/\/|\/|#)/.test(selected);
                    const defaultUrl = selectedLooksLikeUrl ? selected : 'https://';
                    const url = prompt('Baglanti adresi', defaultUrl);

                    if (url) {
                        const text = selected && !selectedLooksLikeUrl ? selected : prompt('Baglanti metni', 'baglanti metni');

                        if (text) {
                            contentInput.setRangeText(`[${text}](${url})`, start, end, 'end');
                            contentInput.focus();
                            updateCount();
                        }
                    }
                }
                if (action === 'emoji') wrapSelection('', ' :)', '');
                if (action === 'gif' && contentInput) {
                    const url = prompt('GIF adresi', 'https://');

                    if (url) {
                        contentInput.setRangeText(`[GIF: ${url}]`, contentInput.selectionStart, contentInput.selectionEnd, 'end');
                        contentInput.focus();
                        updateCount();
                    }
                }
                if (action === 'code') wrapSelection('`', '`', 'kod');
                if (action === 'clear' && contentInput && confirm('İçerik temizlensin mi?')) {
                    contentInput.value = '';
                    contentInput.focus();
                    updateCount();
                }
                if (action === 'fullscreen') {
                    editor.classList.toggle('is-expanded');
                    button.querySelector('i')?.classList.toggle('fa-compress');
                    button.querySelector('i')?.classList.toggle('fa-expand');
                }
            });
        }

        if (fixButton && contentInput) {
            fixButton.addEventListener('click', () => {
                const punctuation = document.querySelector('[data-proof-option="punctuation"]')?.checked;
                const capital = document.querySelector('[data-proof-option="capital"]')?.checked;
                let value = contentInput.value;

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

                contentInput.value = value;
                contentInput.focus();
                updateCount();
            });
        }

        if (uploadTrigger && imageInput) {
            uploadTrigger.addEventListener('click', () => imageInput.click());
        }

        if (!imageInput || !preview || !previewImage) {
            return;
        }

        imageInput.addEventListener('change', () => {
            const file = imageInput.files && imageInput.files[0];
            if (!file) {
                previewImage.src = '';
                previewImage.hidden = true;
                preview.classList.remove('has-image');
                return;
            }

            previewImage.src = URL.createObjectURL(file);
            previewImage.hidden = false;
            preview.classList.add('has-image');
        });
    })();

