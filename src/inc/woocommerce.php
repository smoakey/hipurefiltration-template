<?php
// dont include woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action('after_setup_theme', 'woocommerce_support');
add_action('woocommerce_before_main_content', 'woocommerce_remove_breadcrumb');
add_action('woocommerce_single_product_summary', 'add_cut_sheet', 21);

function woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

function woocommerce_remove_breadcrumb() {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}

function add_cut_sheet() {
    $cutSheet =  get_field('cut_sheet', get_the_ID());
    if (!isset($cutSheet['url'])) {
        return '';
    }

    echo '<div class="cut-sheet"><strong><i class="fas fa-file-pdf"></i> Cut Sheet: </strong>
        <a download href="' . $cutSheet['url'] . '">' . $cutSheet['title'] . '</a></div>';
}
