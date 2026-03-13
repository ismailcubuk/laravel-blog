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

    function sum(values) {
        return (values || []).reduce(function (total, value) {
            return total + Number(value || 0);
        }, 0);
    }

    function flattenItemsByDate(itemsByDate) {
        return Object.values(itemsByDate || {}).reduce(function (all, items) {
            if (Array.isArray(items)) {
                return all.concat(items);
            }
            return all;
        }, []);
    }

        function getPeakDayInfo(rawBlogs, rawUsers, labels, activityDates) {
        let peakIndex = -1;
        let peakValue = -1;

        for (let i = 0; i < labels.length; i += 1) {
            const dayTotal = Number(rawBlogs[i] || 0) + Number(rawUsers[i] || 0);
            if (dayTotal > peakValue) {
                peakValue = dayTotal;
                peakIndex = i;
            }
        }

        if (peakIndex === -1 || peakValue <= 0) {
            return null;
        }

        return {
            index: peakIndex,
            value: peakValue,
            label: labels[peakIndex],
            dateKey: activityDates && activityDates[peakIndex] ? activityDates[peakIndex] : null,
        };
    }

    function updateInsights(rawBlogs, rawUsers, labels) {
        const blogsTotalElement = byId('activityBlogsTotal');
        const usersTotalElement = byId('activityUsersTotal');
        const peakDayElement = byId('activityPeakDay');

        const blogsTotal = sum(rawBlogs);
        const usersTotal = sum(rawUsers);

        if (blogsTotalElement) {
            blogsTotalElement.textContent = String(blogsTotal);
        }

        if (usersTotalElement) {
            usersTotalElement.textContent = String(usersTotal);
        }

        if (peakDayElement) {
            const peakDayInfo = getPeakDayInfo(rawBlogs, rawUsers, labels, []);
            if (!peakDayInfo) {
                peakDayElement.textContent = '-';
            } else {
                peakDayElement.textContent = peakDayInfo.label + ' (' + peakDayInfo.value + ')';
            }
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

    function openActivityModal(modalRefs, modalLabel, items, isBlog) {
        if (!modalRefs.modal || !modalRefs.body) {
            return;
        }

        if (modalRefs.title) {
            modalRefs.title.textContent = modalLabel;
        }

        if (modalRefs.count) {
            modalRefs.count.textContent = String(items.length);
        }

        if (!items.length) {
            renderEmptyState(modalRefs.body);
        } else if (isBlog) {
            renderPostItems(modalRefs.body, items);
        } else {
            renderUserItems(modalRefs.body, items);
        }

        modalRefs.modal.show();
    }

    function initLegendToggle(chart) {
        const legend = byId('activityLegend');
        if (!legend) {
            return;
        }

        const map = {
            blogs: 0,
            users: 1,
        };

        legend.querySelectorAll('[data-series]').forEach(function (button) {
            button.addEventListener('click', function () {
                const key = button.getAttribute('data-series');
                const datasetIndex = map[key];
                if (typeof datasetIndex !== 'number') {
                    return;
                }

                const currentlyVisible = chart.isDatasetVisible(datasetIndex);
                chart.setDatasetVisibility(datasetIndex, !currentlyVisible);
                chart.update();

                button.classList.toggle('is-muted', currentlyVisible);
                button.setAttribute('aria-pressed', String(!currentlyVisible));
            });
        });
    }

    function initBlogsWeekCard(modalRefs, newBlogsItemsByDate) {
        const blogsWeekCard = byId('activityBlogsWeekCard');
        if (!blogsWeekCard) {
            return;
        }

        const open = function () {
            const items = flattenItemsByDate(newBlogsItemsByDate);
            openActivityModal(modalRefs, 'New Blogs - This Week', items, true);
        };

        blogsWeekCard.addEventListener('click', open);
        blogsWeekCard.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                open();
            }
        });
    }

        function initUsersWeekCard(modalRefs, newUsersItemsByDate) {
        const usersWeekCard = byId('activityUsersWeekCard');
        if (!usersWeekCard) {
            return;
        }

        const open = function () {
            const items = flattenItemsByDate(newUsersItemsByDate);
            openActivityModal(modalRefs, 'New Users - This Week', items, false);
        };

        usersWeekCard.addEventListener('click', open);
        usersWeekCard.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                open();
            }
        });
    }

    function initPeakDayCard(modalRefs, rawBlogs, rawUsers, labels, activityDates, newBlogsItemsByDate, newUsersItemsByDate) {
        const peakDayCard = byId('activityPeakDayCard');
        if (!peakDayCard) {
            return;
        }

        const open = function () {
            const peakDayInfo = getPeakDayInfo(rawBlogs, rawUsers, labels, activityDates);
            if (!peakDayInfo) {
                openActivityModal(modalRefs, 'Peak Day', [], true);
                return;
            }

            const blogItems = peakDayInfo.dateKey ? (newBlogsItemsByDate[peakDayInfo.dateKey] || []) : [];
            const userItems = peakDayInfo.dateKey ? (newUsersItemsByDate[peakDayInfo.dateKey] || []) : [];

            if (blogItems.length >= userItems.length) {
                openActivityModal(modalRefs, 'Peak Day - New Blogs - ' + peakDayInfo.label, blogItems, true);
            } else {
                openActivityModal(modalRefs, 'Peak Day - New Users - ' + peakDayInfo.label, userItems, false);
            }
        };

        peakDayCard.addEventListener('click', open);
        peakDayCard.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                open();
            }
        });
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

        updateInsights(rawNewBlogsData, rawNewUsersData, activityLabels);

        const modalElement = byId('activityDetailModal');
        const modalRefs = {
            modal: modalElement && window.bootstrap ? new window.bootstrap.Modal(modalElement) : null,
            title: byId('activityDetailTitle'),
            count: byId('activityDetailCount'),
            body: byId('activityDetailBody'),
        };

        initBlogsWeekCard(modalRefs, newBlogsItemsByDate);
        initUsersWeekCard(modalRefs, newUsersItemsByDate);
        initPeakDayCard(modalRefs, rawNewBlogsData, rawNewUsersData, activityLabels, activityDates, newBlogsItemsByDate, newUsersItemsByDate);

        const ctx = canvas.getContext('2d');
        const blogsGradient = ctx.createLinearGradient(0, 0, 0, 260);
        blogsGradient.addColorStop(0, 'rgba(46, 123, 255, 0.95)');
        blogsGradient.addColorStop(1, 'rgba(46, 123, 255, 0.42)');

        const usersGradient = ctx.createLinearGradient(0, 0, 0, 260);
        usersGradient.addColorStop(0, 'rgba(32, 178, 107, 0.95)');
        usersGradient.addColorStop(1, 'rgba(32, 178, 107, 0.42)');

        const chart = new window.Chart(ctx, {
            type: 'bar',
            data: {
                labels: activityLabels,
                datasets: [
                    {
                        label: 'New Blogs',
                        data: rawNewBlogsData,
                        backgroundColor: blogsGradient,
                        borderColor: '#2e7bff',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 26,
                        categoryPercentage: 0.62,
                        barPercentage: 0.9,
                    },
                    {
                        label: 'New Users',
                        data: rawNewUsersData,
                        backgroundColor: usersGradient,
                        borderColor: '#20b26b',
                        borderWidth: 1,
                        borderRadius: 8,
                        maxBarThickness: 26,
                        categoryPercentage: 0.62,
                        barPercentage: 0.9,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: true,
                },
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
                    if (!elements.length) {
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
                    const modalLabel = (isBlog ? 'New Blogs' : 'New Users') + ' - ' + dateLabel;
                    const items = isBlog
                        ? (newBlogsItemsByDate[dateKey] || [])
                        : (newUsersItemsByDate[dateKey] || []);

                    openActivityModal(modalRefs, modalLabel, items, isBlog);
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            color: '#667892',
                            font: {
                                weight: 600,
                            },
                        },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#667892',
                            stepSize: 1,
                        },
                        grid: {
                            color: 'rgba(148, 167, 195, 0.22)',
                            borderDash: [4, 4],
                        },
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        backgroundColor: '#0f1f3a',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        titleColor: '#fff',
                        bodyColor: '#dbe8ff',
                        padding: 10,
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': ' + context.raw;
                            }
                        }
                    }
                }
            }
        });

        initLegendToggle(chart);
    }

    document.addEventListener('DOMContentLoaded', initDashboardActivityChart);
})();
