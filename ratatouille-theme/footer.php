<?php
/**
 * The template for displaying the footer
 */
?>

    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="container footer-container">
            <div class="footer-left">
                <div class="footer-widget">
                    <div class="footer-logo">
                        <?php
                        if ( has_custom_logo() ) :
                            the_custom_logo();
                        else :
                        ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <h2><?php bloginfo( 'name' ); ?></h2>
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <p class="footer-text">
                        <?php 
                        $footer_text = get_theme_mod( 'footer_about_text', 'Ресторан "Рататуй" - це поєднання французької класики і сучасної кухні. Ми пропонуємо вам незабутню гастрономічну подорож та атмосферу затишку.' );
                        echo esc_html( $footer_text ); 
                        ?>
                    </p>
                    
                    <div class="social-links">
                        <?php 
                        $social_links = array(
                            'facebook' => array(
                                'url' => get_theme_mod( 'social_facebook', 'https://facebook.com/' ),
                                'icon' => 'fab fa-facebook-f',
                                'name' => 'Facebook'
                            ),
                            'instagram' => array(
                                'url' => get_theme_mod( 'social_instagram', 'https://instagram.com/' ),
                                'icon' => 'fab fa-instagram',
                                'name' => 'Instagram'
                            ),
                            'twitter' => array(
                                'url' => get_theme_mod( 'social_twitter', 'https://twitter.com/' ),
                                'icon' => 'fab fa-twitter',
                                'name' => 'Twitter'
                            ),
                            'youtube' => array(
                                'url' => get_theme_mod( 'social_youtube', 'https://youtube.com/' ),
                                'icon' => 'fab fa-youtube',
                                'name' => 'YouTube'
                            ),
                            'telegram' => array(
                                'url' => get_theme_mod( 'social_telegram', 'https://t.me/' ),
                                'icon' => 'fab fa-telegram',
                                'name' => 'Telegram'
                            ),
                            'tiktok' => array(
                                'url' => get_theme_mod( 'social_tiktok', 'https://tiktok.com/' ),
                                'icon' => 'fab fa-tiktok',
                                'name' => 'TikTok'
                            )
                        );
                        
                        foreach ( $social_links as $social => $data ) :
                            if ( $data['url'] && $data['url'] !== '#' ) :
                        ?>
                            <a href="<?php echo esc_url( $data['url'] ); ?>" class="social-link" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $data['name'] ); ?>">
                                <i class="<?php echo esc_attr( $data['icon'] ); ?>"></i>
                            </a>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
                
                <div class="footer-widget">
                    <h3 class="footer-title"><?php echo esc_html__( 'Години роботи', 'ratatouille' ); ?></h3>
                    <ul class="footer-menu">
                        <li>
                            <i class="far fa-clock"></i> 
                            <?php echo esc_html__( 'Понеділок - П\'ятниця:', 'ratatouille' ); ?> 
                            <?php echo esc_html( get_theme_mod( 'working_hours_weekdays', '10:00 - 22:00' ) ); ?>
                        </li>
                        <li>
                            <i class="far fa-clock"></i> 
                            <?php echo esc_html__( 'Субота - Неділя:', 'ratatouille' ); ?> 
                            <?php echo esc_html( get_theme_mod( 'working_hours_weekends', '11:00 - 23:00' ) ); ?>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-right">
                <div class="footer-widget">
                    <h3 class="footer-title"><?php echo esc_html__( 'Контакти', 'ratatouille' ); ?></h3>
                    <ul class="footer-menu">
                        <li>
                            <a href="tel:<?php echo esc_attr( str_replace( array( ' ', '(', ')', '-' ), '', get_theme_mod( 'contact_phone', '+380123456789' ) ) ); ?>">
                                <i class="fas fa-phone"></i> 
                                <?php echo esc_html( get_theme_mod( 'contact_phone', '+38 (012) 345-67-89' ) ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="mailto:<?php echo esc_attr( get_theme_mod( 'contact_email', 'info@ratatouille.com.ua' ) ); ?>">
                                <i class="fas fa-envelope"></i> 
                                <?php echo esc_html( get_theme_mod( 'contact_email', 'info@ratatouille.com.ua' ) ); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo esc_url( get_theme_mod( 'contact_map_link', 'https://goo.gl/maps/qcDcZr9QE2L8Hy8J7' ) ); ?>" target="_blank" rel="noopener">
                                <i class="fas fa-map-marker-alt"></i> 
                                <?php echo esc_html( get_theme_mod( 'contact_address', 'Полтава, вул. Соборності, 27' ) ); ?>
                            </a>
                        </li>
                    </ul>
                </div>
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
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?php echo esc_attr__( 'Карта розташування ресторану', 'ratatouille' ); ?>">
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

<style>
/* Footer Styles */
.site-footer {
    background: var(--primary, #3F2D1D);
    color: var(--white, #FFFFFF);
    padding: 80px 0 30px;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    gap: 40px;
    margin-bottom: 40px;
}

.footer-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.footer-right {
    flex: 0 0 300px;
}

.footer-widget {
    margin-bottom: 30px;
}

.footer-logo {
    margin-bottom: 20px;
}

.footer-logo img {
    height: 60px;
    max-width: 200px;
}

.footer-logo h2 {
    color: var(--accent, #E67E22);
    font-family: 'Playfair Display', serif;
    margin: 0;
}

.footer-title {
    font-size: 1.3rem;
    margin-bottom: 25px;
    color: var(--accent, #E67E22);
    position: relative;
    padding-bottom: 15px;
    font-family: 'Playfair Display', serif;
}

.footer-title:after {
    content: '';
    position: absolute;
    width: 50px;
    height: 2px;
    background: var(--accent, #E67E22);
    bottom: 0;
    left: 0;
}

.footer-text {
    margin-bottom: 20px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
}

.footer-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-menu li {
    margin-bottom: 12px;
    display: flex;
    align-items: flex-start;
}

.footer-menu a {
    color: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    text-decoration: none;
}

.footer-menu a i {
    margin-right: 10px;
    color: var(--accent, #E67E22);
    width: 16px;
    flex-shrink: 0;
}

.footer-menu a:hover {
    color: var(--accent, #E67E22);
    transform: translateX(5px);
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: rgba(255, 255, 255, 0.1);
    color: var(--white, #FFFFFF);
    border-radius: 50%;
    transition: all 0.3s ease;
    text-decoration: none;
}

.social-link:hover {
    background-color: var(--accent, #E67E22);
    transform: translateY(-3px);
    color: var(--white, #FFFFFF);
}

.footer-map-container {
    margin: 40px 0;
}

.map-wrapper {
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.copyright {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
}

.mt-30 {
    margin-top: 30px;
}

.text-center {
    text-align: center;
}

.py-small {
    padding: 20px 0;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        gap: 30px;
    }
    
    .footer-right {
        flex: 1;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>

<?php wp_footer(); ?>

</body>
</html>