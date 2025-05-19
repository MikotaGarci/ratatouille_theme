<?php get_header(); ?>

<main id="main" class="site-main">
    <section class="single-post-section">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <span class="posted-on">
                                <?php the_date(); ?>
                            </span>
                        </div>
                    </header>

                    <div class="entry-content">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php the_content(); ?>
                    </div>

                    <footer class="entry-footer">
                        <?php the_tags('<div class="tags-links">', '', '</div>'); ?>
                    </footer>
                </article>

                <?php
                // Если комментарии открыты или есть хотя бы один комментарий
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>