<?php get_header(); ?>

<main id="main" class="site-main">
    <section class="error-404 not-found">
        <div class="container">
            <div class="page-content">
                <h1><?php esc_html_e('404 - Страница не найдена', 'ratatouille'); ?></h1>
                <p><?php esc_html_e('Извините, но страница, которую вы ищете, не существует.', 'ratatouille'); ?></p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn">
                    <?php esc_html_e('Вернуться на главную', 'ratatouille'); ?>
                </a>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>