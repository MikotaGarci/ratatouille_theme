<?php get_header(); ?>

<main id="main" class="site-main">
    <section class="archive-section">
        <div class="container">
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header>

            <div class="archive-grid">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <h2 class="entry-title"><?php the_title(); ?></h2>
                                <div class="entry-meta">
                                    <?php the_date(); ?>
                                </div>
                                <div class="entry-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                    
                    <div class="pagination">
                        <?php ratatouille_pagination(); ?>
                    </div>
                <?php else : ?>
                    <p><?php esc_html_e('Ничего не найдено.', 'ratatouille'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>