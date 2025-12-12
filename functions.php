<?php
add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
  register_nav_menus([
    'primary' => __('Primary Menu', 'jazira'),
    'trending' => __('Trending Menu', 'jazira'),
  ]);
});
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style('jazira-style', get_stylesheet_uri(), [], null);
});
