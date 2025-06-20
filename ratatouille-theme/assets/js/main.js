jQuery(document).ready(function($) {
    console.log('Main script loaded');
    
    // Фіксована шапка при прокрутці
    function handleStickyHeader() {
        var header = $('.site-header');
        var scrollPosition = $(window).scrollTop();
        
        if (scrollPosition > 200) {
            header.addClass('scrolled');
        } else {
            header.removeClass('scrolled');
        }
        
        $(window).scroll(function() {
            scrollPosition = $(window).scrollTop();
            if (scrollPosition > 200) {
                header.addClass('scrolled');
            } else {
                header.removeClass('scrolled');
            }
        });
    }

    // Мобільне меню
    function handleMobileMenu() {
        var menuToggle = $('.menu-toggle');
        var mainNavigation = $('.main-navigation');
        
        menuToggle.on('click', function() {
            mainNavigation.toggleClass('active');
            $(this).attr('aria-expanded', mainNavigation.hasClass('active'));
        });
        
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.main-navigation, .menu-toggle').length) {
                mainNavigation.removeClass('active');
                menuToggle.attr('aria-expanded', 'false');
            }
        });
    }

    // Анімація елементів при скролі
    function handleScrollAnimations() {
        $('.fade-in-up').each(function() {
            var element = $(this);
            var delay = element.data('delay') || 0;
            
            element.css({
                'opacity': 0,
                'transform': 'translateY(30px)',
                'transition': 'opacity 0.8s ease, transform 0.8s ease',
                'transition-delay': delay + 'ms'
            });
        });
        
        function isElementInViewport(el) {
            var rect = el.getBoundingClientRect();
            return (
                rect.top <= window.innerHeight * 0.8 &&
                rect.bottom >= 0
            );
        }
        
        function animateElements() {
            $('.fade-in-up').each(function() {
                if (isElementInViewport(this) && $(this).css('opacity') === '0') {
                    $(this).css({
                        'opacity': 1,
                        'transform': 'translateY(0)'
                    });
                }
            });
        }
        
        animateElements();
        $(window).on('scroll', animateElements);
    }

    // Показ/приховання складу страв
    function handleIngredientsToggle() {
        $('.ingredients-btn').on('click', function() {
            var $content = $(this).next('.ingredients-content');
            var $button = $(this);
            
            if ($content.hasClass('active')) {
                $content.removeClass('active');
                $button.text('Показати склад');
            } else {
                $content.addClass('active');
                $button.text('Приховати склад');
            }
        });
    }

    // Initialize all functions
    try {
        handleStickyHeader();
        handleMobileMenu();
        handleScrollAnimations();
        handleIngredientsToggle();
        
        console.log('Main script functions initialized successfully');
    } catch (error) {
        console.log('Error in main script initialization:', error);
    }
    
    // Check if we're on reservation page and initialize reservation functionality
    if ($('#reservation-form').length) {
        console.log('Reservation form found, initializing...');
        // The reservation.js file will handle the form functionality
    }
});