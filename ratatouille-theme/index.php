<?php get_header(); ?>


<main id="main" class="site-main">
    <!-- Hero Section -->
    <section class="hero" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero-bg.jpg'); ?>') no-repeat center center/cover;">
        <div class="hero-content">
            <h1 class="hero-title"><?php echo esc_html(get_theme_mod('ratatouille_hero_title', 'Ласкаво просимо до ресторану "Рататуй"')); ?></h1>
            <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('ratatouille_hero_subtitle', 'Істинний смак Франції у серці міста')); ?></p>
            <div class="hero-buttons">
                <a href="<?php echo esc_url(home_url('/table-reservations/')); ?>" class="btn pulse"><?php esc_html_e('Забронювати столик', 'ratatouille'); ?></a>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('menu'))); ?>" class="btn btn-outline"><?php esc_html_e('Наше меню', 'ratatouille'); ?></a>
            </div>
        </div>
    </section>
</main>


<?php get_footer(); ?>