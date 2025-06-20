<?php
/**
 * Template Name: Special Offers Page
 * 
 * This template displays the restaurant special offers
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Special Offers Section -->
    <section id="specialties" class="section specialties-section">
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            
            <?php while (have_posts()) : the_post(); ?>
                <div class="page-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
            
            <?php
            // Get special offers from ACF fields
            $special_offers = get_field('special_offers');
            
            if ($special_offers && is_array($special_offers)) : ?>
                <div class="special-offers-slider-wrapper">
                    <div class="special-offers-slider">
                        <?php foreach ($special_offers as $index => $offer) : 
                            $dish_id = 'special-offer-' . $index; // Уникальный ID для каждого блюда
                        ?>
                            <div class="menu-item fade-in-up">
                                <?php if (!empty($offer['offer_image'])) : ?>
                                    <div class="item-image">
                                        <img src="<?php echo esc_url($offer['offer_image']['url']); ?>" 
                                             alt="<?php echo esc_attr($offer['offer_image']['alt'] ?? $offer['offer_title']); ?>">
                                        <?php if (!empty($offer['offer_badge'])) : ?>
                                            <div class="item-badge <?php echo esc_attr($offer['offer_badge']); ?>">
                                                <?php 
                                                $badge_labels = [
                                                    'new' => 'Новинка',
                                                    'special' => 'Спеціальна пропозиція',
                                                    'limited' => 'Обмежена пропозиція',
                                                    'sale' => 'Акція'
                                                ];
                                                echo esc_html($badge_labels[$offer['offer_badge']] ?? $offer['offer_badge']); 
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="item-content">
                                    <h3 class="item-name"><?php echo esc_html($offer['offer_title']); ?></h3>
                                    <p class="item-description"><?php echo esc_html($offer['offer_description']); ?></p>

                                    <?php if (!empty($offer['offer_spiciness']) && $offer['offer_spiciness'] > 0) : ?>
                                        <div class="spicy-level">
                                            <span class="spicy-label">Рівень гостроти:</span>
                                            <div class="spicy-stars">
                                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                    <i class="fas fa-pepper-hot <?php echo $i <= $offer['offer_spiciness'] ? 'active' : ''; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($offer['offer_ingredients']) && is_array($offer['offer_ingredients'])) : ?>
                                        <button type="button" class="ingredients-btn" data-dish="<?php echo esc_attr($dish_id); ?>">
                                            <?php esc_html_e('Показати склад', 'ratatouille'); ?>
                                        </button>
                                        <div id="<?php echo esc_attr($dish_id); ?>" class="ingredients-content">
                                            <?php foreach ($offer['offer_ingredients'] as $ingredient) : ?>
                                                <div class="ingredient-item">
                                                    <?php echo esc_html($ingredient['ingredient_name']); ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                    <p class="item-price"><?php echo number_format((float)$offer['offer_price'], 2, '.', ''); ?> ₴</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Slider Navigation -->
                    <div class="slider-navigation">
                        <button type="button" class="slider-btn slider-prev">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button type="button" class="slider-btn slider-next">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <!-- Slider Dots -->
                    <div class="slider-dots"></div>
                </div>
            <?php else : ?>
                <div class="no-specialties">
                    <p><?php esc_html_e('Наразі спеціальних пропозицій немає.', 'ratatouille'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
/* Special Offers Slider Styles */
.special-offers-slider-wrapper {
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    overflow: hidden;
}

.special-offers-slider {
    display: flex;
    transition: transform 0.5s ease;
    gap: 30px;
}

.special-offers-slider .menu-item {
    flex: 0 0 350px;
    max-width: 350px;
    margin: 0;
}

/* Slider Navigation */
.slider-navigation {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    pointer-events: none;
    z-index: 10;
}

