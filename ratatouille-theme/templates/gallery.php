<?php
/**
 * Template Name: Gallery Page
 */

get_header(); ?>

<main id="main" class="site-main">
    <section class="gallery-page">
        <div class="container">
            <?php
            // Get gallery fields
            $gallery_title = get_field('gallery_title');
            $gallery_description = get_field('gallery_description');
            $gallery_categories = get_field('gallery_categories');
            $gallery_settings = get_field('gallery_settings');
            
            // Default settings
            $images_per_page = $gallery_settings['images_per_page'] ?? 12;
            $enable_lightbox = $gallery_settings['enable_lightbox'] ?? true;
            $show_categories = $gallery_settings['show_categories'] ?? true;
            ?>

            <div class="gallery-header">
                <h1 class="page-title"><?php echo esc_html($gallery_title ?: __('Наша галерея', 'ratatouille')); ?></h1>
                <?php if ($gallery_description) : ?>
                    <div class="gallery-description">
                        <?php echo wp_kses_post($gallery_description); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($gallery_categories && is_array($gallery_categories)) : ?>
                <?php if ($show_categories && count($gallery_categories) > 1) : ?>
                    <div class="gallery-categories">
                        <button class="category-filter active" data-category="all">
                            <?php esc_html_e('Всі', 'ratatouille'); ?>
                        </button>
                        <?php foreach ($gallery_categories as $category) : 
                            if (!empty($category['category_name'])) :
                                $category_slug = sanitize_title($category['category_name']);
                        ?>
                            <button class="category-filter" data-category="<?php echo esc_attr($category_slug); ?>">
                                <?php echo esc_html($category['category_name']); ?>
                            </button>
                        <?php 
                            endif;
                        endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="gallery-container">
                    <div class="gallery-grid">
                        <?php 
                        foreach ($gallery_categories as $category) :
                            if (empty($category['category_name']) || empty($category['category_images'])) {
                                continue;
                            }
                            
                            $category_slug = sanitize_title($category['category_name']);
                            $images = $category['category_images'];
                            
                            foreach ($images as $image) : 
                                if (!is_array($image) || empty($image['ID'])) {
                                    continue;
                                }
                                
                                $full_image = wp_get_attachment_image_src($image['ID'], 'full');
                                $thumbnail = wp_get_attachment_image_src($image['ID'], 'large');
                                
                                if (!$full_image || !$thumbnail) {
                                    continue;
                                }
                                
                                $image_url = $full_image[0];
                                $thumb_url = $thumbnail[0];
                                $image_alt = $image['alt'] ?: $category['category_name'];
                        ?>
                                <div class="gallery-item" data-category="<?php echo esc_attr($category_slug); ?>">
                                    <a href="<?php echo esc_url($image_url); ?>" 
                                       class="gallery-lightbox"
                                       title="<?php echo esc_attr($image_alt); ?>">
                                        <img src="<?php echo esc_url($thumb_url); ?>" 
                                             alt="<?php echo esc_attr($image_alt); ?>"
                                             loading="lazy">
                                        <div class="gallery-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </a>
                                </div>
                        <?php 
                            endforeach;
                        endforeach; 
                        ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="no-gallery-items">
                    <p><?php esc_html_e('Галерея порожня. Додайте зображення через адмін-панель.', 'ratatouille'); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>