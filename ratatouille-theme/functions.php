<?php
/**
 * Функції теми "Рататуй"
 */

if (!defined('ABSPATH')) {
    exit; // Заборона прямого доступу
}

// Complete Gutenberg disabling
add_filter('use_block_editor_for_post', '__return_false');
add_filter('use_block_editor_for_post_type', '__return_false');
add_filter('use_widgets_block_editor', '__return_false');
add_filter('gutenberg_use_widgets_block_editor', '__return_false');
add_filter('wp_use_widgets_block_editor', '__return_false');

/**
 * Налаштування часового поясу для Полтави, Україна
 */
function ratatouille_set_timezone() {
    // Встановлюємо часовий пояс для Полтави, Україна (UTC+2/UTC+3)
    date_default_timezone_set('Europe/Kiev');
    
    // Також встановлюємо в WordPress
    if (get_option('timezone_string') !== 'Europe/Kiev') {
        update_option('timezone_string', 'Europe/Kiev');
    }
}
add_action('init', 'ratatouille_set_timezone');

/**
 * Функція для отримання поточного часу в часовому поясі Полтави
 */
function ratatouille_current_time($format = 'Y-m-d H:i:s') {
    $timezone = new DateTimeZone('Europe/Kiev');
    $date = new DateTime('now', $timezone);
    return $date->format($format);
}

/**
 * Основні налаштування теми
 */
