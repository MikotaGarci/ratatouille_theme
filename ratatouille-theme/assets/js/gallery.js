jQuery(document).ready(function($) {
    console.log('Gallery script loaded');
    
    // Add loaded class for animation
    $('.gallery-grid').addClass('is-loaded');

    // Initialize Magnific Popup for lightbox only if elements exist
    if ($('.gallery-lightbox').length && typeof $.fn.magnificPopup !== 'undefined') {
        console.log('Initializing Magnific Popup');
        
        try {
            $('.gallery-lightbox').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 2],
                    tCounter: '%curr% з %total%'
                },
                image: {
                    titleSrc: 'title',
                    verticalFit: true,
                    tError: 'Зображення не може бути завантажене.'
                },
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: 'ease-in-out'
                },
                callbacks: {
                    beforeOpen: function() {
                        console.log('Opening lightbox');
                        $('body').addClass('lightbox-open');
                    },
                    afterClose: function() {
                        console.log('Closing lightbox');
                        $('body').removeClass('lightbox-open');
                    },
                    imageLoadComplete: function() {
                        console.log('Image loaded in lightbox');
                    }
                }
            });
        } catch (error) {
            console.log('Error initializing Magnific Popup:', error);
        }
    } else {
        console.log('Magnific Popup not available or no gallery items found');
    }

    // Category filtering
    $('.category-filter').on('click', function() {
        console.log('Category filter clicked');
        
        var filterValue = $(this).attr('data-category');
        
        // Update active button
        $('.category-filter').removeClass('active');
        $(this).addClass('active');
        
        // Filter gallery items
        if (filterValue === 'all') {
            $('.gallery-item').fadeIn(300);
        } else {
            $('.gallery-item').fadeOut(300);
            $('.gallery-item[data-category="' + filterValue + '"]').fadeIn(300);
        }
        
        console.log('Filtered by category: ' + filterValue);
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                    }
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Add hover effects
    $('.gallery-item').hover(
        function() {
            $(this).find('.gallery-overlay').stop().fadeIn(200);
        },
        function() {
            $(this).find('.gallery-overlay').stop().fadeOut(200);
        }
    );
});