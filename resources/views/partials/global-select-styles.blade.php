<style>
    .gselect {
        position: relative;
        width: 100%;
    }

    .gselect-native {
        position: absolute !important;
        inset: 0 auto auto 0;
        width: 1px !important;
        height: 1px !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }

    .gselect-trigger {
        width: 100%;
        min-height: 42px;
        border: 1px solid var(--admin-input-border, var(--front-border, #d6deec));
        border-radius: 12px;
        background: var(--admin-input-bg, var(--front-input-bg, #fbfcff));
        color: var(--admin-text, var(--front-text, #1a2433));
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.65rem;
        padding: 0.56rem 0.78rem;
        font-weight: 600;
        line-height: 1.2;
        text-align: left;
        transition: border-color 0.18s ease, box-shadow 0.18s ease, background-color 0.18s ease;
    }

    .gselect-trigger:hover {
        border-color: rgba(var(--admin-primary-rgb, var(--front-primary-rgb, 31, 107, 255)), 0.55);
        background: rgba(var(--admin-primary-rgb, var(--front-primary-rgb, 31, 107, 255)), 0.06);
    }

    .gselect-trigger:focus-visible {
        outline: 0;
        border-color: var(--admin-focus, var(--front-focus, #93b8ff));
        box-shadow: 0 0 0 4px rgba(var(--admin-primary-rgb, var(--front-primary-rgb, 31, 107, 255)), 0.14);
    }

    .gselect-trigger.is-invalid {
        border-color: #dc3545;
    }

    .gselect-trigger[disabled] {
        opacity: 0.72;
        cursor: not-allowed;
    }

    .gselect-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.95rem;
    }

    .gselect-caret {
        flex: 0 0 auto;
        font-size: 0.75rem;
        opacity: 0.75;
        transition: transform 0.18s ease;
    }

    .gselect.is-open .gselect-caret {
        transform: rotate(180deg);
    }

    .gselect-menu {
        position: absolute;
        inset: calc(100% + 8px) 0 auto 0;
        z-index: 1065;
        border: 1px solid var(--admin-border, var(--front-border, #d6deec));
        border-radius: 12px;
        background: var(--admin-surface, var(--front-surface, #ffffff));
        box-shadow: 0 14px 30px rgba(2, 6, 23, 0.2);
        padding: 0.35rem;
        display: grid;
        gap: 4px;
        max-height: 260px;
        overflow-y: auto;
    }

    .gselect-option {
        width: 100%;
        min-height: 36px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: var(--admin-text, var(--front-text, #1a2433));
        padding: 0.45rem 0.6rem;
        text-align: left;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.55rem;
    }

    .gselect-option:hover {
        background: rgba(var(--admin-primary-rgb, var(--front-primary-rgb, 31, 107, 255)), 0.1);
    }

    .gselect-option[aria-selected="true"] {
        background: rgba(var(--admin-primary-rgb, var(--front-primary-rgb, 31, 107, 255)), 0.16);
    }

    .gselect-option[disabled] {
        opacity: 0.56;
        cursor: not-allowed;
    }

    .gselect-option-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: currentColor;
        opacity: 0.55;
        flex: 0 0 auto;
    }

    .gselect-option-check {
        margin-left: auto;
        opacity: 0;
        color: var(--admin-primary, var(--front-primary, #1f6bff));
    }

    .gselect-option[aria-selected="true"] .gselect-option-check {
        opacity: 1;
    }

    .admin-dark .gselect-trigger {
        background: #0f172a;
        color: #f8fafc;
        border-color: #334155;
    }

    .admin-dark .gselect-trigger:hover {
        background: #111b2f;
        border-color: #475569;
    }

    .admin-dark .gselect-menu {
        background: #0f172a;
        border-color: #334155;
        box-shadow: 0 16px 34px rgba(2, 6, 23, 0.62);
    }

    .admin-dark .gselect-option {
        color: #e2e8f0;
    }

    .admin-dark .gselect-option:hover {
        background: rgba(59, 130, 246, 0.22);
    }

    .admin-dark .gselect-option[aria-selected="true"] {
        background: rgba(59, 130, 246, 0.3);
    }

    .front-dark .gselect-trigger {
        background: #0f172a;
        color: #f8fafc;
        border-color: #334155;
    }

    .front-dark .gselect-trigger:hover {
        background: #111b2f;
        border-color: #475569;
    }

    .front-dark .gselect-menu {
        background: #0f172a;
        border-color: #334155;
        box-shadow: 0 16px 34px rgba(2, 6, 23, 0.62);
    }

    .front-dark .gselect-option {
        color: #e2e8f0;
    }

    .front-dark .gselect-option:hover {
        background: rgba(59, 130, 246, 0.22);
    }

    .front-dark .gselect-option[aria-selected="true"] {
        background: rgba(59, 130, 246, 0.3);
    }
</style>