function ratatouille_setup() {
    load_theme_textdomain('ratatouille', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Add favicon support
    add_theme_support('site-icon');
    
    register_nav_menus(array(
        'primary' => __('Головне меню', 'ratatouille'),
        'footer' => __('Меню у підвалі', 'ratatouille')
    ));

    add_image_size('dish-thumbnail', 350, 250, true);
    add_image_size('gallery-thumb', 400, 300, true);
}
add_action('after_setup_theme', 'ratatouille_setup');

/**
 * Підключення стилів та скриптів
 */
function ratatouille_scripts() {
    // Styles
    wp_enqueue_style('ratatouille-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;500;600&display=swap', array(), null);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    wp_enqueue_style('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), '1.8.1');
    wp_enqueue_style('slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array('slick'), '1.8.1');
    wp_enqueue_style('magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css', array(), '1.1.0');
    
    // Theme styles
    wp_enqueue_style('ratatouille-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
    wp_enqueue_style('ratatouille-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.1');
    wp_enqueue_style('ratatouille-dish', get_template_directory_uri() . '/assets/css/dish-styles.css', array(), '1.0');
    wp_enqueue_style('ratatouille-loading', get_template_directory_uri() . '/assets/css/loading.css', array(), '1.0');
    
    // Gallery styles - ensure it's loaded on gallery page
    if (is_page_template('templates/gallery.php') || is_page('gallery')) {
        wp_enqueue_style('ratatouille-gallery', get_template_directory_uri() . '/assets/css/gallery.css', array(), '1.0.1');
    }

    // Scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('slick', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), '1.8.1', true);
    wp_enqueue_script('magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);
    wp_enqueue_script('imagesloaded', 'https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js', array('jquery'), '4.1.4', true);
    
    wp_enqueue_script('ratatouille-loading', get_template_directory_uri() . '/assets/js/loading.js', array('jquery'), '1.0', true);
    wp_enqueue_script('ratatouille-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.1', true);
    wp_enqueue_script('ratatouille-ingredients', get_template_directory_uri() . '/assets/js/ingredients.js', array('jquery'), '1.0', true);
    wp_enqueue_script('ratatouille-testimonials', get_template_directory_uri() . '/assets/js/testimonials.js', array('jquery', 'slick'), '1.0', true);
    wp_enqueue_script('ratatouille-reservation', get_template_directory_uri() . '/assets/js/reservation.js', array('jquery'), '1.0', true);
    
    // Gallery script - ensure it's loaded on gallery page
    if (is_page_template('templates/gallery.php') || is_page('gallery')) {
        wp_enqueue_script('ratatouille-gallery', get_template_directory_uri() . '/assets/js/gallery.js', array('jquery', 'magnific-popup'), '1.0.1', true);
    }

    // Localize scripts
    wp_localize_script('ratatouille-ingredients', 'ratatouilleIngredients', array(
        'showText' => __('Показати склад', 'ratatouille'),
        'hideText' => __('Приховати склад', 'ratatouille')
    ));

    wp_localize_script('ratatouille-reservation', 'ratatouilleAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('reservation_nonce'),
        'messages' => array(
            'success' => __('Дякуємо! Ваше бронювання прийнято.', 'ratatouille'),
            'error' => __('Помилка при бронюванні. Будь ласка, спробуйте ще раз.', 'ratatouille'),
            'required' => __('Будь ласка, заповніть всі обов\'язкові поля', 'ratatouille'),
            'selectTable' => __('Будь ласка, оберіть столик на схемі', 'ratatouille'),
            'tableNotAvailable' => __('Цей столик вже заброньовано на вказаний час', 'ratatouille')
        )
    ));
}
add_action('wp_enqueue_scripts', 'ratatouille_scripts');

/**
 * Register Custom Post Types
 */
function ratatouille_register_post_types() {
    // Register Reservation Post Type
    $reservation_labels = array(
        'name'               => __('Бронювання', 'ratatouille'),
        'singular_name'      => __('Бронювання', 'ratatouille'),
        'menu_name'          => __('Бронювання', 'ratatouille'),
        'add_new'            => __('Додати нове', 'ratatouille'),
        'add_new_item'       => __('Додати нове бронювання', 'ratatouille'),
        'edit_item'          => __('Редагувати бронювання', 'ratatouille'),
        'new_item'           => __('Нове бронювання', 'ratatouille'),
        'view_item'          => __('Переглянути бронювання', 'ratatouille'),
        'search_items'       => __('Пошук бронювань', 'ratatouille'),
        'not_found'          => __('Бронювань не знайдено', 'ratatouille'),
        'not_found_in_trash' => __('У кошику бронювань не знайдено', 'ratatouille'),
        'all_items'          => __('Всі бронювання', 'ratatouille'),
        'archives'           => __('Архів бронювань', 'ratatouille'),
        'attributes'         => __('Атрибути бронювання', 'ratatouille'),
        'insert_into_item'   => __('Вставити в бронювання', 'ratatouille'),
        'uploaded_to_this_item' => __('Завантажено до цього бронювання', 'ratatouille'),
    );

    $reservation_args = array(
        'labels'              => $reservation_labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => array('title'),
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'show_in_rest'        => false,
    );

    register_post_type('reservation', $reservation_args);

    // Register Testimonial Post Type
    $testimonial_labels = array(
        'name'               => __('Відгуки', 'ratatouille'),
        'singular_name'      => __('Відгук', 'ratatouille'),
        'menu_name'          => __('Відгуки', 'ratatouille'),
        'add_new'            => __('Додати новий', 'ratatouille'),
        'add_new_item'       => __('Додати новий відгук', 'ratatouille'),
        'edit_item'          => __('Редагувати відгук', 'ratatouille'),
        'new_item'           => __('Новий відгук', 'ratatouille'),
        'view_item'          => __('Переглянути відгук', 'ratatouille'),
        'search_items'       => __('Пошук відгуків', 'ratatouille'),
        'not_found'          => __('Відгуків не знайдено', 'ratatouille'),
        'not_found_in_trash' => __('У кошику відгуків не знайдено', 'ratatouille'),
    );

    $testimonial_args = array(
        'labels'              => $testimonial_labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-star-filled',
        'supports'            => array('title'),
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
    );

    register_post_type('testimonial', $testimonial_args);
}
add_action('init', 'ratatouille_register_post_types');

/**
 * AJAX handler for reservation submission
 */
function ratatouille_handle_reservation_submission() {
    // Verify nonce
    if (!check_ajax_referer('reservation_nonce', 'nonce', false)) {
        wp_send_json_error(__('Помилка безпеки. Будь ласка, оновіть сторінку і спробуйте ще раз.', 'ratatouille'));
        return;
    }

    // Sanitize and validate input
    $customer_name = sanitize_text_field($_POST['name']);
    $customer_phone = sanitize_text_field($_POST['phone']);
    $customer_email = sanitize_email($_POST['email'] ?? '');
    $reservation_date = sanitize_text_field($_POST['date']);
    $reservation_time = sanitize_text_field($_POST['time']);
    $guests_count = intval($_POST['guests']);
    $table_number = intval($_POST['table_number']);
    $special_requests = sanitize_textarea_field($_POST['notes'] ?? '');

    // Validation
    if (empty($customer_name) || empty($customer_phone) || empty($reservation_date) || empty($reservation_time) || $guests_count <= 0 || $table_number <= 0) {
        wp_send_json_error(__('Будь ласка, заповніть всі обов\'язкові поля', 'ratatouille'));
        return;
    }

    // Validate date (must be today or future)
    $today = date('Y-m-d');
    if ($reservation_date < $today) {
        wp_send_json_error(__('Дата бронювання не може бути в минулому', 'ratatouille'));
        return;
    }

    // Check if table is available
    if (!ratatouille_is_table_available($table_number, $reservation_date, $reservation_time)) {
        wp_send_json_error(__('Цей столик вже заброньовано на вказаний час', 'ratatouille'));
        return;
    }

    // Create reservation post
    $current_datetime = ratatouille_current_time('Y-m-d H:i:s');
    $post_title = sprintf('Бронювання: %s - %s %s (Столик №%d)', 
        $customer_name, 
        date('d.m.Y', strtotime($reservation_date)), 
        $reservation_time,
        $table_number
    );

    $post_data = array(
        'post_title'   => $post_title,
        'post_type'    => 'reservation',
        'post_status'  => 'publish',
        'post_content' => '',
        'post_date'    => $current_datetime,
        'post_date_gmt' => get_gmt_from_date($current_datetime)
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id && !is_wp_error($post_id)) {
        // Save ACF fields with correct field names
        update_field('customer_name', $customer_name, $post_id);
        update_field('customer_phone', $customer_phone, $post_id);
        if (!empty($customer_email)) {
            update_field('customer_email', $customer_email, $post_id);
        }
        update_field('reservation_date', $reservation_date, $post_id);
        update_field('reservation_time', $reservation_time, $post_id);
        update_field('guests_count', $guests_count, $post_id);
        update_field('table_number', $table_number, $post_id);
        update_field('reservation_status', 'pending', $post_id);
        update_field('reservation_created_date', $current_datetime, $post_id);
        if (!empty($special_requests)) {
            update_field('special_requests', $special_requests, $post_id);
        }
        update_field('reminder_sent', false, $post_id);

        // Send email notification to admin
        ratatouille_send_reservation_notification($post_id);

        // Send confirmation email to customer (if email provided)
        if (!empty($customer_email)) {
            ratatouille_send_customer_confirmation($post_id);
        }

        wp_send_json_success(__('Дякуємо! Ваше бронювання прийнято. Ми зв\'яжемося з вами найближчим часом для підтвердження.', 'ratatouille'));
    } else {
        wp_send_json_error(__('Помилка при створенні бронювання. Спробуйте ще раз.', 'ratatouille'));
    }
}
add_action('wp_ajax_reservation_submit', 'ratatouille_handle_reservation_submission');
add_action('wp_ajax_nopriv_reservation_submit', 'ratatouille_handle_reservation_submission');

/**
 * Check if table is available at specific date and time
 */
function ratatouille_is_table_available($table_number, $date, $time) {
    $args = array(
        'post_type' => 'reservation',
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'table_number',
                'value' => $table_number,
                'compare' => '='
            ),
            array(
                'key' => 'reservation_date',
                'value' => $date,
                'compare' => '='
            ),
            array(
                'key' => 'reservation_time',
                'value' => $time,
                'compare' => '='
            ),
            array(
                'key' => 'reservation_status',
                'value' => array('confirmed', 'pending'),
                'compare' => 'IN'
            )
        )
    );

    $existing_reservations = get_posts($args);
    return empty($existing_reservations);
}

/**
 * AJAX handler for checking table availability
 */
function ratatouille_check_table_availability() {
    if (!check_ajax_referer('reservation_nonce', 'nonce', false)) {
        wp_send_json_error(__('Помилка безпеки', 'ratatouille'));
        return;
    }

    $table_number = intval($_POST['table']);
    $date = sanitize_text_field($_POST['date']);
    $time = sanitize_text_field($_POST['time']);

    $is_available = ratatouille_is_table_available($table_number, $date, $time);

    wp_send_json_success(array('available' => $is_available));
}
add_action('wp_ajax_check_table_availability', 'ratatouille_check_table_availability');
add_action('wp_ajax_nopriv_check_table_availability', 'ratatouille_check_table_availability');

/**
 * Send email notification to admin
 */
function ratatouille_send_reservation_notification($post_id) {
    $admin_email = get_option('admin_email');
    if (empty($admin_email)) {
        return;
    }

    $customer_name = get_field('customer_name', $post_id);
    $customer_phone = get_field('customer_phone', $post_id);
    $customer_email = get_field('customer_email', $post_id);
    $reservation_date = get_field('reservation_date', $post_id);
    $reservation_time = get_field('reservation_time', $post_id);
    $guests_count = get_field('guests_count', $post_id);
    $table_number = get_field('table_number', $post_id);
    $special_requests = get_field('special_requests', $post_id);

    $subject = sprintf('[%s] Нове бронювання столика №%d', get_bloginfo('name'), $table_number);
    
    $message = sprintf(
        "Нове бронювання столика:\n\n" .
        "Ім'я клієнта: %s\n" .
        "Телефон: %s\n" .
        "Email: %s\n" .
        "Дата: %s\n" .
        "Час: %s\n" .
        "Кількість гостей: %d\n" .
        "Столик: №%d\n" .
        "Особливі побажання: %s\n\n" .
        "Перейти до управління бронюванням: %s\n\n" .
        "Дата створення: %s",
        $customer_name,
        $customer_phone,
        $customer_email ?: 'Не вказано',
        date('d.m.Y', strtotime($reservation_date)),
        $reservation_time,
        $guests_count,
        $table_number,
        $special_requests ?: 'Немає',
        admin_url('post.php?post=' . $post_id . '&action=edit'),
        ratatouille_current_time('d.m.Y H:i')
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );

    wp_mail($admin_email, $subject, $message, $headers);
}

/**
 * Send confirmation email to customer
 */
function ratatouille_send_customer_confirmation($post_id) {
    $customer_email = get_field('customer_email', $post_id);
    if (empty($customer_email)) {
        return;
    }

    $customer_name = get_field('customer_name', $post_id);
    $reservation_date = get_field('reservation_date', $post_id);
    $reservation_time = get_field('reservation_time', $post_id);
    $guests_count = get_field('guests_count', $post_id);
    $table_number = get_field('table_number', $post_id);

    $subject = sprintf('[%s] Підтвердження бронювання', get_bloginfo('name'));
    
    $message = sprintf(
        "Шановний(а) %s!\n\n" .
        "Дякуємо за бронювання столика в ресторані \"%s\".\n\n" .
        "Деталі вашого бронювання:\n" .
        "Дата: %s\n" .
        "Час: %s\n" .
        "Кількість гостей: %d\n" .
        "Столик: №%d\n\n" .
        "Ваше бронювання очікує підтвердження. Ми зв'яжемося з вами найближчим часом.\n\n" .
        "З повагою,\n" .
        "Команда ресторану \"%s\"\n" .
        "Телефон: %s",
        $customer_name,
        get_bloginfo('name'),
        date('d.m.Y', strtotime($reservation_date)),
        $reservation_time,
        $guests_count,
        $table_number,
        get_bloginfo('name'),
        get_theme_mod('contact_phone', '+38 (012) 345-67-89')
    );

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );

    wp_mail($customer_email, $subject, $message, $headers);
}

/**
 * AJAX handler for testimonial submission
 */
function ratatouille_handle_testimonial_submission() {
    // Verify nonce
    if (!check_ajax_referer('testimonial_nonce', 'nonce', false)) {
        wp_send_json_error(__('Помилка безпеки. Будь ласка, оновіть сторінку і спробуйте ще раз.', 'ratatouille'));
        return;
    }

    // Sanitize and validate input
    $customer_name = sanitize_text_field($_POST['customer_name']);
    $customer_phone = sanitize_text_field($_POST['customer_phone']);
    $customer_email = sanitize_email($_POST['customer_email']);
    $rating = intval($_POST['rating']);
    $testimonial_text = sanitize_textarea_field($_POST['testimonial_text']);

    // Validation
    if (empty($customer_name) || empty($customer_phone) || empty($customer_email) || empty($testimonial_text)) {
        wp_send_json_error(__('Будь ласка, заповніть всі обов\'язкові поля', 'ratatouille'));
        return;
    }

    if (!is_email($customer_email)) {
        wp_send_json_error(__('Будь ласка, введіть коректний email', 'ratatouille'));
        return;
    }

    if ($rating < 1 || $rating > 5) {
        wp_send_json_error(__('Оцінка повинна бути від 1 до 5', 'ratatouille'));
        return;
    }

    // Create testimonial post
    $post_data = array(
        'post_title'   => sprintf('Відгук від %s', $customer_name),
        'post_type'    => 'testimonial',
        'post_status'  => 'publish',
        'post_content' => $testimonial_text
    );

    $post_id = wp_insert_post($post_data);

    if ($post_id && !is_wp_error($post_id)) {
        // Save ACF fields
        update_field('testimonial_name', $customer_name, $post_id);
        update_field('testimonial_phone', $customer_phone, $post_id);
        update_field('testimonial_email', $customer_email, $post_id);
        update_field('testimonial_rating', $rating, $post_id);
        update_field('testimonial_text', $testimonial_text, $post_id);
        update_field('testimonial_status', 'pending', $post_id);
        update_field('testimonial_date', ratatouille_current_time('d.m.Y H:i'), $post_id);

        // Send email notification to admin
        $admin_email = get_option('admin_email');
        if (!empty($admin_email)) {
            $subject = __('Новий відгук на сайті', 'ratatouille');
            $message = sprintf(
                "Новий відгук від клієнта:\n\nІм'я: %s\nТелефон: %s\nEmail: %s\nОцінка: %d/5\nВідгук: %s\n\nПерейти до модерації: %s",
                $customer_name,
                $customer_phone,
                $customer_email,
                $rating,
                $testimonial_text,
                admin_url('edit.php?post_type=testimonial')
            );
            
            $headers = array('Content-Type: text/plain; charset=UTF-8');
            wp_mail($admin_email, $subject, $message, $headers);
        }

        wp_send_json_success(__('Дякуємо за ваш відгук! Він буде опублікований після модерації.', 'ratatouille'));
    } else {
        wp_send_json_error(__('Помилка при збереженні відгуку', 'ratatouille'));
    }
}
add_action('wp_ajax_submit_testimonial', 'ratatouille_handle_testimonial_submission');
add_action('wp_ajax_nopriv_submit_testimonial', 'ratatouille_handle_testimonial_submission');

/**
 * Add custom columns to reservations admin list
 */
function ratatouille_reservation_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['customer'] = __('Клієнт', 'ratatouille');
    $new_columns['reservation_datetime'] = __('Дата і час', 'ratatouille');
    $new_columns['table_guests'] = __('Столик / Гості', 'ratatouille');
    $new_columns['status'] = __('Статус', 'ratatouille');
    $new_columns['created'] = __('Створено', 'ratatouille');
    
    return $new_columns;
}
add_filter('manage_reservation_posts_columns', 'ratatouille_reservation_admin_columns');

