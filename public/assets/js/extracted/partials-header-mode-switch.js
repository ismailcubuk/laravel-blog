(() => {
            const form = document.querySelector('[data-front-mode-switch]');
            if (!form) {
                return;
            }

            const themeValues = {
                white: {
                    '--front-bg-a': '#f8fbff',
                    '--front-bg-b': '#eef3fb',
                    '--front-surface': '#ffffff',
                    '--front-border': '#e2e8f4',
                    '--front-text': '#1a2433',
                    '--front-muted': '#1f2e46',
                    '--front-input-bg': '#fbfcff',
                    '--front-shadow': '0 14px 30px rgba(16, 33, 61, 0.08)',
                    '--front-sidebar-link': '#41506a',
                    '--front-pagination-bg': '#ffffff',
                    '--front-pagination-color': '#35507f',
                    '--front-page-numbers-color': '#35507f',
                    '--front-pagination-hover-bg': '#f8fbff',
                    '--front-pagination-hover-color': '#1f3b63',
                    '--front-pagination-hover-border': '#bcd0f5',
                    '--front-pagination-disabled-bg': '#f3f6fb',
                    '--front-pagination-disabled-color': '#8aa0c2',
                    '--front-header-bg': 'rgba(255, 255, 255, 0.9)',
                    '--front-header-shadow': '0 8px 24px rgba(16, 33, 61, 0.08)',
                    '--front-nav-link': '#1f2e46',
                    '--front-nav-hover-bg': 'var(--front-soft-bg)',
                    '--front-nav-hover-border': 'var(--front-soft-border)',
                    '--front-user-chip-text': '#13243f',
                    '--front-user-chip-border': 'var(--front-soft-border)',
                    '--front-user-chip-bg': 'var(--front-soft-bg)',
                    '--front-dropdown-item': '#1f2e46',
                    '--front-dropdown-hover-bg': 'var(--front-soft-bg)',
                    '--front-mode-track-bg': 'rgba(255, 255, 255, 0.78)',
                    '--front-mode-button': '#41506a',
                    '--front-mode-hover-bg': 'var(--front-soft-bg)',
                },
                dark: {
                    '--front-bg-a': '#0b1220',
                    '--front-bg-b': '#111a2e',
                    '--front-surface': '#0f172a',
                    '--front-border': '#25324a',
                    '--front-text': '#e2e8f0',
                    '--front-muted': '#94a3b8',
                    '--front-input-bg': '#111b2f',
                    '--front-shadow': '0 14px 30px rgba(2, 6, 23, 0.45)',
                    '--front-sidebar-link': '#cbd5e1',
                    '--front-pagination-bg': 'rgba(15, 23, 42, 0.86)',
                    '--front-pagination-color': '#cbd5e1',
                    '--front-page-numbers-color': '#e2e8f0',
                    '--front-pagination-hover-bg': 'rgba(30, 41, 59, 0.95)',
                    '--front-pagination-hover-color': '#f8fafc',
                    '--front-pagination-hover-border': '#475569',
                    '--front-pagination-disabled-bg': 'rgba(15, 23, 42, 0.72)',
                    '--front-pagination-disabled-color': '#64748b',
                    '--front-header-bg': 'rgba(2, 6, 23, 0.88)',
                    '--front-header-shadow': '0 8px 24px rgba(2, 6, 23, 0.28)',
                    '--front-nav-link': '#e2e8f0',
                    '--front-nav-hover-bg': 'rgba(148, 163, 184, 0.18)',
                    '--front-nav-hover-border': 'rgba(148, 163, 184, 0.3)',
                    '--front-user-chip-text': '#f8fafc',
                    '--front-user-chip-border': 'rgba(148, 163, 184, 0.32)',
                    '--front-user-chip-bg': 'rgba(148, 163, 184, 0.16)',
                    '--front-dropdown-item': '#e2e8f0',
                    '--front-dropdown-hover-bg': 'rgba(148, 163, 184, 0.16)',
                    '--front-mode-track-bg': 'rgba(15, 23, 42, 0.9)',
                    '--front-mode-button': '#cbd5e1',
                    '--front-mode-hover-bg': 'rgba(148, 163, 184, 0.16)',
                },
            };

            const applyMode = (mode) => {
                const safeMode = mode === 'dark' ? 'dark' : 'white';
                const isDark = safeMode === 'dark';

                document.body.classList.toggle('front-dark', isDark);
                document.body.classList.toggle('front-light', !isDark);

                Object.entries(themeValues[safeMode]).forEach(([name, value]) => {
                    document.documentElement.style.setProperty(name, value);
                });

                form.querySelectorAll('button[name="ui_mode"]').forEach((button) => {
                    const active = button.value === safeMode;
                    button.classList.toggle('is-active', active);
                    button.setAttribute('aria-pressed', active ? 'true' : 'false');
                });

                document.cookie = `ui_mode=${safeMode}; path=/; max-age=31536000; SameSite=Lax`;
            };

            form.addEventListener('submit', (event) => event.preventDefault());

            form.querySelectorAll('button[name="ui_mode"]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const mode = button.value === 'dark' ? 'dark' : 'white';
                    const previousMode = document.body.classList.contains('front-dark') ? 'dark' : 'white';
                    const payload = new FormData(form);
                    payload.set('ui_mode', mode);

                    applyMode(mode);

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: payload,
                            headers: {
                                Accept: 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            credentials: 'same-origin',
                        });

                        if (!response.ok) {
                            throw new Error('Mode update failed');
                        }
                    } catch (error) {
                        applyMode(previousMode);
                    }
                });
            });
        })();

