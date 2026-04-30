jQuery(document).ready(function ($) {
    'use strict';

    const hidePreloader = () => {
        const preloader = $('#preloader');
        if (!preloader.length || preloader.data('front-hidden')) {
            return;
        }

        preloader.data('front-hidden', true).animate({
            opacity: '0',
        }, 600, function () {
            setTimeout(function () {
                preloader.css('visibility', 'hidden').fadeOut();
            }, 300);
        });
    };

    const initCarousel = (selector, options) => {
        const element = $(selector);
        if (!element.length || element.hasClass('owl-loaded')) {
            return;
        }

        element.owlCarousel(options);
    };

    const initFrontEnhancements = () => {
        $('header.front-header').removeClass('background-header');

        initCarousel('.owl-clients', {
            loop: true,
            nav: false,
            dots: true,
            items: 1,
            margin: 30,
            autoplay: false,
            smartSpeed: 700,
            autoplayTimeout: 6000,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                },
                460: {
                    items: 1,
                    margin: 0,
                },
                576: {
                    items: 3,
                    margin: 20,
                },
                992: {
                    items: 5,
                    margin: 30,
                },
            },
        });

        initCarousel('.owl-banner', {
            loop: true,
            nav: true,
            dots: true,
            items: 3,
            margin: 10,
            autoplay: false,
            smartSpeed: 700,
            autoplayTimeout: 6000,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                },
                460: {
                    items: 1,
                    margin: 0,
                },
                768: {
                    items: 2,
                    margin: 10,
                },
                1200: {
                    items: 3,
                    margin: 10,
                },
            },
        });
    };

    window.initFrontEnhancements = initFrontEnhancements;

    hidePreloader();
    initFrontEnhancements();

    document.addEventListener('pjax:load', (event) => {
        if (event.detail && event.detail.scope === 'front') {
            initFrontEnhancements();
        }
    });
});
