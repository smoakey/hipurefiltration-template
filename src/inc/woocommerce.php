<?php
// dont include woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

add_action('after_setup_theme', 'woocommerce_support');
add_action('woocommerce_before_main_content', 'woocommerce_remove_breadcrumb');
add_action('woocommerce_single_product_summary', 'add_cut_sheet', 21);
add_action('woocommerce_single_product_summary', 'add_lead_time', 31);

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

function add_lead_time() {
    global $product;

    $numStock = $product->get_stock_quantity();
    $inStock = $product->get_stock_status() == 'instock';

    if ($inStock) {
        return;
    }

    $leadTime = get_field('lead_time', get_the_ID());
    echo ' &mdash; Lead Time: <strong>' . $leadTime . '</strong>' .
        ' &mdash; <a href="/contact-us?product_sku='. $product->get_sku() .'">Contact us to order &rsaquo;</a>';
}
