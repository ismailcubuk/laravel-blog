(function () {
    'use strict';

    const parser = new DOMParser();
    const scriptSkipPattern = /(jquery|bootstrap|adminlte|owl\.js|custom\.js|auto-alerts|form-spellcheck|global-select|pjax|navigation-optimizer|sidebar\.js)/i;

    const normalizeUrl = (value) => {
        try {
            return new URL(value, window.location.href);
        } catch (error) {
            return null;
        }
    };

    const samePath = (left, right) => left.pathname.replace(/\/+$/, '') === right.pathname.replace(/\/+$/, '');
    const isModifiedClick = (event) => event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0;
    const isHtmlResponse = (response) => (response.headers.get('content-type') || '').includes('text/html');

    const runReadyHandlers = (handlers) => {
        const event = new Event('DOMContentLoaded');
        handlers.forEach((handler) => {
            if (typeof handler === 'function') {
                handler.call(document, event);
            } else if (handler && typeof handler.handleEvent === 'function') {
                handler.handleEvent(event);
            }
        });
    };

    const executeScript = (sourceScript) => new Promise((resolve) => {
        if (sourceScript.type && sourceScript.type !== 'text/javascript' && sourceScript.type !== 'module') {
            resolve();
            return;
        }

        const readyHandlers = [];
        const originalAddEventListener = document.addEventListener;
        const interceptReady = () => {
            document.addEventListener = function (type, listener, options) {
                if (type === 'DOMContentLoaded' && document.readyState !== 'loading') {
                    readyHandlers.push(listener);
                    return;
                }

                return originalAddEventListener.call(document, type, listener, options);
            };
        };
        const restoreReady = () => {
            document.addEventListener = originalAddEventListener;
            runReadyHandlers(readyHandlers);
        };

        const script = document.createElement('script');
        Array.from(sourceScript.attributes).forEach((attribute) => script.setAttribute(attribute.name, attribute.value));

        if (sourceScript.src) {
            const src = sourceScript.getAttribute('src') || '';
            if (scriptSkipPattern.test(src)) {
                resolve();
                return;
            }

            interceptReady();
            script.onload = () => {
                restoreReady();
                resolve();
            };
            script.onerror = () => {
                restoreReady();
                resolve();
            };
            script.src = sourceScript.src;
        } else {
            interceptReady();
            script.textContent = sourceScript.textContent;
        }

        document.body.appendChild(script);

        if (!sourceScript.src) {
            script.remove();
            restoreReady();
            resolve();
        }
    });

    class ProjectPjax {
        constructor(options) {
            this.scope = options.scope;
            this.containerSelector = options.containerSelector;
            this.include = options.include || (() => true);
            this.prefetch = new Map();
            this.pageCache = new Map();
            this.maxCacheEntries = options.maxCacheEntries || 12;
            this.maxPrefetchEntries = options.maxPrefetchEntries || 4;
            this.prefetchTimeout = options.prefetchTimeout || 2500;
            this.abortController = null;
            this.isLoading = false;
            this.container = document.querySelector(this.containerSelector);
        }

        start() {
            if (!this.container) {
                return;
            }

            if (!history.state || history.state.pjaxScope !== this.scope) {
                history.replaceState({ pjaxScope: this.scope, url: window.location.href }, '', window.location.href);
            }

            document.addEventListener('click', (event) => this.onClick(event));
            document.addEventListener('submit', (event) => this.onSubmit(event));
            document.addEventListener('mouseover', (event) => this.onHover(event), { passive: true });
            document.addEventListener('focusin', (event) => this.onHover(event), { passive: true });
            this.prefetchVisibleLinks();

            window.addEventListener('popstate', (event) => {
                if (event.state && event.state.pjaxScope === this.scope) {
                    this.visit(window.location.href, { push: false });
                }
            });
        }

        headers() {
            return {
                Accept: 'text/html, application/xhtml+xml',
                'X-Requested-With': 'XMLHttpRequest',
                'X-PJAX': 'true',
            };
        }

        eligibleUrl(url) {
            return Boolean(url && url.origin === window.location.origin && ['http:', 'https:'].includes(url.protocol) && this.include(url));
        }

        eligibleLink(link) {
            if (!link || link.closest('[data-no-pjax]') || link.target && link.target !== '_self' || link.hasAttribute('download')) {
                return false;
            }

            const href = link.getAttribute('href') || '';
            if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) {
                return false;
            }

            const url = normalizeUrl(link.href);
            if (!this.eligibleUrl(url)) {
                return false;
            }

            return !(samePath(url, window.location) && url.hash);
        }

        onClick(event) {
            if (isModifiedClick(event)) {
                return;
            }

            const link = event.target.closest('a[href]');
            if (!this.eligibleLink(link)) {
                return;
            }

            event.preventDefault();
            this.visit(link.href, { push: true });
        }

        onHover(event) {
            const link = event.target.closest('a[href]');
            if (this.eligibleLink(link)) {
                this.prefetchUrl(link.href);
            }
        }

        prefetchVisibleLinks() {
            if (!this.shouldPrefetch()) {
                return;
            }

            const run = () => {
                Array.from(document.querySelectorAll('a[href]'))
                    .filter((link) => this.eligibleLink(link))
                    .slice(0, this.maxPrefetchEntries)
                    .forEach((link) => this.prefetchUrl(link.href));
            };

            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(run, { timeout: 1800 });
                return;
            }

            window.setTimeout(run, 900);
        }

        prefetchUrl(value) {
            if (!this.shouldPrefetch() || this.prefetch.size >= this.maxPrefetchEntries) {
                return;
            }

            const url = normalizeUrl(value);
            if (!url || this.prefetch.has(url.href) || this.pageCache.has(url.href)) {
                return;
            }

            const controller = new AbortController();
            const timeout = window.setTimeout(() => controller.abort(), this.prefetchTimeout);
            const request = fetch(url.href, {
                headers: this.headers(),
                credentials: 'same-origin',
                signal: controller.signal,
            }).then((response) => (isHtmlResponse(response) ? response.text() : null)).then((html) => {
                if (html) {
                    this.remember(url.href, html);
                }

                return html;
            }).catch(() => null).finally(() => {
                window.clearTimeout(timeout);
                this.prefetch.delete(url.href);
            });

            this.prefetch.set(url.href, request);
        }

        shouldPrefetch() {
            const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

            if (!connection) {
                return true;
            }

            if (connection.saveData) {
                return false;
            }

            return !['slow-2g', '2g', '3g'].includes(connection.effectiveType);
        }

        onSubmit(event) {
            if (event.defaultPrevented) {
                return;
            }

            const form = event.target.closest('form');
            if (!form || form.closest('[data-no-pjax]') || form.hasAttribute('data-no-pjax') || form.hasAttribute('data-front-mode-switch')) {
                return;
            }

            const method = (form.getAttribute('method') || 'GET').toUpperCase();
            const action = normalizeUrl(form.getAttribute('action') || window.location.href);
            if (!this.eligibleUrl(action) || action.pathname.includes('/logout')) {
                return;
            }

            if (form.enctype === 'multipart/form-data' || form.querySelector('input[type="file"]')) {
                return;
            }

            event.preventDefault();

            if (method === 'GET') {
                action.search = new URLSearchParams(new FormData(form)).toString();
                this.visit(action.href, { push: true });
                return;
            }

            this.submit(form, action.href, method);
        }

        async visit(url, options) {
            if (this.isLoading && this.abortController) {
                this.abortController.abort();
            }

            const nextUrl = normalizeUrl(url);
            if (!this.eligibleUrl(nextUrl)) {
                window.location.href = url;
                return;
            }

            this.startProgress();

            try {
                const cached = this.pageCache.get(nextUrl.href) || this.prefetch.get(nextUrl.href);
                const html = cached ? await cached : await this.fetchHtml(nextUrl.href);
                if (!html) {
                    throw new Error('Empty PJAX response');
                }

                this.remember(nextUrl.href, html);
                await this.swap(html, nextUrl.href);

                if (options.push) {
                    history.pushState({ pjaxScope: this.scope, url: nextUrl.href }, '', nextUrl.href);
                }

                this.finishProgress();
            } catch (error) {
                if (error.name !== 'AbortError') {
                    window.location.href = url;
                }
            }
        }

        async submit(form, url, method) {
            this.startProgress();

            try {
                const html = await this.fetchHtml(url, {
                    method,
                    body: new FormData(form),
                });

                this.pageCache.clear();
                this.prefetch.clear();
                const finalUrl = this.abortController.responseUrl || url;
                await this.swap(html, finalUrl);
                history.pushState({ pjaxScope: this.scope, url: finalUrl }, '', finalUrl);
                this.finishProgress();
            } catch (error) {
                HTMLFormElement.prototype.submit.call(form);
            }
        }

        async fetchHtml(url, init) {
            this.abortController = new AbortController();
            const response = await fetch(url, Object.assign({
                headers: this.headers(),
                credentials: 'same-origin',
                signal: this.abortController.signal,
            }, init || {}));

            this.abortController.responseUrl = response.url;

            if (!response.ok || !isHtmlResponse(response)) {
                throw new Error('PJAX response is not HTML');
            }

            return response.text();
        }

        remember(url, html) {
            this.pageCache.set(url, html);
            while (this.pageCache.size > this.maxCacheEntries) {
                this.pageCache.delete(this.pageCache.keys().next().value);
            }
        }

        async swap(html, url) {
            const nextDocument = parser.parseFromString(html, 'text/html');
            const nextContainer = nextDocument.querySelector(this.containerSelector);
            if (!nextContainer) {
                throw new Error('Missing PJAX container');
            }

            document.body.classList.add(`${this.scope}-pjax-swapping`);

            if (nextDocument.title) {
                document.title = nextDocument.title;
            }

            this.syncHeadAssets(nextDocument);
            this.container = document.querySelector(this.containerSelector);
            this.container.innerHTML = nextContainer.innerHTML;
            this.syncBody(nextDocument);
            this.syncNavigation(url);
            await this.runPageScripts(nextDocument);
            window.scrollTo({ top: 0, behavior: 'auto' });

            document.dispatchEvent(new CustomEvent('pjax:load', {
                detail: { scope: this.scope, url, container: this.container },
            }));

            requestAnimationFrame(() => {
                document.body.classList.remove(`${this.scope}-pjax-swapping`);
                this.prefetchVisibleLinks();
            });
        }

        syncBody(nextDocument) {
            const keep = [`${this.scope}-is-navigating`, `${this.scope}-pjax-swapping`];
            const transitionClasses = keep.filter((className) => document.body.classList.contains(className));
            document.body.className = Array.from(nextDocument.body.classList).concat(transitionClasses).join(' ');
        }

        getHeadStack(rootDocument) {
            const start = rootDocument.head.querySelector(`meta[name="pjax-head-start"][content="${this.scope}"]`);
            const end = rootDocument.head.querySelector(`meta[name="pjax-head-end"][content="${this.scope}"]`);
            if (!start || !end) {
                return [];
            }

            const nodes = [];
            let node = start.nextSibling;
            while (node && node !== end) {
                if (node.nodeType === Node.ELEMENT_NODE && (node.matches('style') || node.matches('link[rel="stylesheet"]'))) {
                    nodes.push(node);
                }
                node = node.nextSibling;
            }
            return nodes;
        }

        syncHeadAssets(nextDocument) {
            const currentEnd = document.head.querySelector(`meta[name="pjax-head-end"][content="${this.scope}"]`);
            if (!currentEnd) {
                return;
            }

            this.getHeadStack(document).forEach((node) => node.remove());
            this.getHeadStack(nextDocument).forEach((node) => currentEnd.parentNode.insertBefore(node.cloneNode(true), currentEnd));
        }

        syncNavigation(url) {
            const nextUrl = normalizeUrl(url);
            const links = this.scope === 'admin'
                ? document.querySelectorAll('.admin-sidebar .nav-link[href]')
                : document.querySelectorAll('.front-navbar .nav-link[href]');
            const authorTabs = this.scope === 'front'
                ? document.querySelectorAll('.front-author-tab[href]')
                : [];

            let bestMatch = null;
            let bestScore = -1;

            links.forEach((link) => {
                const linkUrl = normalizeUrl(link.href);
                if (!linkUrl) {
                    return;
                }

                const exact = nextUrl && samePath(linkUrl, nextUrl);
                const prefix = nextUrl && this.scope === 'admin' && nextUrl.pathname.startsWith(linkUrl.pathname + '/');
                const score = exact || prefix ? linkUrl.pathname.length : -1;
                if (score > bestScore) {
                    bestScore = score;
                    bestMatch = link;
                }

                link.classList.remove('active');
                const item = link.closest('.nav-item');
                if (item) {
                    item.classList.remove('active');
                }
            });

            if (bestMatch) {
                bestMatch.classList.add('active');
                const item = bestMatch.closest('.nav-item');
                if (item) {
                    item.classList.add('active');
                }
            }

            authorTabs.forEach((tab) => {
                const tabUrl = normalizeUrl(tab.href);
                tab.classList.toggle('is-active', Boolean(nextUrl && tabUrl && samePath(tabUrl, nextUrl)));
            });
        }

        async runPageScripts(nextDocument) {
            const nextContainer = nextDocument.querySelector(this.containerSelector);
            const scripts = Array.from(nextDocument.body.querySelectorAll('script')).filter((script) => {
                if (nextContainer && nextContainer.contains(script)) {
                    return true;
                }
                return Boolean(nextContainer && (nextContainer.compareDocumentPosition(script) & Node.DOCUMENT_POSITION_FOLLOWING));
            });

            for (const script of scripts) {
                await executeScript(script);
            }
        }

        startProgress() {
            this.isLoading = true;
            document.body.classList.add(`${this.scope}-is-navigating`);
        }

        finishProgress() {
            window.setTimeout(() => {
                document.body.classList.remove(`${this.scope}-is-navigating`);
                this.isLoading = false;
            }, 0);
        }
    }

    window.ProjectPjax = {
        start(options) {
            const instance = new ProjectPjax(options);
            instance.start();
            return instance;
        },
    };
})();
