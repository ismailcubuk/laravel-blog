const bindPasswordToggle = (inputId, buttonId) => {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        if (!input || !button) return;

        const eyeIcon = '<span class="auth-icon-svg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6-10-6-10-6z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>';
        const eyeSlashIcon = '<span class="auth-icon-svg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2 12s3.5-6 10-6c2.2 0 4.1.7 5.7 1.6"></path><path d="M22 12s-3.5 6-10 6c-2.2 0-4.1-.7-5.7-1.6"></path><path d="M3 3l18 18"></path></svg></span>';

        button.addEventListener('click', () => {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            button.innerHTML = isHidden ? eyeSlashIcon : eyeIcon;
        });
    };

    bindPasswordToggle('newPasswordInput', 'toggleNewPassword');
    bindPasswordToggle('confirmPasswordInput', 'toggleConfirmPassword');
