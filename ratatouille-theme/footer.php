<?php
/**
 * The template for displaying the footer
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container footer-container">
            <div class="footer-widget">
                <div class="footer-logo">
                    <?php
                    if ( has_custom_logo() ) :
                        the_custom_logo();
                    else :
                    ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                        </a>
                    <?php endif; ?>
                </div>
                
                <p class="footer-text"><?php echo esc_html( get_theme_mod( 'footer_about_text', 'Ресторан "Рататуй" - це поєднання французької класики і сучасної кухні. Ми пропонуємо вам незабутню гастрономічну подорож та атмосферу затишку.' ) ); ?></p>
                
                <div class="social-links">
                    <?php if ( get_theme_mod( 'social_facebook' ) ) : ?>
                        <a href="<?php echo esc_url( get_theme_mod( 'social_facebook' ) ); ?>" class="social-link" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( get_theme_mod( 'social_instagram' ) ) : ?>
                        <a href="<?php echo esc_url( get_theme_mod( 'social_instagram' ) ); ?>" class="social-link" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( get_theme_mod( 'social_twitter' ) ) : ?>
                        <a href="<?php echo esc_url( get_theme_mod( 'social_twitter' ) ); ?>" class="social-link" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( get_theme_mod( 'social_youtube' ) ) : ?>
                        <a href="<?php echo esc_url( get_theme_mod( 'social_youtube' ) ); ?>" class="social-link" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="footer-widget">
                <h3 class="footer-title"><?php echo esc_html__( 'Години роботи', 'ratatouille' ); ?></h3>
                <ul class="footer-menu">
                    <li><i class="far fa-clock"></i> <?php echo esc_html__( 'Понеділок - П\'ятниця:', 'ratatouille' ); ?> <?php echo esc_html( get_theme_mod( 'working_hours_weekdays', '10:00 - 22:00' ) ); ?></li>
                    <li><i class="far fa-clock"></i> <?php echo esc_html__( 'Субота - Неділя:', 'ratatouille' ); ?> <?php echo esc_html( get_theme_mod( 'working_hours_weekends', '11:00 - 23:00' ) ); ?></li>
                </ul>
                
                <h3 class="footer-title mt-30"><?php echo esc_html__( 'Контакти', 'ratatouille' ); ?></h3>
                <ul class="footer-menu">
                    <li>
                        <a href="tel:<?php echo esc_attr( get_theme_mod( 'contact_phone', '+380123456789' ) ); ?>">
                            <i class="fas fa-phone"></i> <?php echo esc_html( get_theme_mod( 'contact_phone', '+38 (012) 345-67-89' ) ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="mailto:<?php echo esc_attr( get_theme_mod( 'contact_email', 'info@ratatouille.com.ua' ) ); ?>">
                            <i class="fas fa-envelope"></i> <?php echo esc_html( get_theme_mod( 'contact_email', 'info@ratatouille.com.ua' ) ); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo esc_url( get_theme_mod( 'contact_map_link', 'https://goo.gl/maps/qcDcZr9QE2L8Hy8J7' ) ); ?>">
                            <i class="fas fa-map-marker-alt"></i> <?php echo esc_html( get_theme_mod( 'contact_address', 'Полтава, вул. Соборності, 27' ) ); ?>
                        </a>
                    </li>
                </ul>
            </div>
            
         
            
            <div class="footer-widget footer-newsletter">
                <h3 class="footer-title"><?php echo esc_html__( 'Розсилка', 'ratatouille' ); ?></h3>
                <p><?php echo esc_html__( 'Підпишіться на нашу розсилку, щоб отримувати новини про акції та спеціальні пропозиції.', 'ratatouille' ); ?></p>
                
                <form class="newsletter-form">
                    <input type="email" placeholder="<?php echo esc_attr__( 'Ваш e-mail', 'ratatouille' ); ?>" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </div>
        
        <div class="container">
            <div class="footer-map-container">
                <h3 class="footer-title text-center"><?php echo esc_html__( 'Наше розташування в Полтаві', 'ratatouille' ); ?></h3>
                <div class="map-wrapper">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2585.938271533796!2d34.55169781571651!3d49.59031607936754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d82601f3347a5f%3A0x36f3f9aeec44a6a!2z0LLRg9C70LjRhtGPINCh0L7QsdC-0YDQvdC-0YHRgtGWLCAyNywg0J_QvtC70YLQsNCy0LAsINCf0L7Qu9GC0LDQstGB0YzQutCwINC-0LHQu9Cw0YHRgtGMLCAzNjAwMA!5e0!3m2!1suk!2sua!4v1715252799104!5m2!1suk!2sua" 
                        width="100%" 
                        height="350" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
        
        <div class="container">
            <div class="copyright text-center py-small">
                <p>
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                    <?php echo esc_html__( 'Всі права захищено.', 'ratatouille' ); ?>
                </p>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>