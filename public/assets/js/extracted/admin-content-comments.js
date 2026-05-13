document.addEventListener('DOMContentLoaded', function () {
    const replyModalElement = document.getElementById('adminCommentReplyModal');

    const cleanupModalState = function () {
        document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
            backdrop.remove();
        });

        if (replyModalElement) {
            replyModalElement.classList.remove('show');
            replyModalElement.style.display = 'none';
            replyModalElement.setAttribute('aria-hidden', 'true');
            replyModalElement.removeAttribute('aria-modal');
            replyModalElement.removeAttribute('role');
        }

        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
    };

    cleanupModalState();

    if (replyModalElement) {
        const replyForm = document.getElementById('adminCommentReplyForm');
        const replyDeleteForm = document.getElementById('adminCommentReplyDeleteForm') || document.getElementById('adminCommentReplySilForm');

        [replyForm, replyDeleteForm].forEach(function (form) {
            if (!form) {
                return;
            }

            form.addEventListener('submit', function () {
                const modal = window.bootstrap ? window.bootstrap.Modal.getInstance(replyModalElement) : null;

                if (modal) {
                    modal.hide();
                }

                cleanupModalState();
            });
        });

        replyModalElement.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            if (!trigger) {
                return;
            }

            const modalTitleTarget = document.getElementById('adminCommentReplyModalTitle');
            const replyForm = document.getElementById('adminCommentReplyForm');
            const replyDeleteForm = document.getElementById('adminCommentReplyDeleteForm') || document.getElementById('adminCommentReplySilForm');
            const replyDeleteButton = document.getElementById('adminCommentReplyDeleteButton') || document.getElementById('adminCommentReplySilButton');
            const postImageTarget = document.getElementById('adminCommentReplyPostImage');
            const postCategoryTarget = document.getElementById('adminCommentReplyPostCategory');
            const postTarget = document.getElementById('adminCommentReplyPost');
            const postAuthorTarget = document.getElementById('adminCommentReplyPostAuthor');
            const postDateTarget = document.getElementById('adminCommentReplyPostDate');
            const postCommentsTarget = document.getElementById('adminCommentReplyPostComments');
            const authorTarget = document.getElementById('adminCommentReplyAuthor');
            const statusTarget = document.getElementById('adminCommentReplyStatus');
            const messageTarget = document.getElementById('adminCommentReplyMessage');
            const parentBlock = document.getElementById('adminCommentParentBlock');
            const parentAuthorTarget = document.getElementById('adminCommentParentAuthor');
            const parentDateTarget = document.getElementById('adminCommentParentDate');
            const parentMessageTarget = document.getElementById('adminCommentParentMessage');
            const inputTarget = document.getElementById('adminCommentReplyInput');

            if (replyForm) {
                replyForm.action = trigger.getAttribute('data-reply-action') || '';
            }

            if (replyDeleteForm) {
                const deleteAction = trigger.getAttribute('data-reply-delete-action') || '';
                replyDeleteForm.action = deleteAction;
                if (replyDeleteButton) {
                    replyDeleteButton.classList.toggle('d-none', deleteAction === '');
                }
            }

            if (modalTitleTarget) {
                modalTitleTarget.textContent = trigger.getAttribute('data-modal-mode') === 'edit'
                    ? 'Yanıtı Düzenle'
                    : 'Yanıt Yaz';
            }

            if (postImageTarget) {
                postImageTarget.src = trigger.getAttribute('data-post-image') || '';
                postImageTarget.alt = trigger.getAttribute('data-post-title') || 'Post image';
            }

            if (postCategoryTarget) {
                postCategoryTarget.textContent = trigger.getAttribute('data-post-category') || '-';
            }

            if (postTarget) {
                postTarget.textContent = trigger.getAttribute('data-post-title') || '-';
            }

            if (postAuthorTarget) {
                postAuthorTarget.textContent = trigger.getAttribute('data-post-author') || '-';
            }

            if (postDateTarget) {
                postDateTarget.textContent = trigger.getAttribute('data-post-date') || '-';
            }

            if (postCommentsTarget) {
                const count = trigger.getAttribute('data-post-comments') || trigger.getAttribute('data-post-yorum') || '0';
                postCommentsTarget.textContent = count + ' yorum';
            }

            if (authorTarget) {
                authorTarget.textContent = trigger.getAttribute('data-comment-author') || '-';
            }

            if (statusTarget) {
                const status = trigger.getAttribute('data-comment-status') || '-';
                statusTarget.textContent = status;
                statusTarget.className = 'admin-comment-reply-status ' + status;
            }

            if (messageTarget) {
                messageTarget.textContent = trigger.getAttribute('data-comment-message') || '-';
            }

            const parentMessage = trigger.getAttribute('data-parent-message') || '';
            if (parentBlock) {
                parentBlock.classList.toggle('d-none', parentMessage === '');
            }

            if (parentAuthorTarget) {
                parentAuthorTarget.textContent = trigger.getAttribute('data-parent-author') || '-';
            }

            if (parentDateTarget) {
                parentDateTarget.textContent = trigger.getAttribute('data-parent-date') || '-';
            }

            if (parentMessageTarget) {
                parentMessageTarget.textContent = parentMessage || '-';
            }

            if (inputTarget) {
                inputTarget.value = trigger.getAttribute('data-reply-message') || '';
            }
        });

        replyModalElement.addEventListener('shown.bs.modal', function () {
            const inputTarget = document.getElementById('adminCommentReplyInput');
            if (inputTarget) {
                inputTarget.focus();
            }
        });

        replyModalElement.addEventListener('hidden.bs.modal', function () {
            const replyForm = document.getElementById('adminCommentReplyForm');
            const replyDeleteForm = document.getElementById('adminCommentReplyDeleteForm') || document.getElementById('adminCommentReplySilForm');
            const replyDeleteButton = document.getElementById('adminCommentReplyDeleteButton') || document.getElementById('adminCommentReplySilButton');
            const inputTarget = document.getElementById('adminCommentReplyInput');

            if (replyForm) {
                replyForm.action = '';
            }

            if (replyDeleteForm) {
                replyDeleteForm.action = '';
            }

            if (replyDeleteButton) {
                replyDeleteButton.classList.add('d-none');
            }

            if (inputTarget) {
                inputTarget.value = '';
            }

            cleanupModalState();
        });
    }
});
