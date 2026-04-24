<style>
:root {
            --admin-bg-a: {{ $uiMode === 'dark' ? '#0b1220' : '#f8fbff' }};
            --admin-bg-b: {{ $uiMode === 'dark' ? '#111a2e' : '#f1f4fb' }};
            --admin-surface: {{ $uiMode === 'dark' ? '#0f172a' : '#ffffff' }};
            --admin-border: {{ $uiMode === 'dark' ? '#25324a' : '#e2e8f4' }};
            --admin-text: {{ $uiMode === 'dark' ? '#e2e8f0' : '#1a2433' }};
            --admin-muted: {{ $uiMode === 'dark' ? '#94a3b8' : '#1f2e46' }};
            --admin-primary: {{ $themePalette['primary'] }};
            --admin-primary-2: {{ $themePalette['secondary'] }};
            --admin-success: {{ $uiMode === 'dark' ? '#34d399' : '#179d6d' }};
            --admin-danger: {{ $uiMode === 'dark' ? '#fb7185' : '#d13c4a' }};
            --admin-primary-rgb: {{ $themePalette['rgb'] }};
            --admin-focus: {{ $themePalette['focus'] }};
            --admin-input-bg: {{ $uiMode === 'dark' ? '#111b2f' : '#fbfcff' }};
            --admin-input-border: {{ $uiMode === 'dark' ? '#334155' : '#d6deec' }};
            --admin-shadow: {{ $uiMode === 'dark' ? '0 14px 30px rgba(2, 6, 23, 0.45)' : '0 14px 30px rgba(16, 33, 61, 0.08)' }};
            --admin-footer-bg: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.85)' : 'rgba(255, 255, 255, 0.8)' }};
            --admin-sidebar-bg: {{ $uiMode === 'dark' ? 'linear-gradient(180deg, #020617 0%, #0f172a 100%)' : 'linear-gradient(180deg, #0f1f3a 0%, #162b4f 100%)' }};
            --admin-label-color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#3a4860' }};
            --admin-table-head-color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#40506c' }};
            --admin-pagination-bg: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.86)' : '#ffffff' }};
            --admin-pagination-color: {{ $uiMode === 'dark' ? '#cbd5e1' : '#35507f' }};
            --admin-pagination-hover-bg: {{ $uiMode === 'dark' ? 'rgba(30, 41, 59, 0.95)' : '#f8fbff' }};
            --admin-pagination-hover-color: {{ $uiMode === 'dark' ? '#f8fafc' : '#1f3b63' }};
            --admin-pagination-hover-border: {{ $uiMode === 'dark' ? '#475569' : '#bcd0f5' }};
            --admin-pagination-disabled-bg: {{ $uiMode === 'dark' ? 'rgba(15, 23, 42, 0.72)' : '#f3f6fb' }};
            --admin-pagination-disabled-color: {{ $uiMode === 'dark' ? '#64748b' : '#8aa0c2' }};
        }
</style>

