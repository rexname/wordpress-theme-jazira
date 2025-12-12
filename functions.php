<?php
add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
  add_theme_support('custom-logo');
  register_nav_menus([
    'primary' => __('Primary Menu', 'jazira'),
    'trending' => __('Trending Menu', 'jazira'),
    'footer' => __('Footer Menu', 'jazira'),
  ]);
});
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style('jazira-style', get_stylesheet_uri(), [], null);
});

// Set category archive to 12 posts per page
add_action('pre_get_posts', function($query){
  if (!is_admin() && $query->is_main_query() && $query->is_category()) {
    $query->set('posts_per_page', 12);
  }
});

// Inject meta description based on context
add_action('wp_head', function(){
  if (is_singular()) {
    global $post;
    $desc = get_the_excerpt($post);
    $desc = wp_strip_all_tags($desc);
    $desc = wp_trim_words($desc, 30);
    if ($desc) {
      echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
    }
  } elseif (is_category()) {
    $term = get_queried_object();
    $name = $term && isset($term->name) ? $term->name : get_bloginfo('name');
    $desc = term_description();
    if (!$desc) { $desc = sprintf('%s articles and latest coverage.', $name); }
    $desc = wp_strip_all_tags($desc);
    $desc = wp_trim_words($desc, 30);
    echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
  } elseif (is_home() || is_front_page()) {
    $desc = get_bloginfo('description');
    if ($desc) {
      echo '<meta name="description" content="' . esc_attr($desc) . '" />' . "\n";
    }
  }
  $brand = get_theme_mod('jazira_brand_color', '#f59e0b');
  $accent_mod = get_theme_mod('jazira_accent_color');
  $accent = $accent_mod ? $accent_mod : $brand;
  $auto = get_theme_mod('jazira_brand_use_logo_color', false);
  if ($auto) {
    $logo_id = get_theme_mod('custom_logo');
    if ($logo_id) {
      $c = jazira_logo_dominant_color();
      if ($c) { $brand = $c; if (!$accent_mod) { $accent = $c; } }
    }
  }
  echo '<style>:root{--brand:' . esc_attr($brand) . ';--accent:' . esc_attr($accent) . ';}</style>' . "\n";
});

add_action('customize_register', function($wp_customize){
  $wp_customize->add_section('jazira_home', [
    'title' => __('Home Layout', 'jazira'),
    'priority' => 160,
  ]);

  $wp_customize->add_setting('jazira_home_cat_select', [
    'default' => [],
    'sanitize_callback' => function($value){
      if (!is_array($value)) return [];
      return array_map('sanitize_text_field', $value);
    },
  ]);

  $categories = get_categories(['hide_empty' => false]);
  $choices = [];
  foreach ($categories as $c) { $choices[$c->slug] = $c->name; }

  $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'jazira_home_cat_select', [
    'section' => 'jazira_home',
    'label' => __('Home categories (select multiple in desired order)', 'jazira'),
    'type' => 'select',
    'choices' => $choices,
    'input_attrs' => ['multiple' => 'multiple', 'size' => 8],
  ]));

  $wp_customize->add_section('jazira_branding', [
    'title' => __('Branding', 'jazira'),
    'priority' => 159,
  ]);
  $wp_customize->add_setting('jazira_brand_use_logo_color', [
    'default' => false,
    'sanitize_callback' => function($v){ return (bool)$v; },
  ]);
  $wp_customize->add_control('jazira_brand_use_logo_color', [
    'section' => 'jazira_branding',
    'label' => __('Use logo dominant color', 'jazira'),
    'type' => 'checkbox',
  ]);
  $wp_customize->add_setting('jazira_brand_color', [
    'default' => '#f59e0b',
    'sanitize_callback' => 'sanitize_hex_color',
  ]);
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jazira_brand_color', [
    'section' => 'jazira_branding',
    'label' => __('Brand color', 'jazira'),
  ]));
  $wp_customize->add_setting('jazira_accent_color', [
    'default' => '#f59e0b',
    'sanitize_callback' => 'sanitize_hex_color',
  ]);
  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'jazira_accent_color', [
    'section' => 'jazira_branding',
    'label' => __('Accent color', 'jazira'),
  ]));
});

function jazira_logo_dominant_color(){
  $id = get_theme_mod('custom_logo');
  if (!$id) return null;
  $path = get_attached_file($id);
  if (!$path || !file_exists($path)) return null;
  $data = @file_get_contents($path);
  if (!$data) return null;
  if (!function_exists('imagecreatefromstring')) return null;
  $img = @imagecreatefromstring($data);
  if (!$img) return null;
  if (function_exists('imagescale')) {
    $scaled = @imagescale($img, 1, 1, IMG_BILINEAR_FIXED);
  } else {
    $scaled = $img;
  }
  $rgb = @imagecolorat($scaled, 0, 0);
  if ($rgb === false) {
    if ($scaled !== $img) imagedestroy($scaled);
    imagedestroy($img);
    return null;
  }
  $r = ($rgb >> 16) & 0xFF;
  $g = ($rgb >> 8) & 0xFF;
  $b = $rgb & 0xFF;
  if ($scaled !== $img) imagedestroy($scaled);
  imagedestroy($img);
  return sprintf('#%02x%02x%02x', $r, $g, $b);
}
