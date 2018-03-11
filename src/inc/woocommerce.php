<?php
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

add_action('after_setup_theme', 'woocommerce_support');
add_action('woocommerce_before_main_content', 'woocommerce_remove_breadcrumb');

function woocommerce_support() {
    add_theme_support('woocommerce');
}

function woocommerce_remove_breadcrumb() {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
