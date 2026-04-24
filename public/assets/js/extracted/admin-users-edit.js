const avatarInput = document.getElementById('avatarInput');
    const avatarTrigger = document.getElementById('avatarTrigger');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarTrigger && avatarInput) {
        avatarTrigger.addEventListener('click', () => avatarInput.click());
    }

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', (event) => {
            const file = event.target.files && event.target.files[0];
            if (!file) {
                return;
            }

            avatarPreview.src = URL.createObjectURL(file);
        });
    }

    const pickers = Array.from(document.querySelectorAll('[data-picker]'));

    if (pickers.length) {
        const closePicker = (picker) => {
            const trigger = picker.querySelector('.role-picker-trigger');
            const menu = picker.querySelector('.role-picker-menu');
            picker.classList.remove('is-open');
            if (menu) menu.hidden = true;
            if (trigger) trigger.setAttribute('aria-expanded', 'false');
        };

        const closeAllPickers = (except = null) => {
            pickers.forEach((picker) => {
                if (except && picker === except) {
                    return;
                }
                closePicker(picker);
            });
        };

        pickers.forEach((picker) => {
            const trigger = picker.querySelector('.role-picker-trigger');
            const menu = picker.querySelector('.role-picker-menu');
            const label = picker.querySelector('.role-picker-label');
            const input = picker.querySelector('.role-picker-input');

            if (!trigger || !menu || !label || !input) {
                return;
            }

            trigger.addEventListener('click', () => {
                const isOpen = picker.classList.contains('is-open');
                if (isOpen) {
                    closePicker(picker);
                    return;
                }

                closeAllPickers(picker);
                picker.classList.add('is-open');
                menu.hidden = false;
                trigger.setAttribute('aria-expanded', 'true');
            });

            menu.querySelectorAll('.role-picker-option').forEach((option) => {
                option.addEventListener('click', () => {
                    const value = option.getAttribute('data-role-value');
                    const text = option.getAttribute('data-role-label');

                    input.value = value || '';
                    label.textContent = text || 'Select';

                    menu.querySelectorAll('.role-picker-option').forEach((item) => {
                        item.classList.remove('is-selected');
                        item.setAttribute('aria-selected', 'false');
                    });

                    option.classList.add('is-selected');
                    option.setAttribute('aria-selected', 'true');
                    closePicker(picker);
                });
            });
        });

        document.addEventListener('click', (event) => {
            const inPicker = event.target.closest('[data-picker]');
            if (!inPicker) {
                closeAllPickers();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAllPickers();
            }
        });
    }
