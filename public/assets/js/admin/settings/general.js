const settingsForm = document.getElementById('generalSettingsForm');
    const logoInput = document.getElementById('siteLogoInput');
    const logoPreview = document.getElementById('siteLogoPreview');
    const logoFileName = document.getElementById('siteLogoFileName');

    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                logoPreview.src = URL.createObjectURL(file);
            }
            if (logoFileName) {
                logoFileName.textContent = file ? file.name : 'No file selected';
            }
        });
    }

    const faviconInput = document.getElementById('siteFaviconInput');
    const faviconPreview = document.getElementById('siteFaviconPreview');
    const faviconFileName = document.getElementById('siteFaviconFileName');

    if (faviconInput && faviconPreview) {
        faviconInput.addEventListener('change', e => {
            const file = e.target.files[0];
            if (file) {
                faviconPreview.src = URL.createObjectURL(file);
            }
            if (faviconFileName) {
                faviconFileName.textContent = file ? file.name : 'No file selected';
            }
        });
    }

    const hexToRgb = (hex) => {
        const value = (hex || '').trim().replace('#', '');
        if (!/^[0-9a-fA-F]{3}$|^[0-9a-fA-F]{6}$/.test(value)) {
            return null;
        }

        const normalized = value.length === 3
            ? value.split('').map((ch) => ch + ch).join('')
            : value;

        const int = parseInt(normalized, 16);
        const r = (int >> 16) & 255;
        const g = (int >> 8) & 255;
        const b = int & 255;
        return `${r}, ${g}, ${b}`;
    };

    const bindColorField = (name) => {
        const colorInput = document.querySelector(`input[name="${name}"]`);
        const textInput = colorInput ? colorInput.parentElement.querySelector('.color-hex-readonly') : null;
        if (!colorInput || !textInput) {
            return;
        }

        const sync = () => {
            textInput.value = colorInput.value;
            applyAdminPreview();
        };

        colorInput.addEventListener('input', sync);
        colorInput.addEventListener('change', sync);
        sync();
    };

    const themePalettes = {
        orange: { primary: '#f48840', secondary: '#fb9857', focus: '#f5b58a', rgb: '244, 136, 64' },
        blue: { primary: '#1f6bff', secondary: '#0f4fd9', focus: '#93b8ff', rgb: '31, 107, 255' },
        emerald: { primary: '#10b981', secondary: '#059669', focus: '#6ee7b7', rgb: '16, 185, 129' },
        rose: { primary: '#e11d48', secondary: '#be123c', focus: '#f9a8d4', rgb: '225, 29, 72' },
        violet: { primary: '#7c3aed', secondary: '#6d28d9', focus: '#c4b5fd', rgb: '124, 58, 237' },
    };

    const modeColors = {
        white: {
            bgA: '#f8fbff',
            bgB: '#f1f4fb',
            surface: '#ffffff',
            border: '#e2e8f4',
            text: '#1a2433',
            muted: '#1f2e46',
            inputBg: '#fbfcff',
            inputBorder: '#d6deec',
            shadow: '0 14px 30px rgba(16, 33, 61, 0.08)',
            success: '#179d6d',
            danger: '#d13c4a',
        },
        dark: {
            bgA: '#0b1220',
            bgB: '#111a2e',
            surface: '#0f172a',
            border: '#25324a',
            text: '#e2e8f0',
            muted: '#e2e8f0',
            inputBg: '#111b2f',
            inputBorder: '#334155',
            shadow: '0 14px 30px rgba(2, 6, 23, 0.45)',
            success: '#34d399',
            danger: '#fb7185',
        },
    };

    const applyAdminPreview = () => {
        const selectedThemeInput = document.querySelector('input.theme-input[name="ui_theme"]:checked');
        const selectedModeInput = document.querySelector('input.theme-input[name="ui_mode"]:checked');

        const selectedTheme = selectedThemeInput ? selectedThemeInput.value : 'orange';
        const selectedMode = selectedModeInput ? selectedModeInput.value : 'white';

        const palette = themePalettes[selectedTheme] ?? themePalettes.orange;
        const mode = modeColors[selectedMode] ?? modeColors.white;
        const primaryColorInput = document.querySelector('input[name="brand_primary_color"]');
        const secondaryColorInput = document.querySelector('input[name="brand_secondary_color"]');
        const customPrimary = primaryColorInput ? primaryColorInput.value : '';
        const customSecondary = secondaryColorInput ? secondaryColorInput.value : '';
        const primaryRgb = hexToRgb(customPrimary);

        const root = document.documentElement;
        root.style.setProperty('--admin-bg-a', mode.bgA);
        root.style.setProperty('--admin-bg-b', mode.bgB);
        root.style.setProperty('--admin-surface', mode.surface);
        root.style.setProperty('--admin-border', mode.border);
        root.style.setProperty('--admin-text', mode.text);
        root.style.setProperty('--admin-muted', mode.muted);
        root.style.setProperty('--admin-primary', customPrimary || palette.primary);
        root.style.setProperty('--admin-primary-2', customSecondary || palette.secondary);
        root.style.setProperty('--admin-focus', palette.focus);
        root.style.setProperty('--admin-primary-rgb', primaryRgb || palette.rgb);
        root.style.setProperty('--admin-input-bg', mode.inputBg);
        root.style.setProperty('--admin-input-border', mode.inputBorder);
        root.style.setProperty('--admin-shadow', mode.shadow);
        root.style.setProperty('--admin-success', mode.success);
        root.style.setProperty('--admin-danger', mode.danger);

        document.body.classList.toggle('admin-dark', selectedMode === 'dark');
        document.body.classList.toggle('admin-light', selectedMode !== 'dark');
    };

    document.querySelectorAll('input.theme-input[name="ui_theme"], input.theme-input[name="ui_mode"]').forEach((input) => {
        input.addEventListener('change', applyAdminPreview);
    });

    bindColorField('brand_primary_color');
    bindColorField('brand_secondary_color');
    applyAdminPreview();
