<?php
add_filter( 'posts_search', 'product_search' );

function product_search( $where ) {
    global $pagenow, $wpdb, $wp;

    if (!is_search() || !isset($wp->query_vars['s']) || 'product' != $wp->query_vars['post_type'] ) {
        return $where;
    }

    $search_ids = array();
    $terms      = explode( ',', $wp->query_vars['s'] );

    foreach ($terms as $term){
        if (is_numeric($term)){
            $post_type = get_post_type( $term );
            if($post_type == 'product_variation'){
                $search_ids[]   =   wp_get_post_parent_id($term);
            }else{
               $search_ids[]   =   $term;
            }
        }
        // Attempt to get a SKU
        $sku_to_id = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_parent FROM {$wpdb->posts} LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id WHERE meta_key='_sku' AND meta_value LIKE %s;", '%' . $wpdb->esc_like( wc_clean( $term ) ) . '%' ) );
        $sku_to_id = array_merge( wp_list_pluck( $sku_to_id, 'ID' ), wp_list_pluck( $sku_to_id, 'post_parent' ) );

        if (sizeof($sku_to_id) > 0) {
            $search_ids = array_merge($search_ids, $sku_to_id);
        }
    }
    $search_ids = array_filter( array_unique( array_map( 'absint', $search_ids ) ) );
    if ( sizeof( $search_ids ) > 0 ) {
        $where = str_replace( 'AND (((', "AND ( ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . ")) OR ((", $where );
    }
    return $where;
}