const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarInput && avatarPreview) {
        avatarPreview.addEventListener('click', () => {
            avatarInput.click();
        });

        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                avatarPreview.src = URL.createObjectURL(file);
            }
        });
    }

    document.querySelectorAll('[data-toggle-password]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.getAttribute('data-toggle-password'));
            if (!input) return;

            const hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            button.innerHTML = hidden ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    });

    const phoneInput = document.getElementById('phoneInput');
    if (phoneInput) {
        const formatTrPhone = (value) => {
            let digits = value.replace(/\D/g, '');

            if (digits.startsWith('90') && digits.length > 10) {
                digits = digits.slice(2);
            } else if (digits.startsWith('0') && digits.length > 10) {
                digits = digits.slice(1);
            }

            if (digits.length > 10) {
                digits = digits.slice(0, 10);
            }

            if (!digits) return '';

            let out = '+90 ';
            if (digits.length >= 1) out += digits.slice(0, 3);
            if (digits.length >= 4) out += ' ' + digits.slice(3, 6);
            if (digits.length >= 7) out += ' ' + digits.slice(6, 8);
            if (digits.length >= 9) out += ' ' + digits.slice(8, 10);

            return out.trim();
        };

        phoneInput.addEventListener('input', () => {
            phoneInput.value = formatTrPhone(phoneInput.value);
        });

        phoneInput.value = formatTrPhone(phoneInput.value);
    }
