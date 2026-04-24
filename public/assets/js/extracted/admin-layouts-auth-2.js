document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('input.form-control').forEach(function (input) {
                const type = (input.getAttribute('type') || 'text').toLowerCase();
                if ((type === 'text' || type === 'email' || type === 'password') && !input.hasAttribute('spellcheck')) {
                    input.setAttribute('spellcheck', 'false');
                }
            });
        });
