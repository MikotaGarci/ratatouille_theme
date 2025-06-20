<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico">
    <?php wp_head(); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 70px;
        }
        
        .site-header {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .site-logo img {
            height: 40px;
            width: auto;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
        }
        
        .nav-menu li {
            margin-left: 20px;
        }
        
        .nav-menu a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-menu a:hover {
            color: #e74c3c;
        }
        
        .btn-reservation {
            background: #E67E22;
            color: white !important;
            padding: 8px 15px;
            border-radius: 4px;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .nav-menu {
                display: none;
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                background: #fff;
                flex-direction: column;
                padding: 20px;
                box-shadow: 0 5px 10px rgba(2, 2, 2, 0.1);
            }
            
            .nav-menu.active {
                display: flex;
            }
            
            .nav-menu li {
                margin: 0 0 15px 0;
            }
            
            .btn-reservation {
                display: inline-block;
                margin-top: 10px;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <div class="site-logo">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                <?php endif; ?>
            </div>

            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'nav-menu',
                    'container' => false,
                    'fallback_cb' => function() {
                        ?>
                        <ul id="primary-menu" class="nav-menu">
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('special-offers'))); ?>"><?php esc_html_e('Спеціальні', 'ratatouille'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('about'))); ?>"><?php esc_html_e('Про нас', 'ratatouille'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('menu'))); ?>"><?php esc_html_e('Меню', 'ratatouille'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('gallery'))); ?>"><?php esc_html_e('Галерея', 'ratatouille'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('testimonials'))); ?>"><?php esc_html_e('Відгуки', 'ratatouille'); ?></a></li>
                            <li><a href="<?php echo esc_url(get_permalink(get_page_by_path('booking'))); ?>" class="btn-reservation"><?php esc_html_e('Забронювати', 'ratatouille'); ?></a></li>
                        </ul>
                        <?php
                    }
                ));
                ?>
            </nav>
        </div>
    </header>

    <div id="content" class="site-content">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
    });
    
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                navMenu.classList.remove('active');
            }
        });
    });
});
</script>