/**
 * Fill custom columns with data
 */
function ratatouille_reservation_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'customer':
            $name = get_field('customer_name', $post_id);
            $phone = get_field('customer_phone', $post_id);
            $email = get_field('customer_email', $post_id);
            
            echo '<strong>' . esc_html($name) . '</strong><br>';
            echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            if ($email) {
                echo '<br><a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            }
            break;
            
        case 'reservation_datetime':
            $date = get_field('reservation_date', $post_id);
            $time = get_field('reservation_time', $post_id);
            
            if ($date && $time) {
                echo '<strong>' . date('d.m.Y', strtotime($date)) . '</strong><br>';
                echo '<span style="color: #666;">' . esc_html($time) . '</span>';
            }
            break;
            
        case 'table_guests':
            $table = get_field('table_number', $post_id);
            $guests = get_field('guests_count', $post_id);
            
            echo '<strong>Столик №' . esc_html($table) . '</strong><br>';
            echo '<span style="color: #666;">' . esc_html($guests) . ' гостей</span>';
            break;
            
        case 'status':
            $status = get_field('reservation_status', $post_id);
            $status_labels = array(
                'pending' => array('label' => 'Очікує', 'color' => '#f39c12'),
                'confirmed' => array('label' => 'Підтверджено', 'color' => '#27ae60'),
                'cancelled' => array('label' => 'Скасовано', 'color' => '#e74c3c'),
                'completed' => array('label' => 'Завершено', 'color' => '#3498db'),
                'no_show' => array('label' => 'Не з\'явився', 'color' => '#95a5a6')
            );
            
            $status_info = $status_labels[$status] ?? array('label' => $status, 'color' => '#333');
            
            echo '<span style="color: ' . esc_attr($status_info['color']) . '; font-weight: bold;">' . 
                 esc_html($status_info['label']) . '</span>';
            break;
            
        case 'created':
            $created = get_field('reservation_created_date', $post_id);
            if ($created) {
                echo date('d.m.Y H:i', strtotime($created));
            } else {
                echo get_the_date('d.m.Y H:i', $post_id);
            }
            break;
    }
}
add_action('manage_reservation_posts_custom_column', 'ratatouille_reservation_admin_column_content', 10, 2);

