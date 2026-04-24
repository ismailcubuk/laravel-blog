<style>
:root {
            --front-bg-a: {{ $uiMode === 'dark' ? '#0b1220' : '#f8fbff' }};
            --front-bg-b: {{ $uiMode === 'dark' ? '#111a2e' : '#eef3fb' }};
            --front-surface: {{ $uiMode === 'dark' ? '#0f172a' : '#ffffff' }};
            --front-border: {{ $uiMode === 'dark' ? '#25324a' : '#e2e8f4' }};
            --front-text: {{ $uiMode === 'dark' ? '#e2e8f0' : '#1a2433' }};
            --front-muted: {{ $uiMode === 'dark' ? '#94a3b8' : '#1f2e46' }};
            --front-primary: {{ $themePalette['primary'] }};
            --front-primary-2: {{ $themePalette['secondary'] }};
            --front-soft-bg: {{ $themePalette['softBg'] }};
            --front-soft-border: {{ $themePalette['softBorder'] }};
            --front-focus: {{ $themePalette['focus'] }};
            --front-primary-rgb: {{ $themePalette['rgb'] }};
            --front-input-bg: {{ $uiMode === 'dark' ? '#111b2f' : '#fbfcff' }};
            --front-shadow: {{ $uiMode === 'dark' ? '0 14px 30px rgba(2, 6, 23, 0.45)' : '0 14px 30px rgba(16, 33, 61, 0.08)' }};
            --front-radius: 16px;
            --front-sidebar-link: {{ $uiMode === 'dark' ? '#cbd5e1' : '#41506a' }};
            --front-pagination-bg: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.86)' : '#ffffff' }};
            --front-pagination-color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#35507f' }};
            --front-page-numbers-color: {{ $uiMode === 'dark' ? '#e2e8f0' : '#35507f' }};
            --front-pagination-hover-bg: {{ $uiMode === 'dark' ? 'rgba(30, 41, 59, 0.95)' : '#f8fbff' }};
            --front-pagination-hover-color: {{ $uiMode === 'dark' ? '#f8fafc' : '#1f3b63' }};
            --front-pagination-hover-border: {{ $uiMode === 'dark' ? '#475569' : '#bcd0f5' }};
            --front-pagination-disabled-bg: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.72)' : '#f3f6fb' }};
            --front-pagination-disabled-color: {{ $uiMode === 'dark' ? '#64748b' : '#8aa0c2' }};
        }
</style>

