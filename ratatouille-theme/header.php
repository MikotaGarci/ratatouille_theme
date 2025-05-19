<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
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
            padding-top: 70px; /* Отступ для фиксированного хедера */
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
            background
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
        
        /* Мобильная версия */
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
            <ul id="primary-menu" class="nav-menu">
                <li><a href="<?php echo esc_url(home_url('/')); ?>">Головна</a></li>
                <li><a href="#specialties">Спеціальні</a></li>
                <li><a href="#about">Про нас</a></li>
                <li><a href="#menu">Меню</a></li>
                <li><a href="#gallery">Галерея</a></li>
                <li><a href="#testimonials">Відгуки</a></li>
                <li><a href="#reservation" class="btn-reservation">Забронювати</a></li>
            </ul>
        </nav>
    </div>
</header>

<div id="content" class="site-content">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    // Переключение мобильного меню
    menuToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
    });
    
    // Закрытие меню при клике на ссылку
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                navMenu.classList.remove('active');
            }
        });
    });
    
    // Плавная прокрутка
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = document.querySelector('.site-header').offsetHeight;
                const targetPosition = target.offsetTop - headerHeight;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>