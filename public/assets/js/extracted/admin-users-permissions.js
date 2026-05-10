window.togglePermissionEdit = function togglePermissionEdit(permissionId, enableEdit) {
    const nameText = document.getElementById('permissionNameText-' + permissionId);
    const nameInput = document.getElementById('permissionNameInput-' + permissionId);
    const editBtn = document.getElementById('editPermissionBtn-' + permissionId);
    const saveBtn = document.getElementById('savePermissionBtn-' + permissionId);
    const cancelBtn = document.getElementById('cancelPermissionBtn-' + permissionId);

    if (!nameText || !nameInput || !editBtn || !saveBtn || !cancelBtn) {
        return;
    }

    if (enableEdit) {
        nameText.classList.add('d-none');
        nameInput.classList.remove('d-none');
        editBtn.classList.add('d-none');
        saveBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
        nameInput.focus();
        nameInput.select();
        return;
    }

    nameInput.value = nameText.textContent.trim();
    nameText.classList.remove('d-none');
    nameInput.classList.add('d-none');
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
    cancelBtn.classList.add('d-none');
};

document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('newPermissionModal');
    const hasValidationErrors = modalElement?.dataset.hasValidationErrors === 'true';
    if (!hasValidationErrors) {
        return;
    }
    if (!modalElement || !window.bootstrap) {
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    modal.show();
});

