jQuery(document).ready(function($) {
    // Store initial scroll position and body overflow
    var initialScrollPos = 0;
    var initialBodyOverflow = $('body').css('overflow');

    // Просто добавляем класс loaded для анимации
    $('.gallery-grid').addClass('is-loaded');

    // Инициализация лайтбокса
    if ($('.gallery-lightbox').length) {
        $('.gallery-lightbox').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 2],
                tCounter: '%curr% из %total%'
            },
            image: {
                titleSrc: function(item) {
                    return item.el.find('img').attr('alt') || '';
                },
                verticalFit: true
            },
            zoom: {
                enabled: true,
                duration: 300,
                easing: 'ease-in-out'
            },
            callbacks: {
                beforeOpen: function() {
                    // Store current scroll position and body overflow
                    initialScrollPos = $(window).scrollTop();
                    initialBodyOverflow = $('body').css('overflow');
                    // Set body overflow to hidden to prevent scrolling
                    $('body').css({
                        'overflow': 'hidden',
                        'paddingRight': getScrollbarWidth() + 'px'
                    });
                },
                beforeClose: function() {
                    // Restore original body overflow and scroll position
                    $('body').css({
                        'overflow': initialBodyOverflow,
                        'paddingRight': ''
                    });
                    // Restore scroll position after a short delay
                    setTimeout(function() {
                        $(window).scrollTop(initialScrollPos);
                    }, 10);
                }
            }
        });
    }

    // Function to calculate scrollbar width
    function getScrollbarWidth() {
        // Create a temporary div with overflow
        var outer = document.createElement('div');
        outer.style.visibility = 'hidden';
        outer.style.overflow = 'scroll';
        document.body.appendChild(outer);

        // Create an inner div
        var inner = document.createElement('div');
        outer.appendChild(inner);

        // Calculate the width difference
        var scrollbarWidth = outer.offsetWidth - inner.offsetWidth;

        // Clean up
        outer.parentNode.removeChild(outer);

        return scrollbarWidth;
    }

    // Обработка фильтрации категорий
    $('.category-filter').on('click', function() {
        const filterValue = $(this).attr('data-category');
        
        $('.category-filter').removeClass('active').attr('aria-pressed', 'false');
        $(this).addClass('active').attr('aria-pressed', 'true');
        
        if (filterValue === 'all') {
            $('.gallery-item').show();
        } else {
            $('.gallery-item').hide();
            $(`.gallery-item[data-category="${filterValue}"]`).show();
        }
    });
});