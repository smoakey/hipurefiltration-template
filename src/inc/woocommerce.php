<?php
// dont include woocommerce styles
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
remove_action('wp_head', 'wp_oembed_add_host_js');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_action('after_setup_theme', 'woocommerce_support');
add_action('woocommerce_before_main_content', 'woocommerce_remove_breadcrumb');
add_action('woocommerce_single_product_summary', 'add_cut_sheet', 21);
add_filter('woocommerce_stock_html', 'add_custom_availability_html', 10, 3);

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

function add_custom_availability_html($html, $availability_availability, $product) {
    $leadTime = get_field('lead_time', $product->get_parent_id());

    switch($product->get_stock_status())
    {
        case 'instock':
            $availability_html = '';
            break;
        case 'onbackorder':
            $availability_html = '<p class="stock backorder">Ships within <strong>' . $leadTime . '</strong></p>';
            break;
        case 'outofstock':
            $availability_html = '<p class="stock out-of-stock">Out of Stock</p>';
            $availability_html .= ' &mdash; Lead Time: <strong>' . $leadTime . '</strong>';
            $availability_html .= ' &mdash; <a href="/contact-us?product_sku='. $product->get_sku() .'">Contact us to order &rsaquo;</a>';
            break;
    }

    return $availability_html;
}

