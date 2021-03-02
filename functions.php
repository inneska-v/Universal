<?php
//   Добавляем расширенные возможности
if ( ! function_exists( 'universal_theme_setup' ) ) :

    function universal_theme_setup() {
        // title-tag
        add_theme_support( 'title-tag' );
        // logo
        add_theme_support( 'custom-logo', [
            'width'      => 163,
            'flex-height' => true,
            'header-text' => 'Universal',
            'unlink-homepage-logo' => false, // WP 5.5
        ] );
        // menu
        register_nav_menus( [
            'header_menu' => 'Меню в шапке',
            'footer_menu' => 'Меню в подвале'
	    ] );

    }
endif;
add_action( 'after_setup_theme', 'universal_theme_setup' );


// Подключение стилей и скиптов
function enqueue_universal_theme() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri() . '/assets/css/universal-theme.css', 'style');

}
add_action( 'wp_enqueue_scripts', 'enqueue_universal_theme' );