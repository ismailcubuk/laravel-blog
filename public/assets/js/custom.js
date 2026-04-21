jQuery( document ).ready(function( $ ) {


	"use strict";


        // Page loading animation

        $("#preloader").animate({
            'opacity': '0'
        }, 600, function(){
            setTimeout(function(){
                $("#preloader").css("visibility", "hidden").fadeOut();
            }, 300);
        });
        

        var $header = $("header.front-header");
        var stickyOffset = null;
        var ticking = false;
        var thresholdGap = 8;

        function resolveStickyOffset() {
            var box = $('.header-text').outerHeight() || 0;
            var headerHeight = $header.outerHeight() || 0;
            stickyOffset = Math.max(0, box - headerHeight);
        }

        function updateStickyHeader() {
            if (!$header.length) {
                return;
            }

            if (stickyOffset === null) {
                resolveStickyOffset();
            }

            var scroll = $(window).scrollTop();
            var isActive = $header.hasClass("background-header");

            if (!isActive && scroll >= stickyOffset + thresholdGap) {
                $header.addClass("background-header");
            } else if (isActive && scroll <= stickyOffset - thresholdGap) {
                $header.removeClass("background-header");
            }
        }

        updateStickyHeader();

        $(window).on('scroll', function() {
            if (ticking) {
                return;
            }

            ticking = true;
            window.requestAnimationFrame(function () {
                updateStickyHeader();
                ticking = false;
            });
        });

        $(window).on('resize', function () {
            resolveStickyOffset();
            updateStickyHeader();
        });

        if ($('.owl-clients').length) {
            $('.owl-clients').owlCarousel({
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
                        margin: 0
                    },
                    460: {
                        items: 1,
                        margin: 0
                    },
                    576: {
                        items: 3,
                        margin: 20
                    },
                    992: {
                        items: 5,
                        margin: 30
                    }
                }
            });
        }

        if ($('.owl-banner').length) {
            $('.owl-banner').owlCarousel({
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
                      margin: 0
                    },
                    460: {
                        items: 1,
                        margin: 0
                    },
                    768: {
                        items: 2,
                        margin: 10
                    },
                    1200: {
                      items: 3,
                      margin: 10
                    }
                }
            });
        }
 
});
