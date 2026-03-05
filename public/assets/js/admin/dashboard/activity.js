(function () {
    'use strict';

    function byId(id) {
        return document.getElementById(id);
    }

    function parseDashboardData() {
        const dataElement = byId('dashboardActivityData');
        if (!dataElement) {
            return null;
        }

        try {
            return JSON.parse(dataElement.textContent || '{}');
        } catch (error) {
            console.error('Dashboard activity data parse error:', error);
            return null;
        }
    }

    function createFromTemplate(templateId) {
        const template = byId(templateId);
        if (!template || !template.content) {
            return null;
        }

        return template.content.firstElementChild.cloneNode(true);
    }

    function setText(root, selector, value) {
        const element = root.querySelector(selector);
        if (element) {
            element.textContent = value;
        }
    }

    function renderEmptyState(bodyElement) {
        const emptyState = createFromTemplate('activityEmptyStateTemplate');
        bodyElement.replaceChildren(emptyState || document.createTextNode(''));
    }

    function renderPostItems(bodyElement, items) {
        const list = document.createElement('div');
        list.className = 'activity-post-list';

        items.forEach(function (item) {
            const postItem = createFromTemplate('activityPostItemTemplate');
            if (!postItem) {
                return;
            }

            const href = item && item.url ? item.url : '#';
            const imageSrc = item && item.image ? item.image : 'https://picsum.photos/seed/default/200/200';
            const title = item && item.title ? item.title : 'Untitled';
            const excerpt = item && item.excerpt ? item.excerpt : '';
            const time = item && item.time ? item.time : '--:--';

            postItem.setAttribute('href', href);

            const imageElement = postItem.querySelector('img');
            if (imageElement) {
                imageElement.setAttribute('src', imageSrc);
            }

            setText(postItem, '[data-role="title"]', title);
            setText(postItem, '[data-role="excerpt"]', excerpt);
            setText(postItem, '[data-role="time"]', time);

            list.appendChild(postItem);
        });

        bodyElement.replaceChildren(list);
    }

    function renderUserItems(bodyElement, items) {
        const list = document.createElement('div');
        list.className = 'activity-user-list';

        items.forEach(function (item) {
            const userItem = createFromTemplate('activityUserItemTemplate');
            if (!userItem) {
                return;
            }

            const name = item && item.name ? item.name : 'Unknown';
            const email = item && item.email ? item.email : '-';
            const time = item && item.time ? item.time : '--:--';
            const avatar = name.charAt(0).toUpperCase();

            setText(userItem, '[data-role="avatar"]', avatar);
            setText(userItem, '[data-role="name"]', name);
            setText(userItem, '[data-role="email"]', email);
            setText(userItem, '[data-role="time"]', time);

            list.appendChild(userItem);
        });

        bodyElement.replaceChildren(list);
    }

    function initDashboardActivityChart() {
        const canvas = byId('blogChart');
        if (!canvas || !window.Chart) {
            return;
        }

        const data = parseDashboardData();
        if (!data) {
            return;
        }

        const rawNewBlogsData = Array.isArray(data.rawNewBlogsData) ? data.rawNewBlogsData : [];
        const rawNewUsersData = Array.isArray(data.rawNewUsersData) ? data.rawNewUsersData : [];
        const activityLabels = Array.isArray(data.activityLabels) ? data.activityLabels : [];
        const activityDates = Array.isArray(data.activityDates) ? data.activityDates : [];
        const newBlogsItemsByDate = data.newBlogsItemsByDate || {};
        const newUsersItemsByDate = data.newUsersItemsByDate || {};
        const visualMinValue = typeof data.visualMinValue === 'number' ? data.visualMinValue : 0.2;

        const visualNewBlogsData = rawNewBlogsData.map(function (value) {
            return value === 0 ? visualMinValue : value;
        });

        const visualNewUsersData = rawNewUsersData.map(function (value) {
            return value === 0 ? visualMinValue : value;
        });

        const modalElement = byId('activityDetailModal');
        const activityDetailModal = modalElement && window.bootstrap ? new window.bootstrap.Modal(modalElement) : null;
        const activityDetailTitle = byId('activityDetailTitle');
        const activityDetailCount = byId('activityDetailCount');
        const activityDetailBody = byId('activityDetailBody');

        new window.Chart(canvas.getContext('2d'), {
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
                    const target = event && event.native ? event.native.target : null;
                    if (!target) {
                        return;
                    }

                    if (!elements.length) {
                        target.style.cursor = 'default';
                        return;
                    }

                    const point = elements[0];
                    const isBlog = point.datasetIndex === 0;
                    const rawValue = isBlog ? rawNewBlogsData[point.index] : rawNewUsersData[point.index];
                    target.style.cursor = rawValue > 0 ? 'pointer' : 'default';
                },
                onClick: function (_, elements) {
                    if (!elements.length || !activityDetailModal || !activityDetailBody) {
                        return;
                    }

                    const point = elements[0];
                    const dataIndex = point.index;
                    const isBlog = point.datasetIndex === 0;
                    const rawValue = isBlog ? rawNewBlogsData[dataIndex] : rawNewUsersData[dataIndex];

                    if (rawValue === 0) {
                        return;
                    }

                    const dateKey = activityDates[dataIndex];
                    const dateLabel = activityLabels[dataIndex] || '';
                    const modalLabel = isBlog ? 'New Blogs' : 'New Users';
                    const items = isBlog
                        ? (newBlogsItemsByDate[dateKey] || [])
                        : (newUsersItemsByDate[dateKey] || []);

                    if (activityDetailTitle) {
                        activityDetailTitle.textContent = modalLabel + ' - ' + dateLabel;
                    }

                    if (activityDetailCount) {
                        activityDetailCount.textContent = String(items.length);
                    }

                    if (!items.length) {
                        renderEmptyState(activityDetailBody);
                    } else if (isBlog) {
                        renderPostItems(activityDetailBody, items);
                    } else {
                        renderUserItems(activityDetailBody, items);
                    }

                    activityDetailModal.show();
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max.apply(null, rawNewBlogsData.concat(rawNewUsersData).concat([1])),
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
    }

    document.addEventListener('DOMContentLoaded', initDashboardActivityChart);
})();
