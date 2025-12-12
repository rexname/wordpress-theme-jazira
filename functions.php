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
});
