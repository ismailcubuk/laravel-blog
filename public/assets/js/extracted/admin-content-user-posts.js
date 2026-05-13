document.querySelectorAll('.user-posts-details').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('userPostDetailImage').src = button.dataset.image || '';
            document.getElementById('userPostDetailAvatar').src = button.dataset.avatar || '';
            document.getElementById('userPostDetailTitle').textContent = button.dataset.title || '-';
            document.getElementById('userPostDetailAuthor').textContent = button.dataset.author || '-';
            document.getElementById('userPostDetailEmail').textContent = button.dataset.email || '-';
            document.getElementById('userPostDetailCategory').textContent = button.dataset.category || '-';
            document.getElementById('userPostDetailDate').textContent = button.dataset.date || '-';
            document.getElementById('userPostDetailStatus').textContent = button.dataset.status || '-';
            document.getElementById('userPostDetailStatus').className = 'user-posts-status ' + (button.dataset.status === 'Onaylandı' ? 'approved' : 'pending');
            document.getElementById('userPostDetailContent').textContent = button.dataset.content || '';
        });
    });

