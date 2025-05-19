<?php
/**
 * ACF Setup for Ratatouille Theme
 * 
 * Handles the configuration and setup of Advanced Custom Fields
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Проверяем, активирован ли плагин ACF
if (!function_exists('acf_add_local_field_group')) {
    add_action('admin_notices', function() {
        echo '<div class="error"><p>';
        _e('Для работы темы Ratatouille требуется плагин Advanced Custom Fields PRO. Пожалуйста, установите и активируйте его.', 'ratatouille');
        echo '</p></div>';
    });
    return;
}

/**
 * Save ACF fields as JSON
 */
function ratatouille_acf_json_save_point($path) {
    $path = get_stylesheet_directory() . '/acf-json';
    
    // Создаем директорию, если она не существует
    if (!file_exists($path)) {
        wp_mkdir_p($path);
    }
    
    return $path;
}
add_filter('acf/settings/save_json', 'ratatouille_acf_json_save_point');

/**
 * Load ACF fields from JSON
 */
function ratatouille_acf_json_load_point($paths) {
    unset($paths[0]); // Удаляем стандартный путь
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
}
add_filter('acf/settings/load_json', 'ratatouille_acf_json_load_point');

/**
 * Hide ACF menu item from admin (раскомментируйте при необходимости)
 */
// add_filter('acf/settings/show_admin', '__return_false');

/**
 * Register ACF Blocks
 */
function ratatouille_register_acf_blocks() {
    if (function_exists('acf_register_block_type')) {
        // Hero Section Block
        acf_register_block_type(array(
            'name'              => 'hero-section',
            'title'             => __('Hero Section', 'ratatouille'),
            'description'       => __('A custom hero section with image and text.', 'ratatouille'),
            'render_template'   => 'template-parts/blocks/hero-section.php',
            'category'          => 'ratatouille-blocks',
            'icon'              => 'cover-image',
            'mode'              => 'preview',
            'supports'          => array(
                'align' => false,
                'mode'  => false,
                'jsx'   => true
            ),
            'enqueue_style'    => get_template_directory_uri() . '/assets/css/blocks/hero-section.css',
        ));

        // Menu Section Block
        acf_register_block_type(array(
            'name'              => 'menu-section',
            'title'             => __('Menu Section', 'ratatouille'),
            'description'       => __('Display your restaurant menu items.', 'ratatouille'),
            'render_template'   => 'template-parts/blocks/menu-section.php',
            'category'          => 'ratatouille-blocks',
            'icon'              => 'food',
            'mode'              => 'preview',
            'supports'          => array(
                'align' => ['wide', 'full'],
            ),
            'enqueue_style'    => get_template_directory_uri() . '/assets/css/blocks/menu-section.css',
        ));

        // About Section Block
        acf_register_block_type(array(
            'name'              => 'about-section',
            'title'             => __('About Section', 'ratatouille'),
            'description'       => __('About your restaurant section.', 'ratatouille'),
            'render_template'   => 'template-parts/blocks/about-section.php',
            'category'          => 'ratatouille-blocks',
            'icon'              => 'info',
            'keywords'          => array('about', 'info', 'restaurant'),
        ));
    }
}
add_action('acf/init', 'ratatouille_register_acf_blocks');

/**
 * Register ACF Options Pages
 */
function ratatouille_register_acf_options_pages() {
    if (function_exists('acf_add_options_page')) {
        // Main Theme Settings
        acf_add_options_page(array(
            'page_title'    => __('Theme Settings', 'ratatouille'),
            'menu_title'    => __('Theme Settings', 'ratatouille'),
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_theme_options',
            'redirect'      => false,
            'icon_url'      => 'dashicons-admin-settings',
            'position'      => 59,
            'autoload'      => true
        ));

        // Header Settings
        acf_add_options_sub_page(array(
            'page_title'    => __('Header Settings', 'ratatouille'),
            'menu_title'    => __('Header', 'ratatouille'),
            'parent_slug'   => 'theme-general-settings',
        ));

        // Footer Settings
        acf_add_options_sub_page(array(
            'page_title'    => __('Footer Settings', 'ratatouille'),
            'menu_title'    => __('Footer', 'ratatouille'),
            'parent_slug'   => 'theme-general-settings',
        ));

        // Social Media
        acf_add_options_sub_page(array(
            'page_title'    => __('Social Media', 'ratatouille'),
            'menu_title'    => __('Social Media', 'ratatouille'),
            'parent_slug'   => 'theme-general-settings',
        ));

        // Restaurant Settings
        acf_add_options_sub_page(array(
            'page_title'    => __('Restaurant Settings', 'ratatouille'),
            'menu_title'    => __('Restaurant', 'ratatouille'),
            'parent_slug'   => 'theme-general-settings',
        ));
    }
}
add_action('acf/init', 'ratatouille_register_acf_options_pages');

