(function () {
        if (window.__globalSelectEnhanced) {
            return;
        }
        window.__globalSelectEnhanced = true;

        const wrappers = new Set();

        const closeAll = (exceptWrapper = null) => {
            wrappers.forEach((wrapper) => {
                if (!wrapper.isConnected) {
                    wrappers.delete(wrapper);
                    return;
                }
                if (exceptWrapper && wrapper === exceptWrapper) {
                    return;
                }
                wrapper.classList.remove('is-open');
                const trigger = wrapper.querySelector('.gselect-trigger');
                const menu = wrapper.querySelector('.gselect-menu');
                if (trigger) {
                    trigger.setAttribute('aria-expanded', 'false');
                }
                if (menu) {
                    menu.hidden = true;
                }
            });
        };

        const buildOptionButton = (option) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'gselect-option';
            btn.dataset.value = option.value;
            btn.setAttribute('role', 'option');
            btn.setAttribute('aria-selected', option.selected ? 'true' : 'false');
            btn.disabled = option.disabled;

            const dot = document.createElement('span');
            dot.className = 'gselect-option-dot';
            btn.appendChild(dot);

            const text = document.createElement('span');
            text.textContent = option.text;
            btn.appendChild(text);

            const check = document.createElement('i');
            check.className = 'bi bi-check2 gselect-option-check';
            btn.appendChild(check);

            return btn;
        };

        const enhanceSelect = (select) => {
            if (!(select instanceof HTMLSelectElement)) {
                return;
            }

            if (select.dataset.nativeSelect === 'true') {
                return;
            }

            if (select.classList.contains('d-none') || select.hidden) {
                return;
            }

            if (select.multiple || Number(select.size || 0) > 1) {
                return;
            }

            if (select.closest('.gselect')) {
                return;
            }

            const wrapper = document.createElement('div');
            wrapper.className = 'gselect';

            select.parentNode.insertBefore(wrapper, select);
            wrapper.appendChild(select);
            select.classList.add('gselect-native');

            const trigger = document.createElement('button');
            trigger.type = 'button';
            trigger.className = 'gselect-trigger';
            trigger.setAttribute('aria-haspopup', 'listbox');
            trigger.setAttribute('aria-expanded', 'false');

            const label = document.createElement('span');
            label.className = 'gselect-label';
            trigger.appendChild(label);

            const caret = document.createElement('i');
            caret.className = 'bi bi-chevron-down gselect-caret';
            trigger.appendChild(caret);

            const menu = document.createElement('div');
            menu.className = 'gselect-menu';
            menu.setAttribute('role', 'listbox');
            menu.hidden = true;

            const render = () => {
                menu.innerHTML = '';

                const current = select.options[select.selectedIndex] || select.options[0];
                label.textContent = current ? current.text : 'Select';
                trigger.disabled = select.disabled;
                trigger.classList.toggle('is-invalid', select.classList.contains('is-invalid'));

                Array.from(select.options).forEach((option) => {
                    const optionButton = buildOptionButton(option);
                    optionButton.addEventListener('click', () => {
                        if (option.disabled) {
                            return;
                        }
                        if (select.value !== option.value) {
                            select.value = option.value;
                            select.dispatchEvent(new Event('input', { bubbles: true }));
                            select.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                        closeAll();
                    });
                    menu.appendChild(optionButton);
                });
            };

            trigger.addEventListener('click', () => {
                if (trigger.disabled) {
                    return;
                }
                const isOpen = wrapper.classList.contains('is-open');
                if (isOpen) {
                    closeAll();
                    return;
                }
                closeAll(wrapper);
                wrapper.classList.add('is-open');
                trigger.setAttribute('aria-expanded', 'true');
                menu.hidden = false;
            });

            select.addEventListener('change', render);
            select.addEventListener('input', render);

            const observer = new MutationObserver(() => {
                render();
            });
            observer.observe(select, {
                attributes: true,
                childList: true,
                subtree: true,
            });

            wrapper.appendChild(trigger);
            wrapper.appendChild(menu);
            wrappers.add(wrapper);
            render();
        };

        const enhanceAll = (root = document) => {
            root.querySelectorAll('select').forEach((select) => enhanceSelect(select));
        };

        document.addEventListener('click', (event) => {
            if (!event.target.closest('.gselect')) {
                closeAll();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAll();
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            enhanceAll(document);

            const bodyObserver = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    mutation.addedNodes.forEach((node) => {
                        if (!(node instanceof Element)) {
                            return;
                        }
                        if (node.matches('select')) {
                            enhanceSelect(node);
                        } else {
                            enhanceAll(node);
                        }
                    });
                });
            });

            bodyObserver.observe(document.body, {
                childList: true,
                subtree: true,
            });
        });
    })();
