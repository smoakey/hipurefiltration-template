<?php
add_action('wp_enqueue_scripts', 'add_theme_scripts');

function add_theme_scripts() {
    wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/releases/v5.0.6/js/all.js', [], 1.0, true);
    wp_enqueue_script('main', 'http://localhost:3001/dist/web.min.js', [], 1.0, true);
}