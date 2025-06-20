<?php
/**
 * Template Name: Menu Page
 * 
 * This template displays the restaurant menu with categories, dishes, and their details
 */

get_header(); ?>

<main id="main" class="site-main">
    <section class="menu-page">
        <div class="container">
            <h1 class="page-title menu-page-title"><?php the_title(); ?></h1>

            <?php 
            // Check if there's a category parameter in the URL
            $selected_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
            
            // Get the menu categories
            if (have_rows('menu_categories')) : ?>
                <!-- Menu filter tabs -->
                <div class="menu-tabs" id="menu-tabs">
                    <div class="menu-tab <?php echo empty($selected_category) ? 'active' : ''; ?>" data-category="all">
                        <?php esc_html_e('Все меню', 'ratatouille'); ?>
                    </div>
                    
                    <?php 
                    while (have_rows('menu_categories')) : the_row();
                        $category_name = get_sub_field('category_name');
                        $category_slug = sanitize_title($category_name);
                        $is_active = ($selected_category === $category_slug);
                    ?>
                        <div class="menu-tab <?php echo $is_active ? 'active' : ''; ?>" data-category="<?php echo esc_attr($category_slug); ?>">
                            <?php echo esc_html($category_name); ?>
                        </div>
                    <?php endwhile; reset_rows(); ?>
                </div>

                <!-- Menu content -->
                <div class="menu-categories">
                    <?php 
                    while (have_rows('menu_categories')) : the_row();
                        $category_name = get_sub_field('category_name');
                        $category_slug = sanitize_title($category_name);
                        $category_description = get_sub_field('category_description');
                        
                        // Show all categories by default, hide with JS if needed
                        $display_style = empty($selected_category) || $selected_category === $category_slug ? 'block' : 'none';
                    ?>
                        <div class="menu-category" id="<?php echo esc_attr($category_slug); ?>" style="display: <?php echo $display_style; ?>;">
                            <h2 class="category-title"><?php echo esc_html($category_name); ?></h2>
                            
                            <?php if ($category_description) : ?>
                                <p class="category-description"><?php echo esc_html($category_description); ?></p>
                            <?php endif; ?>

                            <?php if (have_rows('dishes')) : ?>
                                <div class="menu-items" id="menu-items-<?php echo esc_attr($category_slug); ?>">
                                    <?php 
                                    $dish_counter = 0;
                                    while (have_rows('dishes')) : the_row(); 
                                        $image = get_sub_field('dish_image');
                                        $spiciness = get_sub_field('spiciness_level');
                                        $badge = get_sub_field('special_badge');
                                        $dish_counter++;
                                        $dish_id = 'dish-' . sanitize_title($category_slug) . '-' . $dish_counter;
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
                                                <h3 class="item-name"><?php the_sub_field('dish_name'); ?></h3>
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
                                                        <?php 
                                                        $ingredient_count = 0;
                                                        while (have_rows('ingredients')) : the_row(); 
                                                            $ingredient_count++;
                                                        ?>
                                                            <div class="ingredient-item" style="--item-index: <?php echo esc_attr($ingredient_count); ?>">
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
                                <div class="menu-scroll-controls" id="scroll-controls-<?php echo esc_attr($category_slug); ?>">
                                    <div class="menu-scroll-btn scroll-left" data-target="<?php echo esc_attr($category_slug); ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </div>
                                    <div class="menu-scroll-btn scroll-right" data-target="<?php echo esc_attr($category_slug); ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </div>
                            <?php else : ?>
                                <p class="no-dishes"><?php esc_html_e('Наразі страви в цій категорії відсутні.', 'ratatouille'); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else : ?>
                <p class="no-menu-items"><?php esc_html_e('Меню тимчасово недоступне. Будь ласка, завітайте пізніше.', 'ratatouille'); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<style>
/* Додаткові стилі для сторінки меню */
.menu-page {
    padding-top: 120px; /* Збільшений відступ зверху */
}

.menu-page-title {
    margin-top: 40px; /* Додатковий відступ для заголовка */
    margin-bottom: 50px;
    text-align: center;
    font-size: 3rem;
    color: var(--primary);
    font-family: 'Playfair Display', serif;
    position: relative;
}

.menu-page-title:after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: var(--accent);
    margin: 20px auto;
    border-radius: 2px;
}

/* Адаптивність для мобільних пристроїв */
@media (max-width: 768px) {
    .menu-page {
        padding-top: 100px;
    }
    
    .menu-page-title {
        margin-top: 20px;
        margin-bottom: 30px;
        font-size: 2.5rem;
    }
}

