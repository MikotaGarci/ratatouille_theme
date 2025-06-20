jQuery(document).ready(function($) {
    console.log('Testimonials script loaded');
    
    // Check if slider exists and has content before initializing
    if ($('.testimonials-slider').length && $('.testimonials-slider .testimonial-slide').length > 0) {
        console.log('Found testimonials slider with slides:', $('.testimonials-slider .testimonial-slide').length);
        
        // Wait for DOM to be fully loaded and check if slick is available
        setTimeout(function() {
            try {
                // Check if slick is available
                if (typeof $.fn.slick === 'undefined') {
                    console.log('Slick slider not available');
                    return;
                }
                
                // Initialize slick slider
                $('.testimonials-slider').slick({
                    dots: true,
                    infinite: true,
                    speed: 500,
                    fade: true,
                    cssEase: 'linear',
                    autoplay: true,
                    autoplaySpeed: 5000,
                    arrows: true,
                    adaptiveHeight: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                dots: true
                            }
                        }
                    ]
                });
                console.log('Testimonials slider initialized successfully');
            } catch (error) {
                console.log('Error initializing testimonials slider:', error);
                // Fallback: show all testimonials without slider
                $('.testimonial-slide').show();
            }
        }, 500);
    } else {
        console.log('No testimonials slider found or no slides available');
        console.log('Slider element exists:', $('.testimonials-slider').length > 0);
        console.log('Slides count:', $('.testimonials-slider .testimonial-slide').length);
    }
});