/**
 * Initialize ACF settings
 */
function ratatouille_acf_init() {
    // Google Maps API Key
    $google_maps_key = get_theme_mod('google_maps_api_key', '');
    if ($google_maps_key) {
        acf_update_setting('google_api_key', $google_maps_key);
    }
    
    // Настройки ACF
    acf_update_setting('show_updates', true);
    acf_update_setting('l10n_textdomain', 'ratatouille');
}
add_action('acf/init', 'ratatouille_acf_init');

/**
 * Custom location rules
 */
function ratatouille_acf_location_rules($choices) {
    $choices['Page']['front_page'] = 'Is Front Page';
    $choices['Page']['about_page'] = 'Is About Page';
    $choices['Page']['contact_page'] = 'Is Contact Page';
    return $choices;
}
add_filter('acf/location/rule_types', 'ratatouille_acf_location_rules');
add_filter('acf/location/rule_values/front_page', function($choices) {
    $choices['true'] = 'Yes';
    $choices['false'] = 'No';
    return $choices;
});

/**
 * Custom validation for ACF fields
 */
function ratatouille_acf_validate_value($valid, $value, $field, $input) {
    if (!$valid) {
        return $valid;
    }

    // Пример валидации для email полей
    if ($field['type'] === 'email' && !empty($value) && !is_email($value)) {
        return __('Пожалуйста, введите корректный email адрес', 'ratatouille');
    }

    return $valid;
}
add_filter('acf/validate_value', 'ratatouille_acf_validate_value', 10, 4);

/**
 * Custom WYSIWYG toolbar
 */
function ratatouille_acf_wysiwyg_toolbars($toolbars) {
    // Простой тулбар
    $toolbars['Simple'] = array();
    $toolbars['Simple'][1] = array('bold', 'italic', 'underline', 'link', 'unlink');

    // Полный тулбар
    $toolbars['Full'] = array();
    $toolbars['Full'][1] = array(
        'formatselect', 'bold', 'italic', 'bullist', 'numlist', 
        'blockquote', 'alignleft', 'aligncenter', 'alignright', 
        'link', 'unlink', 'wp_adv'
    );
    $toolbars['Full'][2] = array(
        'strikethrough', 'hr', 'forecolor', 'pastetext', 
        'removeformat', 'charmap', 'outdent', 'indent', 'undo', 
        'redo', 'wp_help'
    );

    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'ratatouille_acf_wysiwyg_toolbars');

/**
 * Добавляем поддержку ACF для REST API
 */
function ratatouille_acf_rest_api_support() {
    // Включаем поддержку REST API для полей ACF
    add_filter('acf/settings/rest_api_enabled', '__return_true');
    
    // Регистрируем поля ACF в REST API
    register_rest_field(
        array('page', 'post'),
        'acf_fields',
        array(
            'get_callback' => function($object) {
                return get_fields($object['id']);
            },
            'schema' => null,
        )
    );
}
add_action('rest_api_init', 'ratatouille_acf_rest_api_support');

/**
 * Добавляем категорию блоков для темы
 */
function ratatouille_block_categories($categories) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'ratatouille-blocks',
                'title' => __('Ratatouille Blocks', 'ratatouille'),
                'icon'  => 'food',
            )
        )
    );
}
add_filter('block_categories_all', 'ratatouille_block_categories');