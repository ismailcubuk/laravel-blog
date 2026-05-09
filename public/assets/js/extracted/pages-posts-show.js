document.addEventListener('click', function (event) {
                document.querySelectorAll('.comment-status-menu[open]').forEach(function (menu) {
                    if (!menu.contains(event.target)) {
                        menu.removeAttribute('open');
                    }
                });
            });

            function toggleReplyCreate(commentId, shouldShow) {
                const trigger = document.getElementById('reply-trigger-' + commentId);
                const form = document.getElementById('reply-create-' + commentId);
                if (!form || !trigger) {
                    return;
                }

                if (shouldShow) {
                    trigger.classList.add('d-none');
                    form.classList.remove('d-none');
                    const textarea = form.querySelector('textarea[name="reply_message"]');
                    if (textarea) {
                        textarea.focus();
                    }
                    return;
                }

                trigger.classList.remove('d-none');
                form.classList.add('d-none');
            }

            function toggleCommentReply(commentId, shouldShow) {
                const trigger = document.getElementById('comment-reply-trigger-' + commentId);
                const form = document.getElementById('comment-reply-form-' + commentId);

                if (!form || !trigger) {
                    return;
                }

                if (shouldShow) {
                    trigger.classList.add('d-none');
                    form.classList.remove('d-none');
                    const textarea = form.querySelector('textarea[name="message"]');
                    if (textarea) {
                        textarea.focus();
                    }
                    return;
                }

                trigger.classList.remove('d-none');
                form.classList.add('d-none');
            }

            function toggleReplyEdit(commentId, shouldEdit) {
                const replyText = document.getElementById('reply-text-' + commentId);
                const replyActions = document.getElementById('reply-actions-' + commentId);
                const form = document.getElementById('reply-edit-' + commentId);

                if (!replyText || !replyActions || !form) {
                    return;
                }

                if (shouldEdit) {
                    replyText.classList.add('d-none');
                    replyActions.classList.add('d-none');
                    form.classList.remove('d-none');
                    const textarea = form.querySelector('textarea[name="reply_message"]');
                    if (textarea) {
                        textarea.focus();
                        textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                    }
                    return;
                }

                replyText.classList.remove('d-none');
                replyActions.classList.remove('d-none');
                form.classList.add('d-none');
            }

            window.toggleReplyCreate = toggleReplyCreate;
            window.toggleReplyEdit = toggleReplyEdit;
            window.toggleCommentReply = toggleCommentReply;
