<?php
add_action('wp_enqueue_scripts', 'add_theme_scripts');

function add_theme_scripts() {
    $bundle = 'web';
    $base = 'http://localhost:3001';
    $base_local = get_template_directory();

    if ($_SERVER['SERVER_NAME'] != 'localhost') {
        $base = get_template_directory_uri();
        $file = "/dist/$bundle.min.css";
        wp_enqueue_style('bundle_css', $base . $file, [], @filemtime($base_local.$file));
    }

    $file = "/dist/$bundle.min.js";
    wp_enqueue_script('main', $base.$file, [], @filemtime($base_local.$file), true);
    wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/releases/v5.0.6/js/all.js', [], 1.0, true);
}