<?php get_header(); ?>

<main id="main" class="site-main">
    <!-- Hero Section -->
    <section class="hero" ('<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-bg.jpg'); ?>');">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html(get_theme_mod('ratatouille_hero_title', 'Ласкаво просимо до ресторану "Рататуй"')); ?></h1>
            <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('ratatouille_hero_subtitle', 'Істинний смак Франції у серці міста')); ?></p>
            <div class="hero-buttons">
                <a href="#reservation" class="btn pulse"><?php esc_html_e('Забронювати столик', 'ratatouille'); ?></a>
                <a href="#menu" class="btn btn-outline"><?php esc_html_e('Наше меню', 'ratatouille'); ?></a>
            </div>
        </div>
    </section>

    <!-- Special Offers Section -->
    <section id="specialties" class="section specialties-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Наші спеціальні пропозиції', 'ratatouille'); ?></h2>
            
            <?php
            $special_offers_page_id = 22; // ID страницы с предложениями
            $special_offers = function_exists('get_field') ? get_field('special_offers', $special_offers_page_id) : false;
            
            if ($special_offers && is_array($special_offers)) : ?>
                <div class="menu-items">
                    <?php foreach ($special_offers as $index => $offer) : 
                        $dish_id = 'dish-' . $index; // Уникальный ID для каждого блюда
                    ?>
                        <div class="menu-item fade-in-up" <?php if ($index > 0) echo 'data-delay="' . ($index * 200) . '"'; ?>>
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
            <?php else : ?>
                <div class="no-specialties">
                    <p><?php esc_html_e('Наразі спеціальних пропозицій немає.', 'ratatouille'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="section about-section">
        <div class="container">
            <div class="row">
                <?php 
                // Получаем страницу "Про нас" по slug или ID
                $about_page = get_page_by_path('about') ?: get_post(355); // 355 - ID из ACF группы
                $about_page_id = $about_page ? $about_page->ID : false;
                
                if ($about_page_id) {
                    $about_image = get_field('about_image', $about_page_id);
                    $about_title = get_field('about_title', $about_page_id, false);
                    $about_description = get_field('about_description', $about_page_id);
                    $about_features = get_field('about_features', $about_page_id);
                }
                
                // Устанавливаем заголовок по умолчанию
                if (empty($about_title)) {
                    $about_title = 'Про нас';
                }
                ?>
                
                <!-- About Image Column -->
                <?php if (!empty($about_image)) : ?>
                <div class="col-md-4">
                    <div class="about-image fade-in-left">
                        <img src="<?php echo esc_url($about_image['url']); ?>" 
                             alt="<?php echo esc_attr($about_image['alt']); ?>" 
                             class="img-fluid">
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- About Content Column -->
                <div class="<?php echo !empty($about_image) ? 'col-md-8' : 'col-md-12'; ?>">
                    <div class="about-content fade-in-right">
                        <h2 class="section-title"><?php echo esc_html($about_title); ?></h2>
                        
                        <?php if (!empty($about_description)) : ?>
                            <div class="about-description">
                                <?php echo wp_kses_post($about_description); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($about_features) && is_array($about_features)) : ?>
                            <div class="about-features row">
                                <?php foreach ($about_features as $index => $feature) : ?>
                                    <div class="feature-item col-md-6 fade-in-up" data-delay="<?php echo ($index % 2) * 200; ?>">
                                        <?php if (!empty($feature['icon'])) : ?>
                                            <div class="feature-icon">
                                                <i class="<?php echo esc_attr($feature['icon']); ?>"></i>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($feature['title'])) : ?>
                                            <h3 class="feature-title"><?php echo esc_html($feature['title']); ?></h3>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($feature['description'])) : ?>
                                            <div class="feature-description">
                                                <?php echo wp_kses_post($feature['description']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

  <!-- Menu Section -->
 <section id="menu" class="section menu-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Наше меню', 'ratatouille'); ?></h2>
            
            <?php
            // Get the menu page ID where ACF fields are stored
            $menu_page = get_page_by_path('menu');
            
            if ($menu_page) {
                // Switch to the menu page context
                global $post;
                $orig_post = $post;
                $post = $menu_page;
                setup_postdata($post);
                
                // Now check for menu categories
                if (have_rows('menu_categories')) :
            ?>
                <div class="menu-tabs">
                    <?php 
                    $first_category = true;
                    $category_index = 0;
                    
                    while (have_rows('menu_categories')) : the_row(); 
                        $category_name = get_sub_field('category_name');
                        $category_slug = sanitize_title($category_name);
                        
                        // Skip only the display of the soup button, but continue counting for index
                        if ($category_name === 'Суп' || $category_name === 'Супы' || $category_name === 'Супи') {
                            $category_index++;
                            continue;
                        }
                        
                        $category_index++;
                    ?>
                        
                        <?php $first_category = false; ?>
                    <?php endwhile; reset_rows(); ?>
                </div>
                
                <div class="menu-content-wrapper">
                    <?php 
                    $first_category = true;
                    $category_counter = 0;
                    
                    while (have_rows('menu_categories')) : the_row(); 
                        $category_name = get_sub_field('category_name');
                        $category_slug = sanitize_title($category_name);
                        $category_counter++;
                    ?>
                        <div class="menu-content <?php echo $first_category ? 'active' : ''; ?>" id="<?php echo esc_attr($category_slug); ?>">
                            <?php if (have_rows('dishes')) : ?>
                                <div class="menu-items" id="menu-items-<?php echo esc_attr($category_slug); ?>">
                                    <?php 
                                    $dish_counter = 0;
                                    while (have_rows('dishes')) : the_row(); 
                                        $image = get_sub_field('dish_image');
                                        $spiciness = get_sub_field('spiciness_level');
                                        $badge = get_sub_field('special_badge');
                                        $dish_counter++;
                                        $dish_id = 'dish-' . $category_counter . '-' . $dish_counter;
                                    ?>
                                        <div class="menu-item fade-in-up">
                                            <?php if ($image) : ?>
                                                <div class="item-image">
                                                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                                    <?php if ($badge) : ?>
                                                        <div class="item-badge <?php echo esc_attr($badge); ?>">
                                                            <?php 
                                                            $badge_labels = [
                                                                'new' => 'Новинка',
                                                                'chef_special' => 'Від шефа',
                                                                'spicy' => 'Гостра',
                                                                'vegetarian' => 'Вегетаріанська',
                                                                'bestseller' => 'Хіт продажу'
                                                            ];
                                                            echo esc_html($badge_labels[$badge] ?? $badge);
                                                            ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="item-content">
                                                <h4 class="item-name"><?php the_sub_field('dish_name'); ?></h4>
                                                <p class="item-description"><?php the_sub_field('dish_description'); ?></p>
                                                
                                                <div class="item-details">
                                                    <span class="item-weight"><?php the_sub_field('weight'); ?></span>
                                                    <span class="item-price"><?php the_sub_field('price'); ?> ₴</span>
                                                </div>
                                                
                                                <?php if ($spiciness > 0) : ?>
                                                    <div class="spicy-level">
                                                        <span class="spicy-label">Рівень гостроти:</span>
                                                        <div class="spicy-stars">
                                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                                <i class="fas fa-pepper-hot <?php echo $i <= $spiciness ? 'active' : ''; ?>"></i>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <?php if (have_rows('ingredients')) : ?>
                                                    <button type="button" class="ingredients-btn" data-dish="<?php echo esc_attr($dish_id); ?>">
                                                        <?php esc_html_e('Показати склад', 'ratatouille'); ?>
                                                    </button>
                                                    <div id="<?php echo esc_attr($dish_id); ?>" class="ingredients-content">
                                                        <?php while (have_rows('ingredients')) : the_row(); ?>
                                                            <div class="ingredient-item">
                                                                <?php the_sub_field('ingredient_name'); ?>
                                                            </div>
                                                        <?php endwhile; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                                
                                <!-- Кнопки для горизонтальной прокрутки -->
                                <div class="menu-scroll-controls">
                                    <div class="menu-scroll-btn scroll-left" data-target="<?php echo esc_attr($category_slug); ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                    <div class="menu-scroll-btn scroll-right" data-target="<?php echo esc_attr($category_slug); ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                                
                                <!-- Ссылка "Смотреть все" -->
                                <div class="view-all-menu">
                                    <a href="<?php echo get_permalink($menu_page->ID); ?>?category=<?php echo esc_attr($category_slug); ?>" class="btn btn-primary">
                                        <?php esc_html_e('Переглянути все меню', 'ratatouille'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php $first_category = false; ?>
                    <?php endwhile; ?>
                </div>
                <?php 
                    endif;
                    
                    // Restore original post
                    $post = $orig_post;
                    wp_reset_postdata();
                }
                ?>
        </div>
    </section>


    <!-- Testimonials Section -->
    <section id="testimonials" class="section testimonials-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Відгуки наших гостей', 'ratatouille'); ?></h2>
            
            <div class="testimonials-slider">
                <!-- Testimonial 1 -->
                <div class="testimonial-item fade-in-up">
                    <div class="testimonial-content">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Найкращий французький ресторан у місті! Рататуй був просто чудовим, а обслуговування - на вищому рівні."</p>
                        <div class="testimonial-author">
                            <p class="author-name">Олена Петренко</p>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-item fade-in-up" data-delay="200">
                    <div class="testimonial-content">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"Атмосфера затишного Парижа, прекрасна винна карта і приголомшливі десерти!"</p>
                        <div class="testimonial-author">
                            <p class="author-name">Михайло Коваленко</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


   <!-- Gallery Preview Section -->
<!-- Gallery Preview Section -->
<section id="gallery" class="section gallery-section">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('Галерея', 'ratatouille'); ?></h2>
        
        <?php
        // Get the gallery page
        $gallery_page = get_page_by_path('gallery');
        
        if ($gallery_page && have_rows('gallery_categories', $gallery_page->ID)) :
            $images_shown = 0;
            $max_images = 6; // Show only 6 images in preview
        ?>
            <div class="gallery-grid">
                <?php
                while (have_rows('gallery_categories', $gallery_page->ID)) : the_row();
                    $images = get_sub_field('category_images');
                    if ($images) :
                        foreach ($images as $image) :
                            if ($images_shown >= $max_images) break;
                            $images_shown++;
                ?>
                            <div class="gallery-item fade-in-up" data-delay="<?php echo $images_shown * 200; ?>">
                                <a href="<?php echo esc_url($image['url']); ?>" class="gallery-image gallery-lightbox">
                                    <img src="<?php echo esc_url($image['sizes']['medium_large']); ?>" 
                                         alt="<?php echo esc_attr($image['alt']); ?>">
                                    <div class="gallery-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </a>
                            </div>
                            
                <?php
                        endforeach;
                    endif;
                    if ($images_shown >= $max_images) break;
                endwhile;
                ?>
            </div>
            
            <div class="gallery-more-link text-center mt -80">
                
                <a href="<?php echo esc_url(get_permalink($gallery_page->ID)); ?>" class="btn1">
                    <?php esc_html_e('Переглянути всі фото', 'ratatouille'); ?>
                    
                </a>
            </div>
        <?php else : ?>
            <p class="no-gallery-items"><?php esc_html_e('Галерея порожня.', 'ratatouille'); ?></p>
        <?php endif; ?>
    </div>
</section>
    <!-- Reservation Section -->
    <section id="reservation" class="section reservation-section">
        <div class="container">
            <div class="reservation-grid">
                <div class="reservation-form-container fade-in-up">
                    <h2 class="section-title"><?php esc_html_e('Забронювати столик', 'ratatouille'); ?></h2>
                    
                    <form id="reservation-form" class="reservation-form">
                        <?php wp_nonce_field('submit_reservation', 'reservation_nonce'); ?>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name"><?php esc_html_e('Ім\'я', 'ratatouille'); ?></label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone"><?php esc_html_e('Телефон', 'ratatouille'); ?></label>
                                <input type="tel" id="phone" name="phone" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="date"><?php esc_html_e('Дата', 'ratatouille'); ?></label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="time"><?php esc_html_e('Час', 'ratatouille'); ?></label>
                                <select id="time" name="time" class="form-control" required>
                                    <option value="">Оберіть час</option>
                                    <option value="12:00">12:00</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:00">14:00</option>
                                    <option value="18:00">18:00</option>
                                    <option value="19:00">19:00</option>
                                    <option value="20:00">20:00</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="guests"><?php esc_html_e('Кількість гостей', 'ratatouille'); ?></label>
                                <select id="guests" name="guests" class="form-control" required>
                                    <option value="">Оберіть кількість</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6+">6+</option>
                                </select>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn"><?php esc_html_e('Забронювати', 'ratatouille'); ?></button>
                        <div class="form-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Unified ingredients toggle functionality for all sections
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('ingredients-btn')) {
            const button = e.target;
            const dishId = button.getAttribute('data-dish');
            const ingredientsContent = document.getElementById(dishId);
            
            if (ingredientsContent) {
                ingredientsContent.classList.toggle('active');
                button.textContent = ingredientsContent.classList.contains('active') 
                    ? '<?php esc_html_e('Приховати склад', 'ratatouille'); ?>' 
                    : '<?php esc_html_e('Показати склад', 'ratatouille'); ?>';
            }
        }
    });

    // Menu tabs functionality
    const menuTabs = document.querySelectorAll('.menu-tab');
    menuTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            menuTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const categoryId = this.getAttribute('data-category');
            document.querySelectorAll('.menu-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(categoryId).classList.add('active');
        });
    });
    
    // Menu scroll buttons functionality
    const scrollLeftBtns = document.querySelectorAll('.scroll-left');
    const scrollRightBtns = document.querySelectorAll('.scroll-right');
    
    scrollLeftBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-target');
            const menuItems = document.getElementById('menu-items-' + categoryId);
            menuItems.scrollBy({ left: -350, behavior: 'smooth' });
        });
    });
    
    scrollRightBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-target');
            const menuItems = document.getElementById('menu-items-' + categoryId);
            menuItems.scrollBy({ left: 350, behavior: 'smooth' });
        });
    });
    
    // Check scroll buttons visibility
    function checkScrollButtons() {
        document.querySelectorAll('.menu-items').forEach(container => {
            const categoryId = container.id.replace('menu-items-', '');
            const leftBtn = document.querySelector(`.scroll-left[data-target="${categoryId}"]`);
            const rightBtn = document.querySelector(`.scroll-right[data-target="${categoryId}"]`);
            
            if (container.scrollWidth > container.clientWidth) {
                leftBtn.style.display = container.scrollLeft > 0 ? 'flex' : 'none';
                rightBtn.style.display = (container.scrollWidth - container.clientWidth > container.scrollLeft) ? 'flex' : 'none';
            } else {
                leftBtn.style.display = 'none';
                rightBtn.style.display = 'none';
            }
        });
    }
    
    window.addEventListener('load', checkScrollButtons);
    window.addEventListener('resize', checkScrollButtons);
    
    document.querySelectorAll('.menu-items').forEach(container => {
        container.addEventListener('scroll', checkScrollButtons);
    });

    // Reservation form AJAX
    jQuery(document).ready(function($) {
        $('#reservation-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitButton = $form.find('button[type="submit"]');
            const $message = $form.find('.form-message');
            
            $submitButton.prop('disabled', true);
            $message.html('<div class="loading">Відправка...</div>');
            
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'submit_reservation',
                    reservation_nonce: $('#reservation_nonce').val(),
                    name: $('#name').val(),
                    phone: $('#phone').val(),
                    date: $('#date').val(),
                    time: $('#time').val(),
                    guests: $('#guests').val()
                },
                success: function(response) {
                    if (response.success) {
                        $message.html('<div class="success">Дякуємо! Ваше бронювання прийнято. Ми зв\'яжемося з вами найближчим часом.</div>');
                        $form[0].reset();
                    } else {
                        $message.html('<div class="error">Помилка при відправці. Будь ласка, спробуйте ще раз.</div>');
                    }
                },
                error: function() {
                    $message.html('<div class="error">Помилка при відправці. Будь ласка, спробуйте ще раз.</div>');
                },
                complete: function() {
                    $submitButton.prop('disabled', false);
                }
            });
        });
    });

    // Gallery lightbox functionality
    document.querySelectorAll('.gallery-lightbox').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const imageUrl = this.getAttribute('href');
            const lightbox = document.createElement('div');
            lightbox.className = 'lightbox';
            
            document.body.appendChild(lightbox);
            setTimeout(() => lightbox.classList.add('show'), 50);
            
            lightbox.querySelector('.lightbox-close').addEventListener('click', () => {
                lightbox.classList.remove('show');
                setTimeout(() => lightbox.remove(), 300);
            });
        });
    });

    // Testimonials slider functionality
    let currentTestimonial = 0;
    const testimonials = document.querySelectorAll('.testimonial-item');

    function showTestimonial(index) {
        testimonials.forEach(item => item.style.display = 'none');
        testimonials[index].style.display = 'block';
    }

    function nextTestimonial() {
        currentTestimonial = (currentTestimonial + 1) % testimonials.length;
        showTestimonial(currentTestimonial);
    }

    if (testimonials.length > 0) {
        showTestimonial(0);
        setInterval(nextTestimonial, 5000);
    }
});
</script>

<?php get_footer(); ?>