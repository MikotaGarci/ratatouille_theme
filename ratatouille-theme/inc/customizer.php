<?php
/**
 * Настройки кастомизатора для темы "Рататуй"
 */

function ratatouille_customize_register($wp_customize) {
    // Секция "Основные настройки"
    $wp_customize->add_section('ratatouille_general_settings', array(
        'title'    => __('Основные настройки', 'ratatouille'),
        'priority' => 30,
    ));

    // Настройка: Телефон
    $wp_customize->add_setting('contact_phone', array(
        'default'   => '+38 (012) 345-67-89',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_phone', array(
        'label'    => __('Телефон', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'text',
    ));

    // Настройка: Email
    $wp_customize->add_setting('contact_email', array(
        'default'   => 'info@ratatouille.com.ua',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('contact_email', array(
        'label'    => __('Email', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'email',
    ));

    // Настройка: Адрес
    $wp_customize->add_setting('contact_address', array(
        'default'   => 'Полтава, вул. Соборності, 27',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('contact_address', array(
        'label'    => __('Адрес', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'textarea',
    ));

    // Настройка: Часы работы будни
    $wp_customize->add_setting('working_hours_weekdays', array(
        'default'   => '10:00 - 22:00',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('working_hours_weekdays', array(
        'label'    => __('Часы работы (будни)', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'text',
    ));

    // Настройка: Часы работы выходные
    $wp_customize->add_setting('working_hours_weekends', array(
        'default'   => '11:00 - 23:00',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('working_hours_weekends', array(
        'label'    => __('Часы работы (выходные)', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'text',
    ));

    // Секция "Социальные сети"
    $wp_customize->add_section('ratatouille_social_settings', array(
        'title'    => __('Социальные сети', 'ratatouille'),
        'priority' => 35,
    ));

    // Facebook
    $wp_customize->add_setting('social_facebook', array(
        'default'   => 'https://facebook.com/ratatouille',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_facebook', array(
        'label'    => __('Facebook URL', 'ratatouille'),
        'section'  => 'ratatouille_social_settings',
        'type'     => 'url',
    ));

    // Instagram
    $wp_customize->add_setting('social_instagram', array(
        'default'   => 'https://instagram.com/ratatouille',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_instagram', array(
        'label'    => __('Instagram URL', 'ratatouille'),
        'section'  => 'ratatouille_social_settings',
        'type'     => 'url',
    ));

    // Twitter
    $wp_customize->add_setting('social_twitter', array(
        'default'   => 'https://twitter.com/ratatouille',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_twitter', array(
        'label'    => __('Twitter URL', 'ratatouille'),
        'section'  => 'ratatouille_social_settings',
        'type'     => 'url',
    ));

    // YouTube
    $wp_customize->add_setting('social_youtube', array(
        'default'   => 'https://youtube.com/ratatouille',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_youtube', array(
        'label'    => __('YouTube URL', 'ratatouille'),
        'section'  => 'ratatouille_social_settings',
        'type'     => 'url',
    ));

    // Telegram
    $wp_customize->add_setting('social_telegram', array(
        'default'   => 'https://t.me/ratatouille',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_telegram', array(
        'label'    => __('Telegram URL', 'ratatouille'),
        'section'  => 'ratatouille_social_settings',
        'type'     => 'url',
    ));

    // TikTok
    $wp_customize->add_setting('social_tiktok', array(
        'default'   => 'https://tiktok.com/@ratatouille',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('social_tiktok', array(
        'label'    => __('TikTok URL', 'ratatouille'),
        'section'  => 'ratatouille_social_settings',
        'type'     => 'url',
    ));

    // Секция "Footer"
    $wp_customize->add_section('ratatouille_footer_settings', array(
        'title'    => __('Footer настройки', 'ratatouille'),
        'priority' => 40,
    ));

    // Footer About Text
    $wp_customize->add_setting('footer_about_text', array(
        'default'   => 'Ресторан "Рататуй" - це поєднання французької класики і сучасної кухні. Ми пропонуємо вам незабутню гастрономічну подорож та атмосферу затишку.',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));

    $wp_customize->add_control('footer_about_text', array(
        'label'    => __('Текст о ресторане в футере', 'ratatouille'),
        'section'  => 'ratatouille_footer_settings',
        'type'     => 'textarea',
    ));

    // Map Link
    $wp_customize->add_setting('contact_map_link', array(
        'default'   => 'https://goo.gl/maps/qcDcZr9QE2L8Hy8J7',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control('contact_map_link', array(
        'label'    => __('Ссылка на карту', 'ratatouille'),
        'section'  => 'ratatouille_footer_settings',
        'type'     => 'url',
    ));

    // Секция "Главная страница"
    $wp_customize->add_section('ratatouille_homepage', array(
        'title'    => __('Главная страница', 'ratatouille'),
        'priority' => 50,
    ));

    // Настройка: Заголовок героя
    $wp_customize->add_setting('ratatouille_hero_title', array(
        'default'   => 'Ласкаво просимо до ресторану "Рататуй"',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('ratatouille_hero_title', array(
        'label'    => __('Заголовок героя', 'ratatouille'),
        'section'  => 'ratatouille_homepage',
        'type'     => 'text',
    ));

    // Настройка: Подзаголовок героя
    $wp_customize->add_setting('ratatouille_hero_subtitle', array(
        'default'   => 'Істинний смак Франції у серці міста',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('ratatouille_hero_subtitle', array(
        'label'    => __('Подзаголовок героя', 'ratatouille'),
        'section'  => 'ratatouille_homepage',
        'type'     => 'text',
    ));

    // Настройка: Фон героя
    $wp_customize->add_setting('ratatouille_hero_background', array(
        'default'   => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ratatouille_hero_background', array(
        'label'    => __('Фон героя', 'ratatouille'),
        'section'  => 'ratatouille_homepage',
        'settings' => 'ratatouille_hero_background',
    )));
}
add_action('customize_register', 'ratatouille_customize_register');