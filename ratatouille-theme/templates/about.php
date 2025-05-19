<?php
/**
 * Template Name: About Page
 */

get_header(); ?>

<main id="main" class="site-main">
    <section class="about-section">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="row">
                        <?php 
                        $about_image = get_field('about_image');
                        if ($about_image) : ?>
                            <div class="col-md-4">
                                <div class="about-image fade-in-up">
                                    <img src="<?php echo esc_url($about_image['url']); ?>" 
                                         alt="<?php echo esc_attr($about_image['alt']); ?>" 
                                         class="img-fluid">
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="<?php echo $about_image ? 'col-md-8' : 'col-md-12'; ?>">
                            <?php 
                            $about_title = get_field('about_title');
                            if ($about_title) : ?>
                                <h2 class="about-title fade-in-up"><?php echo esc_html($about_title); ?></h2>
                            <?php endif; ?>
                            
                            <?php 
                            $about_description = get_field('about_description');
                            if ($about_description) : ?>
                                <div class="about-description fade-in-up">
                                    <?php echo wp_kses_post($about_description); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (have_rows('about_features')) : ?>
                                <div class="about-features row">
                                    <?php 
                                    $delay = 200;
                                    while (have_rows('about_features')) : the_row(); 
                                        $icon = get_sub_field('icon');
                                        $title = get_sub_field('title');
                                        $description = get_sub_field('description');
                                    ?>
                                        <div class="feature-item col-md-6 fade-in-up" data-delay="<?php echo esc_attr($delay); ?>">
                                            <?php if ($icon) : ?>
                                                <div class="feature-icon">
                                                    <i class="<?php echo esc_attr($icon); ?>"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($title) : ?>
                                                <h3 class="feature-title"><?php echo esc_html($title); ?></h3>
                                            <?php endif; ?>
                                            
                                            <?php if ($description) : ?>
                                                <div class="feature-description">
                                                    <?php echo wp_kses_post($description); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php 
                                        $delay += 200;
                                    endwhile; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>