/**
 * Add custom columns to testimonials admin list
 */
function ratatouille_testimonial_admin_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = $columns['title'];
    $new_columns['customer_name'] = __('Ім\'я клієнта', 'ratatouille');
    $new_columns['rating'] = __('Оцінка', 'ratatouille');
    $new_columns['status'] = __('Статус', 'ratatouille');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_testimonial_posts_columns', 'ratatouille_testimonial_admin_columns');

/**
 * Fill testimonial custom columns with data
 */
function ratatouille_testimonial_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'customer_name':
            $name = get_field('testimonial_name', $post_id);
            echo esc_html($name ?: '-');
            break;
            
        case 'rating':
            $rating = get_field('testimonial_rating', $post_id);
            if ($rating) {
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $rating ? '★' : '☆';
                }
                echo ' (' . $rating . '/5)';
            } else {
                echo '-';
            }
            break;
            
        case 'status':
            $status = get_field('testimonial_status', $post_id);
            $status_labels = array(
                'pending' => __('Очікує модерації', 'ratatouille'),
                'approved' => __('Схвалено', 'ratatouille'),
                'rejected' => __('Відхилено', 'ratatouille')
            );
            
            $status_colors = array(
                'pending' => '#f39c12',
                'approved' => '#27ae60',
                'rejected' => '#e74c3c'
            );
            
            $label = $status_labels[$status] ?? $status;
            $color = $status_colors[$status] ?? '#333';
            
            echo '<span style="color: ' . esc_attr($color) . '; font-weight: bold;">' . esc_html($label) . '</span>';
            break;
    }
}
add_action('manage_testimonial_posts_custom_column', 'ratatouille_testimonial_admin_column_content', 10, 2);

// Include additional files
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-functions.php';

if (class_exists('ACF')) {
    require get_template_directory() . '/inc/acf-setup.php';
}