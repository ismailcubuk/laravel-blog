<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rawNewBlogsData = @json($newBlogsData);
    const rawNewUsersData = @json($newUsersData);
    const activityLabels = @json($activityLabels);
    const activityDates = @json($activityDates);
    const newBlogsItemsByDate = @json($newBlogsItemsByDate);
    const newUsersItemsByDate = @json($newUsersItemsByDate);

    const visualNewBlogsData = rawNewBlogsData.map(value => value === 0 ? 0.2 : value);
    const visualNewUsersData = rawNewUsersData.map(value => value === 0 ? 0.2 : value);

    const modalElement = document.getElementById('activityDetailModal');
    const activityDetailModal = window.bootstrap ? new bootstrap.Modal(modalElement) : null;
    const activityDetailTitle = document.getElementById('activityDetailTitle');
    const activityDetailCount = document.getElementById('activityDetailCount');
    const activityDetailBody = document.getElementById('activityDetailBody');

    const escapeHtml = function (text) {
        return String(text ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    };

    const buildEmptyState = function () {
        return '<div class="p-4 text-center text-muted">No record found.</div>';
    };

    new Chart(document.getElementById('blogChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: activityLabels,
            datasets: [
                { label: 'New Blogs', backgroundColor: '#007bff', data: visualNewBlogsData },
                { label: 'New Users', backgroundColor: '#28a745', data: visualNewUsersData }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            onHover: function (event, elements) {
                const canvas = event && event.native && event.native.target ? event.native.target : null;

                if (!canvas) {
                    return;
                }

                if (!elements.length) {
                    canvas.style.cursor = 'default';
                    return;
                }

                const element = elements[0];
                const isBlog = element.datasetIndex === 0;
                const rawValue = isBlog ? rawNewBlogsData[element.index] : rawNewUsersData[element.index];
                canvas.style.cursor = rawValue > 0 ? 'pointer' : 'default';
            },
            onClick: function (event, elements) {
                if (!elements.length || !activityDetailModal) {
                    return;
                }

                const element = elements[0];
                const dataIndex = element.index;
                const isBlog = element.datasetIndex === 0;
                const rawValue = isBlog ? rawNewBlogsData[dataIndex] : rawNewUsersData[dataIndex];

                if (rawValue === 0) {
                    return;
                }

                const dateKey = activityDates[dataIndex];
                const dateLabel = activityLabels[dataIndex];
                const modalLabel = isBlog ? 'New Blogs' : 'New Users';
                const items = isBlog ? (newBlogsItemsByDate[dateKey] || []) : (newUsersItemsByDate[dateKey] || []);

                activityDetailTitle.textContent = modalLabel + ' - ' + dateLabel;
                activityDetailCount.textContent = String(items.length);

                if (!items.length) {
                    activityDetailBody.innerHTML = buildEmptyState();
                } else if (isBlog) {
                    activityDetailBody.innerHTML = '<div class="activity-post-list">' + items.map(function (item) {
                        const safeUrl = escapeHtml(item.url || '#');
                        const safeTitle = escapeHtml(item.title || 'Untitled');
                        const safeExcerpt = escapeHtml(item.excerpt || '');
                        const safeImage = escapeHtml(item.image || 'https://picsum.photos/seed/default/200/200');
                        const safeTime = escapeHtml(item.time || '--:--');

                        return '<a href="' + safeUrl + '" class="d-flex p-3 border-bottom activity-post-item activity-post-link">' +
                            '<div class="me-3">' +
                            '<img src="' + safeImage + '" width="72" height="72" style="object-fit:cover; border-radius:8px;">' +
                            '</div>' +
                            '<div class="flex-grow-1">' +
                            '<h6 class="mb-1">' + safeTitle + '</h6>' +
                            '<p class="mb-1 text-muted small">' + safeExcerpt + '</p>' +
                            '<div class="d-flex justify-content-between align-items-center">' +
                            '<small class="text-secondary"><i class="fa fa-clock"></i> ' + safeTime + '</small>' +
                            '<span class="activity-view-link">View</span>' +
                            '</div>' +
                            '</div>' +
                            '</a>';
                    }).join('') + '</div>';
                } else {
                    activityDetailBody.innerHTML = '<div class="activity-user-list">' + items.map(function (item) {
                        const safeName = escapeHtml(item.name || 'Unknown');
                        const safeEmail = escapeHtml(item.email || '-');
                        const safeTime = escapeHtml(item.time || '--:--');
                        const safeAvatar = escapeHtml((item.name || 'U').charAt(0).toUpperCase());

                        return '<div class="d-flex align-items-center justify-content-between p-3 border-bottom activity-user-item">' +
                            '<div class="d-flex align-items-center gap-3">' +
                            '<div class="activity-avatar">' + safeAvatar + '</div>' +
                            '<div>' +
                            '<div class="fw-semibold">' + safeName + '</div>' +
                            '<div class="text-muted small">' + safeEmail + '</div>' +
                            '</div>' +
                            '</div>' +
                            '<small class="text-secondary"><i class="fa fa-clock"></i> ' + safeTime + '</small>' +
                            '</div>';
                    }).join('') + '</div>';
                }

                activityDetailModal.show();
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max(...rawNewBlogsData, ...rawNewUsersData, 1),
                    ticks: { display: false }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const rawValue = context.dataset.label === 'New Blogs'
                                ? rawNewBlogsData[context.dataIndex]
                                : rawNewUsersData[context.dataIndex];

                            return context.dataset.label + ': ' + rawValue;
                        }
                    }
                }
            }
        }
    });
});
</script>
