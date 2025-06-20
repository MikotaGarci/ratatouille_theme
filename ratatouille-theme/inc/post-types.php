<?php

/**
 * Register Reservation Post Type
 */
function register_reservation_post_type() {
    $labels = array(
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
    );

    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-calendar-alt',
        'supports'            => array('title'),
        'register_meta_box_cb'=> 'add_reservation_metaboxes'
    );

    register_post_type('reservation', $args);
}
add_action('init', 'register_reservation_post_type');

/**
 * Reservation Details Meta Box Callback
 */
function reservation_details_callback($post) {
    $name = get_post_meta($post->ID, 'reservation_name', true);
    $phone = get_post_meta($post->ID, 'reservation_phone', true);
    $date = get_post_meta($post->ID, 'reservation_date', true);
    $time = get_post_meta($post->ID, 'reservation_time', true);
    $guests = get_post_meta($post->ID, 'reservation_guests', true);
    $table = get_post_meta($post->ID, 'reservation_table', true);
    $status = get_post_meta($post->ID, 'reservation_status', true);
    $notes = get_post_meta($post->ID, 'reservation_notes', true);

    wp_nonce_field('reservation_details_nonce', 'reservation_details_nonce');
    ?>
    <table class="form-table">
        <tr>
            <th><label for="reservation_name"><?php _e('Ім\'я', 'ratatouille'); ?></label></th>
            <td><input type="text" id="reservation_name" name="reservation_name" value="<?php echo esc_attr($name); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="reservation_phone"><?php _e('Телефон', 'ratatouille'); ?></label></th>
            <td><input type="text" id="reservation_phone" name="reservation_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th><label for="reservation_date"><?php _e('Дата', 'ratatouille'); ?></label></th>
            <td><input type="date" id="reservation_date" name="reservation_date" value="<?php echo esc_attr($date); ?>"></td>
        </tr>
        <tr>
            <th><label for="reservation_time"><?php _e('Час', 'ratatouille'); ?></label></th>
            <td>
                <select id="reservation_time" name="reservation_time">
                    <?php
                    $times = array('12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00');
                    foreach ($times as $t) {
                        printf('<option value="%1$s" %2$s>%1$s</option>', 
                            esc_attr($t), 
                            selected($time, $t, false)
                        );
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="reservation_guests"><?php _e('Кількість гостей', 'ratatouille'); ?></label></th>
            <td><input type="number" id="reservation_guests" name="reservation_guests" value="<?php echo esc_attr($guests); ?>" min="1" max="20"></td>
        </tr>
        <tr>
            <th><label for="reservation_table"><?php _e('Номер столика', 'ratatouille'); ?></label></th>
            <td><input type="number" id="reservation_table" name="reservation_table" value="<?php echo esc_attr($table); ?>" min="1" max="55"></td>
        </tr>
        <tr>
            <th><label for="reservation_status"><?php _e('Статус', 'ratatouille'); ?></label></th>
            <td>
                <select id="reservation_status" name="reservation_status">
                    <option value="pending" <?php selected($status, 'pending'); ?>><?php _e('Очікує підтвердження', 'ratatouille'); ?></option>
                    <option value="confirmed" <?php selected($status, 'confirmed'); ?>><?php _e('Підтверджено', 'ratatouille'); ?></option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php _e('Скасовано', 'ratatouille'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="reservation_notes"><?php _e('Примітки', 'ratatouille'); ?></label></th>
            <td><textarea id="reservation_notes" name="reservation_notes" rows="5" class="large-text"><?php echo esc_textarea($notes); ?></textarea></td>
        </tr>
    </table>
    <?php
}

/**
 * Save Reservation Meta Box Data
 */
function save_reservation_meta($post_id) {
    if (!isset($_POST['reservation_details_nonce']) || 
        !wp_verify_nonce($_POST['reservation_details_nonce'], 'reservation_details_nonce')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array(
        'reservation_name',
        'reservation_phone',
        'reservation_date',
        'reservation_time',
        'reservation_guests',
        'reservation_table',
        'reservation_status',
        'reservation_notes'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_reservation', 'save_reservation_meta');