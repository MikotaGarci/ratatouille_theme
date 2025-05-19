<?php
/**
 * Template Name: Front Page
 */

get_header(); ?>

<main id="main" class="site-main">
    <!-- Special Offers Section -->
    <section id="specialties" class="section specialties-section">
        <div class="container">
            <h2 class="section-title"><?php esc_html_e('Наші спеціальні пропозиції', 'ratatouille'); ?></h2>
            
            <?php 
            $special_offers = get_field('special_offers');
            if ($special_offers) : ?>
                <div class="menu-items">
                    <?php foreach ($special_offers as $offer) : ?>
                        <div class="menu-item fade-in-up">
                            <?php if ($offer['offer_image']) : ?>
                                <div class="item-image">
                                    <img src="<?php echo esc_url($offer['offer_image']['url']); ?>" 
                                         alt="<?php echo esc_attr($offer['offer_image']['alt']); ?>">
                                    <?php if ($offer['offer_badge']) : ?>
                                        <div class="item-badge">
                                            <?php echo esc_html($offer['offer_badge']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="item-content">
                                <h3 class="item-name"><?php echo esc_html($offer['offer_title']); ?></h3>
                                <p class="item-description"><?php echo esc_html($offer['offer_description']); ?></p>

                                <?php if ($offer['offer_spiciness']) : ?>
                                    <div class="spicy-level">
                                        <span class="spicy-label">Рівень гостроти:</span>
                                        <div class="spicy-stars">
                                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                <i class="fas fa-pepper-hot <?php echo $i <= $offer['offer_spiciness'] ? 'active' : ''; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($offer['offer_ingredients']) : ?>
                                    <button class="ingredients-btn" onclick="toggleIngredients(this)">
                                        <?php esc_html_e('Показати склад', 'ratatouille'); ?>
                                    </button>
                                    <div class="ingredients-content">
                                        <?php foreach ($offer['offer_ingredients'] as $ingredient) : ?>
                                            <div class="ingredient-item">
                                                <?php echo esc_html($ingredient['ingredient_name']); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <p class="item-price"><?php echo esc_html($offer['offer_price']); ?> ₴</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="no-offers"><?php esc_html_e('Наразі спеціальних пропозицій немає.', 'ratatouille'); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <?php get_template_part('template-parts/content', 'page'); ?>
</main>

<?php get_footer(); ?>