.slider-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(230, 126, 34, 0.9);
    border: none;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.3s ease;
    pointer-events: all;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.slider-btn:hover {
    background: var(--accent);
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.slider-btn:disabled {
    background: rgba(108, 117, 125, 0.5);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.slider-prev {
    left: -25px;
}

.slider-next {
    right: -25px;
}

/* Slider Dots */
.slider-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}

.slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-dot.active {
    background: var(--accent);
    transform: scale(1.2);
}

.slider-dot:hover {
    background: var(--accent);
}

/* Responsive */
@media (max-width: 1200px) {
    .special-offers-slider .menu-item {
        flex: 0 0 320px;
        max-width: 320px;
    }
}

@media (max-width: 768px) {
    .special-offers-slider .menu-item {
        flex: 0 0 280px;
        max-width: 280px;
    }
    
    .slider-prev {
        left: -15px;
    }
    
    .slider-next {
        right: -15px;
    }
    
    .slider-btn {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .special-offers-slider .menu-item {
        flex: 0 0 250px;
        max-width: 250px;
    }
    
    .slider-prev {
        left: -10px;
    }
    
    .slider-next {
        right: -10px;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Ingredients toggle functionality for special offers
    $('.ingredients-btn').on('click', function() {
        const dishId = $(this).attr('data-dish');
        const ingredientsContent = $('#' + dishId);
        const button = $(this);
        
        if (ingredientsContent.hasClass('active')) {
            // Hide ingredients
            ingredientsContent.removeClass('active');
            button.text('<?php esc_html_e('Показати склад', 'ratatouille'); ?>');
        } else {
            // Show ingredients
            ingredientsContent.addClass('active');
            button.text('<?php esc_html_e('Приховати склад', 'ratatouille'); ?>');
        }
    });
    
    // Special Offers Slider
    let currentSlide = 0;
    const $slider = $('.special-offers-slider');
    const $slides = $('.special-offers-slider .menu-item');
    const totalSlides = $slides.length;
    
    if (totalSlides > 1) {
        // Calculate slides per view based on screen width
        function getSlidesPerView() {
            const screenWidth = $(window).width();
            if (screenWidth >= 1200) return 3;
            if (screenWidth >= 768) return 2;
            return 1;
        }
        
        let slidesPerView = getSlidesPerView();
        const maxSlide = Math.max(0, totalSlides - slidesPerView);
        
        // Create dots
        function createDots() {
            const $dotsContainer = $('.slider-dots');
            $dotsContainer.empty();
            
            const dotsCount = Math.ceil(totalSlides / slidesPerView);
            for (let i = 0; i < dotsCount; i++) {
                const $dot = $('<div class="slider-dot"></div>');
                if (i === 0) $dot.addClass('active');
                $dot.on('click', function() {
                    goToSlide(i * slidesPerView);
                });
                $dotsContainer.append($dot);
            }
        }
        
        // Update slider position
        function updateSlider() {
            const slideWidth = $slides.first().outerWidth(true);
            const translateX = -currentSlide * slideWidth;
            $slider.css('transform', `translateX(${translateX}px)`);
            
            // Update navigation buttons
            $('.slider-prev').prop('disabled', currentSlide === 0);
            $('.slider-next').prop('disabled', currentSlide >= maxSlide);
            
            // Update dots
            const activeDotIndex = Math.floor(currentSlide / slidesPerView);
            $('.slider-dot').removeClass('active');
            $('.slider-dot').eq(activeDotIndex).addClass('active');
        }
        
        // Go to specific slide
        function goToSlide(slideIndex) {
            currentSlide = Math.max(0, Math.min(slideIndex, maxSlide));
            updateSlider();
        }
        
        // Previous slide
        $('.slider-prev').on('click', function() {
            if (currentSlide > 0) {
                goToSlide(currentSlide - 1);
            }
        });
        
        // Next slide
        $('.slider-next').on('click', function() {
            if (currentSlide < maxSlide) {
                goToSlide(currentSlide + 1);
            }
        });
        
        // Handle window resize
        $(window).on('resize', function() {
            const newSlidesPerView = getSlidesPerView();
            if (newSlidesPerView !== slidesPerView) {
                slidesPerView = newSlidesPerView;
                const newMaxSlide = Math.max(0, totalSlides - slidesPerView);
                
                // Adjust current slide if needed
                if (currentSlide > newMaxSlide) {
                    currentSlide = newMaxSlide;
                }
                
                createDots();
                updateSlider();
            }
        });
        
        // Auto-play slider
        let autoplayInterval;
        
        function startAutoplay() {
            autoplayInterval = setInterval(function() {
                if (currentSlide >= maxSlide) {
                    goToSlide(0);
                } else {
                    goToSlide(currentSlide + 1);
                }
            }, 5000);
        }
        
        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }
        
        // Pause autoplay on hover
        $('.special-offers-slider-wrapper').on('mouseenter', stopAutoplay);
        $('.special-offers-slider-wrapper').on('mouseleave', startAutoplay);
        
        // Initialize
        createDots();
        updateSlider();
        startAutoplay();
        
        // Touch/swipe support for mobile
        let startX = 0;
        let isDragging = false;
        
        $slider.on('touchstart mousedown', function(e) {
            isDragging = true;
            startX = e.type === 'touchstart' ? e.originalEvent.touches[0].clientX : e.clientX;
            stopAutoplay();
        });
        
        $(document).on('touchmove mousemove', function(e) {
            if (!isDragging) return;
            
            const currentX = e.type === 'touchmove' ? e.originalEvent.touches[0].clientX : e.clientX;
            const diffX = startX - currentX;
            
            if (Math.abs(diffX) > 50) {
                if (diffX > 0 && currentSlide < maxSlide) {
                    goToSlide(currentSlide + 1);
                } else if (diffX < 0 && currentSlide > 0) {
                    goToSlide(currentSlide - 1);
                }
                isDragging = false;
            }
        });
        
        $(document).on('touchend mouseup', function() {
            if (isDragging) {
                isDragging = false;
                startAutoplay();
            }
        });
    } else {
        // Hide navigation if only one slide
        $('.slider-navigation, .slider-dots').hide();
    }
    
    // Animation for fade-in-up elements
    $('.fade-in-up').each(function(index) {
        const delay = $(this).data('delay') || 0;
        $(this).css({
            'animation-delay': delay + 'ms'
        });
    });
});
</script>

<?php get_footer(); ?>