@media (max-width: 480px) {
    .menu-page {
        padding-top: 90px;
    }
    
    .menu-page-title {
        margin-top: 15px;
        margin-bottom: 25px;
        font-size: 2rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Menu tab filtering
    const menuTabs = document.querySelectorAll('.menu-tab');
    
    menuTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault(); // Запобігаємо стандартній поведінці
            
            const category = this.getAttribute('data-category');
            
            // Зберігаємо поточну позицію скролу
            const currentScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
            
            // Update active tab
            menuTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // If "All Menu" is selected
            if (category === 'all') {
                // Show all categories
                document.querySelectorAll('.menu-category').forEach(cat => {
                    cat.style.display = 'block';
                });
                
                // Update URL without category parameter (без перезавантаження)
                const url = new URL(window.location);
                url.searchParams.delete('category');
                window.history.replaceState({}, '', url);
            } else {
                // Hide all categories
                document.querySelectorAll('.menu-category').forEach(cat => {
                    cat.style.display = 'none';
                });
                
                // Show only the selected category
                const selectedCategory = document.getElementById(category);
                if (selectedCategory) {
                    selectedCategory.style.display = 'block';
                }
                
                // Update URL with category parameter (без перезавантаження)
                const url = new URL(window.location);
                url.searchParams.set('category', category);
                window.history.replaceState({}, '', url);
            }
            
            // Відновлюємо позицію скролу
            window.scrollTo(0, currentScrollPosition);
            
            // Перевіряємо кнопки скролу після зміни категорії
            setTimeout(() => {
                window.scrollTo(0, currentScrollPosition);
                checkScrollButtons();
            }, 100);
        });
    });
    
    // Ingredients toggle functionality
    const ingredientButtons = document.querySelectorAll('.ingredients-btn');
    
    ingredientButtons.forEach(button => {
        button.addEventListener('click', function() {
            const dishId = this.getAttribute('data-dish');
            const ingredientsContent = document.getElementById(dishId);
            
            if (ingredientsContent.classList.contains('active')) {
                // Hide ingredients
                ingredientsContent.classList.remove('active');
                this.textContent = '<?php esc_html_e('Показати склад', 'ratatouille'); ?>';
            } else {
                // Show ingredients
                ingredientsContent.classList.add('active');
                this.textContent = '<?php esc_html_e('Приховати склад', 'ratatouille'); ?>';
            }
        });
    });
    
    // Initialize: Check if a category is specified in the URL and select that tab
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('category');
    
    if (categoryParam) {
        const categoryTab = document.querySelector(`.menu-tab[data-category="${categoryParam}"]`);
        if (categoryTab) {
            // Не викликаємо click(), а просто встановлюємо стан
            menuTabs.forEach(t => t.classList.remove('active'));
            categoryTab.classList.add('active');
            
            // Показуємо потрібну категорію
            document.querySelectorAll('.menu-category').forEach(cat => {
                cat.style.display = 'none';
            });
            
            const selectedCategory = document.getElementById(categoryParam);
            if (selectedCategory) {
                selectedCategory.style.display = 'block';
            }
        }
    }
    
    // Обработчики для кнопок горизонтальной прокрутки
    const scrollLeftBtns = document.querySelectorAll('.scroll-left');
    const scrollRightBtns = document.querySelectorAll('.scroll-right');
    
    scrollLeftBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-target');
            const menuItems = document.getElementById('menu-items-' + categoryId);
            if (menuItems) {
                menuItems.scrollBy({
                    left: -350,
                    behavior: 'smooth'
                });
                // Перевіряємо кнопки після скролу
                setTimeout(checkScrollButtons, 300);
            }
        });
    });
    
    scrollRightBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-target');
            const menuItems = document.getElementById('menu-items-' + categoryId);
            if (menuItems) {
                menuItems.scrollBy({
                    left: 350,
                    behavior: 'smooth'
                });
                // Перевіряємо кнопки після скролу
                setTimeout(checkScrollButtons, 300);
            }
        });
    });
    
    // Покращена функція для перевірки видимості стрелок скролу
    function checkScrollButtons() {
        const menuContainers = document.querySelectorAll('.menu-items');
        
        menuContainers.forEach(container => {
            // Перевіряємо чи контейнер видимий
            const categoryElement = container.closest('.menu-category');
            if (!categoryElement || categoryElement.style.display === 'none') {
                return; // Пропускаємо приховані категорії
            }
            
            const categoryId = container.id.replace('menu-items-', '');
            const scrollControls = document.getElementById('scroll-controls-' + categoryId);
            const leftBtn = scrollControls ? scrollControls.querySelector('.scroll-left') : null;
            const rightBtn = scrollControls ? scrollControls.querySelector('.scroll-right') : null;
            
            if (!leftBtn || !rightBtn || !scrollControls) {
                return;
            }
            
            // Отримуємо розміри контейнера
            const containerWidth = container.clientWidth;
            const scrollWidth = container.scrollWidth;
            const scrollLeft = container.scrollLeft;
            
            // Показуємо контроли тільки якщо є що скролити
            if (scrollWidth > containerWidth) {
                scrollControls.style.display = 'flex';
                
                // Ліва кнопка - показуємо якщо можна скролити вліво
                if (scrollLeft > 10) { // 10px толерантність
                    leftBtn.style.display = 'flex';
                    leftBtn.style.opacity = '1';
                } else {
                    leftBtn.style.display = 'none';
                }
                
                // Права кнопка - показуємо якщо можна скролити вправо
                if (scrollLeft < (scrollWidth - containerWidth - 10)) { // 10px толерантність
                    rightBtn.style.display = 'flex';
                    rightBtn.style.opacity = '1';
                } else {
                    rightBtn.style.display = 'none';
                }
            } else {
                // Якщо немає що скролити - ховаємо всі кнопки
                scrollControls.style.display = 'none';
            }
        });
    }
    
    // Перевіряємо кнопки при різних подіях
    function initScrollButtonChecking() {
        // При завантаженні сторінки
        setTimeout(checkScrollButtons, 500);
        
        // При зміні розміру вікна
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(checkScrollButtons, 250);
        });
        
        // При скролі контейнерів
        const menuContainers = document.querySelectorAll('.menu-items');
        menuContainers.forEach(container => {
            container.addEventListener('scroll', function() {
                // Використовуємо throttling для оптимізації
                if (!this.scrollTimeout) {
                    this.scrollTimeout = setTimeout(() => {
                        checkScrollButtons();
                        this.scrollTimeout = null;
                    }, 50);
                }
            });
        });
        
        // При зміні вкладок
        menuTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                setTimeout(checkScrollButtons, 200);
            });
        });
    }
    
    // Ініціалізуємо перевірку кнопок
    initScrollButtonChecking();
    
    // Додаткова перевірка через певні інтервали (для надійності)
    setInterval(checkScrollButtons, 2000);
});
</script>

<?php get_footer(); ?>