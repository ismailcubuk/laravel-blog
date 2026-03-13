(function () {
    'use strict';

    function normalizeText(value) {
        return (value || '').toString().toLocaleLowerCase('tr-TR');
    }

    function initAllUsersModalSearch() {
        const input = document.getElementById('allUsersSearchInput');
        const list = document.getElementById('allUsersList');
        const emptyState = document.getElementById('allUsersEmptyState');

        if (!input || !list || !emptyState) {
            return;
        }

        const items = Array.from(list.querySelectorAll('.all-users-item'));

        function applyFilter() {
            const query = normalizeText(input.value.trim());
            let visibleCount = 0;

            items.forEach(function (item) {
                const haystack = normalizeText(item.getAttribute('data-search'));
                const isVisible = query === '' || haystack.indexOf(query) !== -1;
                item.classList.toggle('d-none', !isVisible);
                if (isVisible) {
                    visibleCount += 1;
                }
            });

            emptyState.classList.toggle('d-none', visibleCount > 0);
        }

        input.addEventListener('input', applyFilter);

        const modal = document.getElementById('allUsersModal');
        if (modal) {
            modal.addEventListener('shown.bs.modal', function () {
                input.focus();
            });

            modal.addEventListener('hidden.bs.modal', function () {
                input.value = '';
                applyFilter();
            });
        }
    }

    document.addEventListener('DOMContentLoaded', initAllUsersModalSearch);
})();
