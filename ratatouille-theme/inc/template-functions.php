<?php
/**
 * Функции шаблонов для темы "Рататуй"
 */

/**
 * Резервное меню
 */
function ratatouille_primary_menu_fallback() {
    echo '<ul class="primary-menu">';
    $menu_items = array(
        'about' => __('О нас', 'ratatouille'),
        'menu' => __('Меню', 'ratatouille'),
        'gallery' => __('Галерея', 'ratatouille'),
        'contact' => __('Контакты', 'ratatouille'),
    );
    
    foreach ($menu_items as $slug => $title) {
        echo '<li><a href="' . esc_url(home_url('/' . $slug)) . '">' . esc_html($title) . '</a></li>';
    }
    echo '</ul>';
}

/**
 * Хлебные крошки
 */
function ratatouille_breadcrumbs() {
    if (!is_home()) {
        echo '<nav class="breadcrumbs">';
        echo '<a href="' . home_url() . '">' . __('Главная', 'ratatouille') . '</a>';
        
        if (is_category() || is_single()) {
            echo ' &raquo; ';
            the_category(' &raquo; ');
            
            if (is_single()) {
                echo ' &raquo; ';
                the_title();
            }
        } elseif (is_page()) {
            echo ' &raquo; ';
            the_title();
        }
        echo '</nav>';
    }
}

/**
 * Кастомный логотип
 */
function ratatouille_the_custom_logo() {
    if (function_exists('the_custom_logo')) {
        the_custom_logo();
    }
}

/**
 * Пагинация
 */
function ratatouille_pagination() {
    global $wp_query;
    
    $big = 999999999; // уникальное число
    
    echo paginate_links(array(
        'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'  => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total'   => $wp_query->max_num_pages,
        'prev_text' => __('&laquo; Назад', 'ratatouille'),
        'next_text' => __('Вперед &raquo;', 'ratatouille'),
    ));
}