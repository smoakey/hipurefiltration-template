<?php
add_filter('posts_join', 'products_search_join');
add_filter('posts_where', 'products_search_where');
add_filter('posts_distinct', 'products_search_distinct');

function products_search_join($join) {
    global $wpdb;

    if (is_search()) {
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}

function products_search_where($where) {
    global $pagenow, $wpdb;

    if (is_search()) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where
        );
    }

    return $where;
}

function products_search_distinct($where) {
    global $wpdb;

    if (is_search()) {
        return "DISTINCT";
    }

    return $where;
}
