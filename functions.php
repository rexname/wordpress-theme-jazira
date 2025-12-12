<?php
add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
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
