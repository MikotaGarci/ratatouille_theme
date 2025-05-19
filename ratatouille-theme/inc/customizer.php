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
    $wp_customize->add_setting('ratatouille_phone', array(
        'default'   => '+380 12 345 6789',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('ratatouille_phone', array(
        'label'    => __('Телефон', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'text',
    ));

    // Настройка: Адрес
    $wp_customize->add_setting('ratatouille_address', array(
        'default'   => 'г. Киев, ул. Французская, 15',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('ratatouille_address', array(
        'label'    => __('Адрес', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'textarea',
    ));

    // Настройка: Часы работы
    $wp_customize->add_setting('ratatouille_hours', array(
        'default'   => 'Ежедневно с 10:00 до 23:00',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('ratatouille_hours', array(
        'label'    => __('Часы работы', 'ratatouille'),
        'section'  => 'ratatouille_general_settings',
        'type'     => 'textarea',
    ));

    // Секция "Главная страница"
    $wp_customize->add_section('ratatouille_homepage', array(
        'title'    => __('Главная страница', 'ratatouille'),
        'priority' => 40,
    ));

    // Настройка: Заголовок героя
    $wp_customize->add_setting('ratatouille_hero_title', array(
        'default'   => 'Добро пожаловать в ресторан "Рататуй"',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('ratatouille_hero_title', array(
        'label'    => __('Заголовок героя', 'ratatouille'),
        'section'  => 'ratatouille_homepage',
        'type'     => 'text',
    ));

    // Настройка: Подзаголовок героя
    $wp_customize->add_setting('ratatouille_hero_subtitle', array(
        'default'   => 'Истинный вкус Франции в сердце города',
        'transport' => 'refresh',
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
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ratatouille_hero_background', array(
        'label'    => __('Фон героя', 'ratatouille'),
        'section'  => 'ratatouille_homepage',
        'settings' => 'ratatouille_hero_background',
    )));
}
add_action('customize_register', 'ratatouille_customize_register');