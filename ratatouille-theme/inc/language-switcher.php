<?php
/**
 * Language Switcher for Ratatouille Theme
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

/**
 * Initialize language support
 */
function ratatouille_init_languages() {
    // Set default language
    if (!get_option('ratatouille_default_language')) {
        update_option('ratatouille_default_language', 'uk');
    }
    
    // Set current language from session or default
    if (!session_id()) {
        session_start();
    }
    
    if (isset($_GET['lang']) && in_array($_GET['lang'], ratatouille_get_supported_languages())) {
        $_SESSION['ratatouille_language'] = sanitize_text_field($_GET['lang']);
    }
    
    if (!isset($_SESSION['ratatouille_language'])) {
        $_SESSION['ratatouille_language'] = get_option('ratatouille_default_language', 'uk');
    }
    
    // Set WordPress locale
    add_filter('locale', 'ratatouille_set_locale');
}
add_action('init', 'ratatouille_init_languages');

/**
 * Get supported languages
 */
function ratatouille_get_supported_languages() {
    return array(
        'uk' => array(
            'name' => 'Українська',
            'flag' => '🇺🇦',
            'locale' => 'uk'
        ),
        'en' => array(
            'name' => 'English',
            'flag' => '🇺🇸',
            'locale' => 'en_US'
        ),
        'de' => array(
            'name' => 'Deutsch',
            'flag' => '🇩🇪',
            'locale' => 'de_DE'
        ),
        'fr' => array(
            'name' => 'Français',
            'flag' => '🇫🇷',
            'locale' => 'fr_FR'
        )
    );
}

/**
 * Get current language
 */
function ratatouille_get_current_language() {
    if (!session_id()) {
        session_start();
    }
    return isset($_SESSION['ratatouille_language']) ? $_SESSION['ratatouille_language'] : 'uk';
}

/**
 * Set locale based on current language
 */
function ratatouille_set_locale($locale) {
    $current_lang = ratatouille_get_current_language();
    $languages = ratatouille_get_supported_languages();
    
    if (isset($languages[$current_lang])) {
        return $languages[$current_lang]['locale'];
    }
    
    return $locale;
}

/**
 * Display language switcher
 */
function ratatouille_language_switcher($echo = true) {
    $languages = ratatouille_get_supported_languages();
    $current_lang = ratatouille_get_current_language();
    $current_url = home_url(add_query_arg(array()));
    
    $output = '<div class="language-switcher">';
    $output .= '<div class="current-language">';
    $output .= '<span class="flag">' . $languages[$current_lang]['flag'] . '</span>';
    $output .= '<span class="name">' . $languages[$current_lang]['name'] . '</span>';
    $output .= '<i class="fas fa-chevron-down"></i>';
    $output .= '</div>';
    $output .= '<ul class="language-dropdown">';
    
    foreach ($languages as $code => $language) {
        if ($code !== $current_lang) {
            $lang_url = add_query_arg('lang', $code, $current_url);
            $output .= '<li>';
            $output .= '<a href="' . esc_url($lang_url) . '" class="language-link" data-lang="' . esc_attr($code) . '">';
            $output .= '<span class="flag">' . $language['flag'] . '</span>';
            $output .= '<span class="name">' . $language['name'] . '</span>';
            $output .= '</a>';
            $output .= '</li>';
        }
    }
    
    $output .= '</ul>';
    $output .= '</div>';
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

/**
 * Get translated text
 */
function ratatouille_translate($text, $domain = 'ratatouille') {
    return __($text, $domain);
}

/**
 * Echo translated text
 */
function ratatouille_e($text, $domain = 'ratatouille') {
    echo ratatouille_translate($text, $domain);
}

/**
 * Get translated menu items based on current language
 */
function ratatouille_get_menu_items() {
    $current_lang = ratatouille_get_current_language();
    
    $menu_items = array(
        'uk' => array(
            'home' => 'Головна',
            'about' => 'Про нас',
            'menu' => 'Меню',
            'gallery' => 'Галерея',
            'testimonials' => 'Відгуки',
            'booking' => 'Бронювання'
        ),
        'en' => array(
            'home' => 'Home',
            'about' => 'About',
            'menu' => 'Menu',
            'gallery' => 'Gallery',
            'testimonials' => 'Reviews',
            'booking' => 'Booking'
        ),
        'de' => array(
            'home' => 'Startseite',
            'about' => 'Über uns',
            'menu' => 'Speisekarte',
            'gallery' => 'Galerie',
            'testimonials' => 'Bewertungen',
            'booking' => 'Reservierung'
        ),
        'fr' => array(
            'home' => 'Accueil',
            'about' => 'À propos',
            'menu' => 'Menu',
            'gallery' => 'Galerie',
            'testimonials' => 'Avis',
            'booking' => 'Réservation'
        )
    );
    
    return isset($menu_items[$current_lang]) ? $menu_items[$current_lang] : $menu_items['uk'];
}

/**
 * Add language switcher to admin bar
 */
function ratatouille_admin_bar_language_switcher($wp_admin_bar) {
    if (!is_admin()) {
        $languages = ratatouille_get_supported_languages();
        $current_lang = ratatouille_get_current_language();
        
        $wp_admin_bar->add_node(array(
            'id' => 'language-switcher',
            'title' => $languages[$current_lang]['flag'] . ' ' . $languages[$current_lang]['name'],
            'href' => '#'
        ));
        
        foreach ($languages as $code => $language) {
            if ($code !== $current_lang) {
                $lang_url = add_query_arg('lang', $code, home_url(add_query_arg(array())));
                $wp_admin_bar->add_node(array(
                    'parent' => 'language-switcher',
                    'id' => 'lang-' . $code,
                    'title' => $language['flag'] . ' ' . $language['name'],
                    'href' => $lang_url
                ));
            }
        }
    }
}
add_action('admin_bar_menu', 'ratatouille_admin_bar_language_switcher', 100);

/**
 * Enqueue language switcher styles and scripts
 */
function ratatouille_language_switcher_assets() {
    wp_add_inline_style('ratatouille-style', '
        .language-switcher {
            position: relative;
            display: inline-block;
            margin-left: 20px;
        }
        
        .current-language {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #333;
            font-size: 14px;
            font-weight: 500;
        }
        
        .current-language:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .language-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
            min-width: 150px;
            list-style: none;
            margin: 0;
            padding: 5px 0;
        }
        
        .language-switcher:hover .language-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .language-dropdown li {
            margin: 0;
        }
        
        .language-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .language-link:hover {
            background: #f5f5f5;
            color: #e67e22;
        }
        
        .flag {
            font-size: 16px;
        }
        
        @media (max-width: 768px) {
            .language-switcher {
                margin-left: 10px;
            }
            
            .current-language {
                padding: 6px 10px;
                font-size: 13px;
            }
            
            .language-dropdown {
                right: -10px;
            }
        }
    ');
    
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            $(".language-link").on("click", function(e) {
                e.preventDefault();
                var url = $(this).attr("href");
                window.location.href = url;
            });
        });
    ');
}
add_action('wp_enqueue_scripts', 'ratatouille_language_switcher_assets');